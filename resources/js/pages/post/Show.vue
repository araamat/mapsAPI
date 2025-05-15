<script setup lang="ts">
import Button from '@/components/ui/button/Button.vue';
import Textarea from '@/components/ui/textarea/Textarea.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { useForm, usePage } from '@inertiajs/vue3';

const props = defineProps(['post']);
const user = usePage().props.auth.user;

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Show post',
        href: '/posts/show',
    },
];

const form = useForm({
    content: '',
    post_id: props.post.id
});


const submit = () => {
    form.post(route('comments.store', props.post.id), {
        preserveScroll: true,
        onSuccess: () => form.reset()
    });
};

const canDelete = (comment: any) => {
    return user && (user.id === comment.user_id || user.is_admin);
};

const deleteComment = (id: number) => {
    if (confirm('Oled kindel, et soovid kommentaari kustutada?')) {
        form.delete(route('comments.destroy', id), {
            preserveScroll: true
        });
    }
};

const minutesAgo = (dateStr: string): string => {
    const minutes = Math.max(0, Math.floor((new Date().getTime() - new Date(dateStr).getTime()) / 60000));
    return minutes === 0 ? 'just now' : `${minutes} min tagasi`;
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="my-12 mx-auto w-full max-w-2xl space-y-6">
            <!-- Post details -->
            <div>
                <h1 class="text-2xl font-semibold">{{ post.title }}</h1>
                <p class="mt-2">{{ post.description }}</p>
            </div>

            <!-- Comment form -->
            <form @submit.prevent="submit">
                <div class="relative">
                    <Textarea v-model="form.content" class="w-full h-full" placeholder="Lisa kommentaar..." />

                    <Button class="absolute bottom-4 right-4 z-10">Postita</Button>
                </div>
            </form>

            <!-- Comments -->
            <div>
                <h2 class="text-lg font-semibold mb-2">Kommentaarid</h2>
                <ul>
                    <li
                        v-for="comment in [...post.comments]"
                        :key="comment.id"
                        class="border-b py-3 flex justify-between items-start"
                    >
                        <div>
                            <p class="text-sm text-gray-600 font-semibold">{{ comment.user.name }}</p>
                            <p class="mb-1">{{ comment.body }}</p>
                            <p class="text-xs text-gray-500">{{ minutesAgo(comment.created_at) }}</p>
                        </div>
                        <button
                            v-if="canDelete(comment)"
                            @click="deleteComment(comment.id)"
                            class="text-red-500 text-xs hover:underline"
                        >
                            Kustuta
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </AppLayout>
</template>
