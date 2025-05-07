<script setup lang="ts">
import { reactive } from 'vue';
import axios from 'axios';
import { router } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import {
  Card,
  CardContent,
  CardDescription,
  CardFooter,
  CardHeader,
  CardTitle
} from '@/components/ui/card';
import { ShoppingCart } from 'lucide-vue-next';

interface Product {
  id: number;
  name: string;
  description: string;
  image: string;
  price: number;
  created_at: string;
  updated_at: string;
}

const props = defineProps<{ products: Product[] }>();

const addToCart = (product:Product) => {
    router.post(route('cart.add', product), undefined, {
        preserveScroll: true,
    });
   
};

</script>

<template>
  <AppLayout>
    <div class="flex justify-end p-4">
      {{ $page.props.cart }}
        <button
        size="icon"
        variant="outline"
        class="relative rounded-full border border-gray-300 p-2 hover:bg-gray-100 transition"
      >
        <ShoppingCart class="w-5 h-5 text-gray-700" />

        <!-- Badge / item count (future support) -->
        <span
          class="absolute -top-1 -right-1 bg-red-600 text-white text-xs font-semibold px-1.5 py-0.5 rounded-full"
        >
          {{ Object.entries($page.props.cart ?? {})?.length }}
        </span>
      </button>
    </div>
    <div class="p-6 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
        
      <Card v-for="product in props.products" :key="product.id" class="h-full flex flex-col">
        <CardHeader class="p-4 pb-2">
          <img
            :src="product.image"
            alt="product image"
            class="w-full h-48 object-cover rounded-xl mb-4"
          />
          <CardTitle class="text-xl font-bold text-gray-800 mb-1">
            {{ product.name }}
          </CardTitle>
          <CardDescription class="text-gray-600 text-sm mb-2">
            {{ product.description }}
          </CardDescription>
          <p class="text-lg font-semibold text-blue-700 mb-2">
            €{{ product.price }}
          </p>
        </CardHeader>

        <CardContent class="p-4 pt-0 mt-auto">
          <button
            @click="addToCart(product)"
            class="bg-blue-600 text-white py-2 px-4 rounded-xl w-full hover:bg-blue-700 transition">
            Add to Cart
          </button>
        </CardContent>
      </Card>
    </div>
  </AppLayout>
</template>
