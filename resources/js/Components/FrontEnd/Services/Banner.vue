<script setup>
const props = defineProps({
    service: Object,
});
</script>

<template>
    <div class="bg-white">
        <div class="container py-10">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-10">
                <div>
                    <h2 class="mb-5 font-bold text-4xl">{{ service.title }}</h2>
                    <p
                        class="leading-7 text-justify"
                        v-html="service.description"
                    ></p>
                </div>
                <div>
                    <img
                        class="w-full object-cover rounded transition-transform duration-300 ease-in-out"
                        :src="'/storage/' + service.image"
                        alt=""
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped></style>
