<template>
    <app-layout title="Collections">
        <template #header></template>


        <div class="flex flex-col items-center mt-24">
            <div class="text-center space-y-2 mb-4">
                <div class="inline-flex px-4 py-2 text-lg font-bold rounded-full" :class="'rating-' + bottle.rating">
                    {{ ratingText }}
                </div>
                <div class="font-black text-4xl text-gray-800 pt-2">{{ bottle.vintage }} {{ bottle.varietal }}</div>
                <Link :href="route('wineries.show', bottle.team_id)"
                    class="font-semibold text-2xl text-gray-600">
                    {{ bottle.winery }}
                </Link>
            </div>

            <button @click="toggleFollow" v-if="! ownedByViewer">
                <div class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4"
                     :class="isFollowing ? 'bg-gray-200' : ''">
                    {{ isFollowing ? 'Following' : 'Follow' }}
                </div>
            </button>

        </div>
        <div class="pt-4 pb-12">
            <div class="max-w-2xl mx-auto sm:px-6 lg:px-8 p-4">
                <div>{{ bottle.description }}</div>
            </div>
        </div>
    </app-layout>
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
    },
    data() {
        return {
            isFollowing: false,
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
        ownedByViewer() {
            return this.$page.props.user.current_team.name === this.bottle.team.name
        }
    },
    methods: {
        toggleFollow() {
            this.isFollowing = ! this.isFollowing
        }
    },
})
</script>
