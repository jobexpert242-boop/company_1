<script setup>
import { onMounted, onUnmounted, ref } from "vue";
import Footer from "../Footer/Footer.vue";
import Header from "../Header/Header.vue";

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
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <Header />

        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
    <button
        v-show="showButton"
        @click="scrollToTop"
        class="bg-blue-500 rounded p-3 text-white fixed bottom-5 right-4 transition-all duration-300 hover:bg-blue-800"
    >
        <i class="fa-solid fa-angles-up"></i>
    </button>
</template>

<style scoped></style>
