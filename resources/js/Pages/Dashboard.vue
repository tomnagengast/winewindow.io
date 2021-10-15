<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div>{{ windowWidth }}</div>
        <div>{{ defaultChartWidth }}</div>
        <div>{{ showDefaultChart }}</div>

        <!-- <div class="flex flex-col flex-nowrap max-w-7xl mx-auto py-10">-->
        <div class="max-w-7xl mx-auto py-10 text-center"> <!-- container -->
            <div ref="inlineChart" class="inline-block mx-auto"> <!-- reset for greedy width -->
                <div class="flex bg-white">
                    <div class="flex">
                        <div>Varietals</div>
                        <div v-for="vintage in vintages" class="px-2">{{ vintage }}</div>
                    </div>
                    <div class="flex">
                        <div v-for="(val, key) in chart.body">
                            <div>{{ key }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        <div class="py-12 flex flex-col flex-nowrap max-w-7xl mx-auto">
<!--            <div class="py-2 align-middle  sm:px-6 lg:px-8">-->
                <div class="shadow overflow-x-scroll border-b bg-white border-gray-200 sm:rounded-lg pb-4 pr-4">
                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th class="py-4">Varietals</th>
                            <th v-for="vintage in vintages" class="pr-4">{{ vintage }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(val, key) in chart.body">
                            <th class="px-4">{{ key }}</th>
                            <td v-for="(v, k) in val">
                                <span v-for="(data, rating) in v">
                                    <span v-if="data.id === '#'" >
                                        <div :class="'rating-' + rating + ' flex items-center justify-center rounded'">
                                            <em class="opacity-50">–</em>
                                        </div>
                                    </span>
                                    <span v-else>
                                        <a :href="route('bottles.show', data.id)">
                                        <div :class="'rating-' + rating + ' flex items-center justify-center rounded'">
                                                <strong>{{ rating }}</strong>
                                        </div>
                                    </a>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
<!--            </div>-->
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
        chart: Object,
    },
    components: {
        AppLayout,
        Bottle,
    },

    data() {
        return {
            windowWidth: window.innerWidth,
            defaultChartWidth: 0
        }
    },
    watch: {
        windowHeight(newHeight, oldHeight) {
            this.txt = `it changed to ${newHeight} from ${oldHeight}`;
        }
    },
    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
            this.defaultChartWidth = this.$refs.inlineChart.clientWidth;
        })
    },
    beforeDestroy() {
        window.removeEventListener('resize', this.onResize);
    },
    methods: {
        onResize() {
            this.windowWidth = window.innerWidth
        }
    },

    computed: {
        showDefaultChart() {
            return this.defaultChartWidth < this.windowWidth;
        },
        vintages() {
            return [...new Set(this.team.bottles.map((bottle) => (bottle.vintage)))].sort(function (a, b) {
                return a - b;
            }).unshift('Varietals');
        },
        varietals() {
            return [...new Set(this.team.bottles.map((bottle) => (bottle.varietal)))].filter(function (value, index, self) {
                return self.indexOf(value) === index;
            });
        },
    }
})
</script>
