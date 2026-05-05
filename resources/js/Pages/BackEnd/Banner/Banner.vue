<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { Head, useForm } from "@inertiajs/vue3";
import FileInput from "@/Shared/FileInput.vue";
import RichTextEditor from "@/Shared/RichTextEditor.vue";

const props = defineProps({
    banner: Object,
});

const form = useForm({
    title: props.banner?.title || "",
    description: props.banner?.description || "",
    about_image: null,
    team_image: null,
    service_image: null,
    portfolio_image: null,
    contact_image: null,
    portfoliodetailes_image: null,
    project_image: null,
    booking_image: null,
});

const submit = () => {
    form.post(route("banner.store"), {
        forceFormData: true,
    });
};
</script>

<template>
    <Head title="Banner Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">
                {{ banner ? "Update Banner" : "Create Banner" }}
            </h2>

            <form @submit.prevent="submit" class="space-y-4">
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
                    <RichTextEditor
                        v-model="form.description"
                        placeholder="Write description..."
                        :error="form.errors.description"
                    />
                    <div v-if="form.errors.description" class="error">
                        {{ form.errors.description }}
                    </div>
                </div>

                <!-- IMAGE INPUTS -->
                <div>
                    <FileInput v-model="form.about_image" label="About Image" />
                    <img
                        v-if="banner?.about_image"
                        :src="'/storage/' + banner.about_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput v-model="form.team_image" label="Team Image" />
                    <img
                        v-if="banner?.team_image"
                        :src="'/storage/' + banner.team_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput
                        v-model="form.service_image"
                        label="Service Image"
                    />
                    <img
                        v-if="banner?.service_image"
                        :src="'/storage/' + banner.service_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput
                        v-model="form.portfolio_image"
                        label="Portfolio Image"
                    />
                    <img
                        v-if="banner?.portfolio_image"
                        :src="'/storage/' + banner.portfolio_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput
                        v-model="form.contact_image"
                        label="Contact Image"
                    />
                    <img
                        v-if="banner?.contact_image"
                        :src="'/storage/' + banner.contact_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput
                        v-model="form.portfoliodetailes_image"
                        label="Portfolio Details Image"
                    />
                    <img
                        v-if="banner?.portfoliodetailes_image"
                        :src="'/storage/' + banner.portfoliodetailes_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput
                        v-model="form.project_image"
                        label="Project Image"
                    />
                    <img
                        v-if="banner?.project_image"
                        :src="'/storage/' + banner.project_image"
                        class="h-20"
                    />
                </div>
                <div>
                    <FileInput
                        v-model="form.booking_image"
                        label="Booking Image"
                    />
                    <img
                        v-if="banner?.booking_image"
                        :src="'/storage/' + banner.booking_image"
                        class="h-20"
                    />
                </div>

                <button class="bg-indigo-600 text-white px-4 py-2 rounded">
                    {{ banner ? "Update" : "Save" }}
                </button>
            </form>
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
