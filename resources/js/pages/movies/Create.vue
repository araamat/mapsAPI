<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';

const form = useForm({
  title: '',
  description: '',
  image: '',
  director: '',
  release_year: '',
});

const submit = () => {
  form.post('/movies', {
    onSuccess: () => form.reset(),
  });
};
</script>

<template>
  <AppLayout>
    <div class="max-w-3xl mx-auto p-6 bg-white rounded shadow">
      <h1 class="text-3xl font-bold mb-6">Add New Movie</h1>
      <form @submit.prevent="submit" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div class="col-span-2">
          <label class="block mb-1 font-medium">Title</label>
          <input v-model="form.title" type="text" class="w-full border p-2 rounded" required />
        </div>

        <div class="col-span-2">
          <label class="block mb-1 font-medium">Description</label>
          <textarea v-model="form.description" rows="4" class="w-full border p-2 rounded" required />
        </div>

        <div>
          <label class="block mb-1 font-medium">Image URL</label>
          <input v-model="form.image" type="url" class="w-full border p-2 rounded" />
        </div>

        <div>
          <label class="block mb-1 font-medium">Director</label>
          <input v-model="form.director" type="text" class="w-full border p-2 rounded" required />
        </div>

        <div>
          <label class="block mb-1 font-medium">Release Year</label>
          <input
            v-model="form.release_year"
            type="number"
            min="0"
            class="w-full border p-2 rounded"
            required
          />
        </div>

        <div class="col-span-2 flex justify-end">
          <button
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700"
            :disabled="form.processing"
          >
            Save Movie
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
