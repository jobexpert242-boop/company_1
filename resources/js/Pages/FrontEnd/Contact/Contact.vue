<script setup>
import { Head, useForm } from "@inertiajs/vue3";
import Layout from "@/Components/FrontEnd/Layout/Layout.vue";
import { route } from "ziggy-js";
import FlashMessage from "@/Shared/FlashMessage.vue";

const form = useForm({
    name: "",
    phone: "",
    email: "",
    subject: "",
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
    <Head title="Contact Us" />
    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <div class="relative">
            <!-- Background -->
            <div class="absolute inset-0 -z-10">
                <!-- image -->
                <div
                    class="absolute inset-0 bg-cover bg-center"
                    :style="{
                        backgroundImage: `url(/storage/${$page.props.banner?.contact_image})`,
                    }"
                ></div>

                <!-- overlay -->
                <div class="absolute inset-0 bg-black opacity-60"></div>
            </div>
            <div class="container py-30 text-white">
                <div class="container relative z-10">
                    <h1 class="text-4xl font-bold text-center uppercase">
                        Contact Us
                    </h1>
                </div>
            </div>
        </div>
        <div class="bg-slate-100">
            <div class="container py-10">
                <h2 class="text-3xl font-bold text-center mb-8">Contact Us</h2>
                <div class="border shadow-lg border-white p-5 rounded bg-white">
                    <div
                        class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-3 gap-6 mb-4"
                    >
                        <div
                            class="bg-slate-200 p-6 rounded shadow text-center"
                        >
                            <i
                                class="fa-solid fa-location-dot text-2xl text-blue-500 mb-4"
                            ></i>
                            <h3 class="text-xl font-semibold mb-2">
                                Our Address
                            </h3>
                            <p class="leading-7">
                                {{ $page.props.footer.location }}
                            </p>
                        </div>
                        <div
                            class="bg-slate-200 p-6 rounded shadow text-center"
                        >
                            <i
                                class="fa-solid fa-phone text-2xl text-blue-500 mb-4"
                            ></i>
                            <h3 class="text-xl font-semibold mb-2">
                                Phone Number
                            </h3>
                            <p class="leading-7">
                                <a :href="'tel:' + $page.props.footer.sales">{{
                                    $page.props.footer.sales
                                }}</a>
                            </p>
                        </div>
                        <div
                            class="bg-slate-200 p-6 rounded shadow text-center"
                        >
                            <i
                                class="fa-solid fa-envelope text-2xl text-blue-500 mb-4"
                            ></i>
                            <h3 class="text-xl font-semibold mb-2">
                                Email Address
                            </h3>
                            <p class="leading-7">
                                <a
                                    :href="
                                        'mailto:' + $page.props.footer.email_one
                                    "
                                    >{{ $page.props.footer.email_one }}</a
                                >
                            </p>
                        </div>
                    </div>
                    <div class="pt-10">
                        <h2
                            class="uppercase font-robo inline-block contact-form mb-8"
                        >
                            Contact Form
                        </h2>
                        <form @submit.prevent="submit">
                            <!-- Row 1 -->
                            <div class="flex gap-3 mb-3">
                                <div class="w-full">
                                    <input
                                        v-model="form.name"
                                        type="text"
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
                                        v-model="form.phone"
                                        type="tel"
                                        class="booking-form"
                                        placeholder="Phone Number"
                                    />
                                    <div
                                        v-if="form.errors.phone"
                                        class="text-xs text-red-500"
                                    >
                                        {{ form.errors.phone }}
                                    </div>
                                </div>
                            </div>

                            <!-- Row 2 -->
                            <div class="flex gap-3 mb-3">
                                <div class="w-full">
                                    <input
                                        v-model="form.email"
                                        type="email"
                                        class="booking-form"
                                        placeholder="Email Address"
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
                                        v-model="form.subject"
                                        type="text"
                                        class="booking-form"
                                        placeholder="Subject"
                                    />
                                    <div
                                        v-if="form.errors.subject"
                                        class="text-xs text-red-500"
                                    >
                                        {{ form.errors.subject }}
                                    </div>
                                </div>
                            </div>

                            <!-- Message -->
                            <div class="w-full">
                                <textarea
                                    v-model="form.message"
                                    class="booking-form mb-3"
                                    rows="6"
                                    placeholder="Message"
                                ></textarea>
                                <div
                                    v-if="form.errors.message"
                                    class="text-xs text-red-500"
                                >
                                    {{ form.errors.message }}
                                </div>
                            </div>

                            <!-- Submit -->
                            <button
                                type="submit"
                                class="bg-blue-500 hover:bg-slate-500 text-white font-bold py-4 w-full"
                                :disabled="form.processing"
                            >
                                Submit
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <div class="w-full h-[450px]">
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3651.0786688468993!2d90.3933336!3d23.780212799999997!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3755c7c1e4894a41%3A0xff06b9b2c56ea696!2sCOMITS%20COMPUTERS!5e0!3m2!1sen!2sbd!4v1777286360295!5m2!1sen!2sbd"
                width="100px"
                height="450"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade"
            ></iframe>
        </div>
    </Layout>
</template>

<style scoped>
.contact-form {
    font-size: 22px;
    font-weight: 700;
}
.contact-form::after {
    content: "";
    display: block;
    width: 80%;
    height: 1px;
    background-color: #376fd1;
    margin-top: 6px;
}
.contact-form::before {
    content: "";
    display: block;
    width: 100%;
    height: 1px;
    background-color: #376fd1;
    margin-bottom: -35px;
}
.booking-form {
    background-color: transparent;
    border: 1px solid rgb(177, 177, 177);
    padding: 0.625rem;
    width: 100%;
    color: black;
    ring-width: 0;
    focus-ring-width: 0;
    outline: none;
}
iframe {
    width: 100%;
    height: 450px;
    border: none;
}
</style>
