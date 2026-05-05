<script setup>
import { Link } from "@inertiajs/vue3";
</script>

<template>
    <div class="bg-white">
        <div class="container py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5">
                <div class="">
                    <h1 class="text-5xl font-normal mb-5">
                        {{ $page.props.banner.title }}
                    </h1>
                    <p class="leading-7 text-justify">
                        <span
                            v-html="$page.props.banner.description"
                            class="prose prose-lg text-gray-700"
                        ></span>
                    </p>
                </div>
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-5"
                >
                    <a
                        target="_blank"
                        href="https://comitsbd.com/services/software"
                        class="banner-btn"
                    >
                        Software & Web Solutions
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a
                        target="_blank"
                        href="https://shop.comitsbd.com/"
                        class="banner-btn"
                    >
                        Hardware Solutions
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <Link href="" class="banner-btn">
                        Digital Marketing
                        <i class="fa-solid fa-arrow-right"></i>
                    </Link>
                    <a
                        target="_blank"
                        href="https://comitsbd.com/services/cctv-&-security-services"
                        class="banner-btn"
                    >
                        CCTV & Access Control
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <Link href="" class="banner-btn">
                        Graphics Design
                        <i class="fa-solid fa-arrow-right"></i>
                    </Link>
                    <a
                        target="_blank"
                        href="https://training.jobexpert.com.bd/"
                        class="banner-btn"
                    >
                        Training / Course
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <Link href="" class="banner-btn">
                        SEO & SMM
                        <i class="fa-solid fa-arrow-right"></i>
                    </Link>
                    <a
                        target="_blank"
                        href="https://comitsbd.com/services/it-support"
                        class="banner-btn"
                    >
                        IT Support
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a
                        target="_blank"
                        href="https://hasibmart.comitsbd.com/"
                        class="banner-btn"
                    >
                        Hasib Mart
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                    <a
                        target="_blank"
                        href="https://jobexpert.com.bd/"
                        class="banner-btn"
                    >
                        Career/Job
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
