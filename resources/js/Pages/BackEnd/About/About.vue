<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import RichTextEditor from "@/Shared/RichTextEditor.vue";
import { useForm, Head } from "@inertiajs/vue3";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { route } from "ziggy-js";

const props = defineProps({
    about: Object,
});

// form (auto fill if exists)
const form = useForm({
    title: props.about?.title || "",
    description: props.about?.description || "",
});

const submit = () => {
    form.post(route("about.store"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="About Management" />
    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
            <h1 class="text-2xl font-bold mb-4">
                {{ about ? "Update About Page" : "Create About Page" }}
            </h1>

            <form @submit.prevent="submit" class="space-y-4">
                <!-- TITLE -->
                <div>
                    <label class="block mb-1">Title</label>
                    <input type="text" v-model="form.title" class="input" />
                    <div v-if="form.errors.title" class="error">
                        {{ form.errors.title }}
                    </div>
                </div>

                <!-- DESCRIPTION -->
                <div>
                    <label class="block mb-1">Description</label>
                    <RichTextEditor
                        v-model="form.description"
                        placeholder="Write your description..."
                        :error="form.errors.description"
                    />
                </div>

                <!-- BUTTON -->
                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded"
                    :disabled="form.processing"
                >
                    {{
                        form.processing
                            ? "Saving..."
                            : about
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
