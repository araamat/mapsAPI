<script setup lang="ts">
import { ref, onMounted } from 'vue';
import axios from 'axios';
import AppLayout from '@/layouts/AppLayout.vue';
import {
  Card,
  CardContent,
  CardDescription,
  CardHeader,
  CardTitle
} from '@/components/ui/card';

interface Movie {
  id: number;
  title: string;
  description: string;
  image: string;
  director: string;
  release_year: number;
}

const movies = ref<Movie[]>([]);
const search = ref('');

const fetchMovies = async () => {
  try {
    const response = await axios.get('/movies', {
      params: {
        search: search.value,
        sort_by: 'release_year',
        sort_order: 'desc'
      }
    });
    movies.value = response.data;
  } catch (error) {
    console.error('Error fetching movies:', error);
  }
};

onMounted(fetchMovies);
</script>

<template>
  <AppLayout>
    <div class="p-4">
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Movies</h1>
        <!-- Optional: add create movie button -->
      </div>

      <div class="mb-6">
        <input
          v-model="search"
          @input="fetchMovies"
          type="text"
          placeholder="Search by title"
          class="w-full p-2 border rounded"
        />
      </div>

      <div v-if="movies.length === 0" class="text-gray-500">No movies found.</div>

      <div v-else class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <Card v-for="movie in movies" :key="movie.id" class="h-full flex flex-col">
          <CardHeader class="p-4 pb-2">
            <img
              :src="movie.image"
              alt="Movie image"
              class="w-full h-48 object-cover rounded-xl mb-4"
            />
            <CardTitle class="text-xl font-bold text-gray-800 mb-1">
              {{ movie.title }}
            </CardTitle>
            <CardDescription class="text-gray-600 text-sm mb-2">
              {{ movie.description }}
            </CardDescription>
            <p class="text-sm text-gray-700"><strong>Director:</strong> {{ movie.director }}</p>
            <p class="text-sm text-gray-700"><strong>Year:</strong> {{ movie.release_year }}</p>
          </CardHeader>

          <CardContent class="p-4 pt-0 mt-auto">
            <!-- Future buttons/actions go here -->
          </CardContent>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>
