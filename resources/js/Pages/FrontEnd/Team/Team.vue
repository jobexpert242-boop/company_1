<script setup>
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { Head, Link } from "@inertiajs/vue3";
import { computed } from "vue";
import { route } from "ziggy-js";

const props = defineProps({
    teams: Array,
});
const activeTeams = computed(() =>
    props.teams.filter((team) => team.is_active),
);
</script>

<template>
    <Head title="Our Team" />
    <Layout>
        <div class="relative">
            <!-- Background -->
            <div class="absolute inset-0 -z-10">
                <!-- image -->
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    :style="{
                        backgroundImage: `url(/storage/${$page.props.banner?.team_image})`,
                    }"
                ></div>

                <!-- overlay -->
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
            <div class="container py-30 text-white">
                <div class="container relative z-10">
                    <h1 class="text-4xl font-bold text-center uppercase">
                        Our Team
                    </h1>
                </div>
            </div>
        </div>
        <div class="bg-slate-100">
            <div class="container py-10">
                <h2 class="text-3xl font-bold text-center mb-8">
                    Meet the Team
                </h2>
                <div class="bg-white p-5 rounded shadow-lg">
                    <div
                        class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6"
                    >
                        <div
                            v-for="(team, index) in activeTeams"
                            :key="index"
                            class="bg-slate-200 shadow-lg text-center group relative"
                        >
                            <img
                                class="w-full h-60 mx-auto object-cover"
                                :src="
                                    team.image
                                        ? '/storage/' + team.image
                                        : '/storage/images/default.jpg'
                                "
                                alt="team image"
                            />

                            <div class="p-5 bg-blue-500 relative text-white">
                                <Link :href="route('team.details', team.id)"
                                    ><h3 class="text-2xl font-semibold mb-2">
                                        {{ team.name }}
                                    </h3></Link
                                >
                                <p>{{ team.podobi }}</p>
                                <div
                                    class="absolute top-[-51px] left-0 w-full bg-white text-black opacity-0 translate-y-5 group-hover:opacity-100 group-hover:translate-y-0 transition-all duration-500"
                                >
                                    <div
                                        class="p-2 flex justify-center items-center"
                                    >
                                        <div
                                            class="border border-slate-200 rounded flex justify-center items-center shadow-lg bg-slate-200"
                                        >
                                            <a
                                                :href="team.facebook"
                                                target="_blank"
                                                class="hover:bg-blue-500 hover:text-white p-2 transition-all duration-500"
                                                ><i
                                                    class="fa-brands fa-facebook"
                                                ></i
                                            ></a>
                                            <a
                                                :href="team.twitter"
                                                target="_blank"
                                                class="hover:bg-blue-500 hover:text-white p-2 transition-all duration-500"
                                                ><i
                                                    class="fa-brands fa-twitter"
                                                ></i
                                            ></a>
                                            <a
                                                :href="team.linkdin"
                                                target="_blank"
                                                class="hover:bg-blue-500 hover:text-white p-2 transition-all duration-500"
                                                ><i
                                                    class="fa-brands fa-linkedin"
                                                ></i
                                            ></a>
                                            <a
                                                :href="team.youtube"
                                                target="_blank"
                                                class="hover:bg-blue-500 hover:text-white p-2 transition-all duration-500"
                                                ><i
                                                    class="fa-brands fa-youtube"
                                                ></i
                                            ></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>
