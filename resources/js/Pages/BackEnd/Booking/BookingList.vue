<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import Pagination from "@/Shared/Pagination.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { Head, router } from "@inertiajs/vue3";

const props = defineProps({
    bookings: Object,
});

// delete
const deleteItem = (id) => {
    if (!confirm("Are you sure you want to delete?")) return;

    router.delete(route("bookings.destroy", id), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Booking List" />

    <Layout>
        <FlashMessage
            v-if="$page.props.flash?.status"
            :message="$page.props.flash.status"
            type="success"
        />

        <div class="p-6 bg-white rounded shadow">
            <h2 class="text-2xl font-bold mb-4">Booking List</h2>

            <!-- TABLE -->
            <div class="overflow-x-auto">
                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border">Phone</th>
                            <th class="p-2 border">Email</th>
                            <th class="p-2 border">Subject</th>
                            <th class="p-2 border">Message</th>
                            <th class="p-2 border">Date</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="(item, index) in bookings.data"
                            :key="item.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-2 border">
                                {{ index + 1 }}
                            </td>

                            <td class="p-2 border">
                                {{ item.first_name }} {{ item.last_name }}
                            </td>

                            <td class="p-2 border">
                                {{ item.phone }}
                            </td>

                            <td class="p-2 border">
                                {{ item.email }}
                            </td>

                            <td class="p-2 border">
                                {{ item.subject }}
                            </td>

                            <td class="p-2 border">
                                <span class="line-clamp-2">
                                    {{ item.message }}
                                </span>
                            </td>

                            <td class="p-2 border">
                                {{ item.created_at }}
                            </td>

                            <td class="p-2 border">
                                <button
                                    @click="deleteItem(item.id)"
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <tr v-if="!bookings.data.length">
                            <td colspan="8" class="text-center p-4">
                                No bookings found
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PAGINATION -->
            <div class="mt-4">
                <Pagination :links="bookings.links" />
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
