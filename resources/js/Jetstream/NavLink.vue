<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>

<script>
    import { defineComponent } from 'vue'
    import { Link } from '@inertiajs/inertia-vue3';

    export default defineComponent({
        components: {
            Link,
        },
        props: ['href', 'active'],

        computed: {
            classes() {
                return this.active
                    ? 'inline-flex items-center px-1 pt-1 text-indigo-600 text-md font-bold leading-5 focus:outline-none transition'
                    : 'inline-flex items-center px-1 pt-1 text-md font-medium leading-5 text-gray-500 hover:text-gray-700 hover:text-indigo-600 focus:outline-none focus:text-indigo-600  transition'
            }
        }
    })
</script>
