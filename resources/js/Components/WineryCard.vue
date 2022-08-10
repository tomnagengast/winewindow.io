<template>
    <Link :href="route('wineries.show', winery)">
        <div class="max-w-4xl bg-white mb-4 px-8 py-8 rounded shadow-xl">
            <div class="text-2xl">{{ winery.name }}</div>
            <div class="font-bold text-gray-500">{{ bottles.length }} bottles over {{ vintages.length }} vintages</div>
        </div>
    </Link>
</template>

<script>
import {defineComponent} from 'vue'
import {Link} from "@inertiajs/inertia-vue3";
import {sortedUniq} from "lodash";

export default defineComponent({
    props: {
        winery: Object,
    },
    components: {
        Link
    },
    computed: {
        bottles() {
            return this.winery.owned_bottles
        },

        vintages() {
            const vintages = [...new Set(this.bottles.map(bottle => bottle.vintage))];
            return sortedUniq(vintages.sort((a, b) => a - b))
        },
    }
})
</script>
