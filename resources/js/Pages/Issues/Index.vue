<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Issue from '@/Components/Issue.vue';
import InputError from '@/Components/InputError.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import { useForm, Head } from '@inertiajs/vue3';

defineProps(['issues', 'testAppVar']);
 
const form = useForm({
    recipientEmail: '',
    subject: '',
});
</script>
 
<template>
    <Head title="Issues" />
 
    <AuthenticatedLayout>
        <div class="max-w-2xl mx-auto p-4 sm:p-6 lg:p-8">
            <form @submit.prevent="form.post(route('issues.store'), { onSuccess: () => form.reset() })">
                <textarea
                    v-model="form.recipientEmail"
                    placeholder="Recipient's email"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </textarea>
                <InputError :issue="form.errors.recipientEmail" class="mt-2" />
                
                <!-- TODO: testing AppVar CHECK NAMESPACE PLURAL CONVENTION-->
                {{testAppVar}}

                <textarea
                    v-model="form.subject"
                    placeholder="What's on your mind?"
                    class="block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                </textarea>
                <InputError :issue="form.errors.subject" class="mt-2" />
                <PrimaryButton class="mt-4">Save</PrimaryButton>
            </form>

            <!-- TODO: issues.edit with the correct id-->
            <div class="mt-6 bg-white shadow-sm rounded-lg divide-y">
                <Issue
                    v-for="issue in issues"
                    :key="issue.id"
                    :issue="issue"
                    :href="route('issues.update', { id: issue.id })"
                />
            </div>
        </div>
    </AuthenticatedLayout>
</template>