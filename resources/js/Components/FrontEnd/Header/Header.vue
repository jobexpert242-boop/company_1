<script setup>
import { computed, ref } from "vue";
import { Link, usePage } from "@inertiajs/vue3";
import { route } from "ziggy-js";

const isOpen = ref(false);

const page = usePage();

const services = computed(() => page.props.globalServices);
</script>

<template>
    <div class="bg">
        <div
            class="flex flex-wrap gap-4 md:justify-between md:items-center justify-center items-center py-4 container mx-auto"
        >
            <div class="flex items-center gap-4">
                <a
                    :href="$page.props.header.facebook"
                    target="_blank"
                    class="text-white"
                    ><i class="fab fa-facebook-f"></i
                ></a>
                <a
                    :href="$page.props.header.twitter"
                    target="_blank"
                    class="text-white"
                    ><i class="fab fa-twitter"></i
                ></a>
                <a
                    :href="$page.props.header.linkedin"
                    target="_blank"
                    class="text-white"
                    ><i class="fab fa-linkedin-in"></i
                ></a>
                <a
                    :href="$page.props.header.pinterest"
                    target="_blank"
                    class="text-white"
                    ><i class="fab fa-pinterest"></i
                ></a>
                <a
                    :href="$page.props.header.youtube"
                    target="_blank"
                    class="text-white"
                    ><i class="fab fa-youtube"></i
                ></a>
            </div>

            <div class="flex gap-4 items-center">
                <a
                    :href="'mailto:' + $page.props.header.email"
                    class="text-white"
                >
                    <i class="fa fa-envelope"></i>
                    {{ $page.props.header.email }}
                </a>
                <a :href="'tel:' + $page.props.header.phone" class="text-white">
                    <i class="fa fa-phone"></i> {{ $page.props.header.phone }}
                </a>
            </div>
        </div>
    </div>

    <header class="sticky top-0 z-50 bg-white shadow">
        <div class="container mx-auto">
            <div class="flex justify-between items-center py-2">
                <!-- Logo -->
                <Link
                    :href="route('home')"
                    class="text-xl font-bold text-indigo-600"
                >
                    <img
                        width="150"
                        :src="`/storage/${$page.props.site?.logo}`"
                        alt="logo"
                    />
                </Link>

                <!-- Hamburger (mobile) -->
                <button
                    @click="isOpen = !isOpen"
                    class="md:hidden text-gray-700 focus:outline-none"
                >
                    <i
                        :class="
                            isOpen
                                ? 'fa-solid fa-xmark text-2xl'
                                : 'fa-solid fa-bars text-2xl'
                        "
                    ></i>
                </button>

                <!-- Nav (desktop) -->
                <nav class="hidden md:block">
                    <ul class="flex gap-10 font-[800]">
                        <li>
                            <Link
                                :href="route('home')"
                                :class="
                                    route().current('home')
                                        ? 'text-[#376fd1]'
                                        : 'text-gray-700 hover:text-[#376fd1]'
                                "
                            >
                                Home
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('about')"
                                :class="
                                    route().current('about')
                                        ? 'text-[#376fd1]'
                                        : 'text-gray-700 hover:text-[#376fd1]'
                                "
                            >
                                About
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('team')"
                                :class="
                                    route().current('team')
                                        ? 'text-[#376fd1]'
                                        : 'text-gray-700 hover:text-[#376fd1]'
                                "
                            >
                                Team
                            </Link>
                        </li>
                        <li class="relative group">
                            <!-- Main Link -->
                            <Link
                                :href="route('services')"
                                class="flex items-center gap-1 text-gray-700 hover:text-[#376fd1] transition"
                            >
                                Services
                                <i
                                    class="fa-solid fa-angle-down text-xl font-bold"
                                ></i>
                            </Link>

                            <!-- Dropdown -->
                            <ul
                                class="absolute left-0 top-full mt-2 w-64 bg text-white rounded shadow-lg opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50"
                            >
                                <li
                                    v-for="service in services"
                                    :key="service.id"
                                >
                                    <Link
                                        :href="
                                            route(
                                                'services.details',
                                                service.slug,
                                            )
                                        "
                                        class="block px-4 py-2 hover:bg-white hover:text-blue-600 transition"
                                    >
                                        {{ service.title }}
                                    </Link>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <Link
                                :href="route('portfolio')"
                                :class="
                                    route().current('portfolio')
                                        ? 'text-[#376fd1]'
                                        : 'text-gray-700 hover:text-[#376fd1]'
                                "
                            >
                                Portfolio
                            </Link>
                        </li>
                        <li>
                            <Link
                                :href="route('contact')"
                                :class="
                                    route().current('contact')
                                        ? 'text-[#376fd1]'
                                        : 'text-gray-700 hover:text-[#376fd1]'
                                "
                            >
                                Contact
                            </Link>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Mobile menu -->
            <nav v-if="isOpen" class="md:hidden bg-white shadow-lg">
                <ul class="flex flex-col gap-4 font-[800] p-4">
                    <li>
                        <Link
                            :href="route('home')"
                            :class="
                                route().current('home')
                                    ? 'text-[#376fd1]'
                                    : 'text-gray-700 hover:text-[#376fd1]'
                            "
                            >Home</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="route('about')"
                            :class="
                                route().current('about')
                                    ? 'text-[#376fd1]'
                                    : 'text-gray-700 hover:text-[#376fd1]'
                            "
                            >About</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="route('team')"
                            :class="
                                route().current('team')
                                    ? 'text-[#376fd1]'
                                    : 'text-gray-700 hover:text-[#376fd1]'
                            "
                            >Team</Link
                        >
                    </li>
                    <li class="relative group">
                        <!-- Main Link -->
                        <Link
                            :href="route('services')"
                            class="flex items-center gap-1 text-gray-700 hover:text-[#376fd1] transition"
                        >
                            Services
                            <i
                                class="fa-solid fa-angle-down text-xl font-bold"
                            ></i>
                        </Link>

                        <!-- Dropdown -->
                        <ul
                            class="absolute left-0 top-full mt-2 w-64 bg text-white rounded shadow-lg opacity-0 invisible translate-y-2 group-hover:opacity-100 group-hover:visible group-hover:translate-y-0 transition-all duration-300 z-50"
                        >
                            <li v-for="service in services" :key="service.id">
                                <Link
                                    :href="
                                        route('services.details', service.slug)
                                    "
                                    class="block px-4 py-2 hover:bg-white hover:text-blue-600 transition"
                                >
                                    {{ service.title }}
                                </Link>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <Link
                            :href="route('portfolio')"
                            :class="
                                route().current('portfolio')
                                    ? 'text-[#376fd1]'
                                    : 'text-gray-700 hover:text-[#376fd1]'
                            "
                            >Portfolio</Link
                        >
                    </li>
                    <li>
                        <Link
                            :href="route('contact')"
                            :class="
                                route().current('contact')
                                    ? 'text-[#376fd1]'
                                    : 'text-gray-700 hover:text-[#376fd1]'
                            "
                            >Contact</Link
                        >
                    </li>
                </ul>
            </nav>
        </div>
    </header>
</template>
