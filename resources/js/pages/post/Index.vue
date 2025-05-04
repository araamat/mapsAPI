<script setup lang="ts">
import {
    AlertDialog,
    AlertDialogAction,
    AlertDialogCancel,
    AlertDialogContent,
    AlertDialogDescription,
    AlertDialogFooter,
    AlertDialogHeader,
    AlertDialogTitle,
    AlertDialogTrigger,
} from '@/components/ui/alert-dialog';
import Button from '@/components/ui/button/Button.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import AppLayout from '@/layouts/AppLayout.vue';
import { BreadcrumbItem } from '@/types';
import { router } from '@inertiajs/vue3';
import { ref } from 'vue';

defineProps(['posts']);

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Posts',
        href: '/posts',
    },
];

const posttoDelete = ref();

const deletePost = () => {
    router.delete(route('posts.destroy', posttoDelete.value), {
        onSuccess: () => {
            posttoDelete.value = undefined;
        },
    });
};
</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="mx-auto my-12 w-full max-w-screen-lg">
            <div>
                <h1 class="tracking wide text-2xl font-semibold">Posts</h1>
                <Button>Add new</Button>
            </div>
            <div class="rounded-md border shadow-sm">
                <Table>
                    <TableHeader>
                        <TableRow>
                            <TableHead>Title</TableHead>
                            <TableHead class="text-right">Created At</TableHead>
                        </TableRow>
                    </TableHeader>
                    <TableBody>
                        <TableRow v-for="post in posts" :key="post.id">
                            <TableCell> {{ post.title }}</TableCell>
                            <TableCell class="text-right">{{ post.created_at_for_humans }}</TableCell>
                        </TableRow>
                    </TableBody>
                </Table>
            </div>
        </div>
        <AlertDialog :open="!!posttoDelete">
            
            <AlertDialogContent>
                <AlertDialogHeader>
                    <AlertDialogTitle>Are you absolutely sure?</AlertDialogTitle>
                    <AlertDialogDescription>
                        This action cannot be undone. This will permanently delete your account and remove your data from our servers.
                    </AlertDialogDescription>
                </AlertDialogHeader>
                <AlertDialogFooter>
                    <AlertDialogCancel @click="posttoDelete = undefined">Cancel</AlertDialogCancel>
                    <AlertDialogAction @click="deletePost">Continue</AlertDialogAction>
                </AlertDialogFooter>
            </AlertDialogContent>
        </AlertDialog>
    </AppLayout>
</template>
