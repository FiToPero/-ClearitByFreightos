<script setup>
import { Head, usePage, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import SecondaryButton from '@/Components/SecondaryButton.vue'

const page = usePage()
const isMessage = ref(false)

const form = useForm({
    ticket_id: page.props.ticketId,
    content: '',
    type: page.props.user, // user, agent
    is_read: null,
    attachment: null,
})
  
const store = () => {
    form.post(route('message.store'))
}
const handleFileChange = (event) => {
    form.attachment = event.target.files[0] || null
}



</script>
<template>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            
                <form v-on:submit.prevent="store"  class="w-full p-10 text-black" >
                    <h2 class="text-2xl font-bold mb-4">Message</h2>
                    <SecondaryButton class="mt-4" type="button" @click="$inertia.visit(route('ticket.user'))">
                        Close
                    </SecondaryButton>
                    <hr />  
                    <br />
                    <div class="m-2">
                        <InputLabel for="content" value="content" />
                        <TextInput v-model="form.content" id="content" type="text" class="mt-1 block w-full" />
                        <InputError class="mt-2" :message="page.props.errors.content" />
                    </div>
                    <div class="m-2">
                        <InputLabel for="is_read" value="is_read" />
                        <TextInput v-model="form.is_read" disabled id="is_read" type="text" class="mt-1 block w-full" />
                        <InputError class="mt-2" :message="page.props.errors.is_read" />
                    </div>
                    <div class="m-2">
                        <InputLabel for="attachment" value="attachment" />
                        <input @change="handleFileChange" id="attachment" type="file" class="mt-1 block w-full" />
                        <InputError class="mt-2" :message="page.props.errors.attachment" />
                    </div>
                    <PrimaryButton class="mt-4" type="submit">
                        New Message
                    </PrimaryButton>
                </form>

            </div>
        </div>
    </div>
 

</template>
