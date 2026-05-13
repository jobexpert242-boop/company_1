<script setup>
import { ref, watch } from "vue";

const props = defineProps({
    modelValue: {
        type: [File, Array, Object, null],
        default: null,
    },
    label: String,
    accept: { type: String, default: "" },
    multiple: { type: Boolean, default: false },
    error: String,
});

const emit = defineEmits(["update:modelValue"]);

const fileInput = ref(null);
const previewFiles = ref([]);

// ========================
// SELECT FILE
// ========================
function handleFileChange(event) {
    const files = Array.from(event.target.files);

    if (props.multiple) {
        files.forEach((file) => {
            previewFiles.value.push({
                file,
                url: URL.createObjectURL(file),
            });
        });

        emit(
            "update:modelValue",
            previewFiles.value.map((f) => f.file),
        );
    } else {
        const file = files[0] || null;

        previewFiles.value = file
            ? [{ file, url: URL.createObjectURL(file) }]
            : [];

        emit("update:modelValue", file);
    }
}

// ========================
// DROP
// ========================
function handleDrop(event) {
    const files = Array.from(event.dataTransfer.files);

    if (props.multiple) {
        files.forEach((file) => {
            previewFiles.value.push({
                file,
                url: URL.createObjectURL(file),
            });
        });

        emit(
            "update:modelValue",
            previewFiles.value.map((f) => f.file),
        );
    } else {
        const file = files[0] || null;

        previewFiles.value = file
            ? [{ file, url: URL.createObjectURL(file) }]
            : [];

        emit("update:modelValue", file);
    }
}

// ========================
// REMOVE SINGLE IMAGE
// ========================
function removeSingle(index) {
    previewFiles.value.splice(index, 1);

    if (props.multiple) {
        emit(
            "update:modelValue",
            previewFiles.value.map((f) => f.file),
        );
    } else {
        emit("update:modelValue", null);
    }
}

// ========================
// TRIGGER
// ========================
function triggerBrowse() {
    fileInput.value.click();
}

// ========================
// RESET FROM OUTSIDE
// ========================
watch(
    () => props.modelValue,
    (val) => {
        if (!val || (Array.isArray(val) && val.length === 0)) {
            previewFiles.value = [];
        }
    },
);
</script>

<template>
    <div>
        <label v-if="label" class="form-label">
            {{ label }}
        </label>

        <!-- DROP ZONE -->
        <div
            class="form-input p-0 border-2 border-dashed border-gray-300 rounded-md cursor-pointer bg-white"
            @dragover.prevent
            @drop.prevent="handleDrop"
            @click="triggerBrowse"
        >
            <input
                ref="fileInput"
                type="file"
                class="hidden"
                :accept="accept"
                :multiple="multiple"
                @change="handleFileChange"
            />

            <div class="p-4 text-center text-gray-500 text-sm">
                <p v-if="!previewFiles.length">
                    Drag & drop or
                    <span class="underline text-blue-600">browse</span>
                </p>

                <p v-else class="text-xs text-gray-700">
                    {{ previewFiles.length }} file(s) selected
                </p>
            </div>
        </div>

        <!-- PREVIEW -->
        <div class="flex flex-wrap gap-2 mt-3">
            <div
                v-for="(item, index) in previewFiles"
                :key="index"
                class="relative"
            >
                <img
                    :src="item.url"
                    class="w-20 h-20 object-cover rounded"
                    alt="image"
                    loading="lazy"
                />

                <!-- REMOVE SINGLE -->
                <button
                    type="button"
                    @click="removeSingle(index)"
                    class="absolute top-0 right-0 bg-red-600 text-white text-xs px-1 rounded"
                >
                    ✕
                </button>
            </div>
        </div>

        <!-- ERROR -->
        <div v-if="error" class="text-red-500 text-xs mt-1">
            {{ error }}
        </div>
    </div>
</template>

<style scoped>
.form-input {
    transition: border-color 0.2s ease;
}
.form-input:hover {
    border-color: #4b5563;
}
/*
import FileInput from "@/Shared/FileInput.vue";
<FileInput
  v-model="form.avatar"
  label="Profile Picture"
  accept="image/*"
  :multiple="false"
  :error="form.errors.avatar"
/>
*/
</style>
