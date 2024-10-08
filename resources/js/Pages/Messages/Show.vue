<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from '@/Components/Message.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';
import { useForm, Head, router } from '@inertiajs/vue3';
import SendModal from './SendModal.vue';

// Define the props
const props = defineProps({
  message: Object,
});

// Create a form instance with Inertia.js
const form = useForm({
  subject: props.message.subject,
  recipientEmail: props.message.recipientEmail
});

const sendMessage = () => {
  form.post(route('messages.send', props.message.id), {
    preserveScroll: true,
    preserveState: true,
    onSuccess: () => {
      // Handle success (e.g., show a success message)
      console.log('Message sent successfully')
      // You might want to emit an event or update some local state here
    },
    onError: (errors) => {
      // Handle errors (e.g., display error messages)
      console.error('Error sending message:', errors)
    },
  })
}

const cancelEdit = () => {
  router.get(route('messages.index'));
};

const showModal = ref(false);
const openSendModal = () => {
  showModal.value = true;
};

const isMessageSent = computed(() => props.message.sent != null)

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
  <Head title="Edit Message" />

  <AuthenticatedLayout>
    <div class="max-w-3xl mx-auto p-6 sm:p-8 lg:p-12 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Message {{ $page.props.auth.user }}</h1>
      <!-- TODO: steal the validation from the expanding form on messages.index -->
      <form @submit.prevent="form.put(route('messages.update', message.id), { onSuccess: () => editing = false })">
        <!-- Recipient Email Field -->
        <div class="mb-4">
          <label for="recipientEmail" class="block text-lg font-medium text-gray-700">Recipient Email:</label>
          <input 
            v-model="form.recipientEmail" 
            id="recipientEmail" 
            type="email"
            class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            placeholder="Enter recipient's email" />
        </div>

        <!-- Message Subject Field -->
         <!-- TODO: lock all the inputs if sent -->
        <div class="mb-4">
          <label for="subject" class="block text-lg font-medium text-gray-700">Message Subject:</label>
          <textarea 
            v-model="form.subject" 
            id="subject" 
            rows="4" 
            class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            placeholder="Enter your message subject"
            :disabled="isMessageSent">
          </textarea>
        </div>

        <!-- Buttons -->
        <div class="flex justify-end space-x-4">
          <PrimaryButton
            class="bg-gray-200 text-gray-700 hover:bg-gray-300"
            type="button"
            @click="cancelEdit">
              Cancel
          </PrimaryButton>
          <PrimaryButton
            :class="{
              'bg-blue-600 text-white hover:bg-blue-700': !isMessageSent,
              'bg-yellow-500 text-white hover:bg-yellow-600': isMessageSent
            }"
            type="submit"
            :title="isMessageSent ? 'This message has been sent' : ''"
          >
            Save
          </PrimaryButton>
          <PrimaryButton
            :class="{
              'bg-green-600 text-white hover:bg-green-700': $page.props.auth.user.can_send_message,
              'bg-gray-400 text-gray-700 cursor-not-allowed': !$page.props.auth.user.can_send_message
            }"
            :disabled="!$page.props.auth.user.can_send_message"
            type="button"
            @click="openSendModal"
            :title="!$page.props.auth.user.can_send_message ? 'Can\'t send' : ''"
          >
            Send
          </PrimaryButton>
        </div>
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