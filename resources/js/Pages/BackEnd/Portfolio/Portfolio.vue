<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import { ref } from "vue";
import FileInput from "@/Shared/FileInput.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import RichTextEditor from "@/Shared/RichTextEditor.vue";

const props = defineProps({
    portfolios: Array,
    categories: Array,
});

const editId = ref(null);
const selected = ref(null);

const form = useForm({
    title: "",
    slug: "",
    image: null,
    description: "",
    client_name: "",
    company_name: "",
    start_date: "",
    end_date: "",
    client_comment: "",
    category_id: "",
    gallery: [],
});

// submit
const submit = () => {
    if (editId.value) {
        form._method = "put";

        form.put(route("portfolios.update", editId.value), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("portfolios.store"), {
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
    form.slug = item.slug;
    form.description = item.description;
    form.client_name = item.client_name;
    form.company_name = item.company_name;
    form.start_date = item.start_date;
    form.end_date = item.end_date;
    form.client_comment = item.client_comment;
    form.category_id = item.category_id;
};

// delete
const deleteData = (id) => {
    if (confirm("Delete this portfolio?")) {
        form.delete(route("portfolios.destroy", id));
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
    <Head title="Portfolio Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- ================= LEFT TABLE ================= -->
            <div
                class="border rounded shadow p-4 overflow-auto border-slate-200 h-fit"
            >
                <h2 class="font-bold mb-3 text-lg">Portfolio List</h2>

                <table class="w-full text-sm border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Image</th>
                            <th class="p-2 border">Title</th>
                            <th class="p-2 border">Client</th>
                            <th class="p-2 border">Company</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(item, i) in portfolios" :key="item.id">
                            <td class="border p-2">{{ i + 1 }}</td>

                            <td class="border p-2">
                                <img
                                    :src="'/storage/' + item.image"
                                    class="w-12 h-12 object-cover rounded"
                                />
                            </td>

                            <td class="border p-2">{{ item.title }}</td>
                            <td class="border p-2">
                                {{ item.client_name }}
                            </td>
                            <td class="border p-2">
                                {{ item.company_name }}
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

            <!-- ================= RIGHT FORM ================= -->
            <div class="border rounded shadow p-4 border-slate-200 h-fit">
                <h2 class="font-bold mb-3 text-lg">
                    {{ editId ? "Edit Portfolio" : "Add Portfolio" }}
                </h2>

                <form
                    @submit.prevent="submit"
                    class="space-y-3"
                    enctype="multipart/form-data"
                >
                    <!-- Title -->
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

                    <!-- Slug -->
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

                    <!-- Category -->
                    <div>
                        <label class="form-label">Category</label>
                        <select v-model="form.category_id" class="input">
                            <option value="">Select Category</option>
                            <option
                                v-for="cat in categories"
                                :key="cat.id"
                                :value="cat.id"
                            >
                                {{ cat.name }}
                            </option>
                        </select>
                        <p v-if="form.errors.category_id" class="error">
                            {{ form.errors.category_id }}
                        </p>
                    </div>

                    <!-- Client -->
                    <div>
                        <label class="form-label">Client Name</label>
                        <input
                            v-model="form.client_name"
                            placeholder="Client Name"
                            class="input"
                        />
                        <p v-if="form.errors.client_name" class="error">
                            {{ form.errors.client_name }}
                        </p>
                    </div>

                    <!-- Company -->
                    <div>
                        <label class="form-label">Company Name</label>
                        <input
                            v-model="form.company_name"
                            placeholder="Company Name"
                            class="input"
                        />
                        <p v-if="form.errors.company_name" class="error">
                            {{ form.errors.company_name }}
                        </p>
                    </div>

                    <!-- Dates -->
                    <div class="flex gap-2">
                        <div class="w-full">
                            <label class="form-label">Project Start Date</label>
                            <input
                                type="date"
                                v-model="form.start_date"
                                class="input w-full"
                            />
                            <p v-if="form.errors.start_date" class="error">
                                {{ form.errors.start_date }}
                            </p>
                        </div>
                        <div class="w-full">
                            <label class="form-label">Project End Date</label>
                            <input
                                type="date"
                                v-model="form.end_date"
                                class="input w-full"
                            />
                            <p v-if="form.errors.end_date" class="error">
                                {{ form.errors.end_date }}
                            </p>
                        </div>
                    </div>

                    <!-- Comment -->
                    <div>
                        <label class="form-label">Client Comment</label>
                        <textarea
                            v-model="form.client_comment"
                            placeholder="Client Comment"
                            rows="5"
                            class="input"
                        ></textarea>
                        <p v-if="form.errors.client_comment" class="error">
                            {{ form.errors.client_comment }}
                        </p>
                    </div>

                    <!-- Main Image -->
                    <div>
                        <FileInput
                            v-model="form.image"
                            label="Main Image"
                            accept="image/*"
                            :multiple="false"
                        />
                        <p v-if="form.errors.image" class="error">
                            {{ form.errors.image }}
                        </p>
                    </div>

                    <!-- Preview -->
                    <img
                        v-if="selected?.image"
                        :src="'/storage/' + selected.image"
                        class="w-20 h-20 rounded"
                    />

                    <!-- Gallery -->
                    <div>
                        <FileInput
                            v-model="form.gallery"
                            label="Gallery Image"
                            accept="image/*"
                            :multiple="true"
                        />
                        <p v-if="form.errors.gallery" class="error">
                            {{ form.errors.gallery }}
                        </p>
                    </div>

                    <!-- Old Gallery -->
                    <div v-if="selected?.images" class="flex flex-wrap gap-2">
                        <div
                            v-for="img in selected.images"
                            :key="img.id"
                            class="relative"
                        >
                            <img
                                :src="'/storage/' + img.image"
                                class="w-16 h-16 rounded"
                            />

                            <button
                                @click.prevent="
                                    $inertia.delete(
                                        route('portfolio.image.delete', img.id),
                                    )
                                "
                                class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1"
                            >
                                X
                            </button>
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="form-label">Description</label>
                        <RichTextEditor
                            v-model="form.description"
                            label="Description"
                            placeholder="Write your Description..."
                            :error="form.errors.description"
                        />
                        <p v-if="form.errors.description" class="error">
                            {{ form.errors.description }}
                        </p>
                    </div>

                    <!-- Buttons -->
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
