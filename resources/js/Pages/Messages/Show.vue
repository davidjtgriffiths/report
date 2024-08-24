<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from '@/Components/Message.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref } from 'vue';
import { useForm, Head, router } from '@inertiajs/vue3';
import SendModal from './SendModal.vue';

// Define the props
const props = defineProps({
  message: Object,
});

// Create a form instance with Inertia.js
const form = useForm({
  subject: props.message.subject
});

const sendMessage = () => {
  // TODO:Implement your sendMessage logic here
  console.log('Sending message...', props.message.id);
  // For example:
  // form.post(route('messages.send', props.messageId));
};

const cancelEdit = () => {
  router.get(route('messages.index'));
};

const showModal = ref(false);
const openSendModal = () => {
  showModal.value = true;
};

</script>

<style scoped>
.modal-enter-active, .modal-leave-active {
  transition: opacity 0.3s ease;
}
.modal-enter-from, .modal-leave-to {
  opacity: 0;
}
</style>
 
<template>
  <Head title="Messages" />

  <AuthenticatedLayout>
    <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
      <h1>Edit Message</h1>
      <form @submit.prevent="form.put(route('messages.update', message.id), { onSuccess: () => editing = false })"> 
        <label for="subject">Message Subject:</label>
        <textarea v-model="form.subject" id="subject" rows="4" cols="50"></textarea>
        <PrimaryButton class="mt-4" type="submit">Save</PrimaryButton>
        <PrimaryButton
          class="mt-4"
          type="button"
          @click="cancelEdit">
            Cancel
        </PrimaryButton>
        <PrimaryButton
          class="mt-4"
          type="button"
          @click="openSendModal">
            Send
        </PrimaryButton>
      </form>
    </div>
    <transition name="modal">
      <SendModal 
        v-if="showModal" 
        :message="form.subject"
        @close="showModal = false"
        @send="sendMessage"
      />
    </transition>
  </AuthenticatedLayout>
</template>