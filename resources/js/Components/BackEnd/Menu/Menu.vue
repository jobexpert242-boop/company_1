<script setup>
import { ref, computed, onMounted, onUnmounted } from "vue";
import { Link } from "@inertiajs/vue3";
import { route } from "ziggy-js";

/* =========================
   SEARCH
========================= */
const search = ref("");

/* =========================
   MENU (DYNAMIC)
========================= */
const menu = ref([
    {
        title: "Dashboard",
        route: "admin.dashboard",
        icon: "fa-solid fa-gauge",
    },
    {
        title: "Setting",
        icon: "fa-solid fa-gear",
        children: [
            {
                title: "Create Permission",
                route: "permissions.index",
                icon: "fa-solid fa-unlock",
            },
            {
                title: "Create Role",
                route: "roles.index",
                icon: "fa-regular fa-user",
            },
            {
                title: "Create User",
                route: "users.index",
                icon: "fa-solid fa-users",
            },
            {
                title: "Site Setting",
                route: "admin.sitesetting",
                icon: "fa-solid fa-gear",
            },
        ],
    },
    {
        title: "Portfolio",
        icon: "fa-brands fa-deviantart",
        children: [
            {
                title: "Category",
                route: "categories.index",
                icon: "fa-solid fa-table-list",
            },
            {
                title: "Portfolio",
                route: "portfolios.index",
                icon: "fa-brands fa-deviantart",
            },
        ],
    },
    {
        title: "Service",
        icon: "fa-brands fa-servicestack",
        children: [
            {
                title: "Service",
                route: "service.index",
                icon: "fa-brands fa-servicestack",
            },
            {
                title: "Comment",
                route: "comments.index",
                icon: "fa-regular fa-comment",
            },
            {
                title: "Feature",
                route: "features.index",
                icon: "fa-solid fa-feather",
            },
        ],
    },
    {
        title: "Header",
        route: "headers.index",
        icon: "fa-solid fa-heading",
    },
    {
        title: "Footer",
        route: "footer.index",
        icon: "fa-solid fa-paw",
    },
    {
        title: "About",
        route: "about.index",
        icon: "fa-solid fa-info-circle",
    },
    {
        title: "Privacy Policy",
        route: "privacy.index",
        icon: "fa-solid fa-anchor-lock",
    },
    {
        title: "Termes&Condition",
        route: "termes.index",
        icon: "fa-solid fa-t",
    },
    {
        title: "Faq",
        route: "faqs.index",
        icon: "fa-regular fa-circle-question",
    },
    {
        title: "Team",
        route: "teams.index",
        icon: "fa-solid fa-people-group",
    },
    {
        title: "Home Carousel",
        route: "home-carousels.index",
        icon: "fa-solid fa-car-side",
    },
    {
        title: "Service Carousel",
        route: "service-carousels.index",
        icon: "fa-solid fa-taxi",
    },
    {
        title: "Banner Bg Image",
        route: "banner.index",
        icon: "fa-regular fa-flag",
    },
    {
        title: "Choose Us",
        route: "choose-us.index",
        icon: "fa-solid fa-c",
    },
    {
        title: "Project",
        route: "projects.index",
        icon: "fa-brands fa-product-hunt",
    },
    {
        title: "Company Logo",
        route: "company-logos.index",
        icon: "fa-brands fa-asymmetrik",
    },
    {
        title: "Booking Notification",
        route: "booking.notification",
        icon: "fa-regular fa-bell",
    },
    {
        title: "News Letter",
        route: "newsletter.list",
        icon: "fa-regular fa-newspaper",
    },
    {
        title: "Contact List",
        route: "contact.list",
        icon: "fa-regular fa-address-book",
    },
]);

/* =========================
   DROPDOWN STATE
========================= */
const openDropdowns = ref({});

/* =========================
   CHECK ACTIVE ROUTE
========================= */
function isActive(routeName) {
    return route().current(routeName);
}

/* =========================
   AUTO OPEN IF ACTIVE
========================= */
onMounted(() => {
    menu.value.forEach((item, index) => {
        if (item.children) {
            openDropdowns.value[index] = item.children.some((child) =>
                route().current(child.route),
            );
        } else {
            openDropdowns.value[index] = false;
        }
    });

    document.addEventListener("click", handleClickOutside);
});

/* =========================
   FILTER MENU
========================= */
const filteredMenu = computed(() => {
    if (!search.value) return menu.value;

    const keyword = search.value.toLowerCase();

    return menu.value
        .map((item, index) => {
            if (!item.children) {
                return item.title.toLowerCase().includes(keyword) ? item : null;
            }

            const children = item.children.filter((child) =>
                child.title.toLowerCase().includes(keyword),
            );

            if (children.length) {
                openDropdowns.value[index] = true; // auto open
                return { ...item, children };
            }

            openDropdowns.value[index] = false;
            return null;
        })
        .filter(Boolean);
});

/* =========================
   TOGGLE
========================= */
function toggleDropdown(index) {
    openDropdowns.value[index] = !openDropdowns.value[index];
}

/* =========================
   CLICK OUTSIDE
========================= */
function handleClickOutside(e) {
    if (e.target.closest(".sidebar")) return;

    menu.value.forEach((item, index) => {
        if (item.children?.some((c) => route().current(c.route))) {
            openDropdowns.value[index] = true;
        } else {
            openDropdowns.value[index] = false;
        }
    });
}

function hasActiveChild(item) {
    if (!item.children) return false;

    return item.children.some((child) => route().current(child.route));
}

onUnmounted(() => {
    document.removeEventListener("click", handleClickOutside);
});

/* =========================
   HIGHLIGHT TEXT
========================= */
function highlight(text) {
    if (!search.value) return text;

    const escaped = search.value.replace(/[.*+?^${}()|[\]\\]/g, "\\$&");
    const regex = new RegExp(`(${escaped})`, "gi");

    return text.replace(
        regex,
        `<span class="bg-yellow-400 text-black px-1 rounded">$1</span>`,
    );
}
</script>

<template>
    <div class="sidebar w-64 min-h-screen bg-indigo-800 text-white p-4">
        <!-- SEARCH -->
        <input
            v-model="search"
            placeholder="Search menu..."
            class="form-input mb-3"
        />

        <!-- MENU -->
        <ul class="space-y-2">
            <template v-for="(item, index) in filteredMenu" :key="index">
                <!-- SINGLE ITEM -->
                <li v-if="!item.children">
                    <Link
                        :href="route(item.route)"
                        class="block px-3 py-2 rounded hover:bg-indigo-600 flex items-center gap-2"
                        :class="{ 'bg-indigo-500': isActive(item.route) }"
                    >
                        <i :class="item.icon"></i>
                        <span v-html="highlight(item.title)"></span>
                    </Link>
                </li>

                <!-- DROPDOWN -->
                <li v-else class="dropdown">
                    <button
                        @click="toggleDropdown(index)"
                        class="w-full text-left px-3 py-2 rounded flex justify-between items-center hover:bg-indigo-600"
                        :class="{
                            'bg-indigo-500':
                                openDropdowns[index] ||
                                item.children.some((c) => isActive(c.route)),
                        }"
                    >
                        <div class="flex items-center gap-2">
                            <i :class="item.icon"></i>
                            <span v-html="highlight(item.title)"></span>
                        </div>
                        <span>{{ openDropdowns[index] ? "▼" : "▲" }}</span>
                    </button>

                    <!-- CHILDREN -->
                    <ul
                        v-show="openDropdowns[index]"
                        class="ml-6 mt-2 space-y-1"
                    >
                        <li v-for="child in item.children" :key="child.route">
                            <Link
                                :href="route(child.route)"
                                class="block px-3 py-2 rounded hover:bg-indigo-600"
                                :class="{
                                    'bg-indigo-500': isActive(child.route),
                                }"
                            >
                                <i :class="child.icon"></i>
                                <span
                                    class="ml-2"
                                    v-html="highlight(child.title)"
                                ></span>
                            </Link>
                        </li>
                    </ul>
                </li>
            </template>
        </ul>
    </div>
</template>
