<template>
    <app-layout title="Wineries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Wineries
            </h2>
        </template>

        <div class="max-w-xl mx-auto mt-4 flex flex-col">
            <a :href="route('wineries.show', winery)" v-for="winery in wineries" class="max-w-4xl bg-white mb-4 px-4 py-2 rounded shadow">
                <div class="text-2xl">{{ winery.name }}</div>
                <div class="text-gray-500 font-bold">{{ winery.bottles.length }} bottles</div>
            </a>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    props: {
        wineries: Object,
    },
    components: {
        AppLayout,
    },
})
</script>
