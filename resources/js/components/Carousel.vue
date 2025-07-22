<template>
    <div id="controls-carousel" class="relative w-full" data-carousel="static">
        <!-- Carousel wrapper -->
        <div class="relative h-56 overflow-hidden rounded-lg md:h-96">
            <!-- Item 1 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img
                    src="https://images.unsplash.com/photo-1551434678-e076c223a692?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="Modern workspace with laptop and coding setup"
                />
            </div>
            <!-- Item 2 -->
            <div
                class="hidden duration-700 ease-in-out"
                data-carousel-item="active"
            >
                <img
                    src="https://images.unsplash.com/photo-1522071820081-009f0129c71c?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="Team collaboration in modern office"
                />
            </div>
            <!-- Item 3 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img
                    src="https://images.unsplash.com/photo-1552664730-d307ca884978?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="Business meeting presentation"
                />
            </div>
            <!-- Item 4 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img
                    src="https://images.unsplash.com/photo-1559136555-9303baea8ebd?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="Creative workspace with design tools"
                />
            </div>
            <!-- Item 5 -->
            <div class="hidden duration-700 ease-in-out" data-carousel-item>
                <img
                    src="https://images.unsplash.com/photo-1557804506-669a67965ba0?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=2070&q=80"
                    class="absolute block w-full -translate-x-1/2 -translate-y-1/2 top-1/2 left-1/2"
                    alt="Modern office space with city view"
                />
            </div>
        </div>
        <!-- button controller -->
        <div
            class="absolute z-30 flex -translate-x-1/2 bottom-5 left-1/2 space-x-3 rtl:space-x-reverse"
        >
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/30 aria-[current=true]:bg-white/70 transition"
                aria-current="true"
                aria-label="Slide 1"
                data-carousel-slide-to="0"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/30 aria-[current=true]:bg-white/70 transition"
                aria-current="true"
                aria-label="Slide 2"
                data-carousel-slide-to="1"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/30 aria-[current=true]:bg-white/70 transition"
                aria-current="true"
                aria-label="Slide 3"
                data-carousel-slide-to="2"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/30 aria-[current=true]:bg-white/70 transition"
                aria-current="true"
                aria-label="Slide 4"
                data-carousel-slide-to="3"
            ></button>
            <button
                type="button"
                class="w-3 h-3 rounded-full bg-white/30 aria-[current=true]:bg-white/70 transition"
                aria-current="true"
                aria-label="Slide 5"
                data-carousel-slide-to="4"
            ></button>
        </div>

        <!-- Slider controls -->
        <button
            type="button"
            class="absolute top-0 start-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-prev
        >
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-300 group-hover:bg-white/50 dark:group-hover:bg-white group-focus:outline-none"
            >
                <svg
                    class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 6 10"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 1 1 5l4 4"
                    />
                </svg>
                <span class="sr-only">Previous</span>
            </span>
        </button>
        <button
            type="button"
            class="absolute top-0 end-0 z-30 flex items-center justify-center h-full px-4 cursor-pointer group focus:outline-none"
            data-carousel-next
        >
            <span
                class="inline-flex items-center justify-center w-10 h-10 rounded-full bg-white/30 dark:bg-gray-300 group-hover:bg-white/50 dark:group-hover:bg-white group-focus:outline-none"
            >
                <svg
                    class="w-4 h-4 text-white dark:text-gray-800 rtl:rotate-180"
                    aria-hidden="true"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 6 10"
                >
                    <path
                        stroke="currentColor"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="m1 9 4-4-4-4"
                    />
                </svg>
                <span class="sr-only">Next</span>
            </span>
        </button>
    </div>
</template>
