<template>
    <app-layout title="Collections">
        <template #header></template>

        <form @submit.prevent="submit">
            <div class="flex flex-col mt-24 max-w-xl m-auto">
                <validation-errors />
                <label for="vintage">Vintage</label>
                <input id="vintage" v-model="form.vintage" class="mb-4 border rounded px-2 py-3"/>
                <label for="varietal">Varietal</label>
                <input id="varietal" v-model="form.varietal" class="mb-4 border rounded px-2 py-3"/>
                <label for="rating">Rating</label>
                <input id="rating" v-model="form.rating" class="mb-4 border rounded px-2 py-3"/>
                <label>Description</label>
                <textarea id="description" v-model="form.description" class="mb-4 border rounded px-2 py-3 min-h-15"></textarea>

                <div class="flex space-x-2 justify-center">
                    <button type="submit" id="save"
                        class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4">
                        Save
                    </button>
                    <Link as="button" type="button" :href="route('dashboard')">
                        <div class="inline-block text-sm border border-gray-200 text-gray-500 font-bold rounded-lg px-12 py-4">
                            Cancel
                        </div>
                    </Link>
                </div>
            </div>
        </form>
    </app-layout>
</template>

<script>
import {defineComponent} from 'vue'
import AppLayout from '@/Layouts/AppLayout.vue'
import {Link} from "@inertiajs/inertia-vue3";
import ValidationErrors from "../../Jetstream/ValidationErrors";

export default defineComponent({
    components: {
        AppLayout,
        Link,
        ValidationErrors,
    },
    data() {
        return {
            form: this.$inertia.form({
                vintage: '',
                varietal: '',
                rating: '',
                description: '',
            }),
        }
    },
    methods: {
        submit() {
            this.$inertia.post(`/wineries/${this.$page.props.user.current_team.id}/bottles/store`, this.form)
        },
    },
})
</script>
