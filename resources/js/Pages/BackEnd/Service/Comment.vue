<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { route } from "ziggy-js";
import RichTextEditor from "@/Shared/RichTextEditor.vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    comments: Object,
    services: Array,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    icon: "",
    title: "",
    description: "",
    service_id: "",
});

/* SUBMIT */
const submit = () => {
    if (editId.value) {
        form.put(route("comments.update", editId.value), {
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("comments.store"), {
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
};

/* DELETE */
const deleteData = (id) => {
    if (confirm("Delete this comment?")) {
        form.delete(route("comments.destroy", id));
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
    <Head title="Comment Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">Comment List</h2>

                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Icon</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Service</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in comments.data" :key="item.id">
                            <td class="border p-2">{{ i + 1 }}</td>

                            <!-- ICON -->
                            <td class="border p-2 text-center">
                                <i
                                    :class="
                                        item.icon + ' text-xl text-blue-500'
                                    "
                                ></i>
                            </td>

                            <td class="border p-2">{{ item.title }}</td>

                            <td class="border p-2">
                                {{ item.service?.title }}
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
                <Pagination :links="comments.links" />
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded shadow border-slate-200 h-fit">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit Comment" : "Add Comment" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <!-- ICON INPUT -->
                    <div>
                        <label class="form-label">Icon</label>
                        <input
                            v-model="form.icon"
                            placeholder="Icon (fa-solid fa-star)"
                            class="input"
                        />
                        <p class="text-xs text-gray-500">
                            Example: fa-solid fa-star
                        </p>
                        <p v-if="form.errors.icon" class="error">
                            {{ form.errors.icon }}
                        </p>

                        <!-- PREVIEW -->
                        <div v-if="form.icon" class="mt-2">
                            <i
                                :class="form.icon + ' text-2xl text-blue-500'"
                            ></i>
                        </div>
                    </div>

                    <!-- TITLE -->
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

                    <!-- PORTFOLIO -->
                    <div>
                        <label class="form-label">Service</label>
                        <select v-model="form.service_id" class="input">
                            <option value="">Select Portfolio</option>
                            <option
                                v-for="p in services"
                                :key="p.id"
                                :value="p.id"
                            >
                                {{ p.title }}
                            </option>
                        </select>
                        <p v-if="form.errors.service_id" class="error">
                            {{ form.errors.service_id }}
                        </p>
                    </div>

                    <!-- DESCRIPTION -->
                    <div>
                        <label class="form-label">Description</label>
                        <RichTextEditor
                            v-model="form.description"
                            placeholder="Write your description..."
                            :error="form.errors.description"
                        />
                    </div>

                    <!-- BUTTONS -->
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
