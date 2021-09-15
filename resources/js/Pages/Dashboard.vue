<template>
    <app-layout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12 flex flex-col">
            <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                <div class="shadow overflow-hidden border-b bg-white border-gray-200 sm:rounded-lg">
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
                                    <span v-if="data.id === '#'" >
                                        <div :class="'rating-' + rating + ' flex items-center justify-center'">
                                            <em class="opacity-50">–</em>
                                        </div>
                                    </span>
                                    <span v-else>
                                        <a :href="route('bottles.show', data.id)">
                                        <div :class="'rating-' + rating + ' flex items-center justify-center'">
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
