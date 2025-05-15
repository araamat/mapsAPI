<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { useForm, usePage } from '@inertiajs/vue3';
import AppLayout from '@/layouts/AppLayout.vue';
import { Link } from '@inertiajs/vue3';
import axios from 'axios';

const page = usePage();

onMounted(() => {
  if (page.props.flash?.force_reload) {
    location.reload();
  }
});

const form = useForm({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
});

const submit = async () => {
  if (form.processing) return;

  form.processing = true;

  try {
    const response = await axios.post(route('checkout.process'), form.data());
    if (response.data?.url) {
      window.location.href = response.data.url;
    } else {
      alert('Unexpected response from server');
    }
  } catch (error) {
    console.error(error);
    alert('Something went wrong. Please try again.');
  } finally {
    form.processing = false;
  }
};

</script>

<template>
  <AppLayout>
    <div class="max-w-2xl w-full mx-auto p-8 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-6">Checkout</h1>

      <!-- Veateade, kui olemas -->
      <div v-if="$page.props.flash?.error" class="mb-4 p-3 bg-red-100 text-red-800 rounded">
        {{ $page.props.flash.error }}
      </div>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block mb-1 font-medium">First Name</label>
          <input
            v-model="form.first_name"
            type="text"
            class="w-full border rounded p-2"
            required
          />
        </div>

        <div>
          <label class="block mb-1 font-medium">Last Name</label>
          <input
            v-model="form.last_name"
            type="text"
            class="w-full border rounded p-2"
            required
          />
        </div>

        <div>
          <label class="block mb-1 font-medium">Email</label>
          <input
            v-model="form.email"
            type="email"
            class="w-full border rounded p-2"
            required
          />
        </div>

        <div>
          <label class="block mb-1 font-medium">Phone</label>
          <input
            v-model="form.phone"
            type="tel"
            class="w-full border rounded p-2"
            required
          />
        </div>

        <div class="flex justify-between items-center pt-4">
          <Link
            href="/cart"
            class="text-sm text-gray-600 hover:underline"
          >
            ← Back to Cart
          </Link>

          <button
            type="submit"
            :disabled="form.processing"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
          >
            {{ form.processing ? 'Redirecting to Stripe...' : 'Pay with Stripe' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
