<script setup>
const props = defineProps({
    features: Array,
});
</script>

<template>
    <div class="bg-white">
        <div class="container py-10">
            <div>
                <h2 class="font-bold mb-4 text-center text-4xl uppercase">
                    Features
                </h2>
                <!-- EMPTY -->
                <div v-if="!features.length" class="text-center text-gray-500">
                    No features found
                </div>
                <div
                    v-else
                    class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mt-10"
                >
                    <div v-for="(feature, index) in features" :key="index">
                        <div class="flex hover-div">
                            <div
                                class="p-6 h-fit border border-slate-200 bg-blue-500 bg-div"
                            >
                                <i
                                    :class="
                                        feature.icon + ' text-4xl text-white'
                                    "
                                ></i>
                            </div>
                            <div
                                class="p-5 h-fit border border-slate-200 bg-div2"
                            >
                                <h3 class="font-bold text-xl mb-2">
                                    {{ feature.title }}
                                </h3>
                                <p class="text-gray-600 leading-7 text-justify">
                                    <span v-html="feature.description"></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.hover-div:hover .bg-div2 {
    color: white;
    background-color: #3b82f6;
}
.hover-div .bg-div2 {
    transition: all 0.3s ease;
}
.hover-div:hover p {
    color: white;
}
.hover-div p {
    transition: color 0.3s ease;
}
.hover-div:hover .bg-div {
    background-color: white;
}
.hover-div .bg-div {
    transition: background-color 0.3s ease;
}
.hover-div:hover .bg-div i {
    color: #3b82f6;
}
.hover-div:hover .bg-div i {
    transition: color 0.3s ease;
}
</style>
