<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head } from "@inertiajs/vue3";

const props = defineProps({
    notification: Object,
});
</script>

<template>
    <Head title="Notification Details" />

    <Layout>
        <div class="max-w-5xl mx-auto bg-white shadow-md rounded-lg p-6">
            <!-- Header -->
            <div class="border-b pb-4 mb-6">
                <h1 class="text-2xl font-bold text-gray-800">
                    Notification Details
                </h1>

                <p class="text-sm text-gray-500">ID: #{{ notification?.id }}</p>
            </div>

            <!-- Notification Info -->
            <div class="mb-6 bg-blue-50 p-4 rounded border border-blue-100">
                <h2 class="text-lg font-semibold text-gray-700">
                    {{ notification?.title }}
                </h2>

                <p class="text-xs text-gray-500 mt-1">
                    {{ notification?.created_at }}
                </p>

                <p class="text-gray-700 mt-2">
                    {{ notification?.message }}
                </p>
            </div>

            <!-- ===================== -->
            <!-- BOOKING DETAILS -->
            <!-- ===================== -->
            <!-- BOOKING -->
            <div
                v-if="notification?.type === 'booking' && notification?.booking"
                class="grid grid-cols-2 gap-4"
            >
                <div>
                    <label class="form-label">First Name : </label>
                    <div>{{ notification.booking?.first_name }}</div>
                </div>

                <div>
                    <label class="form-label">Last Name : </label>
                    <div>{{ notification.booking?.last_name }}</div>
                </div>

                <div>
                    <label class="form-label">Phone : </label>
                    <div>{{ notification.booking?.phone }}</div>
                </div>

                <div>
                    <label class="form-label">Email : </label>
                    <div>{{ notification.booking?.email }}</div>
                </div>

                <div class="col-span-2">
                    <label class="form-label">Message : </label>
                    <div>{{ notification.booking?.message }}</div>
                </div>
            </div>

            <!-- CONTACT (same layout as booking) -->
            <div
                v-else-if="
                    notification?.type === 'contact' && notification?.contact
                "
                class="grid grid-cols-2 gap-4"
            >
                <div>
                    <label class="form-label">Name : </label>
                    <div>{{ notification.contact?.name }}</div>
                </div>

                <div>
                    <label class="form-label">Phone : </label>
                    <div>{{ notification.contact?.phone }}</div>
                </div>

                <div>
                    <label class="form-label">Email : </label>
                    <div>{{ notification.contact?.email }}</div>
                </div>

                <div class="col-span-2">
                    <label class="form-label">Subject : </label>
                    <div>{{ notification.contact?.subject }}</div>
                </div>

                <div class="col-span-2">
                    <label class="form-label">Message : </label>
                    <div>{{ notification.contact?.message }}</div>
                </div>
            </div>

            <!-- NEWSLETTER -->
            <div v-else class="bg-gray-50 border p-5 rounded">
                <h3 class="font-bold text-lg">Newsletter</h3>
                <p class="mt-3">{{ notification?.message }}</p>
            </div>

            <!-- Footer -->
            <div class="flex justify-between items-center mt-8">
                <button
                    @click="$inertia.visit(route('admin.dashboard'))"
                    class="bg-gray-600 text-white px-5 py-2 rounded hover:bg-gray-700"
                >
                    ← Back
                </button>

                <button
                    @click="window.print()"
                    class="bg-blue-600 text-white px-5 py-2 rounded hover:bg-blue-700"
                >
                    Print
                </button>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.card {
    background: #f9fafb;
    padding: 12px;
    border-radius: 8px;
    border: 1px solid #e5e7eb;
}

.label {
    font-size: 12px;
    color: #6b7280;
    font-weight: 600;
    display: block;
    margin-bottom: 4px;
}

.value {
    font-size: 14px;
    color: #111827;
}
</style>
