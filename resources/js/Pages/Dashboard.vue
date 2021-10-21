<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="max-w-7xl mx-auto mt-10 text-center" :style="showDefaultChart ? '' : 'overflow-x: scroll'">
            <!-- container -->
            <div ref="chart" class="inline-block mx-auto bg-white border-b shadow rounded-lg" style="padding: 1em">
                <!-- reset for greedy width -->
                <div class="flex m-4">
                    <div v-for="(v, header) in chartHeader" class="px-2">
                        <div class="py-2">{{ header }}</div>
                        <div v-for="(varietals, header) in v" class="py-1" style="white-space: nowrap">
                            <strong class="py-2">{{ varietals }}</strong>
                        </div>
                    </div>
                    <div v-for="col in chartData" class="px-2">
                        <div v-for="(data, header) in col" class="">
                            <div class="py-2">{{ header }}</div>
                            <span v-for="bottle in data">
                                <div v-if="bottle.id === '#'" class="py-1">
                                    <div :class="'rating-' + bottle.rating">
                                        <em class="opacity-50">–</em>
                                    </div>
                                </div>
                                <div v-else class="py-1">
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
import Bottle from '@/Pages/Bottles/Show.vue'
import {range, sortedUniq} from "lodash";
import {Link} from "@inertiajs/inertia-vue3";

export default defineComponent({
    props: {
        team: Object,
    },

    data() {
        return {
            windowWidth: window.innerWidth,
            defaultChartWidth: null,
            chartData: null,
            chartHeader: null,
        }
    },

    components: {
        AppLayout,
        Bottle,
        Link,
    },

    mounted() {
        this.$nextTick(() => {
            window.addEventListener('resize', this.onResize);
            this.setChartData()
        })
    },

    beforeUnmount() {
        window.removeEventListener('resize', this.onResize);
    },

    methods: {
        onResize() {
            this.windowWidth = window.innerWidth;
        },

        getVintages(bottles) {
            const vintages = [...new Set(bottles.map((bottle) => (bottle.vintage)))];
            return sortedUniq(vintages.sort(function (a, b) {
                return a - b;
            }))
        },

        getVarietals(bottles) {
            const varietals = [...new Set(bottles.map((bottle) => (bottle.varietal)))];
            return sortedUniq(varietals.sort())
        },

        setChartData() {
            const nullBottle = {id: '#', rating: "NA", varietal: "NA", vintage: null}
            const bottles = this.team.bottles;
            const vintages = this.getVintages(bottles);
            const varietals = this.getVarietals(bottles);
            this.chartData = [{'Varietals': varietals}];
            vintages.forEach(vintage => {
                let col = [];
                varietals.forEach(varietal => {
                    let b = bottles.filter(bottle => {
                        return bottle.vintage === vintage && bottle.varietal === varietal;
                    })
                    col.push(b.length > 0 ? b[0] : nullBottle);
                })
                let obj = {}
                obj[vintage] = col
                this.chartData.push(obj);
            })
            this.chartHeader = this.chartData.shift();
            this.$nextTick(function () {
                this.defaultChartWidth = this.$refs.chart.clientWidth;
            })
        },
    },

    computed: {
        showDefaultChart() {
            return this.defaultChartWidth < this.windowWidth;
        },
    }
})
</script>
