<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { route } from "ziggy-js";
import Pagination from "@/Shared/Pagination.vue";
import RichTextEditor from "@/Shared/RichTextEditor.vue";
import FileInput from "@/Shared/FileInput.vue";

const props = defineProps({
    services: Object,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    title: "",
    slug: "",
    sub_title: "",
    description: "",
    image: null,
    is_active: false,
});

/* =========================
   SUBMIT
========================= */
const submit = () => {
    form.transform((data) => {
        return {
            ...data,
            is_active: data.is_active ? 1 : 0,
        };
    });
    form.transform((data) => {
        const fd = new FormData();

        for (const key in data) {
            if (key === "image") {
                if (data.image instanceof File) {
                    fd.append("image", data.image);
                }
            } else if (key === "is_active") {
                fd.append("is_active", data.is_active ? 1 : 0);
            } else {
                fd.append(key, data[key] ?? "");
            }
        }

        if (editId.value) {
            fd.append("_method", "PUT");
        }

        return fd;
    }).post(
        editId.value
            ? route("service.update", editId.value)
            : route("service.store"),
        {
            forceFormData: true,
            preserveScroll: true,
            onSuccess: () => resetForm(),
        },
    );
};

/* =========================
   EDIT
========================= */
const editData = (item) => {
    editId.value = item.id;
    selected.value = item;

    form.title = item.title;
    form.slug = item.slug;
    form.sub_title = item.sub_title;
    form.description = item.description;
    form.is_active = item.is_active ? 1 : 0;
};

/* =========================
   DELETE
========================= */
const deleteData = (id) => {
    if (confirm("Delete this service?")) {
        form.delete(route("service.destroy", id));
    }
};

/* =========================
   RESET
========================= */
const resetForm = () => {
    editId.value = null;
    selected.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Service Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ================= LEFT LIST ================= -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3 text-lg">Service List</h2>

                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Image</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in services.data" :key="item.id">
                            <td class="p-2 border">{{ i + 1 }}</td>

                            <td class="p-2 border">
                                <img
                                    :src="'/storage/' + item.image"
                                    class="w-12 h-12 rounded object-cover"
                                    alt="image"
                                    loading="lazy"
                                />
                            </td>

                            <td class="p-2 border">{{ item.title }}</td>

                            <td class="p-2 border">
                                <span
                                    :class="
                                        item.is_active
                                            ? 'text-green-600'
                                            : 'text-red-500'
                                    "
                                >
                                    {{ item.is_active ? "Active" : "Inactive" }}
                                </span>
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
                <Pagination :links="services.links" />
            </div>

            <!-- ================= RIGHT FORM ================= -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3 text-lg">
                    {{ editId ? "Edit Service" : "Add Service" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="form-label">Title</label>
                        <input
                            v-model="form.title"
                            placeholder="Title"
                            class="input"
                        />
                        <p v-if="form.errors.title" class="error">
                            {{ form.errors.title }}
                        </p>
                    </div>

                    <div>
                        <label class="form-label">Slug</label>
                        <input
                            v-model="form.slug"
                            placeholder="Slug"
                            class="input"
                        />
                        <p v-if="form.errors.slug" class="error">
                            {{ form.errors.slug }}
                        </p>
                    </div>

                    <div>
                        <label class="form-label">Sub Title</label>
                        <textarea
                            class="input"
                            rows="5"
                            v-model="form.sub_title"
                            placeholder="Sub Title"
                        ></textarea>
                        <p v-if="form.errors.sub_title" class="error">
                            {{ form.errors.sub_title }}
                        </p>
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <RichTextEditor
                            v-model="form.description"
                            placeholder="Write your Description..."
                            :error="form.errors.description"
                        />
                    </div>

                    <FileInput
                        v-model="form.image"
                        label="Service Image"
                        accept="image/*"
                        :multiple="false"
                        :error="form.errors.image"
                    />
                    <img
                        v-if="selected?.image"
                        :src="'/storage/' + selected.image"
                        class="w-20 mt-2"
                        alt="image"
                        loading="lazy"
                    />

                    <label class="flex items-center gap-2 select-none">
                        <input
                            type="checkbox"
                            v-model="form.is_active"
                            :true-value="1"
                            :false-value="0"
                        />
                        Active
                    </label>

                    <div class="flex gap-2">
                        <button class="btn-primary">
                            {{ editId ? "Update" : "Save" }}
                        </button>

                        <button
                            type="button"
                            @click="resetForm"
                            class="btn-secondary"
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

.btn-primary {
    background: #4f46e5;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
}

.btn-secondary {
    background: gray;
    color: white;
    padding: 8px 14px;
    border-radius: 6px;
}
</style>
