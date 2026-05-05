<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FileInput from "@/Shared/FileInput.vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    logos: Object,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    name: "",
    link: "",
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
        })).post(route("company-logos.update", editId.value), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("company-logos.store"), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    }
};

// edit
const editData = (item) => {
    editId.value = item.id;
    selected.value = item;

    form.name = item.name;
    form.link = item.link;
    form.is_active = item.is_active ? 1 : 0;

    form.image = null;
};

// delete
const deleteData = (id) => {
    if (confirm("Delete?")) {
        form.delete(route("company-logos.destroy", id));
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
    <Head title="Company Logo Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">Logo List</h2>

                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="border p-2">#</th>
                            <th class="border p-2">Name</th>
                            <th class="border p-2">Link</th>
                            <th class="border p-2">Image</th>
                            <th class="border p-2">Active</th>
                            <th class="border p-2">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in logos.data" :key="item.id">
                            <td class="border p-2">{{ i + 1 }}</td>
                            <td class="border p-2">{{ item.name }}</td>
                            <td class="border p-2">{{ item.link }}</td>
                            <td class="border p-2">
                                <img
                                    v-if="item.image"
                                    :src="'/storage/' + item.image"
                                    class="w-12 h-12"
                                />
                            </td>
                            <td class="border p-2">
                                {{ item.is_active ? "Yes" : "No" }}
                            </td>
                            <td class="space-x-2 border p-2">
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
                <Pagination :links="logos.links" />
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit Logo" : "Add Logo" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="form-label">Company Name</label>
                        <input
                            v-model="form.name"
                            placeholder="Name"
                            class="input"
                        />
                    </div>
                    <div>
                        <label class="form-label">Company Link</label>
                        <input
                            v-model="form.link"
                            placeholder="Link"
                            class="input"
                        />
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

                    <div class="flex gap-2">
                        <button class="bg-indigo-600 text-white px-4 py-2">
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
