<script setup>
import {
    ArrowTrendingUpIcon,
    TrashIcon,
    EllipsisVerticalIcon,
    PencilIcon,
    DocumentDuplicateIcon
} from '@heroicons/vue/24/outline';
</script>

<template>
    <div class="relative mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        <ul role="list">
            <li v-for="discussion in 10" :key="discussion"
                class="relative flex justify-between gap-x-3 py-8 bg-white rounded-md mb-4">
                <div class="flex items-center">
                    <EllipsisVerticalIcon class="h-8 w-8 text-gray-200 mr-4" aria-hidden="true"/>
                    <div>
                        <p class="text-lg font-semibold leading-6 text-gray-900">
                            <a href="#" class="hover:underline">http://127.0.0.1/tnw37wso</a>
                        </p>
                        <div class="mt-1 flex items-center gap-x-2 text-xs font-semibold leading-5 text-sky-400">
                            <p>
                                <a href="#" class="hover:underline">http://www.rodrigues.com/ea-accusantium-iure-debitis-voluptate-doloremque-nihil</a>
                            </p>
                        </div>
                    </div>
                </div>
                <dl class="flex items-center justify-between gap-x-8">
                    <div class="hidden md:flex gap-x-2 pr-5">
                        <span class="text-gray-300 text-xs mr-0 mt-1">10</span>
                        <ArrowTrendingUpIcon class="h-4 w-4 text-gray-300 mr-3 ml-0 mt-1" aria-hidden="true"/>
                        <DocumentDuplicateIcon class="h-5 w-5 text-gray-500" aria-hidden="true"/>
                        <PencilIcon class="h-5 w-5 text-gray-500" aria-hidden="true"/>
                        <TrashIcon class="h-5 w-5 text-gray-500" aria-hidden="true"/>
                    </div>
                    <div class="md:hidden flex gap-x-2 pr-5">
                        <span class="text-gray-300 text-xs mr-0 mt-1">10</span>
                        <ArrowTrendingUpIcon class="h-4 w-4 text-gray-300 mr-3 ml-0 mt-1" aria-hidden="true"/>
                        <EllipsisVerticalIcon class="h-5 w-5 text-gray-500" aria-hidden="true"/>
                    </div>
                </dl>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
