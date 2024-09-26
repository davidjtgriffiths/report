<script setup>
import { ref, computed } from 'vue';

defineProps({
  message: {
    type: String,
    required: true
  }
});

const options = ref({
  sendNotification: false,
  markAsUrgent: false
});

const sendButtonEnabled = computed(() => {

  return options.value.sendNotification && options.value.markAsUrgent;
});

defineEmits(['send', 'close']);
</script>

<template>
    <div class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full" id="my-modal">
      <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
        <div class="mt-3 text-center">
          <h3 class="text-lg leading-6 font-medium text-gray-900">Send Message</h3>
          <div class="mt-2 px-7 py-3">
            <p class="text-sm text-gray-500">
              Are you sure you want to send this message?{{ sendButtonEnabled }}
            </p>
            <p class="text-sm text-gray-700 mt-1">
              "{{ message }}"
            </p>
            <div class="mt-4">
              <label class="inline-flex items-center">
                <input type="checkbox" v-model="options.sendNotification" class="form-checkbox">
                <span class="ml-2">Send notification to recipient</span>
              </label>
            </div>
            <div class="mt-2">
              <label class="inline-flex items-center">
                <input type="checkbox" v-model="options.markAsUrgent" class="form-checkbox">
                <span class="ml-2">Mark as urgent</span>
              </label>
            </div>
          </div>
          <div class="items-center px-4 py-3">
            <button
                id="ok-btn"
                @click="$emit('send', options)"
                class="px-4 py-2 bg-blue-500 text-white text-base font-medium rounded-md w-full shadow-sm hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-300"
                :disabled="!sendButtonEnabled"
                :class="[
                'px-4 py-2 text-white text-base font-medium rounded-md w-full shadow-sm focus:outline-none focus:ring-2',
                sendButtonEnabled ? 'bg-blue-500 hover:bg-blue-700 focus:ring-blue-300' : 'bg-gray-400 cursor-not-allowed focus:ring-gray-300'
                ]"
            >
              Send
            </button>
            <button
              id="cancel-btn"
              @click="$emit('close')"
              class="mt-3 px-4 py-2 bg-gray-300 text-gray-800 text-base font-medium rounded-md w-full shadow-sm hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-300"
            >
              Cancel
            </button>
          </div>
        </div>
      </div>
    </div>
  </template>