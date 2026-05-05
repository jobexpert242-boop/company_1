<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import RichTextEditor from "@/Shared/RichTextEditor.vue";

const props = defineProps({
    features: Array,
    services: Array,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    icon: "",
    title: "",
    description: "",
    service_id: "",
    is_active: false,
});

/* SUBMIT */
const submit = () => {
    form.transform((data) => {
        return {
            ...data,
            is_active: data.is_active ? 1 : 0,
        };
    });
    if (editId.value) {
        form.put(route("features.update", editId.value), {
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("features.store"), {
            onSuccess: () => resetForm(),
        });
    }
};

/* EDIT */
const editData = (item) => {
    editId.value = item.id;
    selected.value = item;

    form.icon = item.icon;
    form.title = item.title;
    form.description = item.description;
    form.service_id = item.service_id;
    form.is_active = item.is_active ? 1 : 0;
};

/* DELETE */
const deleteData = (id) => {
    if (confirm("Delete this feature?")) {
        form.delete(route("features.destroy", id));
    }
};

/* RESET */
const resetForm = () => {
    editId.value = null;
    selected.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Feature Management" />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">Feature List</h2>

                <table class="w-full text-sm border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Icon</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Service</th>
                            <th class="p-2 border">Status</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in features" :key="item.id">
                            <td class="border p-2">{{ i + 1 }}</td>

                            <td class="border p-2 text-center">
                                <i :class="item.icon"></i>
                            </td>

                            <td class="border p-2">{{ item.title }}</td>

                            <td class="border p-2">
                                {{ item.service?.title }}
                            </td>

                            <td class="border p-2">
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
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit Feature" : "Add Feature" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="form-label">Icon</label>
                        <input
                            v-model="form.icon"
                            placeholder="Icon class (fa-solid fa-star)"
                            class="input"
                        />
                        <p v-if="form.errors.icon" class="error">
                            {{ form.errors.icon }}
                        </p>
                        <div v-if="form.icon" class="mt-2">
                            <i
                                :class="form.icon + ' text-2xl text-blue-500'"
                            ></i>
                        </div>
                    </div>

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
                        <label class="form-label">Service</label>
                        <select v-model="form.service_id" class="input">
                            <option value="">Select Service</option>
                            <option
                                v-for="s in services"
                                :key="s.id"
                                :value="s.id"
                            >
                                {{ s.title }}
                            </option>
                        </select>
                        <p v-if="form.errors.service_id" class="error">
                            {{ form.errors.service_id }}
                        </p>
                    </div>

                    <div>
                        <label class="form-label">Description</label>
                        <RichTextEditor
                            v-model="form.description"
                            placeholder="Write your description..."
                            :error="form.errors.description"
                        />
                    </div>
                    <label class="flex gap-2 select-none">
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
