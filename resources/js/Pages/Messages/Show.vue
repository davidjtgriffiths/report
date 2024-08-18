<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from '@/Components/Message.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import { useForm, Head } from '@inertiajs/vue3';

// Define the props
const props = defineProps({
  message: Object
});

// Create a form instance with Inertia.js
const form = useForm({
  subject: props.message.subject
});

</script>
 
<template>
  <Head title="Messages" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <h1>Edit Message</h1>
      <form @submit.prevent="form.put(route('messages.update', message.id), { onSuccess: () => editing = false })">
        <div>
          <label for="subject">Message Subject:</label>
          <textarea v-model="form.subject" id="subject" rows="4" cols="50"></textarea>
        </div>
        <PrimaryButton class="mt-4">Save</PrimaryButton>
      </form>
    </div>
  </AuthenticatedLayout>
</template>