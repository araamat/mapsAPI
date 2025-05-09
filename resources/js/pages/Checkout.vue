<script setup lang="ts">
import { ref } from 'vue';
import AppLayout from '@/layouts/AppLayout.vue';

const form = ref({
  first_name: '',
  last_name: '',
  email: '',
  phone: '',
});

const processing = ref(false);

const submit = () => {
  processing.value = true;

  const formElement = document.createElement('form');
  formElement.method = 'POST';
  formElement.action = route('checkout.process');

  // Lisa CSRF token meta tagist
  const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
  if (token) {
    const csrfInput = document.createElement('input');
    csrfInput.type = 'hidden';
    csrfInput.name = '_token';
    csrfInput.value = token;
    formElement.appendChild(csrfInput);
  }

  // Lisa vormi andmed
  for (const [key, value] of Object.entries(form.value)) {
    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = key;
    input.value = value;
    formElement.appendChild(input);
  }

  document.body.appendChild(formElement);
  formElement.submit();
};
</script>

<template>
  <AppLayout>
    <div class="max-w-xl mx-auto p-6 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-bold mb-6">Checkout</h1>

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

        <div class="text-right pt-4">
          <button
            type="submit"
            :disabled="processing"
            class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition"
          >
            {{ processing ? 'Redirecting to Stripe...' : 'Pay with Stripe' }}
          </button>
        </div>
      </form>
    </div>
  </AppLayout>
</template>
