<script setup>
import Layout from "@/Components/BackEnd/Layout/Layout.vue";
import { ref } from "vue";
import { Head, useForm } from "@inertiajs/vue3";
import FileInput from "@/Shared/FileInput.vue";
import { route } from "ziggy-js";
import RichTextEditor from "@/Shared/RichTextEditor.vue";
import FlashMessage from "@/Shared/FlashMessage.vue";
import Pagination from "@/Shared/Pagination.vue";

const props = defineProps({
    teams: Object,
});

const editId = ref(null);

const form = useForm({
    name: "",
    podobi: "",
    image: null,
    facebook: "",
    twitter: "",
    linkdin: "",
    youtube: "",
    email: "",
    website: "",
    description: "",
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
        form.put(route("teams.update", editId.value), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    } else {
        form.post(route("teams.store"), {
            forceFormData: true,
            onSuccess: () => resetForm(),
        });
    }
};

const selectedTeam = ref(null);

// edit
const editData = (team) => {
    editId.value = team.id;
    selectedTeam.value = team;

    form.name = team.name;
    form.podobi = team.podobi;
    form.facebook = team.facebook;
    form.twitter = team.twitter;
    form.linkdin = team.linkdin;
    form.youtube = team.youtube;
    form.email = team.email;
    form.website = team.website;
    form.description = team.description;
    form.is_active = item.is_active ? 1 : 0;
};

// delete
const deleteData = (id) => {
    if (confirm("Delete?")) {
        form.delete(route("teams.destroy", id));
    }
};

// reset
const resetForm = () => {
    editId.value = null;
    form.reset();
};
</script>

<template>
    <Head title="Team Management" />
    <FlashMessage
        v-if="$page.props.flash?.status"
        :message="$page.props.flash.status"
        type="success"
    />
    <Layout>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- LEFT LIST -->
            <div
                class="border p-4 rounded border-slate-300 h-fit overflow-x-scroll"
            >
                <h2 class="font-bold mb-3">Team List</h2>

                <table class="w-full text-sm border">
                    <thead>
                        <tr class="bg-gray-100">
                            <th class="p-2 border">#</th>
                            <th class="p-2 border">Name</th>
                            <th class="p-2 border">Image</th>
                            <th class="p-2 border">Facebook</th>
                            <th class="p-2 border">Twitter</th>
                            <th class="p-2 border">Linkdin</th>
                            <th class="p-2 border">Youtube</th>
                            <th class="p-2 border">Email</th>
                            <th class="p-2 border">Website</th>
                            <th class="p-2 border">Is Active</th>
                            <th class="p-2 border">Action</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr v-for="(team, i) in teams.data" :key="team.id">
                            <td class="border p-2">{{ i + 1 }}</td>
                            <td class="border p-2">{{ team.name }}</td>
                            <td class="border p-2">
                                <img
                                    v-if="team.image"
                                    :src="'/storage/' + team.image"
                                    class="w-10 h-10 rounded"
                                    alt="team image"
                                    loading="lazy"
                                />
                            </td>
                            <td class="border p-2">{{ team.facebook }}</td>
                            <td class="border p-2">{{ team.twitter }}</td>
                            <td class="border p-2">{{ team.linkdin }}</td>
                            <td class="border p-2">{{ team.youtube }}</td>
                            <td class="border p-2">{{ team.email }}</td>
                            <td class="border p-2">{{ team.website }}</td>
                            <td class="border p-2">
                                {{ team.is_active ? "Yes" : "No" }}
                            </td>
                            <td class="border p-2 space-x-2">
                                <button
                                    @click="editData(team)"
                                    class="bg-blue-500 text-white px-2 py-1 rounded"
                                >
                                    <i class="fa fa-edit"></i>
                                </button>
                                <button
                                    @click="deleteData(team.id)"
                                    class="bg-red-500 text-white px-2 py-1 rounded"
                                >
                                    <i class="fa fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination :links="teams.links" />
            </div>

            <!-- RIGHT FORM -->
            <div class="border p-4 rounded border-slate-300 h-fit">
                <h2 class="font-bold mb-3">
                    {{ editId ? "Edit Team" : "Add Team" }}
                </h2>

                <form @submit.prevent="submit" class="space-y-3">
                    <div>
                        <label class="form-label">Name</label>
                        <input
                            v-model="form.name"
                            placeholder="Name"
                            class="input"
                        />
                        <div v-if="form.errors.name" class="error">
                            {{ form.errors.name }}
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Podobi</label>
                        <input
                            v-model="form.podobi"
                            placeholder="Podobi"
                            class="input"
                        />
                        <div v-if="form.errors.podobi" class="error">
                            {{ form.errors.podobi }}
                        </div>
                    </div>
                    <div>
                        <FileInput
                            v-model="form.image"
                            label="Image"
                            accept="image/*"
                            :multiple="false"
                            :error="form.errors.image"
                        />
                        <div>
                            <img
                                v-if="selectedTeam?.image"
                                :src="'/storage/' + selectedTeam.image"
                                class="w-20 h-20 rounded"
                                alt="image"
                                loading="lazy"
                            />
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Facebook</label>
                        <input
                            v-model="form.facebook"
                            placeholder="Facebook"
                            class="input"
                        />
                    </div>
                    <div>
                        <label class="form-label">Twitter</label>
                        <input
                            v-model="form.twitter"
                            placeholder="Twitter"
                            class="input"
                        />
                    </div>
                    <div>
                        <label class="form-label">Linkdin</label>
                        <input
                            v-model="form.linkdin"
                            placeholder="LinkedIn"
                            class="input"
                        />
                    </div>
                    <div>
                        <label class="form-label">Youtube</label>
                        <input
                            v-model="form.youtube"
                            placeholder="YouTube"
                            class="input"
                        />
                    </div>
                    <div>
                        <label class="form-label">Email</label>
                        <input
                            v-model="form.email"
                            placeholder="Email"
                            class="input"
                        />
                        <div v-if="form.errors.email" class="error">
                            {{ form.errors.email }}
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Website</label>
                        <input
                            v-model="form.website"
                            placeholder="Website"
                            class="input"
                        />
                        <div v-if="form.errors.website" class="error">
                            {{ form.errors.website }}
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Description</label>
                        <RichTextEditor
                            v-model="form.description"
                            placeholder="Description"
                            :error="form.errors.description"
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
                        <button
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
