<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>


        <div class="py-12">

            <div class="overflow-x-scroll max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="mx-auto bg-white">
                    <table class="table-auto">
                        <thead>
                        <tr>
                            <th class="">Varietals</th>
                            <th v-for="vintage in vintages" class="w-12">{{ vintage }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(val, key) in chart.body">
                            <th class="">{{ key }}</th>
                            <td v-for="(v, k) in val">
                                    <span v-for="(data, rating) in v">
                                        <em v-if="data.id === '#'" class="rating-na">{{ rating }}</em>
                                        <span v-else>
                                            <a :href="route('bottles.show', data.id)">
<!--                                               data-hint='@{{id.bottle}} \u000A @{{id.key}}'-->
                                                <strong class="rating-{{ rating }}">{{ rating }}</strong>
                                            </a>
                                        </span>
                                    </span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
<!--            <div>-->
<!--                <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">-->
<!--                    <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">-->
<!--                        <div v-for="bottle in $page.props.team.bottles">-->
<!--                            <bottle :bottle="bottle"/>-->
<!--                        </div>-->
<!--                    </div>-->
<!--                </div>-->
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
    computed: {
        vintages() {
            return [...new Set(this.team.bottles.map((bottle) => (bottle.vintage)))].sort(function (a, b) {
                return a - b;
            });
        },
        varietals() {
            return [...new Set(this.team.bottles.map((bottle) => (bottle.varietal)))].filter(function (value, index, self) {
                return self.indexOf(value) === index;
            });
        },
    }
})
</script>
