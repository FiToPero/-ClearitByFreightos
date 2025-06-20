<script setup>
import { Head, usePage, useForm } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import InputLabel from '@/Components/InputLabel.vue'
import TextInput from '@/Components/TextInput.vue'
import InputError from '@/Components/InputError.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FlashMessage from '@/Components/FlashMessage.vue'

const page = usePage()
const isMessage = ref(false)

const form = useForm({
    user_id: page.props.auth.user.id,
    name: '',
    type: 1, // 1, 2, 3
    transport_mode: 'air', // air, land, sea
    product: '',
    origin_country: '',
    destination_country: '',
    status: 'new', // new, in_process, completed
    content: '',
    message_type: 'user', // user, agent
    is_read: null,
    attachment: null,
})
  
const store = () => {
    form.post(route('ticket.store'))
}
const handleFileChange = (event) => {
    form.attachment = event.target.files[0] || null
}

const closeMessage = () => { 
    isMessage.value = false
    page.props.flash.message = null;
}

</script>
<template>

       <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">User</h2>
        </template>
        <FlashMessage v-if="isMessage" :message="$page.props.flash.message" :color="$page.props.flash.color" @closeMessage="closeMessage" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                    <form v-on:submit.prevent="store"  class="w-full p-10 text-black" >
                       
                        <div class="m-2">
                            <InputLabel for="name" value="Name" />
                            <TextInput v-model="form.name" id="name" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="page.props.errors.name" />
                        </div>
                        <div class="m-2">
                            <InputLabel for="type" value="Type" />
                            <select v-model="form.type" id="type" class="mt-1 block w-full" >
                                <option value=1>Type 1</option>
                                <option value=2>Type 2</option>
                                <option value=3>Type 3</option>
                            </select>
                            <InputError class="mt-2" :message="page.props.errors.type" />
                        </div>
                        <div class="m-2">
                            <InputLabel for="transport_mode" value="transport_mode" />
                            <select v-model="form.transport_mode" id="transport_mode" class="mt-1 block w-full" >
                                <option value="air">Air</option>
                                <option value="land">Land</option>
                                <option value="sea">Sea</option>
                            </select>
                            <InputError class="mt-2" :message="page.props.errors.transport_mode" />
                        </div>
                        <div class="m-2">
                            <InputLabel for="product" value="product" />
                            <TextInput v-model="form.product" id="product" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="page.props.errors.product" />
                        </div>
                        <div class="m-2">
                            <InputLabel for="origin_country" value="origin_country" />
                            <TextInput v-model="form.origin_country" id="origin_country" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="page.props.errors.origin_country" />
                        </div>
                        <div class="m-2">
                            <InputLabel for="destination_country" value="destination_country" />
                            <TextInput v-model="form.destination_country" id="destination_country" type="text" class="mt-1 block w-full" />
                            <InputError class="mt-2" :message="page.props.errors.destination_country" />
                        </div>
                        <div class="m-2">
                            <InputLabel for="type" value="status" />
                            <select v-model="form.status" id="status" class="mt-1 block w-full" >
                                <option value="new">New</option>
                                <option value="in_process">in_process</option>
                                <option value="completed">completed</option>
                            </select>
                            <InputError class="mt-2" :message="page.props.errors.status" />
                        </div>
                        <br />
                        <hr />
                        <h2 class="text-2xl font-bold mb-4">Message</h2>
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
                            New Ticket
                        </PrimaryButton>
                    </form>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
