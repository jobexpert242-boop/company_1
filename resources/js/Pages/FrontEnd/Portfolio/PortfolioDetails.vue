<script setup>
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay } from "swiper/modules";
import "swiper/css";
import FlashMessage from "@/Shared/FlashMessage.vue";

import { Head, Link, useForm, usePage } from "@inertiajs/vue3";
import { ref, computed } from "vue";
import { route } from "ziggy-js";

const page = usePage();
const modalImages = ref([]);

const portfolio = computed(() => page.props.portfolio);
const recent = computed(() => page.props.recent || []);

/* =========================
   IMAGES (MAIN + GALLERY)
========================= */
const images = computed(() => {
    let arr = [];

    if (portfolio.value?.image) {
        arr.push("/storage/" + portfolio.value.image);
    }

    if (portfolio.value?.images) {
        portfolio.value.images.forEach((img) => {
            arr.push("/storage/" + img.image);
        });
    }

    return arr;
});

/* =========================
   MODAL
========================= */
const showModal = ref(false);
const currentIndex = ref(0);

const openImage = (index, type = "main") => {
    if (type === "recent") {
        modalImages.value = recent.value.map(
            (item) => "/storage/" + item.image,
        );
    } else {
        modalImages.value = images.value;
    }

    currentIndex.value = index;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

const nextImage = () => {
    currentIndex.value = (currentIndex.value + 1) % modalImages.value.length;
};

const prevImage = () => {
    currentIndex.value =
        (currentIndex.value - 1 + modalImages.value.length) %
        modalImages.value.length;
};

const form = useForm({
    name: "",
    phone: "",
    email: "",
    message: "",
});

const submit = () => {
    form.post(route("contact.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};
</script>

<template>
    <Head :title="portfolio.title" />
    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <!-- HERO -->
        <div class="relative">
            <div class="absolute inset-0 -z-10">
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    :style="{
                        backgroundImage: `url(/storage/${$page.props.banner?.portfoliodetailes_image})`,
                    }"
                ></div>
                <div class="absolute inset-0 bg-black/60"></div>
            </div>

            <div class="container py-20 text-white text-center">
                <h1 class="text-3xl md:text-4xl font-bold uppercase">
                    {{ portfolio.title }}
                </h1>
            </div>
        </div>

        <!-- MAIN SECTION -->
        <div class="bg-white">
            <div class="container py-10">
                <div class="flex flex-col lg:flex-row gap-10">
                    <!-- LEFT -->
                    <div class="w-full lg:w-2/3">
                        <Swiper
                            :modules="[Autoplay]"
                            :slides-per-view="1"
                            :loop="true"
                            :autoplay="{
                                delay: 3000,
                                pauseOnMouseEnter: true,
                            }"
                        >
                            <SwiperSlide v-for="(img, i) in images" :key="i">
                                <img
                                    @click="openImage(i, 'main')"
                                    :src="img"
                                    class="w-full h-[300px] md:h-[450px] object-cover rounded cursor-pointer"
                                    alt="image"
                                    loading="lazy"
                                />
                            </SwiperSlide>
                        </Swiper>
                        <div class="mt-10">
                            <h2 class="text-2xl font-bold">Project Overview</h2>
                            <p class="pt-6 leading-7">
                                <span
                                    v-html="portfolio.description"
                                    class="prose prose-lg text-gray-700"
                                ></span>
                            </p>
                        </div>
                    </div>

                    <!-- RIGHT -->
                    <div class="w-full lg:w-1/3">
                        <div class="border border-slate-200 p-6 mb-6">
                            <h2 class="font-bold mb-4 text-lg">
                                Project Detail
                            </h2>
                            <p class="border-b border-slate-200 py-2">
                                <span class="text-blue-500">Client Name :</span>
                                {{ portfolio.client_name }}
                            </p>
                            <p class="border-b border-slate-200 py-3">
                                <span class="text-blue-500">Company :</span>
                                {{ portfolio.company_name }}
                            </p>
                            <p class="border-b border-slate-200 py-3">
                                <span class="text-blue-500">Start Date :</span>
                                {{ portfolio.start_date }}
                            </p>
                            <p class="border-b border-slate-200 py-3">
                                <span class="text-blue-500">End Date :</span>
                                {{ portfolio.end_date }}
                            </p>
                            <p class="border-b border-slate-200 py-3 leading-7">
                                <span class="text-blue-500"
                                    >Client Comment :</span
                                >
                                {{ portfolio.client_comment }}
                            </p>
                        </div>

                        <div class="border border-slate-200 p-6">
                            <h2 class="font-bold mb-4 text-lg">
                                Quick Contact
                            </h2>

                            <form class="space-y-3" @submit.prevent="submit">
                                <div class="w-full">
                                    <input
                                        v-model="form.name"
                                        class="booking-form"
                                        placeholder="Name"
                                    />
                                    <div
                                        v-if="form.errors.name"
                                        class="text-xs text-red-500"
                                    >
                                        {{ form.errors.name }}
                                    </div>
                                </div>

                                <div class="w-full">
                                    <input
                                        type="email"
                                        v-model="form.email"
                                        class="booking-form"
                                        placeholder="Email"
                                    />
                                    <div
                                        v-if="form.errors.email"
                                        class="text-xs text-red-500"
                                    >
                                        {{ form.errors.email }}
                                    </div>
                                </div>

                                <div class="w-full">
                                    <input
                                        v-model="form.phone"
                                        class="booking-form"
                                        placeholder="Phone"
                                    />
                                    <div
                                        v-if="form.errors.phone"
                                        class="text-xs text-red-500"
                                    >
                                        {{ form.errors.phone }}
                                    </div>
                                </div>

                                <div class="w-full">
                                    <textarea
                                        v-model="form.message"
                                        class="booking-form"
                                        placeholder="Message"
                                        rows="5"
                                    ></textarea>
                                    <div
                                        v-if="form.errors.message"
                                        class="text-xs text-red-500"
                                    >
                                        {{ form.errors.message }}
                                    </div>
                                </div>

                                <button
                                    class="bg-blue-500 text-white py-3 w-full"
                                >
                                    Submit
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RECENT -->
        <div class="bg-slate-100">
            <div class="container py-10">
                <div class="text-center mb-6">
                    <h2 class="text-3xl font-bold">Recent Portfolio</h2>
                </div>

                <Swiper
                    :modules="[Autoplay]"
                    :loop="true"
                    :space-between="20"
                    :autoplay="{ delay: 2500, pauseOnMouseEnter: true }"
                    :breakpoints="{
                        0: { slidesPerView: 1 },
                        640: { slidesPerView: 2 },
                        768: { slidesPerView: 3 },
                    }"
                >
                    <SwiperSlide v-for="(item, i) in recent" :key="item.id">
                        <div class="bg-white shadow rounded">
                            <div class="relative group overflow-hidden">
                                <img
                                    :src="'/storage/' + item.image"
                                    class="w-full h-60 object-cover"
                                    alt="image"
                                    loading="lazy"
                                />

                                <div
                                    @click="openImage(i, 'recent')"
                                    class="absolute inset-0 bg-blue-600/70 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white cursor-pointer"
                                >
                                    <i class="fa fa-search"></i>
                                </div>
                            </div>

                            <div class="p-4 text-center">
                                <Link
                                    :href="
                                        route('portfolio.details', item.slug)
                                    "
                                    class="font-semibold hover:text-blue-600"
                                >
                                    {{ item.title }}
                                </Link>
                            </div>
                        </div>
                    </SwiperSlide>
                </Swiper>
            </div>
        </div>
    </Layout>

    <!-- MODAL -->
    <div
        v-if="showModal"
        @click.self="closeModal"
        class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
    >
        <!-- close -->
        <button
            @click="closeModal"
            class="absolute top-5 right-5 text-white text-3xl"
        >
            ✕
        </button>

        <!-- left -->
        <button
            @click.stop="prevImage"
            class="absolute left-5 text-white text-4xl"
        >
            ❮
        </button>

        <!-- image -->
        <img
            :src="modalImages[currentIndex]"
            class="max-w-[90%] max-h-[90%] rounded"
            alt="image"
            loading="lazy"
        />

        <!-- right -->
        <button
            @click.stop="nextImage"
            class="absolute right-5 text-white text-4xl"
        >
            ❯
        </button>
    </div>
</template>

<style scoped>
.booking-form {
    border: 1px solid #ccc;
    padding: 10px;
    width: 100%;
    outline: none;
}
</style>
