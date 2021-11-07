<template>
    <app-layout title="Collections">
        <template #header></template>

        <form @submit.prevent="submit">
            <div class="flex flex-col mt-24 max-w-xl m-auto">
                <label for="vintage">Vintage</label>
                <input id="vintage" v-model="bottle.vintage" class="mb-4 border rounded px-2 py-3"/>
                <label for="varietal">Varietal</label>
                <input id="varietal" v-model="bottle.varietal" class="mb-4 border rounded px-2 py-3"/>
                <label for="rating">Rating</label>
                <input id="rating" v-model="bottle.rating" class="mb-4 border rounded px-2 py-3"/>
                <label>Description</label>
                <textarea id="description" v-model="bottle.description" class="mb-4 border rounded px-2 py-3 min-h-15"></textarea>

                <div class="flex space-x-2 justify-between">
                    <div>
                        <button type="submit"
                            class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4 mr-4">
                            Save
                        </button>
                        <Link as="button" type="button" :href="route('bottles.show', bottle.id)">
                            <div class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4">
                                Cancel
                            </div>
                        </Link>
                    </div>
                    <div>
                        <Link as="button" type="button" id="delete" :href="route('bottles.destroy', bottle.id)">
                            <div class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4">
                                Delete
                            </div>
                        </Link>
                    </div>
                </div>
            </div>
        </form>
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
        following: Object,
    },
    data() {
        return {
            form: {
                vintage: null,
                varietal: null,
                rating: null,
                description: null,
            },
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
            const bottleIds = this.following.map(bottle => bottle.id)
            return bottleIds.includes(this.bottle.id)
        },
        ownedByViewer() {
            return this.$page.props.user.current_team.name === this.bottle.team.name
        },
    },
    methods: {
        submit() {
            this.$inertia.post(`/bottles/${this.bottle.id}/update`, this.bottle)
        },
    },
})
</script>
