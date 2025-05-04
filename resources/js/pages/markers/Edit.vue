<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { useForm } from '@inertiajs/vue3';

const props = defineProps<{
  marker: {
    id: number,
    name: string,
    description: string,
    latitude: number,
    longitude: number,
  }
}>();

const form = useForm({
  name: props.marker.name,
  description: props.marker.description,
  latitude: props.marker.latitude,
  longitude: props.marker.longitude,
});

function submit() {
  form.put(`/markers/${props.marker.id}`);
}

const breadcrumbs = [
  { title: 'Markerid', href: '/markers' },
  { title: 'Muuda', href: `/markers/${props.marker.id}/edit` },
];
</script>

<template>
  <AppLayout :breadcrumbs="breadcrumbs">
    <h1 class="text-xl font-bold mb-4">Muuda markerit</h1>
    <form @submit.prevent="submit" class="space-y-4">
      <div>
        <label for="name">Nimi:</label>
        <input id="name" v-model="form.name" type="text" class="w-full border px-2 py-1" />
      </div>

      <div>
        <label for="description">Kirjeldus:</label>
        <textarea id="description" v-model="form.description" class="w-full border px-2 py-1" />
      </div>

      <div>
        <label for="latitude">Laiuskraad:</label>
        <input id="latitude" v-model="form.latitude" type="number" step="any" class="w-full border px-2 py-1" />
      </div>

      <div>
        <label for="longitude">Pikkuskraad:</label>
        <input id="longitude" v-model="form.longitude" type="number" step="any" class="w-full border px-2 py-1" />
      </div>

      <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Salvesta</button>
    </form>
  </AppLayout>
</template>
