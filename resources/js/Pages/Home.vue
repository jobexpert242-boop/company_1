<script setup>
import { ref, onMounted, onUnmounted } from "vue";
import { Head } from "@inertiajs/vue3";
import Layout from "../Components/FrontEnd/Layout/Layout.vue";
import Carousel from "../Components/FrontEnd/Home/Carousel.vue";
import Banner from "../Components/FrontEnd/Home/Banner.vue";
import Services from "../Components/FrontEnd/Home/Services.vue";
import Portfolio from "../Components/FrontEnd/Home/Portfolio.vue";
import ChooseUs from "../Components/FrontEnd/Home/ChooseUs.vue";
import Projects from "../Components/FrontEnd/Home/Projects.vue";
import CompanyLogo from "../Components/FrontEnd/Home/CompanyLogo.vue";
import BookingForm from "../Components/FrontEnd/Home/BookingForm.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";

const showButton = ref(false);

const handleScroll = () => {
    showButton.value = window.scrollY > 200;
};

const scrollToTop = () => {
    window.scrollTo({
        top: 0,
        behavior: "smooth",
    });
};

onMounted(() => {
    window.addEventListener("scroll", handleScroll);
});

onUnmounted(() => {
    window.removeEventListener("scroll", handleScroll);
});

const props = defineProps({
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
        <Carousel :carousels="carousels" />
        <Banner />
        <Services :services="services" />
        <Portfolio :categories="categories" :portfolios="portfolios" />
        <ChooseUs :chooseus="props.chooseus" />
        <Projects :projects="props.projects" />
        <CompanyLogo :logos="props.logos" />
        <BookingForm :faqs="faqs" />
        <button
            v-show="showButton"
            @click="scrollToTop"
            class="bg-blue-500 rounded p-3 text-white fixed bottom-5 right-4 transition-all duration-300 hover:bg-blue-800"
        >
            <i class="fa-solid fa-angles-up"></i>
        </button>
    </Layout>
</template>

<style scoped></style>
