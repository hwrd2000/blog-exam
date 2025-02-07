<script setup>
import { ref, onMounted } from 'vue';
import axios from 'axios';
import PostItem from '@/Components/User/PostItem.vue';
// import PostForm from '@/Components/User/PostForm.vue';

const posts = ref([]);           
const currentPage = ref(1);
const totalPages = ref(1);

const fetchPosts = async (page = 1) => {
  try {
    const response = await axios.get('/post', { params: { page } });
    const paginationData = response.data.data;
    posts.value = paginationData.data; 
    currentPage.value = paginationData.current_page;
    totalPages.value = paginationData.last_page;
  } catch (error) {
    console.error('Error fetching posts:', error);
  }
};

const handlePostDeleted = (postId) => {
  posts.value = posts.value.filter(post => post.id !== postId);
};

const handlePostCreated = (newPost) => {
  posts.value.unshift(newPost);
};

onMounted(() => {
  fetchPosts();
});
</script>

<template>
  <div>
    <div v-for="post in posts" :key="post.id">
      <PostItem :post="post" @postDeleted="handlePostDeleted" />
    </div>

    <div class="flex justify-between items-center mt-4">
      <button 
        @click="fetchPosts(currentPage - 1)" 
        :disabled="currentPage === 1"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
      >
        Previous
      </button>

      <span style="color: white;">Page {{ currentPage }} of {{ totalPages }}</span>

      <button 
        @click="fetchPosts(currentPage + 1)" 
        :disabled="currentPage === totalPages"
        class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded"
      >
        Next
      </button>
    </div>
  </div>
</template>