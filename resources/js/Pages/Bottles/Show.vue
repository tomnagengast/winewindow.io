<template>
    <app-layout title="Collections">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight flex">
                <span :class="'inline-flex items-center justify-center px-2 py-1 mr-2 text-sm font-bold leading-none text-green-100 bg-green-500 rounded-full rating-' + bottle.rating">{{ bottle.rating }}</span>
                {{ bottle.vintage }} {{ bottle.varietal }}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
                <a :href="route('bottles.show', [bottle.team_id, bottle.id])">
                    <div>{{ bottle.description }}</div>
                </a>
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
