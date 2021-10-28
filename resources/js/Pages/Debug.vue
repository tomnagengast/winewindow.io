<template>
    <div class="flex flex-col justify-center items-center min-h-screen font-sans">
        <div class="p-4 w-full mx-auto text-center">
            <div class="font-black xl:text-9xl lg:text-8xl md:text-7xl text-6xl">Paso Nose Sniffers</div>
            <div class="w-full m-auto">
                <div class="text-xl md:text-2xl font-bold pt-6 pb-10 text-gray-500">The most exclusive wine group in the world.</div>
                <div><strong>Invitation only</strong>, apply for membership below.</div>
                <div>
                    Names move from the waiting list onto the active list on a <br>
                     first come first serve basis.
                </div>
            </div>
        </div>
        <div class="p-4 border rounded shadow-xl w-full max-w-md">
            <form name="contact" method="POST" data-netlify="true">
                <div>
                    <div class="pt-2 pb-1">Name</div>
                    <div><input type="text" name="name" class="rounded border-none bg-purple-100 w-full" /></div>
                </div>
                <div>
                    <div class="pt-2 pb-1">Email</div>
                    <div><input type="email" name="email" class="rounded border-none bg-purple-100 w-full" /></div>
                </div>
                <div>
                    <div class="pt-2 pb-1">Message</div>
                    <textarea name="message" class="rounded border-none bg-purple-100 w-full"></textarea>
                </div>
                <button type="submit"
                    class="inline-flex items-center min-w-full bg-purple-600 rounded justify-center py-2 text-white font-bold text-xl space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                        class="feather feather-mail">
                        <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                        <polyline points="22,6 12,13 2,6"></polyline>
                    </svg>
                    <span>Apply Now</span>
                </button>
            </form>
        </div>
    </div>
</template>
