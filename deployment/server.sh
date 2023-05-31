#!/usr/bin/env bash

sysctl -w fs.aio-max-nr=2097152 \
  && locale-gen pt_BR.UTF-8 \
  && export LANG=pt_BR.UTF-8 \
  && ln -snf /usr/share/zoneinfo/America/Sao_Paulo /etc/localtime \
  && echo America/Sao_Paulo > /etc/timezone \
  && apt clean -y \
  && apt update -y \
  && apt list --upgradable \
  && apt upgrade -y \
  && apt dist-upgrade -y \
  && curl -sS 'https://keyserver.ubuntu.com/pks/lookup?op=get&search=0x14aa40ec0831756756d7f66c4f4ea0aae5267a6c' | gpg --dearmor | tee /usr/share/keyrings/ppa_ondrej_php.gpg > /dev/null \
  && echo "deb [signed-by=/usr/share/keyrings/ppa_ondrej_php.gpg] https://ppa.launchpadcontent.net/ondrej/php/ubuntu jammy main" > /etc/apt/sources.list.d/ppa_ondrej_php.list \
  && curl -sLS https://deb.nodesource.com/setup_14.x | bash - \
  && apt install -y nginx zip unzip php8.1-fpm php8.1-zip php8.1-mbstring php8.1-curl php8.1-xml php8.1-mysql supervisor mysql-server git nodejs \
  && curl -sLS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer \
  && npm install -g yarn \
  && apt autoremove -y \
  && apt autoclean -y \
  && apt clean -y \
  && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

setcap "cap_net_bind_service=+ep" /usr/bin/php8.1


if [ -f /var/www/html/index.nginx-debian.html ]; then
  rm /var/www/html/index.nginx-debian.html
fi

if [ ! -d /etc/nginx/sites-available/sites ]; then
  mkdir /etc/nginx/sites-available/sites
fi


echo "map \$http_upgrade \$connection_upgrade {
  default upgrade;
  \"\"      close;
}

include /etc/nginx/sites-available/sites/*.conf;

server {
  listen 80;
  listen [::]:80;
  root /var/www/html;
  index index.php index.html index.htm index.nginx-debian.html;
  server_name _;
  location / {
    deny all;
  }
  location ~ \.php$ {
    deny all;
  }
  location ~ /\.ht {
    deny all;
  }
}
" > /etc/nginx/sites-available/default

echo "server {
  listen 80;
  listen [::]:80;
  server_name bitly.eduardocarlos.com.br;
  server_tokens off;
  root /var/www/html/bitly.eduardocarlos.com.br/public;

  add_header X-Frame-Options \"SAMEORIGIN\";
  add_header X-Content-Type-Options \"nosniff\";

  index index.php;

  charset utf-8;

  client_max_body_size 100M;

    if (\$host != \"bitly.eduardocarlos.com.br\") {
        return 403;
    }

  location / {
    try_files \$uri \$uri/ /index.php?\$query_string;
  }

  location = /favicon.ico { access_log off; log_not_found off; }
  location = /robots.txt  { access_log off; log_not_found off; }

  access_log off;
  error_log  /var/log/nginx/bitly.eduardocarlos.com.br-error.log error;

  error_page 404 /index.php;

  location ~ \.php$ {
    fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    fastcgi_param SCRIPT_FILENAME \$realpath_root\$fastcgi_script_name;
    include fastcgi_params;
  }

  location ~ /\.(?!well-known).* {
    deny all;
  }
}
" > /etc/nginx/sites-available/sites/bitly.eduardocarlos.com.br.conf

echo "user www-data;
worker_processes auto;
pid /run/nginx.pid;
include /etc/nginx/modules-enabled/*.conf;
worker_rlimit_nofile 1500000;

events {
  worker_connections 100000;
}

http {
  sendfile on;
  tcp_nopush on;
  tcp_nodelay on;
  keepalive_timeout 65;
  types_hash_max_size 2048;

  server_names_hash_bucket_size 64;
  server_name_in_redirect off;

  include /etc/nginx/mime.types;
  default_type application/octet-stream;

  error_log /var/log/nginx/error.log;

  gzip on;

  gzip_vary on;
  gzip_proxied any;
  gzip_comp_level 6;
  gzip_buffers 16 8k;
  gzip_http_version 1.1;
  gzip_types text/plain text/css application/json application/javascript text/xml application/xml application/xml+rss text/javascript;

  include /etc/nginx/conf.d/*.conf;
  include /etc/nginx/sites-enabled/*;
}
" > /etc/nginx/nginx.conf

service nginx reload

if [ ! -d /var/www/git ]; then
  mkdir /var/www/git
  git config --global init.defaultBranch master
  git init --bare /var/www/git/bitly.eduardocarlos.com.br.git
fi


echo "#!/usr/bin/env bash
git --work-tree=/var/www/html/bitly.eduardocarlos.com.br --git-dir=/var/www/git/bitly.eduardocarlos.com.br.git checkout -f
COMPOSER_ALLOW_SUPERUSER=1 composer install --no-plugins --no-scripts --optimize-autoloader --no-dev --working-dir=/var/www/html/bitly.eduardocarlos.com.br

if [ ! -f /var/www/html/bitly.eduardocarlos.com.br/.env ]; then
  cp /var/www/html/bitly.eduardocarlos.com.br/.env.example /var/www/html/bitly.eduardocarlos.com.br/.env
  sed -i 's/APP_URL=http:/APP_URL=https:/g' /var/www/html/bitly.eduardocarlos.com.br/.env
  sed -i 's/127.0.0.1:8000/bitly.eduardocarlos.com.br/g' /var/www/html/bitly.eduardocarlos.com.br/.env
  sed -i 's/APP_ENV=local/APP_ENV=production/g' /var/www/html/bitly.eduardocarlos.com.br/.env
  sed -i 's/APP_DEBUG=true/APP_DEBUG=false/g' /var/www/html/bitly.eduardocarlos.com.br/.env
  sed -i 's/DB_DATABASE=bitly/DB_DATABASE=bitly.eduardocarlos.com.br/g' /var/www/html/bitly.eduardocarlos.com.br/.env
  sed -i 's/DB_PASSWORD=/DB_PASSWORD=123456/g' /var/www/html/bitly.eduardocarlos.com.br/.env
  php /var/www/html/bitly.eduardocarlos.com.br/artisan key:generate
fi

if [ ! -d /var/www/html/bitly.eduardocarlos.com.br/public/storage ]; then
  php /var/www/html/bitly.eduardocarlos.com.br/artisan storage:link
fi

php /var/www/html/bitly.eduardocarlos.com.br/artisan optimize:clear
php /var/www/html/bitly.eduardocarlos.com.br/artisan migrate --force
php /var/www/html/bitly.eduardocarlos.com.br/artisan optimize
php /var/www/html/bitly.eduardocarlos.com.br/artisan config:cache
php /var/www/html/bitly.eduardocarlos.com.br/artisan event:cache
php /var/www/html/bitly.eduardocarlos.com.br/artisan route:cache
php /var/www/html/bitly.eduardocarlos.com.br/artisan view:cache

supervisorctl restart bitly.eduardocarlos.com.br-worker:*
supervisorctl restart bitly.eduardocarlos.com.br-cron:*

yarn --cwd /var/www/html/bitly.eduardocarlos.com.br install
yarn --cwd /var/www/html/bitly.eduardocarlos.com.br build
rm -r /var/www/html/bitly.eduardocarlos.com.br/node_modules
chmod -R 777 /var/www/html/bitly.eduardocarlos.com.br
" > /var/www/git/bitly.eduardocarlos.com.br.git/hooks/post-receive

chmod +x /var/www/git/bitly.eduardocarlos.com.br.git/hooks/post-receive

if [ ! -d /var/www/html/bitly.eduardocarlos.com.br/storage/logs ]; then
  mkdir /var/www/html/bitly.eduardocarlos.com.br
  mkdir /var/www/html/bitly.eduardocarlos.com.br/storage
  mkdir /var/www/html/bitly.eduardocarlos.com.br/storage/logs
fi

echo "[program:bitly.eduardocarlos.com.br-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/bitly.eduardocarlos.com.br/artisan queue:work sync --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/bitly.eduardocarlos.com.br/storage/logs/worker.log
stopwaitsecs=3600
" > /etc/supervisor/conf.d/bitly.eduardocarlos.com.br-worker.conf

echo "[program:bitly.eduardocarlos.com.br-cron]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/html/bitly.eduardocarlos.com.br/artisan schedule:work
autostart=true
autorestart=true
stopasgroup=true
killasgroup=true
user=root
numprocs=1
redirect_stderr=true
stdout_logfile=/var/www/html/bitly.eduardocarlos.com.br/storage/logs/cron.log
stopwaitsecs=3600
" > /etc/supervisor/conf.d/bitly.eduardocarlos.com.br-cron.conf

supervisorctl reread && supervisorctl update

mysql --user=root  <<-EOSQL
    CREATE DATABASE IF NOT EXISTS \`bitly.eduardocarlos.com.br\`;
    GRANT ALL PRIVILEGES ON \`bitly.eduardocarlos.com.br%\`.* TO 'root'@'localhost';
    ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '123456';
    FLUSH PRIVILEGES;
EOSQL

#git remote add prod root@165.22.184.218:/var/www/git/bitly.eduardocarlos.com.br.git
#git push prod master
