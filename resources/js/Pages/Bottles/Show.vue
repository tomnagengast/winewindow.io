<template>
    <app-layout title="Collections">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex justify-between">
                <div>
                    <span
                        :class="'inline-flex items-center justify-center px-2 py-1 mr-2 text-sm font-bold leading-none text-green-100 bg-green-500 rounded-full rating-' + bottle.rating">{{
                            bottle.rating
                        }}</span>
                    {{ bottle.vintage }} {{ bottle.varietal }}
                </div>
            </h2>
        </template>

        <div class="pt-4 pb-12">
            <div class="mx-auto max-w-7xl mb-4">
                <div class="inline-block text-sm border bg-purple-600 text-white font-bold rounded-lg px-4 py-2">Follow</div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white border-b shadow rounded-lg p-4">
                <div class="font-black pb-2">Notes</div>
                <div>{{ bottle.description }}</div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    props: {
        bottle: Object,
    },
    components: {
        AppLayout,
    },
})
</script>
