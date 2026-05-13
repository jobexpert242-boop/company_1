<script setup>
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    team: Object,
});
</script>

<template>
    <Head :title="team.name" />
    <Layout>
        <div class="container py-10">
            <div class="border p-8 border-slate-200 shadow-lg rounded bg-white">
                <div class="flex flex-wrap md:flex-nowrap gap-10">
                    <!-- Left column -->
                    <div class="w-full md:w-1/3">
                        <img
                            class=""
                            :src="
                                team.image
                                    ? '/storage/' + team.image
                                    : '/storage/images/default.jpg'
                            "
                            alt="team image"
                            loading="lazy"
                        />
                        <div
                            class="border border-slate-200 p-6 mt-10 bg-slate-100"
                        >
                            <h2 class="uppercase font-robo inline-block mb-6">
                                Contact
                            </h2>
                            <div class="mb-3 flex items-center">
                                <i
                                    class="fa-solid fa-envelope text-blue-500 mr-2"
                                ></i>
                                <a
                                    :href="'mailto:' + team.email"
                                    class="text-gray-700"
                                    >{{ team.email }}</a
                                >
                            </div>
                            <div class="flex items-center">
                                <i class="fa fa-globe text-blue-500 mr-2"></i>
                                <a
                                    :href="team.website"
                                    target="_blank"
                                    class="text-gray-700"
                                    >{{ team.website }}</a
                                >
                            </div>
                        </div>
                    </div>

                    <!-- Right column -->
                    <div class="w-full md:w-2/3">
                        <p class="leading-7">
                            <span
                                v-html="team.description"
                                class="prose prose-lg text-gray-700"
                            ></span>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
h2 {
    font-size: 22px;
    font-weight: 700;
}
h2::after {
    content: "";
    display: block;
    width: 80%;
    height: 1px;
    background-color: #376fd1;
    margin-top: 6px;
}
h2::before {
    content: "";
    display: block;
    width: 100%;
    height: 1px;
    background-color: #376fd1;
    margin-bottom: -35px;
}
</style>
