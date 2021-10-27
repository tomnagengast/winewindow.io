<template>
    <Head title="Welcome" />

    <div class="px-4 sm:px-6 md:px-8 mb-14 sm:mb-20 xl:mb-8 max-w-7xl mx-auto">
        <div
            class="border-b border-gray-200 py-4 flex items-center justify-between mb-16 sm:mb-20 -mx-4 px-4 sm:mx-0 sm:px-0">
            <div class="flex items-center space-x-6 sm:space-x-10 ml-6 sm:ml-10 text-right content-end" v-if="canLogin">

                <Link v-if="$page.props.user" :href="route('dashboard')" class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                    Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')" class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                        Log in
                    </Link>

                    <Link v-if="canRegister" :href="route('register')" class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                        Register
                    </Link>
                </template>
            </div>
        </div>
        <div class="text-2xl sm:text-4xl sm:leading-10 font-medium mb-10 sm:mb-11">
<!--            <img src="https://winewindow-local.s3.us-west-1.amazonaws.com/assets/ww-logo-icon.png" alt="Wine Window Logo" width="30" class="inline-block">-->
            WineWindow
        </div>
        <h1 class="text-4xl sm:text-6xl lg:text-7xl leading-none font-extrabold tracking-tight text-gray-900 mt-10 mb-8 sm:mt-14 sm:mb-10">
            Drink more wine. Now.</h1>
        <p class="max-w-screen-lg text-lg sm:text-2xl sm:leading-10 font-medium mb-10 sm:mb-11">Let's help you figure
            out which one 😘 </p>
        <div class="flex flex-wrap space-y-4 sm:space-y-0 sm:space-x-4 text-center"><a
            class="w-full sm:w-auto flex-none bg-gray-900 hover:bg-gray-700 text-white text-lg leading-6 font-semibold py-3 px-6 border border-transparent rounded-xl focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-900 focus:outline-none transition-colors duration-200"
            href="/docs">Hop into your cellar</a></div>
    </div>
    <!--    </div>-->
</template>

<style scoped>
.bg-gray-100 {
    background-color: #f7fafc;
    background-color: rgba(247, 250, 252, var(--tw-bg-opacity));
}

.border-gray-200 {
    border-color: #edf2f7;
    border-color: rgba(237, 242, 247, var(--tw-border-opacity));
}

.text-gray-400 {
    color: #cbd5e0;
    color: rgba(203, 213, 224, var(--tw-text-opacity));
}

.text-gray-500 {
    color: #a0aec0;
    color: rgba(160, 174, 192, var(--tw-text-opacity));
}

.text-gray-600 {
    color: #718096;
    color: rgba(113, 128, 150, var(--tw-text-opacity));
}

.text-gray-700 {
    color: #4a5568;
    color: rgba(74, 85, 104, var(--tw-text-opacity));
}

.text-gray-900 {
    color: #1a202c;
    color: rgba(26, 32, 44, var(--tw-text-opacity));
}

@media (prefers-color-scheme: dark) {
    .dark\:bg-gray-800 {
        background-color: #2d3748;
        background-color: rgba(45, 55, 72, var(--tw-bg-opacity));
    }

    .dark\:bg-gray-900 {
        background-color: #1a202c;
        background-color: rgba(26, 32, 44, var(--tw-bg-opacity));
    }

    .dark\:border-gray-700 {
        border-color: #4a5568;
        border-color: rgba(74, 85, 104, var(--tw-border-opacity));
    }

    .dark\:text-white {
        color: #fff;
        color: rgba(255, 255, 255, var(--tw-text-opacity));
    }

    .dark\:text-gray-400 {
        color: #cbd5e0;
        color: rgba(203, 213, 224, var(--tw-text-opacity));
    }
}
</style>

<script>
import {defineComponent} from 'vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

export default defineComponent({
    components: {
        Head,
        Link,
    },

    props: {
        canLogin: Boolean,
        canRegister: Boolean,
    }
})
</script>
