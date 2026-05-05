<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { route } from "ziggy-js";

const props = defineProps({
    header: Object,
});

// single form (auto fill if exists)
const form = useForm({
    facebook: props.header?.facebook || "",
    twitter: props.header?.twitter || "",
    linkedin: props.header?.linkedin || "",
    pinterest: props.header?.pinterest || "",
    youtube: props.header?.youtube || "",
    email: props.header?.email || "",
    phone: props.header?.phone || "",
});

const submit = () => {
    form.post(route("headers.store"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Header Management" />
    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <div class="w-2xl mx-auto bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">
                {{ header ? "Update Header Info" : "Create Header Info" }}
            </h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="form-label">Facebook</label>
                    <input v-model="form.facebook" class="input" />
                    <div v-if="form.errors.facebook" class="error">
                        {{ form.errors.facebook }}
                    </div>
                </div>

                <div>
                    <label class="form-label">Twitter</label>
                    <input v-model="form.twitter" class="input" />
                </div>

                <div>
                    <label class="form-label">LinkedIn</label>
                    <input v-model="form.linkedin" class="input" />
                </div>

                <div>
                    <label class="form-label">Pinterest</label>
                    <input v-model="form.pinterest" class="input" />
                </div>

                <div>
                    <label class="form-label">YouTube</label>
                    <input v-model="form.youtube" class="input" />
                </div>

                <div>
                    <label class="form-label">Email</label>
                    <input v-model="form.email" class="input" />
                    <div v-if="form.errors.email" class="error">
                        {{ form.errors.email }}
                    </div>
                </div>

                <div>
                    <label class="form-label">Phone</label>
                    <input v-model="form.phone" class="input" />
                </div>

                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded"
                    :disabled="form.processing"
                >
                    {{
                        form.processing
                            ? "Saving..."
                            : header
                              ? "Update"
                              : "Save"
                    }}
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
