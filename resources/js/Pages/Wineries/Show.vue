<template>
    <app-layout title="Wineries">
        <template #header></template>

        <div class="flex flex-col items-center">
            <div class="mb-6 text-center">
                <div class="font-black text-4xl text-gray-800">{{ team.name }}</div>
                <div class="font-bold text-gray-500">{{ bottles.length }} bottles over {{ vintages.length }} vintages</div>
            </div>
            <div>
                <div class="flex flex-row-reverse justify-between items-center">
                    <div class="relative inline-block text-left" v-if="!isWinery">
                        <div>
                            <button type="button" @click="updateSort" v-click-away="away"
                                class="inline-flex justify-center w-full rounded-md bg-gray-200 py-2 px-4 rounded-full text-sm font-medium text-gray-700 hover:bg-gray-300"
                                id="menu-button" aria-expanded="true" aria-haspopup="true">
                                {{ sortByWinery ? 'Sort by Winery' : 'Sort by Varietal' }}
                                <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path
                                        d="M3 3a1 1 0 000 2h11a1 1 0 100-2H3zM3 7a1 1 0 000 2h7a1 1 0 100-2H3zM3 11a1 1 0 100 2h4a1 1 0 100-2H3zM15 8a1 1 0 10-2 0v5.586l-1.293-1.293a1 1 0 00-1.414 1.414l3 3a1 1 0 001.414 0l3-3a1 1 0 00-1.414-1.414L15 13.586V8z" />
                                </svg>
                            </button>

                            <div
                                class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                v-show="showSortDropdown"
                                role="menu" aria-orientation="vertical" aria-labelledby="menu-button"
                                tabindex="-1">
                                <div class="py-1" role="none">
                                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="menu-item-0" @click="sortByWinery = true">Sort by Winery</a>
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50"
                                        role="menuitem"
                                        tabindex="-1"
                                        id="menu-item-1" @click="sortByWinery = false">Sort by Varietal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="max-w-7xl mx-auto mt-10 text-center" :style="showDefaultChart ? '' : 'overflow-x: scroll'">
            <!-- container -->
            <div ref="chart" class="inline-block mx-auto border border-2 shadow-xl border-gray-100 rounded-lg"
                style="padding: 1em">
                <!-- reset for greedy width -->
                <div class="flex m-4">
                    <div v-for="(v, header) in chartHeader" class="px-2">
                        <div class="py-2 font-bold text-gray-800">{{ header }}</div>
                        <div v-for="varietal in v" class="text-left" style="white-space: nowrap">
                            <div class="py-1">
                                <div class="font-bold text-gray-800">{{ varietal.varietal }}</div>
                                <div class="text-xs text-gray-500" v-if="!isWinery">{{ varietal.winery }}</div>
                            </div>
                        </div>
                    </div>
                    <div v-for="col in chartData" class="px-2">
                        <div v-for="(data, header) in col" class="">
                            <div class="py-2 font-bold text-gray-800">{{ header }}</div>
                            <span v-for="bottle in data">
                                <div v-if="bottle.id === '#'" :class="isWinery ? 'py-1' : 'py-3'">
                                    <div :class="'rating-' + bottle.rating">
                                        <em class="opacity-50">–</em>
                                    </div>
                                </div>
                                <div v-else :class="isWinery ? 'py-1' : 'py-3'">
                                    <Link :href="route('bottles.show', bottle)">
                                        <div :class="'rounded rating-' + bottle.rating">
                                            <strong>{{ bottle.rating ? bottle.rating : bottle }}</strong>
                                        </div>
                                    </Link>
                                </div>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link} from "@inertiajs/inertia-vue3";
import {sortedUniq} from "lodash";

export default defineComponent({
    props: {
        winery: Object,
        bottles: Object,
    },

    data() {
        return {
            windowWidth: window.innerWidth,
            defaultChartWidth: null,
            chartHeader: null,
        }
    },

    components: {
        AppLayout,
        Link,
    },

    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
            this.defaultChartWidth = this.$refs.chart.clientWidth;
        })
    },

    beforeUnmount() {
        window.removeEventListener('resize', this.onResize);
    },

    methods: {
        onResize() {
            this.windowWidth = window.innerWidth;
        },

        away() {
            this.showSortDropdown = false;
        },

        updateSort() {
            this.showSortDropdown = !this.showSortDropdown
        },
    },

    computed: {
        showDefaultChart() {
            return this.defaultChartWidth < this.windowWidth;
        },

        team() {
            return this.winery
        },

        isWinery() {
            return true
        },

        bottleList() {
            return this.bottles.slice(0, 4);
        },

        vintages() {
            const vintages = [...new Set(this.bottles.map(bottle => bottle.vintage))];
            return sortedUniq(vintages.sort((a, b) => a - b))
        },

        varietals() {
            let [first, second] = (!this.isWinery && this.sortByWinery) ? ['winery', 'varietal'] : ['varietal', 'winery']

            const bottles = [...new Set(this.bottles.map(bottle => ({'winery': bottle.team.name, 'varietal': bottle.varietal})))]
            return [...new Set(bottles.map((object) => JSON.stringify(object)))]
                .map((string) => JSON.parse(string))
                .sort((a, b) => (a[first] === b[first]) ? b[second] - a[second] : a[first] > b[first] ? 1 : -1)
        },

        chartData() {
            const nullBottle = {id: '#', rating: "NA", varietal: "NA", vintage: null}
            this.chartHeader = {'Varietals': this.varietals};
            let chartData = [];
            this.vintages.forEach(vintage => {
                let col = [];
                this.varietals.forEach(varietal => {
                    let b = this.bottles.filter(bottle => {
                        return bottle.vintage === vintage && bottle.team.name === varietal.winery && bottle.varietal === varietal.varietal
                    })
                    col.push(b.length > 0 ? b[0] : nullBottle);
                })
                let obj = {}
                obj[vintage] = col
                chartData.push(obj);
            })
            return chartData;
        },
    }
})
</script>
