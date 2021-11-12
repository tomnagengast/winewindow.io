<template>
    <Head title="Welcome" />

    <div class="px-4 sm:px-6 md:px-8 mb-14 sm:mb-20 xl:mb-8 max-w-7xl mx-auto text-gray-800">
        <div
            class="border-b border-gray-200 py-4 flex items-center flex-row justify-between mb-16 sm:mb-20 -mx-4 px-4 sm:mx-0 sm:px-0">
            <jet-application-mark />
            <div class="flex items-center space-x-6 sm:space-x-10 ml-6 sm:ml-10 text-right content-end" v-if="canLogin">

                <Link v-if="$page.props.user" :href="route('dashboard')"
                    class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                    Dashboard
                </Link>

                <template v-else>
                    <Link :href="route('login')"
                        class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                        Log In
                    </Link>

                    <Link v-if="canRegister" :href="route('register')"
                        class="text-base leading-6 font-medium hover:text-gray-600 transition-colors duration-200 py-2">
                        Sign Up
                    </Link>
                </template>
            </div>
        </div>
        <div class="flex items-center justify-center mt-10 md:flex-row flex-col-reverse flex-col">
            <div class="w-full md:w-1/2 md:pl-10 md:pr-8 text-center md:text-left">
                <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-gray-800 mb-8 sm:mt-14 sm:mb-10">
                    Connecting Wineries with Winos
                </h1>
                <p class="max-w-screen-lg sm:text-xl sm:leading-8 font-medium text-gray-700 mb-10 sm:mb-11">
                    With the first every interactive aging chart, wineries keep their customers informed
                    as their wines age, when they win awards, and when they're at their best.
                </p>
                <div class="flex flex-wrap space-y-4 sm:space-y-0 sm:space-x-4 text-center">
                    <a href="/dashboard"
                        class="w-full sm:w-auto flex-none bg-indigo-600 hover:bg-indigo-500 text-white text-lg leading-6 font-semibold py-3 px-6 border border-transparent rounded focus:ring-2 focus:ring-offset-2 focus:ring-offset-white focus:ring-gray-900 focus:outline-none transition-colors duration-200"
                    >Hop into your cellar
                    </a>
                </div>
            </div>
            <div class="w-2/3 md:w-1/2 pb-12">
                <img class="rounded" src="/img/hero-4.png" alt="Girl drinking wine surrounded by bubbles">
            </div>
        </div>
        <div class="flex max-w-xl mx-auto my-24 justify-between">
            <div>First ever interactive aging chart for wineries.</div>
            <div>
                <!-- chart -->
                <div class="border-gray-300  flex px-4 rounded-3xl space-x-2">
                    <!-- row -->
                    <div class="space-y-2">
                        <div class="bg-gray-200 w-10 h-4 rounded"></div>
                        <div class="bg-gray-200 w-16 h-4 rounded"></div>
                        <div class="bg-gray-200 w-14 h-4 rounded"></div>
                        <div class="bg-gray-200 w-8 h-4 rounded"></div>
                        <div class="bg-gray-200 w-12 h-4 rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="rating-3 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="bg-gray-500 w-6 h-4 rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="rating-4 w-6 h-4 rounded"></div>
                        <div class="rating-3 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="rating-4 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="rating-2 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="rating-3 w-6 h-4 rounded"></div>
                        <div class="rating-2 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                    </div>
                    <div class="space-y-2">
                        <div class="rating-1 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="rating-2 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                        <div class="bg-gray-200 w-6 h-4 rounded"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="flex max-w-xl mx-auto my-24 justify-between">
            <div>Instantly notify customer of new awards and updates to bottle ratings and notes.</div>
            <div>
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </div>
        </div>
    </div>
    <div class="bg-gray-800 text-white py-24 max-w-full">
        <div class="max-w-7xl mx-auto flex justify-between px-8">
            <div class="space-y-4 md:w-72">
                <div class="flex text-lg sm:text-2xl sm:leading-10 font-medium items-center space-x-2 text-white">
                    <div class="w-6">
                        <svg viewBox="0 0 198 198" width="100%" xmlns="http://www.w3.org/2000/svg"
                            xmlns:xlink="http://www.w3.org/1999/xlink">
                            <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                                <path
                                    d="M150.969581,157.165981 C166.94472,142.882805 177,122.115671 177,99 C177,66.0931686 156.622387,37.9457837 127.797655,26.4883405 C127.649431,34.789565 127.435649,67.3169014 132.361531,95.0254504 C137.703872,125.076616 148.065353,150.421995 150.969581,157.165981 Z M47.5674764,157.641756 C50.1502236,151.701028 60.9039138,125.836654 66.3813702,95.0254504 C71.366469,66.9838041 71.0875875,34.0068162 70.939938,26.1995155 C41.7258545,37.467144 21,65.8131806 21,99 C21,122.373643 31.2809678,143.346037 47.5674764,157.641756 Z M99,198 C44.3238098,198 0,153.67619 0,99 C0,44.3238098 44.3238098,0 99,0 C153.67619,0 198,44.3238098 198,99 C198,153.67619 153.67619,198 99,198 Z"
                                    id="Combined-Shape" fill="#ffffff"></path>
                            </g>
                        </svg>
                    </div>
                    <div>winewindow</div>
                </div>
                <div>Wine Window is the first ever interactive aging chart for wineries.</div>
                <div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
            </div>
            <div class="flex space-x-12">
                <div class="space-y-2 w-48">
                    <div class="font-semibold">Product</div>
                    <div>Features</div>
                    <div>FAQ</div>
                </div>
                <div class="space-y-2 w-48">
                    <div class="font-semibold">Contact</div>
                    <div>Support</div>
                    <div>Sales</div>
                    <div>Report abuse</div>
                    <div>Share your ideas</div>
                </div>
                <div class="space-y-2 w-48">
                    <div class="font-semibold">Company</div>
                    <div>About</div>
                    <div>Support</div>
                    <div>Media kit</div>
                    <div>Terms of service</div>
                    <div>Privacy policy</div>
                </div>
            </div>
        </div>
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
