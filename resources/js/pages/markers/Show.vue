<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';

const props = defineProps<{
  marker: {
    id: number;
    name: string;
    description: string;
    latitude: number;
    longitude: number;
  }
}>();

const breadcrumbs = [
  { title: 'Markerid', href: '/markers' },
  { title: props.marker.name, href: `/markers/${props.marker.id}` },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <h1 class="text-2xl font-bold mb-4">{{ props.marker.name }}</h1>
    <p class="mb-2"><strong>Kirjeldus:</strong> {{ props.marker.description }}</p>
    <p class="mb-2"><strong>Laiuskraad:</strong> {{ props.marker.latitude }}</p>
    <p class="mb-2"><strong>Pikkuskraad:</strong> {{ props.marker.longitude }}</p>
    <div class="mt-4">
      <a :href="`/markers/${props.marker.id}/edit`" class="text-blue-500 hover:underline mr-4">Muuda</a>
    </div>
  </AppLayout>
</template>
