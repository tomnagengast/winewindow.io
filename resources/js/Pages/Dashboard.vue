<template>
    <app-layout title="Dashboard">
        <template #header></template>

        <div class="flex flex-col items-center">
            <div class="mb-6 text-center">
                <div class="font-black text-4xl text-gray-800">{{ team.name }}</div>
                <div class="mb-4"><a class="text-md text-gray-400" :href="'https://winewindow.io/' + team.slug" target="_blank">https://winewindow.io/{{
                        team.slug }}</a></div>
                <div v-if="hasBottles" class="font-bold text-gray-500">{{ bottles.length }} bottles over
                    {{ vintages.length }} vintages
                </div>
                <Link :href="route('bottles.create', team)" id="create-bottle" v-if="$props.team.type === 'winery'"
                    class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4 mt-4">
                Add bottle
                </Link>
            </div>
            <div class="w-full max-w-lg">
                <div v-if="! hasBottles" class="text-center">
                    <div class="font-semibold text-gray-700 pb-4">
                        <span v-if="team.type === 'winery'">You haven't added any bottles yet!</span>
                        <span v-else>You're not following any bottles yet!</span>
                    </div>
                    <div class="pb-4">Here are some wineries you might be interested in</div>
                    <div class="flex justify-between">
                        <Link :href="route('wineries.show', 'cinquain-cellars')">
                        <div class="border rounded px-8 py-4">
                            <div>Cinquain Cellars</div>
                            <div>Paso Robles, California</div>
                        </div>
                        </Link>
                        <Link :href="route('wineries.show', 'bajka-wine-company')">
                        <div class="border rounded px-8 py-4">
                            <div>Bajka Wine Company</div>
                            <div>Paso Robles, California</div>
                        </div>
                        </Link>
                    </div>
                </div>
                <div v-if="hasBottles" class="flex flex-row-reverse justify-between items-center">
                    <div class="relative inline-block text-left" v-if="!isWinery">
                        <div>
                            <div class="flex items-center">
                                Sort by
                                <!--                                grid grid-cols-2 divide-x divide-green-500 p-2 border-->
                                <div class="mx-2">
                                    <button class="p-2 border border border-r-0 rounded-l"
                                        :class="sortByWinery ? 'bg-indigo-600 border-indigo-600 text-white': 'hover:bg-indigo-600 hover:border-indigo-600 hover:text-white'"
                                        @click="sortByWinery = true">Winery</button>
                                    <button class="p-2 border border border-l-0 rounded-r"
                                        :class="!sortByWinery ? 'bg-indigo-600 border-indigo-600 text-white': 'hover:bg-indigo-600 hover:border-indigo-600 hover:text-white'"
                                        @click="sortByWinery = false">Varietal</button>
                                </div>
                            </div>

                            <div class="origin-top-right absolute right-0 mt-2 w-56 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 focus:outline-none"
                                v-show="showSortDropdown" role="menu" aria-orientation="vertical"
                                aria-labelledby="menu-button" tabindex="-1">
                                <div class="py-1" role="none">
                                    <!-- Active: "bg-gray-100 text-gray-900", Not Active: "text-gray-700" -->
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50"
                                        role="menuitem" tabindex="-1" id="menu-item-0" @click="sortByWinery = true">Sort
                                        by Winery</a>
                                    <a href="#" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-50"
                                        role="menuitem" tabindex="-1" id="menu-item-1"
                                        @click="sortByWinery = false">Sort by Varietal</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="hasBottles" class="max-w-7xl mx-auto mt-4 text-center"
            :style="showDefaultChart ? '' : 'overflow-x: scroll'">
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
                                    <Link :href="route('bottles.show', [bottle.team.slug, bottle])">
                                    <div :class="'rounded active-bottle rating-' + bottle.rating">
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
import Bottle from '@/Pages/Bottles/Show.vue'
import {range, sortedUniq} from "lodash"
import {Link} from "@inertiajs/inertia-vue3"
import {mixin as clickaway} from "vue3-click-away"

export default defineComponent({
    mixins: [clickaway],

    props: {
        team: Object,
        bottles: Object,
    },

    data() {
        return {
            windowWidth: window.innerWidth,
            defaultChartWidth: null,
            chartHeader: null,
            sortByWinery: true,
            showSortDropdown: false,
            winery: this.team
        }
    },

    components: {
        AppLayout,
        Bottle,
        Link,
    },

    mounted() {
        this.$nextTick(() => {
            if (this.bottles.length > 0) {
                window.addEventListener('resize', this.onResize)
                this.defaultChartWidth = this.$refs.chart.clientWidth
            }
        })
    },

    beforeUnmount() {
        window.removeEventListener('resize', this.onResize)
    },

    methods: {
        onResize() {
            this.windowWidth = window.innerWidth
        },

        away() {
            this.showSortDropdown = false
        },

        updateSort() {
            this.showSortDropdown = !this.showSortDropdown
        },
    },

    computed: {
        showDefaultChart() {
            return this.defaultChartWidth < this.windowWidth
        },

        isWinery() {
            return this.team.type === 'winery'
        },

        bottleList() {
            return this.bottles.slice(0, 4)
        },

        hasBottles() {
            return this.bottles.length > 0
        },

        vintages() {
            const vintages = [...new Set(this.bottles.map(bottle => bottle.vintage))]
            return sortedUniq(vintages.sort((a, b) => a - b))
        },

        varietals() {
            // TODO need to figure out why this isn't sorty winery > varietals correctly
            let [first, second] = (!this.isWinery && this.sortByWinery) ? ['winery', 'varietal'] : ['varietal', 'winery']

            const bottles = [...new Set(this.bottles.map(bottle => ({
                'winery': bottle.team.name,
                'varietal': bottle.varietal
            })))]
            return [...new Set(bottles.map((object) => JSON.stringify(object)))]
                .map((string) => JSON.parse(string))
                .sort((a, b) => (a[first] === b[first]) ? b[second] - a[second] : a[first] > b[first] ? 1 : -1)
        },

        chartData() {
            const nullBottle = {id: '#', rating: "NA", varietal: "NA", vintage: null}
            this.chartHeader = {'Varietals': this.varietals}
            let chartData = []
            this.vintages.forEach(vintage => {
                let col = [];
                this.varietals.forEach(varietal => {
                    let b = this.bottles.filter(bottle => {
                        return bottle.vintage === vintage && bottle.team.name === varietal.winery && bottle.varietal === varietal.varietal
                    })
                    col.push(b.length > 0 ? b[0] : nullBottle)
                })
                let obj = {}
                obj[vintage] = col
                chartData.push(obj)
            })
            return chartData
        },
    }
})
</script>
