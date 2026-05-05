<script setup>
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    about: Object,
});
</script>

<template>
    <Head title="About Us" />
    <Layout>
        <div class="relative">
            <!-- Background -->
            <div class="absolute inset-0 -z-10">
                <!-- image -->
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    :style="{
                        backgroundImage: `url(/storage/${$page.props.banner?.about_image})`,
                    }"
                ></div>

                <!-- overlay -->
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
            <div class="container py-30 text-white">
                <div class="container relative z-10">
                    <h1 class="text-4xl font-bold text-center uppercase">
                        About Us
                    </h1>
                </div>
            </div>
        </div>
        <div class="bg-slate-100">
            <div class="container py-10">
                <h2 class="text-3xl font-bold text-center mb-8">
                    {{ props.about.title }}
                </h2>
                <div
                    class="border border-slate-100 p-5 bg-white rounded shadow-xl"
                >
                    <p class="leading-7">
                        <span
                            v-html="props.about.description"
                            class="prose prose-lg text-gray-700"
                        ></span>
                    </p>
                </div>
            </div>
        </div>
    </Layout>
</template>
