<script setup>
import { ref } from "vue";

const props = defineProps({
    comments: Array,
});

const showModal = ref(false);
const selectedItem = ref(null);

const openModal = (item) => {
    selectedItem.value = item;
    showModal.value = true;
};

const closeModal = () => {
    showModal.value = false;
    selectedItem.value = null;
};
</script>

<template>
    <div class="bg-white">
        <div class="container py-10">
            <!-- EMPTY -->
            <div v-if="!comments.length" class="text-center text-gray-500">
                No comments found
            </div>

            <!-- LIST -->
            <div v-else class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div v-for="item in comments" :key="item.id">
                    <div
                        class="border border-slate-200 rounded p-6 text-center shadow-lg hover:bg-blue-500 transition-all duration-300 hover:text-white cursor-pointer hover-div"
                        @click="openModal(item)"
                    >
                        <!-- ICON -->
                        <i :class="item.icon + ' text-6xl mb-3'"></i>

                        <h2 class="font-bold mb-4 text-2xl">
                            {{ item.title }}
                        </h2>

                        <p class="text-gray-600 line-clamp-3 text-left">
                            <span
                                v-html="item.description"
                                class="leading-7"
                            ></span>
                        </p>

                        <button
                            class="mt-4 px-5 py-2 bg-blue-500 text-white rounded hover:bg-white hover:text-blue-500 transition"
                            @click.stop="openModal(item)"
                        >
                            Read More
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- MODAL -->
    <div
        v-if="showModal"
        @click="closeModal"
        class="fixed inset-0 bg-black/80 flex items-center justify-center z-50"
    >
        <div
            class="bg-white rounded-lg shadow-lg p-6 max-w-lg w-full relative"
            @click.stop
        >
            <button
                class="absolute top-2 right-2 text-gray-500"
                @click="closeModal"
            >
                ✖
            </button>

            <i :class="selectedItem.icon + ' text-5xl mb-3 text-blue-500'"></i>

            <h2 class="text-2xl font-bold mb-4">
                {{ selectedItem.title }}
            </h2>

            <p class="text-gray-700 leading-7">
                <span
                    v-html="selectedItem.description"
                    class="leading-7"
                ></span>
            </p>
        </div>
    </div>
</template>

<style scoped>
.hover-div:hover p {
    color: white;
}
.hover-div:hover button {
    color: black;
    background: white !important;
}
.hover-div p {
    transition: color 0.3s ease;
}
.hover-div button {
    transition:
        color 0.3s ease,
        background-color 0.3s ease;
}
</style>
