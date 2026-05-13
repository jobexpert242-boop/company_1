<script setup>
import { Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { route } from "ziggy-js";
const props = defineProps({
    services: Array,
});
const activeservices = computed(() =>
    props.services.filter((service) => service.is_active),
);
</script>

<template>
    <div class="bg-slate-100">
        <div class="container py-10">
            <div class="text-center">
                <h2 class="font-bold mb-4 text-4xl">Our Services</h2>
                <p class="leading-7 text-lg text-gray-600">
                    ComitsBD delivers expert web design, software development,
                    bulk SMS solutions, and CCTV integration. We provide
                    innovative, reliable digital solutions to help your business
                    grow and succeed online.
                </p>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10"
            >
                <div
                    v-for="(service, index) in activeservices"
                    :key="index"
                    class="shadow-lg bg-white rounded border border-slate-200 hover-div overflow-hidden"
                >
                    <Link :href="route('services.details', service.slug)">
                        <img
                            class="w-full h-60 object-cover rounded-t transition-transform duration-300 ease-in-out"
                            :src="'/storage/' + service.image"
                            alt="service image"
                            loading="lazy"
                        />
                    </Link>
                    <div class="p-6">
                        <Link :href="route('services.details', service.slug)"
                            ><h3
                                class="font-semibold text-xl mb-2 hover:text-blue-700 inline-block"
                            >
                                {{ service.title }}
                            </h3></Link
                        >
                        <p class="text-gray-600 leading-7 mb-3">
                            {{ service.sub_title }}
                        </p>
                        <Link
                            :href="route('services.details', service.slug)"
                            class="text-black hover:text-blue-700 items-center gap-2 font-semibold inline-block"
                        >
                            Read More
                            <i class="fa-solid fa-circle-chevron-right"></i>
                        </Link>
                    </div>
                </div>
            </div>
            <div class="mt-16 text-center">
                <Link
                    :href="route('services')"
                    class="bg p-3 text-white rounded mt-10"
                >
                    View All Services
                </Link>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hover-div:hover img {
    transform: scale(1.05);
}
</style>
