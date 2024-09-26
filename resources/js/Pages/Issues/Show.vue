<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Issue from '@/Components/Issue.vue';
import Message from '@/Components/Message.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { ref, computed } from 'vue';
import { useForm, Head, router } from '@inertiajs/vue3';
import SendModal from './SendModal.vue';

// Define the props
const props = defineProps({
  issue: Object,
});

// Create a form instance with Inertia.js
const form = useForm({
  description: props.issue.description,
  title: props.issue.title
});

const sortedMessages = computed(() => {
  return [...props.issue.messages].sort((a, b) => {
    return new Date(b.created_at) - new Date(a.created_at)
  })
})

const cancelEdit = () => {
  router.get(route('issues.index'));
};

const showModal = ref(false);
const openSendModal = () => {
  showModal.value = true;
};

const isIssueSent = computed(() => props.issue.sent != null)

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
  <Head title="Edit Issue" />

  <AuthenticatedLayout>
    <div class="max-w-3xl mx-auto p-6 sm:p-8 lg:p-12 bg-white rounded-lg shadow-md">
      <h1 class="text-2xl font-semibold text-gray-800 mb-6">Edit Issue {{ $page.props.auth.user }}</h1>
      <!-- TODO: steal the validation from the expanding form on issues.index -->
      <form @submit.prevent="form.put(route('issues.update', issue.id), { onSuccess: () => editing = false })">
        <!-- Title Field -->
        <div class="mb-4">
          <label for="title" class="block text-lg font-medium text-gray-700">Title:</label>
          <input 
            v-model="form.title" 
            id="title" 
            type="title"
            class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            placeholder="Enter title" />
        </div>

        <!-- Issue Description Field -->
         <!-- TODO: lock all the inputs if sent -->
        <div class="mb-4">
          <label for="description" class="block text-lg font-medium text-gray-700">Issue Description:</label>
          <textarea 
            v-model="form.description" 
            id="description" 
            rows="4" 
            class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
            placeholder="Enter your issue description"
            :disabled="isIssueSent">
          </textarea>
        </div>

        <!-- TODO: Put all the messages in here -->
        <div
          class="w-full mt-2 p-3 border border-gray-300 rounded-lg focus:outline-none focus:ring focus:border-blue-300"
        >
          <Message
            v-for="message in sortedMessages"
            :key="message.id"
            :message="message"
            :href="route('messages.update', { id: message.id })"
                />
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
              'bg-blue-600 text-white hover:bg-blue-700': !isIssueSent,
              'bg-yellow-500 text-white hover:bg-yellow-600': isIssueSent
            }"
            type="submit"
            :title="isIssueSent ? 'This issue has been sent' : ''"
          >
            Save
          </PrimaryButton>
          <PrimaryButton
            :class="{
              'bg-green-600 text-white hover:bg-green-700': $page.props.auth.user.can_send_issue,
              'bg-gray-400 text-gray-700 cursor-not-allowed': !$page.props.auth.user.can_send_issue
            }"
            :disabled="!$page.props.auth.user.can_send_issue"
            type="button"
            @click="openSendModal"
            :title="!$page.props.auth.user.can_send_issue ? 'Can\'t send' : ''"
          >
            Send
          </PrimaryButton>
        </div>
      </form>
    </div>

    <transition name="modal">
      <SendModal 
        v-if="showModal" 
        :issue="form.subject"
        @close="showModal = false"
        @send="sendIssue"
      />
    </transition>
  </AuthenticatedLayout>
</template>