<script setup>
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { computed } from "vue";
import { route } from "ziggy-js";

const form = useForm({
    email: "",
});

const submit = () => {
    form.post(route("newsletter.store"), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset();
        },
    });
};

const page = usePage();

const services = computed(() => page.props.globalServices);
</script>

<template>
    <div>
        <div class="bg-white">
            <div
                class="container mx-auto py-10 grid md:grid-cols-4 lg:grid-cols-4 grid-cols-1 gap-5"
            >
                <div>
                    <h2 class="uppercase font-robo inline-block">Newsletter</h2>

                    <p class="leading-7 my-4">
                        {{ $page.props.footer.newsletter_text }}
                    </p>
                    <div>
                        <form
                            @submit.prevent="submit"
                            class="flex items-center relative"
                        >
                            <input
                                v-model="form.email"
                                type="email"
                                placeholder="Email Address"
                                required
                                class="p-3 w-full border-2 border-[#376fd1] text-gray-700 focus:outline-none"
                            />

                            <button
                                type="submit"
                                class="bg-blue-600 text-white p-3 border-2 border-[#376fd1] absolute right-0 top-0 h-full"
                            >
                                <i class="fas fa-location-arrow"></i>
                            </button>
                        </form>
                    </div>
                </div>
                <div>
                    <h2 class="uppercase font-robo inline-block">Services</h2>
                    <ul class="my-4 flex flex-col gap-2">
                        <li v-for="service in services" :key="service.id">
                            <Link
                                :href="route('services.details', service.slug)"
                                class="hover:text-[#376fd1]"
                                ><i class="fas fa-caret-right"></i>
                                {{ service.title }}</Link
                            >
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="uppercase font-robo inline-block">Company</h2>
                    <ul class="my-4 flex flex-col gap-2">
                        <li>
                            <Link
                                :href="route('about')"
                                class="hover:text-[#376fd1]"
                                ><i class="fas fa-caret-right"></i> About
                                Us</Link
                            >
                        </li>
                        <li>
                            <Link
                                :href="route('portfolio')"
                                class="hover:text-[#376fd1]"
                                ><i class="fas fa-caret-right"></i>
                                Portfolio</Link
                            >
                        </li>
                        <li>
                            <Link
                                :href="route('faq')"
                                class="hover:text-[#376fd1]"
                                ><i class="fas fa-caret-right"></i> FAQ</Link
                            >
                        </li>
                        <li>
                            <Link
                                :href="route('privacy-policy')"
                                class="hover:text-[#376fd1]"
                                ><i class="fas fa-caret-right"></i> Privacy
                                policy</Link
                            >
                        </li>
                        <li>
                            <Link
                                :href="route('termes&conditions')"
                                class="hover:text-[#376fd1]"
                                ><i class="fas fa-caret-right"></i> Terms &
                                Conditions</Link
                            >
                        </li>
                    </ul>
                </div>
                <div>
                    <h2 class="uppercase font-robo inline-block">
                        Contact Details
                    </h2>
                    <p class="leading-7 mt-4">
                        <i class="fas fa-map-marker-alt"></i>
                        {{ $page.props.footer.location }}
                    </p>
                    <p class="leading-7 mt-4">
                        <i class="fas fa-phone-alt"></i> Sales:
                        <a :href="'tel:' + $page.props.footer.sales">
                            {{ $page.props.footer.sales }}</a
                        >
                        <br />
                        Support:
                        <a :href="'tel:' + $page.props.footer.support">{{
                            $page.props.footer.support
                        }}</a>
                    </p>
                    <p class="leading-7 mt-4">
                        <i class="fas fa-envelope mr-1.5"></i>

                        <a :href="'mailto:' + $page.props.footer.email_one">{{
                            $page.props.footer.email_one
                        }}</a>
                        <br />
                        <a :href="'mailto:' + $page.props.footer.email_two">{{
                            $page.props.footer.email_two
                        }}</a>
                    </p>
                </div>
            </div>
        </div>
        <footer class="bg-gray-800 text-white py-6">
            <div class="container mx-auto px-4">
                <p class="text-center">
                    Copyright &copy; {{ new Date().getFullYear() }}
                    <a
                        href="https://comitsbd.com/"
                        target="_blank"
                        class="text-blue-500 hover:underline"
                        >ComitsBD</a
                    >
                    . All rights reserved.
                </p>
            </div>
        </footer>
    </div>
</template>

<style scoped>
h2 {
    font-size: 22px;
    font-weight: 700;
}
h2::after {
    content: "";
    display: block;
    width: 80%;
    height: 1px;
    background-color: #376fd1;
    margin-top: 6px;
}
h2::before {
    content: "";
    display: block;
    width: 100%;
    height: 1px;
    background-color: #376fd1;
    margin-bottom: -35px;
}
</style>
