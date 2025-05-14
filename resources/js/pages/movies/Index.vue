<script setup lang="ts">
import { ref, computed } from 'vue';
import { Link } from '@inertiajs/vue3';
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
  director?: string;
  release_year?: number;
  developer?: string;
  genres?: string[];
}

const props = defineProps<{
  movies: Movie[],
  externalMovies: Movie[]
}>();

const search = ref('');

const filteredLocal = computed(() => {
  if (!search.value) return props.movies;
  return props.movies.filter(movie =>
    movie.title.toLowerCase().includes(search.value.toLowerCase())
  );
});

const filteredExternal = computed(() => {
  if (!search.value) return props.externalMovies;
  return props.externalMovies.filter(movie =>
    movie.title.toLowerCase().includes(search.value.toLowerCase())
  );
});
</script>

<template>
  <AppLayout>
    <div class="p-4">
      <!-- Header -->
      <div class="flex justify-between items-center mb-4">
        <h1 class="text-2xl font-bold">Movies</h1>
        <Link
          href="/movies/create"
          class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition"
        >
          Add New Movie
        </Link>
      </div>

      <!-- Search -->
      <div class="mb-6">
        <input
          v-model="search"
          type="text"
          placeholder="Search by title"
          class="w-full p-2 border rounded"
        />
      </div>

      <!-- Local Movies -->
      <h2 class="text-xl font-semibold mb-2">Your Movies</h2>
      <div v-if="filteredLocal.length === 0" class="text-gray-500 mb-4">No local movies found.</div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-8">
        <Card
          v-for="movie in filteredLocal"
          :key="'local-' + movie.id"
          class="h-full flex flex-col"
        >
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
        </Card>
      </div>

      <!-- External Movies -->
      <h2 class="text-xl font-semibold mb-2">Content of others</h2>
      <div v-if="filteredExternal.length === 0" class="text-gray-500">No external movies found.</div>
      <div v-else class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        <Card
          v-for="movie in filteredExternal"
          :key="'external-' + movie.id"
          class="h-full flex flex-col"
        >
          <CardHeader class="p-4 pb-2">
            <img
              :src="movie.image"
              alt="External Movie image"
              class="w-full h-48 object-cover rounded-xl mb-4"
            />
            <CardTitle class="text-xl font-bold text-gray-800 mb-1">
              {{ movie.title }}
            </CardTitle>
            <CardDescription class="text-gray-600 text-sm mb-2">
              {{ movie.description }}
            </CardDescription>
            <p class="text-sm text-gray-700" v-if="movie.developer">
              <strong>Developer:</strong> {{ movie.developer }}
            </p>
            <p class="text-sm text-gray-700" v-if="movie.genres">
              <strong>Genres:</strong> {{ movie.genres.join(', ') }}
            </p>
          </CardHeader>
        </Card>
      </div>
    </div>
  </AppLayout>
</template>
