<script setup>
import { ref } from "vue";
import axios from "axios";

// const emit = defineEmits(['postCreated']);

const title = ref("");
const content = ref("");
const selectedImage = ref(null);

const handleFileChange = (e) => {
    if (e.target.files && e.target.files[0]) {
        selectedImage.value = e.target.files[0];
    }
};

const submitPost = async () => {
    if (title.value.trim() === "") {
        alert("Title is required.");
        return;
    }
    if (content.value.trim() === "") {
        alert("Content is required.");
        return;
    }

    const formData = new FormData();
    formData.append("title", title.value);
    formData.append("content", content.value);
    if (selectedImage.value) {
        formData.append("image", selectedImage.value);
    }

    try {
        const response = await axios.post("/post", formData, {
            headers: { "Content-Type": "multipart/form-data" },
        });
        console.log("Post created:", response.data);
        // emit('postCreated', response.data.data);
        title.value = "";
        content.value = "";
        selectedImage.value = null;
    } catch (error) {
        console.error("Error creating post:", error);
    }
};
</script>

<template>
    <div
        class="max-w-10xl mx-auto bg-white dark:bg-gray-800 shadow rounded p-4"
    >
        <div>
            <input
                type="text"
                v-model="title"
                placeholder="Title"
                class="w-full p-2 border rounded dark:bg-gray-700 dark:text-gray-100"
            />
        </div>
        <div class="mt-2">
            <textarea
                v-model="content"
                placeholder="What's on your mind?"
                class="w-full p-2 border rounded resize-none dark:bg-gray-700 dark:text-gray-100"
                rows="3"
            ></textarea>
        </div>
        <div class="mt-2">
            <input
                type="file"
                @change="handleFileChange"
                accept="image/*"
                class="block w-full text-sm text-gray-900 dark:text-gray-300"
            />
        </div>
        <div class="flex justify-end mt-2">
            <button
                @click="submitPost"
                class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
            >
                Post
            </button>
        </div>
    </div>
</template>
