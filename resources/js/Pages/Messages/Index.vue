<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Message from '@/Components/Message.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['messages']);
 
const form = useForm({
    recipientEmail: '',
    subject: '',
});
</script>
 
<template>
    <Head title="Messages" />
 
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('messages.store'), { onSuccess: () => form.reset() })">
                <textarea
                    v-model="form.recipientEmail"
                    placeholder="Recipient's email"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </textarea>
                <InputError :message="form.errors.recipientEmail" class="mt-2" />

                <textarea
                    v-model="form.subject"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </textarea>
                <InputError :message="form.errors.subject" class="mt-2" />
                <PrimaryButton class="mt-4">Save</PrimaryButton>
            </form>

            <!-- TODO: messages.edit with the correct id-->
            <a :href="route('messages.update', { id: messages[0].id })" class="block mt-6 bg-white shadow-sm rounded-lg divide-y">
                <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                    <Message
                        v-for="message in messages"
                        :key="message.id"
                        :message="message"
                    />
                </div>
            </a>
        </div>
    </AuthenticatedLayout>
</template>