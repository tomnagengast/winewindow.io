<template>
    <app-layout title="Wineries">
        <div class="flex flex-col items-center">
            <div>
                <div class="py-24 font-black text-4xl text-gray-800">Explore Wineries</div>
            </div>
            <div class="grid grid-cols-3 gap-4">
                <div v-for="winery in wineries">
                    <WineryCard :winery="winery"/>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import WineryCard from '@/Components/WineryCard'
import {Link} from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: {
        wineries: Object,
    },
    components: {
        AppLayout,
        WineryCard,
        Link,
    },
})
</script>
