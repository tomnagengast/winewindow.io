<template>
    <app-layout title="Wineries">
        <template #header>
<!--            <h2 class="font-semibold text-xl text-gray-800 leading-tight">-->
<!--                Wineries-->
<!--            </h2>-->
        </template>

        <div id="feed" class="flex">
            <div id="feed-sidebar" class="">
                <div id="feed-sidebar-featured" class="">
                    <h1>Featured wineries</h1>
                    <div>Bajka Wine Company</div>
                    <div>Cinquain Cellars</div>
                </div>
                <div id="feed-sidebar-trending" class="">
                    <h1>Trending wineries</h1>
                    <div>Bajka Wine Company</div>
                    <div>Cinquain Cellars</div>
                </div>
                <div id="feed-sidebar-recently-updated" class="">
                    <h1>Recently updated</h1>
                    <div>2013 Cabernet Sauvignon</div>
                    <div>2006 Syrah</div>
                </div>
            </div>
            <div id="feed-main">
                <div>New award</div>
                <div>New description</div>
                <div>New tasting notes</div>
                <div>New bottles added</div>
            </div>
        </div>
<!--        <div class="max-w-xl mx-auto mt-4 flex flex-col">-->
<!--            <Link :href="route('wineries.show', winery)" v-for="winery in wineries" class="max-w-4xl bg-white mb-4 px-4 py-2 rounded shadow">-->
<!--                <div class="text-2xl">{{ winery.name }}</div>-->
<!--                <div class="text-gray-500 font-bold">{{ winery.owned_bottles.length }} bottles</div>-->
<!--            </Link>-->
<!--        </div>-->
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link} from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: {
        wineries: Object,
    },
    components: {
        AppLayout,
        Link,
    },
})
</script>
