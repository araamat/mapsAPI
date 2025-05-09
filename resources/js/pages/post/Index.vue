<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
} from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { router, Link } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['posts']);

const breadcrumbs: BreadcrumbItem[] = [
    { title: 'Posts', href: '/posts' },
];

const posttoDelete = ref<number | null>(null);

const confirmDelete = (id: number) => {
    console.log('Kustutamiseks valitud ID:', id);
    posttoDelete.value = id;
};

const deletePost = () => {
    if (!posttoDelete.value) return;

    console.log('Kustutame postituse ID:', posttoDelete.value);

    router.delete(route('posts.destroy', posttoDelete.value), {
        preserveScroll: true,
        onSuccess: () => {
            console.log('Kustutamine õnnestus');
            posttoDelete.value = null;
        },
        onError: (errors) => {
            console.error('Kustutamine ebaõnnestus', errors);
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-12 w-full max-w-screen-lg space-y-6">
            <div class="flex justify-between items-center">
                <h1 class="tracking-wide text-2xl font-semibold">Posts</h1>
                <Link :href="route('posts.create')">
                    <Button>Add new</Button>
                </Link>
            </div>

            <div class="rounded-md border shadow-sm">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead class="font-bold">Title</TableHead>
                            <TableHead class="font-bold">Created At</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableCell>{{ post.title }}</TableCell>
                            <TableCell>{{ post.created_at_for_humans }}</TableCell>
                            <TableCell class="text-right space-x-2">
                                <Link :href="route('posts.show', post.id)">
                                    <Button class="bg-blue-500 hover:bg-blue-600 text-white border-none" variant="outline" size="sm">View post</Button>
                                </Link>
                                <Link :href="route('posts.edit', post.id)">
                                    <Button class="bg-yellow-500 hover:bg-yellow-600 text-white border-none" variant="outline" size="sm">Edit post</Button>
                                </Link>
                                <Button
                                    variant="destructive"
                                    size="sm"
                                    @click="confirmDelete(post.id)"
                                >
                                    Delete post
                                </Button>
                            </TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>

        <AlertDialog :open="!!posttoDelete" @update:open="posttoDelete = null">
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Oled kindel?</AlertDialogTitle>
                    <AlertDialogDescription>
                        See toiming kustutab postituse jäädavalt.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="posttoDelete = null">Tühista</AlertDialogCancel>
                    <button
                        @click="deletePost"
                        type="button"
                        class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700 text-sm"
                    >
                        Kustuta
                    </button>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>
