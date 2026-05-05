<script setup>
import { Head } from "@inertiajs/vue3";
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { computed, ref } from "vue";

const activeIndex = ref(0);

const toggle = (index) => {
    activeIndex.value = activeIndex.value === index ? null : index;
};

const props = defineProps({
    faqs: Array,
});
const activeFaqs = computed(() => props.faqs.filter((faq) => faq.is_active));
</script>

<template>
    <Head title="FAQ" />
    <Layout>
        <div class="relative">
            <!-- Background -->
            <div class="absolute inset-0 -z-10">
                <!-- image -->
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    style="
                        background-image: url(&quot;/storage/images/service1.jpg&quot;);
                    "
                ></div>

                <!-- overlay -->
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
            <div class="container py-30 text-white">
                <div class="container relative z-10">
                    <h1 class="text-4xl font-bold text-center uppercase">
                        FAQ
                    </h1>
                </div>
            </div>
        </div>
        <div class="bg-slate-100">
            <div class="container py-10">
                <h2 class="text-3xl font-bold text-center mb-8">FAQ</h2>
                <div
                    class="border bg-white p-6 rounded shadow-lg border-slate-100"
                >
                    <div
                        v-for="(item, index) in activeFaqs"
                        :key="index"
                        class="mb-4"
                    >
                        <!-- QUESTION -->
                        <h3
                            @click="toggle(index)"
                            class="font-bold text-xl bg-slate-200 text-black p-3 cursor-pointer flex items-center justify-between hover:bg-blue-500 hover:text-white transition-colors duration-300"
                        >
                            <span>
                                <i
                                    class="fa-solid mr-2 transition-transform duration-300"
                                    :class="
                                        activeIndex === index
                                            ? 'fa-caret-down rotate-180'
                                            : 'fa-caret-right'
                                    "
                                ></i>
                                {{ item.question }}
                            </span>
                        </h3>

                        <!-- ANSWER -->
                        <div
                            class="overflow-hidden transition-all duration-500"
                            :class="
                                activeIndex === index
                                    ? 'max-h-40 opacity-100'
                                    : 'max-h-0 opacity-0'
                            "
                        >
                            <p class="bg-slate-100 text-black p-3 leading-7">
                                {{ item.answer }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
</style>
