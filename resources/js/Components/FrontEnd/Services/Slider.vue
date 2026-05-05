<script setup>
import { Swiper, SwiperSlide } from "swiper/vue";
import { Navigation, Autoplay } from "swiper/modules";

// styles
import "swiper/css";
import "swiper/css/navigation";
import { computed } from "vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const props = defineProps({
    carousels: Array,
});

const activecarousels = computed(() =>
    props.carousels.filter((carousel) => carousel.is_active),
);
</script>

<template>
    <Swiper
        :modules="[Navigation, Autoplay]"
        :navigation="true"
        :autoplay="{
            delay: 4000,
            disableOnInteraction: false,
            pauseOnMouseEnter: true,
        }"
        :speed="1200"
        loop
    >
        <SwiperSlide v-for="(carousel, index) in activecarousels" :key="index">
            <div
                class="carousel"
                :style="{ backgroundImage: `url(/storage/${carousel.image})` }"
            >
                <div class="overlay">
                    <div class="container text-white">
                        <div class="content">
                            <h1 class="title">
                                {{ carousel.title }}
                            </h1>

                            <p class="desc">
                                {{ carousel.description }}
                            </p>

                            <div class="buttons">
                                <Link href="" class="btn-primary bg">
                                    <i class="fa-solid fa-arrow-right"></i>
                                    Read More
                                </Link>

                                <Link
                                    :href="route('contact')"
                                    class="btn-secondary"
                                >
                                    <i class="fa-solid fa-user"></i>
                                    Contact Us
                                </Link>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </SwiperSlide>
    </Swiper>
</template>
<style scoped>
.carousel {
    height: 70vh;
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
}

.overlay {
    width: 100%;
    height: 100%;
    background: linear-gradient(
        to right,
        rgba(0, 0, 0, 0.7),
        rgba(255, 255, 255, 0.3)
    );
    display: flex;
    align-items: center;
}

.content {
    max-width: 600px;
}

/* ANIMATION */
.title {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 15px;
    animation: slideDown 1.5s ease;
    line-height: 50px;
}

.desc {
    font-size: 1.1rem;
    margin-bottom: 30px;
    animation: slideUp 1.8s ease;
    line-height: 30px;
}

.buttons {
    display: flex;
    gap: 10px;
    animation: slideUp 2.2s ease;
}

/* BUTTONS */
.btn-primary {
    color: #ffffff;
    padding: 10px 20px;
    border-radius: 5px;
    font-weight: bold;
}

.btn-primary:hover {
    background: white !important;
    color: #000;
    transition: all 0.3s ease;
}

.btn-secondary {
    background: #333;
    color: #fff;
    padding: 10px 20px;
    border-radius: 5px;
}

.btn-secondary:hover {
    background: #fff;
    color: #000;
}
/* Move arrows to bottom */
:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    top: auto;
    bottom: 20px;
    transform: none;
}

/* Position left & right */
:deep(.swiper-button-prev) {
    left: 47.5%;
}
:deep(.swiper-button-next) {
    right: 47.5%;
}

/* Small (≥576px) */
@media (max-width: 576px) {
    :deep(.swiper-button-prev) {
        left: 40%;
    }
    :deep(.swiper-button-next) {
        right: 40%;
    }
}
@media (min-width: 576px) {
    :deep(.swiper-button-prev) {
        left: 40%;
    }
    :deep(.swiper-button-next) {
        right: 40%;
    }
}

/* Medium (≥768px) */
@media (min-width: 768px) {
    :deep(.swiper-button-prev) {
        left: 45%;
    }
    :deep(.swiper-button-next) {
        right: 45%;
    }
}

/* Large (≥992px) */
@media (min-width: 992px) {
    :deep(.swiper-button-prev) {
        left: 46%;
    }
    :deep(.swiper-button-next) {
        right: 46%;
    }
}

/* X-Large (≥1200px) */
@media (min-width: 1200px) {
    :deep(.swiper-button-prev) {
        left: 46%;
    }
    :deep(.swiper-button-next) {
        right: 46%;
    }
}

/* XX-Large (≥1400px) */
@media (min-width: 1400px) {
    :deep(.swiper-button-prev) {
        left: 47.5%;
    }
    :deep(.swiper-button-next) {
        right: 47.5%;
    }
}

/* Style buttons */
:deep(.swiper-button-next),
:deep(.swiper-button-prev) {
    background: #376fd1;
    width: 40px;
    height: 40px;
    padding: 10px;
    border-radius: 3px;
    color: #fff;
}

/* KEYFRAMES */
@keyframes slideDown {
    from {
        transform: translateY(-80px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}

@keyframes slideUp {
    from {
        transform: translateY(80px);
        opacity: 0;
    }
    to {
        transform: translateY(0);
        opacity: 1;
    }
}
</style>
