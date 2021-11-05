<template>
    <Head title="Welcome" />

    <div class="px-4 sm:px-6 md:px-8 mb-14 sm:mb-20 xl:mb-8 max-w-7xl mx-auto text-gray-800">
        <div
            class="border-b border-gray-200 py-4 flex items-center flex-row-reverse justify-between mb-16 sm:mb-20 -mx-4 px-4 sm:mx-0 sm:px-0">
            <div class="flex items-center space-x-6 sm:space-x-10 ml-6 sm:ml-10 text-right content-end" v-if="canLogin">

                <Link v-if="$page.props.user" :href="route('dashboard')" class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                    Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')" class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                        Log In
                    </Link>

                    <Link v-if="canRegister" :href="route('register')" class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                        Register
                    </Link>
                </template>
            </div>
        </div>
        <jet-application-mark />
        <h1 class="text-4xl sm:text-6xl lg:text-7xl leading-none font-extrabold tracking-tight text-gray-800 mt-10 mb-8 sm:mt-14 sm:mb-10">
            Drink more wine. Now.</h1>
        <p class="max-w-screen-lg text-lg sm:text-2xl sm:leading-10 font-medium mb-10 sm:mb-11">Let's help you figure
            out which one 😘 </p>
        <div class="flex flex-wrap space-y-4 sm:space-y-0 sm:space-x-4 text-center"><a
            class="w-full sm:w-auto flex-none bg-gray-800 hover:bg-gray-700 text-white text-lg leading-6 font-semibold py-3 px-6 border border-transparent rounded-xl focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-900 focus:outline-none transition-colors duration-200"
            href="/dashboard">Hop into your cellar</a></div>
    </div>
</template>

<script>
import {defineComponent} from 'vue'
import JetApplicationMark from '@/Jetstream/ApplicationMark.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head,
        Link,
        JetApplicationMark
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    }
})
</script>
