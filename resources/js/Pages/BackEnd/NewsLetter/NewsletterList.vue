<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, router } from "@inertiajs/vue3";
import Pagination from "@/Shared/Pagination.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";

const props = defineProps({
    newsletter: Object,
});

// delete
const deleteItem = (id) => {
    if (confirm("Are you sure to delete this newsletter?")) {
        router.delete(route("newsletter.destroy", id), {
            preserveScroll: true,
        });
    }
};
</script>

<template>
    <Head title="Newsletter List" />
    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <div class="max-w-6xl mx-auto p-6">
            <!-- Title -->
            <div class="flex justify-between items-center mb-5">
                <h1 class="text-2xl font-bold text-gray-800">
                    Newsletter Subscribers
                </h1>
            </div>

            <!-- Table -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="w-full text-sm text-left">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border">#</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Created At</th>
                            <th class="p-3 border text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr
                            v-for="(item, index) in newsletter.data"
                            :key="item.id"
                            class="hover:bg-gray-50"
                        >
                            <td class="p-3 border">
                                {{ index + 1 }}
                            </td>

                            <td class="p-3 border font-medium text-gray-700">
                                {{ item.email }}
                            </td>

                            <td class="p-3 border text-gray-500">
                                {{ item.created_at }}
                            </td>

                            <td class="p-3 border text-center">
                                <button
                                    @click="deleteItem(item.id)"
                                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-5">
                <Pagination :links="newsletter.links" />
            </div>
        </div>
    </Layout>
</template>
