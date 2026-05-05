<script setup>
import { computed } from "vue";

const props = defineProps({
    chooseus: Array,
});
const activechooseus = computed(() =>
    props.chooseus.filter((choose) => choose.is_active),
);
</script>

<template>
    <div class="bg-slate-100">
        <div class="container py-10">
            <div class="text-center">
                <h2 class="font-bold mb-4 text-4xl">WHY CHOOSE US</h2>
                <p class="leading-7 text-lg text-gray-600">
                    We have some special crieteria that will help you
                </p>
            </div>
            <div
                class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-10"
            >
                <div
                    v-for="(choose, index) in activechooseus"
                    :key="index"
                    class="relative rounded shadow-lg text-center text-white overflow-hidden group"
                >
                    <!-- background image -->
                    <div
                        class="absolute inset-0 bg-cover bg-center transition-opacity duration-500 group-hover:opacity-100"
                        :style="{
                            backgroundImage:
                                'url(/storage/' + choose.image + ')',
                        }"
                    ></div>

                    <!-- overlay color -->
                    <div
                        class="absolute inset-0 bg-blue-500 opacity-70 transition-opacity duration-500 group-hover:opacity-100"
                    ></div>

                    <!-- content -->
                    <div class="relative px-5 py-10">
                        <i :class="choose.icon + ' text-6xl mb-3'"></i>
                        <h3 class="font-semibold text-xl mb-2">
                            {{ choose.title }}
                        </h3>
                        <p class="text-gray-200 leading-7">
                            {{ choose.description }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
