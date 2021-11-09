<template>
    <app-layout title="Collections">
        <template #header></template>

        <form @submit.prevent="submit">
            <div class="flex flex-col mt-24 max-w-xl m-auto">
                <label for="vintage">Vintage</label>
                <input id="vintage" v-model="form.vintage" class="mb-4 border rounded px-2 py-3"/>
                <label for="varietal">Varietal</label>
                <input id="varietal" v-model="form.varietal" class="mb-4 border rounded px-2 py-3"/>
                <label for="rating">Rating</label>
                <input id="rating" v-model="form.rating" class="mb-4 border rounded px-2 py-3"/>
                <TrixEditor id="description" :content="form.description" @dataFromTrix="getDataFromTrix" class="my-4" placeholder="Description" />



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
import {Link} from '@inertiajs/inertia-vue3'
import TrixEditor from "@/Components/TrixEditor"

export default defineComponent({
    components: {
        AppLayout,
        Link,
        TrixEditor,
    },
    props: {
        bottle: Object,
        following: Object,
    },
    data() {
        return {
            form: this.$inertia.form({
                vintage: this.bottle.vintage,
                varietal: this.bottle.varietal,
                rating: this.bottle.rating,
                description: this.bottle.description,
            }),
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
        },
    },
    methods: {
        submit() {
            this.$inertia.post(`/bottles/${this.bottle.id}/update`, this.form)
        },
        getDataFromTrix: function(data) {
            this.form.description = data;
        }
    },
})
</script>
