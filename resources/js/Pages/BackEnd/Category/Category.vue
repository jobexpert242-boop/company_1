<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    categories: Object,
});

const editId = ref(null);

// form
const form = useForm({
    name: "",
    is_active: false,
});

// submit
const submit = () => {
    form.transform((data) => {
        return {
            ...data,
            is_active: data.is_active ? 1 : 0,
        };
    });
    if (editId.value) {
        form.put(route("categories.update", editId.value), {
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("categories.store"), {
            onSuccess: () => resetForm(),
        });
    }
};

// edit
const editData = (item) => {
    editId.value = item.id;
    form.name = item.name;
    form.is_active = item.is_active ? 1 : 0;
};

// delete
const deleteData = (id) => {
    if (confirm("Delete this category?")) {
        form.delete(route("categories.destroy", id));
    }
};

// reset
const resetForm = () => {
    editId.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Category Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">Category List</h2>

                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border">Active</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in categories.data" :key="item.id">
                            <td class="p-2 border">{{ i + 1 }}</td>
                            <td class="p-2 border">{{ item.name }}</td>
                            <td class="p-2 border">
                                {{ item.is_active ? "Yes" : "No" }}
                            </td>

                            <td class="p-2 border space-x-2">
                                <button
                                    @click="editData(item)"
                                    class="bg-blue-500 text-white px-2 py-1 rounded"
                                >
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button
                                    @click="deleteData(item.id)"
                                    class="bg-red-500 text-white px-2 py-1 rounded"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="categories.links" />
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit Category" : "Add Category" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <input
                            v-model="form.name"
                            placeholder="Category name"
                            class="input"
                        />
                        <div v-if="form.errors.name" class="error">
                            {{ form.errors.name }}
                        </div>
                    </div>

                    <label class="form-label">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            :true-value="1"
                            :false-value="0"
                        />
                        Active
                    </label>

                    <div class="flex gap-2">
                        <button
                            class="bg-indigo-600 text-white px-4 py-2 rounded"
                        >
                            {{ editId ? "Update" : "Save" }}
                        </button>

                        <button
                            type="button"
                            @click="resetForm"
                            class="bg-gray-400 text-white px-4 py-2 rounded"
                        >
                            Reset
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </Layout>
</template>

<style scoped>
.input {
    width: 100%;
    border: 1px solid #ccc;
    padding: 8px;
    border-radius: 6px;
}
.error {
    color: red;
    font-size: 12px;
}
</style>
