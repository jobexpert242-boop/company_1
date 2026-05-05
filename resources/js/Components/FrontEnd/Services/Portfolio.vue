<script setup>
import { Link, Head } from "@inertiajs/vue3";
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { ref, computed, watch, onMounted, onBeforeUnmount } from "vue";
import { route } from "ziggy-js";

const props = defineProps({
    categories: Array,
    portfolios: Array,
});

/* =========================
   FILTER
========================= */
const activeCategory = ref("all");

const filteredPortfolios = computed(() => {
    if (activeCategory.value === "all") {
        return props.portfolios;
    }

    return props.portfolios.filter(
        (p) => Number(p.category_id) === Number(activeCategory.value),
    );
});

/* RESET INDEX WHEN FILTER CHANGE */
watch(activeCategory, () => {
    selectedIndex.value = 0;
});

/* =========================
   MODAL
========================= */
const showModal = ref(false);
const selectedIndex = ref(0);

const openImage = (index) => {
    selectedIndex.value = index;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
};

/* NEXT / PREV */
const nextImage = () => {
    if (selectedIndex.value < filteredPortfolios.value.length - 1) {
        selectedIndex.value++;
    }
};

const prevImage = () => {
    if (selectedIndex.value > 0) {
        selectedIndex.value--;
    }
};

/* KEYBOARD SUPPORT */
const handleKey = (e) => {
    if (!showModal.value) return;

    if (e.key === "ArrowRight") nextImage();
    if (e.key === "ArrowLeft") prevImage();
    if (e.key === "Escape") closeModal();
};

onMounted(() => {
    window.addEventListener("keydown", handleKey);
});

onBeforeUnmount(() => {
    window.removeEventListener("keydown", handleKey);
});

const activecategories = computed(() =>
    props.categories.filter((category) => category.is_active),
);
</script>

<template>
    <div class="bg-slate-100">
        <div class="container py-10">
            <div class="text-center">
                <h2 class="font-bold mb-4 text-4xl">WORK PORTFOLIO</h2>
                <p class="leading-7 text-lg text-gray-600">
                    See what we do for our valuable clients
                </p>
            </div>
            <div class="mt-6 flex justify-center gap-5 flex-wrap">
                <!-- ALL -->
                <button
                    @click="activeCategory = 'all'"
                    :class="[
                        'text-lg font-semibold border-b pb-1',
                        activeCategory === 'all' ? 'active' : '',
                    ]"
                >
                    All
                </button>

                <!-- CATEGORY -->
                <button
                    v-for="cat in activecategories"
                    :key="cat.id"
                    @click="activeCategory = Number(cat.id)"
                    :class="[
                        'text-lg font-semibold border-b pb-1',
                        activeCategory == cat.id ? 'active' : '',
                    ]"
                >
                    {{ cat.name }}
                </button>
            </div>
            <!-- GRID -->
            <div
                v-if="filteredPortfolios.length"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mt-10"
            >
                <div
                    v-for="(portfolio, index) in filteredPortfolios"
                    :key="portfolio.id"
                    class="shadow-lg rounded border border-slate-200"
                >
                    <div class="relative group overflow-hidden">
                        <img
                            class="w-full h-60 object-cover rounded-t"
                            :src="'/storage/' + portfolio.image"
                        />

                        <!-- OVERLAY -->
                        <div
                            @click="openImage(index)"
                            class="absolute inset-0 bg-blue-600 opacity-0 group-hover:opacity-70 flex justify-center items-center text-white text-3xl cursor-pointer transition-all duration-300"
                        >
                            <i class="fa fa-search"></i>
                        </div>
                    </div>

                    <div class="p-4 text-center bg-gray-100">
                        <Link
                            :href="route('portfolio.details', portfolio.slug)"
                            class="font-semibold text-lg hover:text-blue-600"
                        >
                            {{ portfolio.title }}
                        </Link>
                    </div>
                </div>
            </div>

            <!-- EMPTY -->
            <div v-else class="text-center mt-10 text-yellow-500 text-xl">
                No portfolio found
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div
        v-if="showModal"
        @click.self="closeModal"
        class="fixed inset-0 bg-black/80 flex justify-center items-center z-50"
    >
        <!-- CLOSE -->
        <button
            @click="closeModal"
            class="absolute top-5 right-5 text-white text-3xl"
        >
            ✕
        </button>

        <!-- PREV -->
        <button
            v-if="selectedIndex > 0"
            @click="prevImage"
            class="absolute left-5 text-white text-3xl"
        >
            ◀
        </button>

        <!-- IMAGE -->
        <img
            :src="'/storage/' + filteredPortfolios[selectedIndex].image"
            class="max-w-[90%] max-h-[90%] rounded"
        />

        <!-- NEXT -->
        <button
            v-if="selectedIndex < filteredPortfolios.length - 1"
            @click="nextImage"
            class="absolute right-5 text-white text-3xl"
        >
            ▶
        </button>
    </div>
</template>

<style scoped>
.active {
    color: #376fd1;
    border-color: #376fd1;
    position: relative;
}

.active::after {
    content: "\f0d7";
    font-family: "Font Awesome 5 Free";
    font-weight: 900;

    position: absolute;
    left: 50%;
    transform: translateX(-50%);
    bottom: -15px;

    font-size: 14px;
    color: #376fd1;
}
</style>
