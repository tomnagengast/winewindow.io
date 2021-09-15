<template>
    <app-layout title="Collections">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Collections
            </h2>
        </template>

        <div class="py-12">
            <div v-html="qrCode"></div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-for="collection in $page.props.collections">
                        <a :href="route('collections.show', collection.id)">
                            <div>{{ collection.name }}</div>
                            <div>{{ collection.bottles.length }} bottles</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import Bottle from '@/Pages/Bottles/Show.vue'

export default defineComponent({
    props: {
        team: Object,
        qrCode: String,
    },
    components: {
        AppLayout,
        Bottle,
    },
})
</script>
