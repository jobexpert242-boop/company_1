<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { Head, useForm } from "@inertiajs/vue3";
import FlashMessage from "@/Shared/FlashMessage.vue";
import { route } from "ziggy-js";

const props = defineProps({
    footer: Object,
});

// single form (auto fill if exists)
const form = useForm({
    newsletter_text: props.footer?.newsletter_text || "",
    location: props.footer?.location || "",
    sales: props.footer?.sales || "",
    support: props.footer?.support || "",
    email_one: props.footer?.email_one || "",
    email_two: props.footer?.email_two || "",
});

const submit = () => {
    form.post(route("footer.store"), {
        preserveScroll: true,
    });
};
</script>

<template>
    <Head title="Footer Management" />

    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />

    <Layout>
        <div class="w-2xl mx-auto bg-white p-6 rounded shadow">
            <h2 class="text-xl font-bold mb-4">
                {{ footer ? "Update Footer" : "Create Footer" }}
            </h2>

            <form @submit.prevent="submit" class="space-y-4">
                <div>
                    <label class="form-label">Newsletter Text</label>
                    <input v-model="form.newsletter_text" class="input" />
                </div>

                <div>
                    <label class="form-label">Location</label>
                    <input v-model="form.location" class="input" />
                </div>

                <div>
                    <label class="form-label">Sales</label>
                    <input v-model="form.sales" class="input" />
                </div>

                <div>
                    <label class="form-label">Support</label>
                    <input v-model="form.support" class="input" />
                </div>

                <div>
                    <label class="form-label">Email One</label>
                    <input v-model="form.email_one" class="input" />
                    <div v-if="form.errors.email_one" class="error">
                        {{ form.errors.email_one }}
                    </div>
                </div>

                <div>
                    <label class="form-label">Email Two</label>
                    <input v-model="form.email_two" class="input" />
                    <div v-if="form.errors.email_two" class="error">
                        {{ form.errors.email_two }}
                    </div>
                </div>

                <button
                    type="submit"
                    class="bg-indigo-600 text-white px-4 py-2 rounded"
                    :disabled="form.processing"
                >
                    {{
                        form.processing
                            ? "Saving..."
                            : footer
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
