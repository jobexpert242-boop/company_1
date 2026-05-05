<script setup>
import Footer from "../Footer/Footer.vue";
import Header from "../Header/Header.vue";
</script>

<template>
    <div class="min-h-screen flex flex-col">
        <Header />

        <main class="flex-grow">
            <slot />
        </main>

        <Footer />
    </div>
</template>

<style scoped></style>
