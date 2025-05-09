<script setup lang="ts">
import Input from '@/components/ui/input/Input.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { router } from '@inertiajs/vue3';
import { Trash } from 'lucide-vue-next';

const formatCurrency = (amount: number) => {
  return new Intl.NumberFormat('et', {
    style: 'currency',
    currency: 'EUR',
  }).format(amount);
};

const updateCart = (id: number | string, quantity: number | string) => {
  router.post(route('cart.update'), {
    id,
    quantity,
  });
};

const removeFromCart = (id: number | string) => {
  router.delete(route('cart.remove'), {
    data: { id },
    preserveScroll: true,
  });
};

const goToCheckout = () => {
  router.visit(route('checkout.index'));
};
</script>

<template>
  <AppLayout>
    <div class="container mx-auto p-6">
      <h1 class="mb-6 text-2xl font-bold">Shopping Cart</h1>
      <div class="rounded-lg bg-white p-4 shadow-md">
        <table class="w-full border-collapse text-left">
          <thead>
            <tr>
              <th class="border-b px-4 py-2">Image</th>
              <th class="border-b px-4 py-2">Product</th>
              <th class="border-b px-4 py-2">Price</th>
              <th class="border-b px-4 py-2">Quantity</th>
              <th class="border-b px-4 py-2">Total</th>
              <th class="border-b px-4 py-2 text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(item, id) in $page.props.cart" :key="id">
              <td class="border-b px-4 py-2">
                <img :src="item.image" alt="Product Image" class="h-16 w-16 rounded object-cover" />
              </td>
              <td class="border-b px-4 py-2">{{ item.name }}</td>
              <td class="border-b px-4 py-2">{{ formatCurrency(item.price) }}</td>
              <td class="border-b px-4 py-2">
                <Input
                  class="w-full max-w-24 text-right"
                  type="number"
                  :min="1"
                  :model-value="item.quantity"
                  @update:model-value="(val) => updateCart(id, val)"
                />
              </td>
              <td class="border-b px-4 py-2">{{ formatCurrency(item.price * item.quantity) }}</td>
              <td class="border-b px-4 py-2 text-right">
                <button
                  @click="removeFromCart(id)"
                  class="p-2 rounded-full hover:bg-red-100 transition"
                  title="Remove item"
                >
                  <Trash class="w-5 h-5 text-red-600" />
                </button>
              </td>
            </tr>
          </tbody>
        </table>

        <div class="mt-4 flex justify-end">
          <p class="text-lg font-bold">Total: {{ formatCurrency($page.props.cartTotal) }}</p>
        </div>

        <div class="mt-6 flex justify-end">
          <button
            @click="goToCheckout"
            class="rounded bg-blue-600 px-6 py-2 text-white hover:bg-blue-700 transition"
          >
            Proceed to Payment
          </button>
        </div>
      </div>
    </div>
  </AppLayout>
</template>
