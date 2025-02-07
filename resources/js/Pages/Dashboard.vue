<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import PostForm from '@/Components/User/PostForm.vue';
import PostList from '@/Components/User/PostList.vue';
</script>

<template>
    <Head title="BREAD" />
  
    <AuthenticatedLayout>
      <template #header>
        <h2 class="text-xl font-semibold leading-tight text-gray-800 dark:text-gray-200">
          WELCOME TO BREAD?! (Browse, Read, Edit, Add, Delete)
        </h2>
      </template>
  
      <div class="py-12">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div class="p-6 text-gray-900 dark:text-gray-100">
              You're logged in!
            </div>
          </div>
        </div>
      </div>
  
      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <PostForm />
      </div>
  
      <div class="py-10">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
          <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg dark:bg-gray-800">
            <div class="p-6 text-gray-900 dark:text-gray-100">
             Suggested Post
            </div>
          </div>
        </div>
      </div>

      <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
        <PostList />
      </div>
    </AuthenticatedLayout>
  </template>