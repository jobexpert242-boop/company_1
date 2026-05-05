<script setup>
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { Head } from "@inertiajs/vue3";
import Slider from "@/Components/FrontEnd/Services/Slider.vue";
import Banner from "@/Components/FrontEnd/Services/Banner.vue";
import ChooseUs from "@/Components/FrontEnd/Services/ChooseUs.vue";
import Comment from "@/Components/FrontEnd/Services/Comment.vue";
import Portfolio from "@/Components/FrontEnd/Services/Portfolio.vue";
import Feature from "@/Components/FrontEnd/Services/Feature.vue";
import Services from "@/Components/FrontEnd/Services/Services.vue";

const props = defineProps({
    carousels: Array,
    service: Object,
    chooseus: Array,
    categories: Array,
    portfolios: Array,
    services: Array,
    comments: Array,
    features: Array,
});
</script>

<template>
    <Head :title="service.title" />
    <Layout>
        <Slider :carousels="props.carousels" />
        <Banner :service="service" />
        <ChooseUs :chooseus="chooseus" />
        <Comment :comments="comments" />
        <Portfolio :categories="categories" :portfolios="portfolios" />
        <Feature :features="features" />
        <Services :services="services" />
    </Layout>
</template>

<style scoped></style>
