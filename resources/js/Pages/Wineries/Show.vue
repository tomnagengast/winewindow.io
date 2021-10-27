<template>
    <app-layout title="Wineries">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ winery.name }}
            </h2>
        </template>

        <div class="max-w-xl mx-auto mt-4 flex flex-col">
            Aging Chart
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'

export default defineComponent({
    props: {
        winery: Object,
    },
    components: {
        AppLayout,
    },
})
</script>
