<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import Button from '@/components/ui/button/Button.vue';
import { BreadcrumbItem } from '@/types';
import { useForm, Head } from '@inertiajs/vue3';

const props = defineProps<{
  post: {
    id: number;
    title: string;
    description: string;
    created_at_for_humans: string;
  };
}>();

const breadcrumbs: BreadcrumbItem[] = [
  { title: 'Posts', href: '/posts' },
  { title: 'Muuda postitust', href: `/posts/${props.post.id}/edit` },
];

const form = useForm({
  title: props.post.title,
  description: props.post.description,
});

const submit = () => {
  form.put(route('posts.update', props.post.id));
};
</script>

<template>
  <Head title="Muuda postitust" />
  <AppLayout :breadcrumbs="breadcrumbs">
    <div class="my-12 mx-auto w-full max-w-2xl space-y-6">
      <h1 class="text-2xl font-semibold">Muuda postitust</h1>

      <form @submit.prevent="submit" class="space-y-6">
        <div>
          <label for="title" class="block text-sm text-gray-600 mb-1">Pealkiri</label>
          <input
            id="title"
            v-model="form.title"
            class="w-full rounded-md border border-gray-300 px-3 py-2"
            :class="{ 'border-red-500': form.errors.title }"
          />
          <p v-if="form.errors.title" class="text-red-500 text-sm mt-1">{{ form.errors.title }}</p>
        </div>

        <div>
          <label for="description" class="block text-sm text-gray-600 mb-1">Kirjeldus</label>
          <textarea
            id="description"
            v-model="form.description"
            rows="5"
            class="w-full rounded-md border border-gray-300 px-3 py-2"
            :class="{ 'border-red-500': form.errors.description }"
          ></textarea>
          <p v-if="form.errors.description" class="text-red-500 text-sm mt-1">{{ form.errors.description }}</p>
        </div>

        <div class="text-right">
          <Button type="submit">Salvesta</Button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
