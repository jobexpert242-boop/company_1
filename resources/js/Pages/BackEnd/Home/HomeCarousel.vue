<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FileInput from "@/Shared/FileInput.vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    carousels: Object,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    title: "",
    description: "",
    image: null,
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
        form.put(route("home-carousels.update", editId.value), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("home-carousels.store"), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    }
};

// edit
const editData = (item) => {
    editId.value = item.id;
    selected.value = item;

    form.title = item.title;
    form.description = item.description;
    form.is_active = item.is_active ? 1 : 0;
};

// delete
const deleteData = (id) => {
    if (confirm("Delete?")) {
        form.delete(route("home-carousels.destroy", id));
    }
};

// reset
const resetForm = () => {
    editId.value = null;
    selected.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Home Carousel Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div class="border p-4 rounded border-slate-200 shadow h-fit">
                <h2 class="font-bold mb-3">Carousel List</h2>

                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Description</th>
                            <th class="p-2 border">Image</th>
                            <th class="p-2 border">Is Active</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in carousels.data" :key="item.id">
                            <td class="border p-2">{{ i + 1 }}</td>
                            <td class="border p-2">{{ item.title }}</td>
                            <td class="border p-2">{{ item.description }}</td>
                            <td class="border p-2">
                                <img
                                    :src="'/storage/' + item.image"
                                    class="w-12 h-12"
                                />
                            </td>
                            <td class="border p-2">
                                {{ item.is_active ? "Yes" : "No" }}
                            </td>
                            <td class="border p-2 space-x-2">
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
                <Pagination :links="carousels.links" />
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded border-slate-200 shadow h-fit">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit Carousel" : "Add Carousel" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <input
                            v-model="form.title"
                            placeholder="Title"
                            class="input"
                        />
                        <div v-if="form.errors.title" class="error">
                            {{ form.errors.title }}
                        </div>
                    </div>
                    <div>
                        <textarea
                            v-model="form.description"
                            placeholder="Description"
                            class="input"
                            rows="5"
                        ></textarea>
                        <div v-if="form.errors.description" class="error">
                            {{ form.errors.description }}
                        </div>
                    </div>
                    <div>
                        <FileInput
                            v-model="form.image"
                            label="Image"
                            accept="image/*"
                            :multiple="false"
                            :error="form.errors.image"
                        />
                        <div>
                            <img
                                v-if="selected?.image"
                                :src="'/storage/' + selected.image"
                                class="w-20 h-20 rounded"
                            />
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
