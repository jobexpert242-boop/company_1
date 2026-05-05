<script setup>
import { computed, ref } from "vue";
import { useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const activeIndex = ref(null);

const toggle = (index) => {
    activeIndex.value = activeIndex.value === index ? null : index;
};

const props = defineProps({
    faqs: Array,
});
const visibleFaqs = computed(() =>
    props.faqs.filter((faq) => faq.is_active && faq.show_home),
);

const form = useForm({
    first_name: "",
    last_name: "",
    phone: "",
    email: "",
    subject: "",
    message: "",
});

const submit = () => {
    form.post(route("booking.store"), {
        onSuccess: () => form.reset(),
    });
};
</script>

<template>
    <div class="relative">
        <!-- Background -->
        <div class="absolute inset-0 -z-10">
            <!-- image -->
            <div
                class="absolute inset-0 bg-cover bg-center"
                :style="{
                    backgroundImage: `url(/storage/${$page.props.banner?.booking_image})`,
                }"
            ></div>

            <!-- overlay -->
            <div
                class="absolute inset-0 bg-blue-500 opacity-70 md:w-[50%] lg:w-[50%] w-[100%]"
            ></div>
        </div>

        <!-- CONTENT -->
        <div class="container py-10 text-white">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-16">
                <div>
                    <h2 class="uppercase text-4xl font-bold mb-5">
                        Booking Form
                    </h2>
                    <form @submit.prevent="submit">
                        <div class="flex gap-3 mb-3">
                            <div class="w-100">
                                <input
                                    v-model="form.first_name"
                                    type="text"
                                    class="booking-form"
                                    placeholder="First Name"
                                />
                                <div
                                    v-if="form.errors.first_name"
                                    class="error"
                                >
                                    {{ form.errors.first_name }}
                                </div>
                            </div>
                            <div class="w-100">
                                <input
                                    v-model="form.last_name"
                                    type="text"
                                    class="booking-form"
                                    placeholder="Last Name"
                                />
                                <div v-if="form.errors.last_name" class="error">
                                    {{ form.errors.last_name }}
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-3 mb-3">
                            <div class="w-100">
                                <input
                                    v-model="form.phone"
                                    type="tel"
                                    class="booking-form"
                                    placeholder="Phone Number"
                                />
                                <div v-if="form.errors.phone" class="error">
                                    {{ form.errors.phone }}
                                </div>
                            </div>
                            <div class="w-100">
                                <input
                                    v-model="form.email"
                                    type="email"
                                    class="booking-form"
                                    placeholder="Email Address"
                                />
                                <div v-if="form.errors.email" class="error">
                                    {{ form.errors.email }}
                                </div>
                            </div>
                        </div>
                        <div class="w-full">
                            <input
                                v-model="form.subject"
                                type="text"
                                class="booking-form mb-3"
                                placeholder="Subject"
                            />
                            <div v-if="form.errors.subject" class="error">
                                {{ form.errors.subject }}
                            </div>
                        </div>
                        <div class="w-full">
                            <textarea
                                v-model="form.message"
                                class="booking-form mb-3"
                                rows="5"
                                placeholder="Message"
                            ></textarea>
                            <div v-if="form.errors.message" class="error">
                                {{ form.errors.message }}
                            </div>
                        </div>
                        <button
                            type="submit"
                            class="bg-slate-600 hover:bg-white hover:text-black text-white font-bold py-4 w-full"
                        >
                            Submit
                        </button>
                    </form>
                </div>

                <div>
                    <h2 class="uppercase text-4xl font-bold mb-5">
                        FREQUENTLY ASKED QUESTIONS
                    </h2>

                    <div
                        v-for="(item, index) in visibleFaqs"
                        :key="index"
                        class="mb-4"
                    >
                        <!-- QUESTION -->
                        <h3
                            @click="toggle(index)"
                            class="font-bold text-xl bg-white text-black p-3 cursor-pointer flex items-center justify-between hover:bg-blue-500 hover:text-white transition-colors duration-300"
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
                            <p class="bg-white text-black p-3 leading-7">
                                {{ item.answer }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>
.booking-form {
    background-color: transparent;
    border: 1px solid white;
    padding: 0.625rem;
    width: 100%;
    color: white;
    ring-width: 0;
    focus-ring-width: 0;
    outline: none;
}
.fade-enter-active,
.fade-leave-active {
    transition: all 0.3s ease;
}

.fade-enter-from,
.fade-leave-to {
    opacity: 0;
    transform: translateY(-10px);
}
.error {
    color: red;
    font-size: 12px;
}
</style>
