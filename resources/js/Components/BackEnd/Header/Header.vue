<script setup>
import { Link, router, usePage } from "@inertiajs/vue3";
import { ref, onMounted, onBeforeUnmount, computed } from "vue";
import { route } from "ziggy-js";

const page = usePage();
const props = defineProps({ auth: Object });

const auth = props.auth || page.props.auth || {};

const open = ref(false);
const isOpen = ref(false);
const isDark = ref(false);

// notifications
const notifications = ref(
    page.props.notifications?.data || page.props.notifications || [],
);

// unread count
const notificationCount = computed(() => {
    return notifications.value.filter((n) => !n.is_read).length;
});

/* =========================
   PROFILE MENU
========================= */
function toggleMenu() {
    open.value = !open.value;
}

/* =========================
   NOTIFICATION MENU
========================= */
const toggleDropdown = () => {
    isOpen.value = !isOpen.value;
};

const goToDetails = (item) => {
    const index = notifications.value.findIndex((n) => n.id === item.id);

    if (index !== -1) {
        // instant UI update
        notifications.value[index].is_read = true;
        notifications.value = [...notifications.value];
    }

    // update DB first
    router.post(
        route("notifications.read", item.id),
        {},
        {
            preserveScroll: true,
            onSuccess: () => {
                router.get(route("notifications.show", item.id));
            },
        },
    );
};

const goToAll = () => {
    router.visit(route("notifications.index"));
};

/* =========================
   CLICK OUTSIDE (ONE ONLY)
========================= */
function handleClickOutside(e) {
    if (!e.target.closest(".profile-dropdown")) {
        open.value = false;
    }

    if (!e.target.closest("#notification-dropdown")) {
        isOpen.value = false;
    }
}

/* =========================
   THEME
========================= */
function applyTheme() {
    if (isDark.value) {
        document.documentElement.classList.add("dark");
        localStorage.setItem("theme", "dark");
    } else {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("theme", "light");
    }
}

function toggleTheme() {
    isDark.value = !isDark.value;
    applyTheme();
}

/* =========================
   ECHO REALTIME
========================= */
let echoChannel = null;

onMounted(() => {
    document.addEventListener("click", handleClickOutside);

    const saved = localStorage.getItem("theme");
    isDark.value = saved === "dark";
    applyTheme();

    if (window.Echo) {
        window.Echo.channel("notifications").listen(".NewNotification", (e) => {
            // force reactivity
            notifications.value = [
                e.notification,
                ...notifications.value,
            ].slice(0, 10);
        });
    }
});

/* =========================
   CLEANUP
========================= */
onBeforeUnmount(() => {
    document.removeEventListener("click", handleClickOutside);

    if (echoChannel) {
        window.Echo.leave("notifications");
    }
});
</script>

<template>
    <div
        class="flex justify-between bg-indigo-800 py-4 px-10 items-center border-b-2"
    >
        <div>
            <Link :href="route('admin.dashboard')"
                ><img
                    :src="`/storage/${$page.props.site?.logo}`"
                    class="h-12"
                    alt="ComitsBD Admin"
            /></Link>
        </div>
        <div class="flex gap-10 items-center">
            <h2 class="text-lg underline font-bold text-slate-200">
                <a :href="route('home')" target="_blank">Visit Site</a>
            </h2>
            <button
                @click="toggleTheme"
                class="border rounded-full h-12 w-12 border-white text-white flex items-center justify-center gap-2"
            >
                <!-- Sun (Light mode) -->
                <i v-if="!isDark" class="fa-regular fa-sun text-yellow-400"></i>

                <!-- Moon (Dark mode) -->
                <i v-else class="fa-regular fa-moon text-gray-200"></i>
            </button>
            <div class="relative profile-dropdown">
                <!-- USER ICON -->
                <div
                    @click="toggleMenu"
                    class="flex gap-3 items-center text-xl text-white"
                >
                    <span class="cursor-pointer">{{ auth.user?.name }}</span>
                    <div
                        class="h-12 w-12 rounded-full flex justify-center items-center border border-white text-white cursor-pointer"
                    >
                        <img
                            v-if="auth.user?.image"
                            :src="`/storage/${auth.user?.image}`"
                            class="w-full rounded-full"
                        />
                        <i v-else class="fa-regular fa-user text-2xl"></i>
                    </div>
                </div>

                <!-- DROPDOWN -->
                <ul
                    v-show="open"
                    class="absolute right-0 mt-2 w-48 bg-white text-black shadow-lg rounded-md overflow-hidden"
                >
                    <li>
                        <Link
                            :href="route('admin.profile')"
                            class="p-3 w-full block hover:bg-gray-100"
                            >Profile</Link
                        >
                    </li>

                    <li>
                        <Link
                            :href="route('admin.logout')"
                            method="post"
                            class="p-3 w-full block text-left hover:bg-gray-100 text-red-500"
                            >Logout</Link
                        >
                    </li>
                </ul>
            </div>
            <div id="notification-dropdown" class="relative inline-block">
                <!-- Bell -->
                <button
                    type="button"
                    @click="toggleDropdown"
                    class="text-white text-2xl font-bold relative"
                >
                    <i class="fa-regular fa-bell"></i>

                    <span
                        class="absolute -top-2 -right-2 bg-red-600 text-white text-xs font-bold rounded-full px-2 py-0.5"
                    >
                        {{ notificationCount }}
                    </span>
                </button>

                <!-- Dropdown -->
                <ul
                    v-if="isOpen"
                    class="absolute right-0 mt-2 w-72 bg-white text-black shadow-lg rounded"
                >
                    <!-- LIST -->
                    <li v-if="notifications.length">
                        <div
                            v-for="item in notifications"
                            :key="item.id"
                            @click="goToDetails(item)"
                            class="p-2 cursor-pointer hover:bg-gray-100 border-b"
                        >
                            <!-- TITLE STYLE -->
                            <p
                                :class="
                                    item.is_read
                                        ? 'text-gray-400'
                                        : 'font-bold text-black'
                                "
                            >
                                {{ item.title }}
                            </p>
                        </div>
                    </li>

                    <li v-else class="p-2 text-gray-500">No notifications</li>

                    <!-- READ MORE BUTTON -->
                    <li class="p-2 border-t">
                        <button
                            @click="goToAll"
                            class="w-full bg-blue-500 text-white py-1 rounded hover:bg-blue-600"
                        >
                            Read More
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<style scoped>
li {
    font-weight: 600;
}
</style>
