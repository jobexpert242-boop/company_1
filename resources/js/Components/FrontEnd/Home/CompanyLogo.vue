<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Autoplay } from "swiper/modules";

import "swiper/css";
import { computed } from "vue";

const props = defineProps({
    logos: Array,
});
const activelogos = computed(() =>
    props.logos.filter((logo) => logo.is_active),
);
</script>

<template>
    <div class="bg-white">
        <div class="container py-10">
            <Swiper
                :modules="[Autoplay]"
                :slides-per-view="5"
                :space-between="20"
                :loop="true"
                :autoplay="{
                    delay: 3000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                }"
                :breakpoints="{
                    0: { slidesPerView: 2 },
                    640: { slidesPerView: 3 },
                    768: { slidesPerView: 4 },
                    1024: { slidesPerView: 5 },
                }"
            >
                <SwiperSlide v-for="(logo, index) in activelogos" :key="index">
                    <div
                        class="flex items-center justify-center h-24 bg-gray-200 rounded"
                    >
                        <img
                            :src="/storage/ + logo.image"
                            class="h-12 object-contain"
                            alt="logo"
                            loading="lazy"
                        />
                    </div>
                </SwiperSlide>
            </Swiper>
        </div>
    </div>
</template>
