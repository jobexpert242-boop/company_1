<script setup>
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";

const props = defineProps({
    services: Array,
});
const activeservices = computed(() =>
    props.services.filter((service) => service.is_active),
);
</script>

<template>
    <Head title="Our Services" />
    <Layout>
        <div class="relative">
            <!-- Background -->
            <div class="absolute inset-0 -z-10">
                <!-- image -->
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    :style="{
                        backgroundImage: `url(/storage/${$page.props.banner?.service_image})`,
                    }"
                ></div>

                <!-- overlay -->
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
            <div class="container py-30 text-white">
                <div class="container relative z-10">
                    <h1 class="text-4xl font-bold text-center uppercase">
                        Our Services
                    </h1>
                </div>
            </div>
        </div>
        <div class="bg-slate-100">
            <div class="container py-10">
                <h2 class="text-3xl font-bold text-center mb-8">
                    Our All Services
                </h2>
                <div class="bg-white p-5 shadow-lg rounded">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
                    >
                        <div
                            v-for="(service, index) in activeservices"
                            :key="index"
                            class="shadow-lg bg-white rounded border border-slate-200 hover-div overflow-hidden"
                        >
                            <Link
                                :href="route('services.details', service.slug)"
                                ><img
                                    class="w-full h-60 object-cover rounded-t transition-transform duration-300 ease-in-out"
                                    :src="'storage/' + service.image"
                                    alt="service image"
                                    loading="lazy"
                            /></Link>
                            <div class="p-6 bg-slate-100">
                                <Link
                                    :href="
                                        route('services.details', service.slug)
                                    "
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
                                    :href="
                                        route('services.details', service.slug)
                                    "
                                    class="text-black hover:text-blue-700 inline-block items-center gap-2 font-semibold"
                                >
                                    Read More
                                    <i
                                        class="fa-solid fa-circle-chevron-right"
                                    ></i>
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
<style scoped>
.hover-div:hover img {
    transform: scale(1.05);
}
</style>
