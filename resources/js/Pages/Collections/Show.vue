<template>
    <app-layout title="Collections">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Collections
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div v-for="bottle in $page.props.collection.bottles">
                        <bottle :bottle="bottle"/>
                    </div>

                    <div class="flex">
                        <div v-html="qrCode" class="mx-auto"></div>
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
        collection: Object,
        qrCode: String,
    },
    components: {
        AppLayout,
        Bottle,
    },
})
</script>
