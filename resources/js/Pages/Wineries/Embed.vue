<template>
    <div class="max-w-7xl mt-4 mx-auto text-center" :style="showDefaultChart ? '' : 'overflow-x: scroll'">
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
                                    <Link :href="route('bottles.show.embed', [bottle.team, bottle])">
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
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link} from "@inertiajs/inertia-vue3";
import {sortedUniq} from "lodash";
import {mixin as clickaway} from "vue3-click-away";

export default defineComponent({
    mixins: [clickaway],

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
