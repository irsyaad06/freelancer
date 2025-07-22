<template>
    <div class="max-w-screen-xl mx-auto p-4 mt-10 pt-10">
        <div>
            <div class="flex">
                <span class="text-3xl mr-2 font-semibold">Desain</span>
                <span class="text-3xl font-semibold">Logo</span>
            </div>
        </div>

        <div class="mt-3 mb-2">
            <Avatar />
        </div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="col-span-3 flex flex-col gap-4">
                <div>
                    <Carousel />
                </div>
                <div id="default-styled-tab-content">
                    <span class="text-2xl font-semibold p-2">Detail Services</span>
                    <div class="p-2">
                        <div
                            class="hidden"
                            id="styled-dashboard"
                            role="tabpanel"
                            aria-labelledby="settings-tab"
                        >
                            <p>
                                Hi is some placeholder content the Dashboard
                                tab's associated content. Clicking another tab
                                will toggle the visibility of this one for the
                                next. The tab JavaScript swaps classes to
                                control the content visibility and styling.This
                                is some placeholder content the Dashboard tab's
                                associated content. Clicking another tab will
                            </p>
                        </div>
                        <div
                            class="hidden"
                            id="styled-settings"
                            role="tabpanel"
                            aria-labelledby="settings-tab"
                        >
                            <p>
                                This is some placeholder content the Dashboard
                                tab's associated content. Clicking another tab
                                will toggle the visibility of this one for the
                                next. The tab JavaScript swaps classes to
                                control the content visibility and styling.This
                                is some placeholder content the Dashboard tab's
                                associated content. Clicking another tab will
                                toggle the visibility of this one for the next.
                                The tab JavaScript swaps classes to control the
                                content visibility and styling.This is some
                                placeholder content the Dashboard tab's
                                associated content. Clicking another tab will
                                toggle the visibility of this one for the next.
                                The tab JavaScript swaps classes to control the
                                content visibility and styling.
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col">
                <div>
                    <Tabs />
                </div>
                <div class="mt-2 pl-3 w-full flex items-end">
                    <button
                        @click=""
                        class="w-full inline-flex justify-center px-4 py-2 text-sm font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer"
                    >
                        Rekrut
                    </button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import Avatar from "../components/Avatar.vue";
import Carousel from "../components/Carousel.vue";
import Tabs from "../components/Tabs.vue";
</script>
