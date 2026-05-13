<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FileInput from "@/Shared/FileInput.vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    items: Object,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    icon: "",
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
        form.transform((data) => ({
            ...data,
            _method: "put",
        })).post(route("choose-us.update", editId.value), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("choose-us.store"), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    }
};

// edit
const editData = (item) => {
    editId.value = item.id;
    selected.value = item;

    form.icon = item.icon;
    form.title = item.title;
    form.description = item.description;
    form.is_active = item.is_active ? 1 : 0;

    form.image = null;
};

// delete
const deleteData = (id) => {
    if (confirm("Delete?")) {
        form.delete(route("choose-us.destroy", id));
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
    <Head title="Choose Us Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">Choose Us List</h2>

                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Icon</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Description</th>
                            <th class="p-2 border">Image</th>
                            <th class="p-2 border">Active</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in items.data" :key="item.id">
                            <td class="p-2 border">{{ i + 1 }}</td>
                            <td class="p-2 border">
                                <i :class="item.icon"></i>
                            </td>
                            <td class="p-2 border">{{ item.title }}</td>
                            <td class="p-2 border">{{ item.description }}</td>
                            <td class="p-2 border">
                                <img
                                    v-if="item.image"
                                    :src="'/storage/' + item.image"
                                    class="w-12 h-12"
                                    alt="item image"
                                    loading="lazy"
                                />
                            </td>
                            <td class="p-2 border">
                                {{ item.is_active ? "Yes" : "No" }}
                            </td>
                            <td class="p-2 border">
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
                <Pagination :links="items.links" />
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="mb-2 font-bold">
                    {{ editId ? "Edit Choose Us" : "Add Choose Us" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="form-label">Icon</label>
                        <input
                            v-model="form.icon"
                            placeholder="Icon class"
                            class="input"
                        />
                        <div v-if="form.errors.icon" class="error">
                            {{ form.errors.icon }}
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Title</label>
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
                        <label class="form-label">Description</label>
                        <textarea
                            v-model="form.description"
                            rows="5"
                            class="input"
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
                        <img
                            v-if="selected?.image"
                            :src="'/storage/' + selected.image"
                            class="w-20 h-20"
                            alt="selected image"
                            loading="lazy"
                        />
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
                    <!-- live icon preview -->
                    <div>
                        <span class="text-gray-500">Preview Icon :</span>
                        <i :class="form.icon" class="ml-2"></i>
                    </div>
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
