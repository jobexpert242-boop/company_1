<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, router } from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    notifications: Object,
});

const goToDetails = (item) => {
    router.visit(route("notifications.show", item.id));
};
</script>

<template>
    <Head title="All Notifications" />

    <Layout>
        <div class="max-w-5xl mx-auto p-6">
            <h1 class="text-2xl font-bold mb-5">All Notifications</h1>

            <div class="bg-white shadow rounded">
                <div
                    v-for="item in notifications.data"
                    :key="item.id"
                    class="p-3 border-b cursor-pointer hover:bg-gray-50"
                    @click="goToDetails(item)"
                >
                    <p :class="item.is_read ? 'text-gray-400' : 'font-bold'">
                        {{ item.title }}
                    </p>

                    <small class="text-gray-500">
                        {{ item.created_at }}
                    </small>
                </div>
            </div>

            <div class="mt-4">
                <Pagination :links="notifications.links" />
            </div>
        </div>
    </Layout>
</template>
