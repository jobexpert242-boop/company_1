<script setup>
import { defineAsyncComponent } from "vue";
import { Head, Deferred } from "@inertiajs/vue3";

import Layout from "../Components/FrontEnd/Layout/Layout.vue";

import FlashMessage from "@/Shared/FlashMessage.vue";

// Lazy Load Components
const Carousel = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/Carousel.vue"),
);

const Banner = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/Banner.vue"),
);

const Services = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/Services.vue"),
);

const Portfolio = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/Portfolio.vue"),
);

const ChooseUs = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/ChooseUs.vue"),
);

const Projects = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/Projects.vue"),
);

const CompanyLogo = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/CompanyLogo.vue"),
);

const BookingForm = defineAsyncComponent(
    () => import("../Components/FrontEnd/Home/BookingForm.vue"),
);

defineProps({
    faqs: Array,
    carousels: Array,
    chooseus: Array,
    projects: Array,
    logos: Array,
    categories: Array,
    portfolios: Array,
    services: Array,
});
</script>

<template>
    <Head title="Home" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <!-- Instant -->
        <Carousel :carousels="carousels" />

        <Banner />

        <!-- Services -->
        <Deferred data="services">
            <template #fallback>
                <div class="text-center py-10">Loading Services...</div>
            </template>

            <Services :services="services" />
        </Deferred>

        <!-- Portfolio -->
        <Deferred data="portfolios">
            <template #fallback>
                <div class="text-center py-10">Loading Portfolio...</div>
            </template>

            <Portfolio :categories="categories" :portfolios="portfolios" />
        </Deferred>

        <!-- Choose Us -->
        <Deferred data="chooseus">
            <template #fallback>
                <div class="text-center py-10">Loading...</div>
            </template>

            <ChooseUs :chooseus="chooseus" />
        </Deferred>

        <!-- Projects -->
        <Deferred data="projects">
            <template #fallback>
                <div class="text-center py-10">Loading Projects...</div>
            </template>

            <Projects :projects="projects" />
        </Deferred>

        <!-- Logos -->
        <Deferred data="logos">
            <template #fallback>
                <div class="text-center py-10">Loading Logos...</div>
            </template>

            <CompanyLogo :logos="logos" />
        </Deferred>

        <!-- FAQ -->
        <Deferred data="faqs">
            <template #fallback>
                <div class="text-center py-10">Loading FAQ...</div>
            </template>

            <BookingForm :faqs="faqs" />
        </Deferred>
    </Layout>
</template>
