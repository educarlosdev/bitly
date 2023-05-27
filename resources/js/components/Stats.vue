<script setup>
import {ClockIcon, LinkIcon, EyeIcon, CursorArrowRaysIcon, PresentationChartLineIcon} from '@heroicons/vue/24/outline';

const stats = [
    {name: 'Links', stat: 10},
    {name: 'Views', stat: '249'},
    {name: 'Clicks', stat: '53'},
    {name: 'Avg. CTR', stat: '21%'},
    {name: 'Avg. Time', stat: '6.37s'},
];
</script>

<template>
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 pt-10 pb-4">
        <div class="flex justify-between">
            <h3 class="text-base leading-7 text-gray-400 font-bold uppercase">Stats</h3>
            <h3 class="text-sky-400 font-light">See all</h3>
        </div>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-5">
            <div v-for="item in stats" :key="item.name" class="overflow-hidden rounded-lg px-4 py-5 shadow sm:p-6">
                <div class="flex justify-between">
                    <LinkIcon v-if="item.name === 'Links'" class="h-6 w-6 text-gray-400" aria-hidden="true"/>
                    <EyeIcon v-if="item.name === 'Views'" class="h-6 w-6 text-gray-400" aria-hidden="true"/>
                    <CursorArrowRaysIcon v-if="item.name === 'Clicks'" class="h-6 w-6 text-gray-400"
                                         aria-hidden="true"/>
                    <PresentationChartLineIcon v-if="item.name === 'Avg. CTR'" class="h-6 w-6 text-gray-400"
                                               aria-hidden="true"/>
                    <ClockIcon v-if="item.name === 'Avg. Time'" class="h-6 w-6 text-gray-400" aria-hidden="true"/>
                    <div>
                        <dd class="mt-1 text-2xl font-semibold tracking-tight text-gray-900">{{ item.stat }}</dd>
                        <dt class="truncate text-sm font-light text-gray-400">{{ item.name }}</dt>
                    </div>
                </div>
            </div>
        </dl>
    </div>
</template>

<style scoped>

</style>
