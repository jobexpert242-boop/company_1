<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import { route } from "ziggy-js";
import FlashMessage from "@/Shared/FlashMessage.vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    faqs: Object,
});

const editId = ref(null);

// form
const form = useForm({
    question: "",
    answer: "",
    is_active: false,
    show_home: false,
});

// submit
const submit = () => {
    form.transform((data) => {
        return {
            ...data,
            is_active: data.is_active ? 1 : 0,
            show_home: data.show_home ? 1 : 0,
        };
    });
    if (editId.value) {
        form.put(route("faqs.update", editId.value), {
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("faqs.store"), {
            onSuccess: () => resetForm(),
        });
    }
};

// edit
const editData = (faq) => {
    editId.value = faq.id;

    form.question = faq.question;
    form.answer = faq.answer;
    form.is_active = faq.is_active ? 1 : 0;
    form.show_home = faq.show_home ? 1 : 0;
};

// delete
const deleteData = (id) => {
    if (confirm("Are you sure?")) {
        form.delete(route("faqs.destroy", id));
    }
};

// reset
const resetForm = () => {
    editId.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Faq Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT: FAQ LIST -->
            <div class="border p-4 rounded h-fit border-slate-300">
                <h2 class="font-bold mb-3">FAQ List</h2>

                <table class="w-full border text-sm">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Question</th>
                            <th class="p-2 border">Answer</th>
                            <th class="p-2 border">Active</th>
                            <th class="p-2 border">Home Show</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(faq, i) in faqs.data" :key="faq.id">
                            <td class="border p-2">{{ i + 1 }}</td>
                            <td class="border p-2">{{ faq.question }}</td>
                            <td class="border p-2">{{ faq.answer }}</td>
                            <td class="border p-2">
                                {{ faq.is_active ? "Yes" : "No" }}
                            </td>
                            <td class="border p-2">
                                {{ faq.show_home ? "Yes" : "No" }}
                            </td>
                            <td class="border p-2 space-x-2">
                                <button
                                    @click="editData(faq)"
                                    class="bg-blue-500 text-white px-2 py-1 rounded"
                                >
                                    <i class="fa fa-edit"></i>
                                </button>

                                <button
                                    @click="deleteData(faq.id)"
                                    class="bg-red-500 text-white px-2 py-1 rounded"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="faqs.links" />
            </div>

            <!-- RIGHT: FORM -->
            <div class="border p-4 rounded h-fit border-slate-300">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit FAQ" : "Add FAQ" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="form-label">Question</label>
                        <input v-model="form.question" class="input" />
                        <div v-if="form.errors.question" class="error">
                            {{ form.errors.question }}
                        </div>
                    </div>

                    <div>
                        <label class="form-label">Answer</label>
                        <textarea
                            v-model="form.answer"
                            class="input"
                            rows="5"
                        ></textarea>
                        <div v-if="form.errors.answer" class="error">
                            {{ form.errors.answer }}
                        </div>
                    </div>

                    <div class="flex gap-4">
                        <label>
                            <input
                                type="checkbox"
                                v-model="form.is_active"
                                :true-value="1"
                                :false-value="0"
                            />
                            Active
                        </label>

                        <label>
                            <input
                                type="checkbox"
                                v-model="form.show_home"
                                :true-value="1"
                                :false-value="0"
                            />
                            Show Home
                        </label>
                    </div>

                    <div class="flex gap-2">
                        <button
                            type="submit"
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
