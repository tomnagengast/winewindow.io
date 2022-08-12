<template>
        <div class="flex flex-col items-center mt-8">
            <div class="text-center space-y-2 mb-4">
                <div class="inline-flex px-4 py-2 text-lg font-bold rounded-full" :class="'rating-' + bottle.rating">
                    {{ ratingText }}
                </div>
                <div class="font-black text-4xl text-gray-800 pt-2">{{ bottle.vintage }} {{ bottle.varietal }}</div>
                <Link :href="route('wineries.show.embed', bottle.team)"
                    class="font-semibold text-2xl text-gray-600">
                    {{ bottle.winery }}
                </Link>
            </div>
        </div>
        <div class="pt-4 pb-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 p-4">
                <div class="trix-content" v-html="bottle.description"></div>
            </div>
        </div>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link} from "@inertiajs/inertia-vue3";

export default defineComponent({
    components: {
        AppLayout,
        Link,
    },
    props: {
        bottle: Object,
        following: Object,
    },
    data() {
        return {
            auth: this.$page.props.user
        }
    },
    computed: {
        ratingText() {
            const mappings = {
                1: 'Very Youthful',
                2: 'Youthful',
                3: 'Prime',
                4: 'Prime Plus',
                5: 'Mature',
            }
            return mappings[this.bottle.rating]
        },
        isFollowing() {
            return this.auth ? this.following.map(bottle => bottle.id).includes(this.bottle.id) : null
        },
        ownedByViewer() {
            return this.auth && this.$page.props.user.current_team.name === this.bottle.team.name
        },
    },
    methods: {
        //
    },
})
</script>
