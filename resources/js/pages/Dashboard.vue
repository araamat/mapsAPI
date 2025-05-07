
<script setup lang="ts">
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { Dialog, DialogContent, DialogDescription, DialogHeader, DialogTitle } from '@/components/ui/dialog';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, useForm, router } from '@inertiajs/vue3';
import { MapMouseEvent } from 'maplibre-gl';
import Radar from 'radar-sdk-js';
import 'radar-sdk-js/dist/radar.css';
import RadarMap from 'radar-sdk-js/dist/ui/RadarMap';
import { onMounted, ref } from 'vue';

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Dashboard', href: '/dashboard' },
];

const props = defineProps({
    weather: { type: Object, required: true },
    markers: { type: Array, required: true },
});

const form = useForm({
    title: '',
    description: '',
    latitude: 0,
    longitude: 0,
});

const show = ref(false);
const confirmDelete = ref(false);
const selectedMarker = ref<{ id: number; name: string; description: string; latitude: number; longitude: number } | null>(null);
const map = ref<RadarMap>();

Radar.initialize('prj_test_pk_a4a4006fc00a17f9f08ec73995e78a0393b3c22f', {});

onMounted(() => {
    const radarMap = Radar.ui.map({
        container: 'map',
        style: 'radar-default-v1',
        center: [22.488819593503443, 58.25398239259826],
        zoom: 14,
    });

    map.value = radarMap;

    for (let marker of props.markers as Array<{ id: number; name: string; description: string; latitude: number; longitude: number }>) {
        const radarMarker = Radar.ui
            .marker({ color: '#000257', width: 40, height: 80 })
            .setLngLat([marker.longitude, marker.latitude])
            .addTo(radarMap);

        radarMarker.on('click', () => {
            selectedMarker.value = marker;
            form.title = marker.name;
            form.description = marker.description;
            form.latitude = marker.latitude;
            form.longitude = marker.longitude;
            show.value = true;
        });
    }

    radarMap.on('click', (e: MapMouseEvent) => {
        form.reset();
        form.latitude = e.lngLat.lat;
        form.longitude = e.lngLat.lng;
        selectedMarker.value = null;
        show.value = true;
    });
});

function handleSubmit() {
    form.post(route('markers.store'), {
        onSuccess: () => {
            form.reset();
            show.value = false;
            location.reload();
        }
    });
}

function updateMarker() {
    if (!selectedMarker.value) return;
    form.put(`/markers/${selectedMarker.value.id}`, {
        onSuccess: () => {
            form.reset();
            selectedMarker.value = null;
            show.value = false;
            location.reload();
        }
    });
}

function confirmDeleteMarker() {
    confirmDelete.value = true;
}

function reallyDeleteMarker() {
    if (!selectedMarker.value) return;
    router.delete(`/markers/${selectedMarker.value.id}`, {
        onSuccess: () => {
            confirmDelete.value = false;
            selectedMarker.value = null;
            show.value = false;
            location.reload();
        }
    });
}
</script>

<template>
  <Head title="Dashboard" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
      <div class="grid auto-rows-min gap-4 md:grid-cols-3">
        <Card>
          <CardHeader class="flex h-16 flex-row items-center justify-between space-y-0 pb-2">
            <CardTitle class="text-sm font-medium">Weather</CardTitle>
            <img :src="'http://openweathermap.org/img/wn/' + weather.weather[0].icon + '@2x.png'" alt="Weather icon" class="h-12 w-12" />
          </CardHeader>
          <CardContent>
            <div class="text-2xl font-bold">{{ weather.main.temp }}°C</div>
            <p class="text-xs text-muted-foreground">{{ weather.wind.speed }} m/s ({{ weather.weather[0].description }})</p>
          </CardContent>
        </Card>
      </div>

      <div class="relative min-h-[100vh] flex-1 overflow-hidden rounded-xl border md:min-h-min">
        <div id="map" style="width: 100%; height: 100%" />
      </div>

      <Dialog :open="show" @update:open="show = $event">
        <DialogContent>
          <DialogHeader>
            <DialogTitle>{{ selectedMarker ? 'Muuda markerit' : 'Uus marker' }}</DialogTitle>
            <DialogDescription>
              {{ selectedMarker ? 'Redigeeri olemasolevat markerit' : 'Lisa uus marker kaardilt klikkides' }}
            </DialogDescription>
          </DialogHeader>
          <form class="space-y-4" @submit.prevent="handleSubmit">
            <div>
              <label for="title" class="block text-sm font-medium text-gray-700">Title</label>
              <input id="title" type="text" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" v-model="form.title" />
            </div>
            <div>
              <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
              <textarea id="description" rows="4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" v-model="form.description" />
            </div>
            <div class="flex gap-4 mt-4">
              <button v-if="selectedMarker" type="button" @click="updateMarker" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">Salvesta muudatused</button>
              <button v-if="selectedMarker" type="button" @click="confirmDeleteMarker" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">Kustuta marker</button>
              <input v-if="!selectedMarker" type="submit" value="Salvesta uus" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700" />
            </div>
          </form>
        </DialogContent>
      </Dialog>

      <Dialog :open="confirmDelete" @update:open="confirmDelete = $event">
        <DialogContent>
          <DialogHeader>
            <DialogTitle>Kustuta marker</DialogTitle>
            <DialogDescription>Oled kindel, et soovid selle markeri kustutada?</DialogDescription>
          </DialogHeader>
          <div class="flex justify-end gap-4 mt-4">
            <button @click="confirmDelete = false" class="px-4 py-2 rounded bg-gray-300">Tühista</button>
            <button @click="reallyDeleteMarker" class="px-4 py-2 rounded bg-red-600 text-white hover:bg-red-700">Kustuta</button>
          </div>
        </DialogContent>
      </Dialog>
    </div>
  </AppLayout>
</template>
