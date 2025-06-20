<script setup>
import { Head, usePage, router } from '@inertiajs/vue3'
import { ref } from 'vue'
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue'
import PrimaryButton from '@/Components/PrimaryButton.vue'
import FlashMessage from '@/Components/FlashMessage.vue'

const page = usePage()
const isMessage = ref(false)
 
const newMessage = (id) => { router.get(route('message.agent', [id]), {}, {}) }
const sabeTicket = (id, status) => { console.log(status), router.post(route('ticket.update.agent', [id, status]), {}, {})  }
const sabeMessage = (id) => { router.post(route('message.update.agent', [id]), {}, {}) }

const closeMessage = () => { 
    isMessage.value = false
    page.props.flash.message = null;
}

</script>
<template>

       <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Agent</h2>
        </template>
        <FlashMessage v-if="isMessage" :message="$page.props.flash.message" :color="$page.props.flash.color" @closeMessage="closeMessage" />

        <div class="py-12">
            <div class="max-w-9sxl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                   <table class="w-full p-10 text-black">
                    
                        <thead>
                            <tr>
                                <th class="px-4 py-2">Name</th>
                                <th class="px-4 py-2">Type</th>
                                <th class="px-4 py-2">Transp</th>
                                <th class="px-4 py-2">Product</th>
                                <th class="px-4 py-2">Orig</th>
                                <th class="px-4 py-2">Dest</th>
                                <th class="px-4 py-2">Status</th>
                                <th class="px-4 py-2">Action</th>
                                <th class="px-4 py-2">Message</th>
                                <th class="px-4 py-2">User/agent</th>
                                <th class="px-4 py-2">Is Read</th>
                                <th class="px-4 py-2">Attachment</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="ticket in page.props.tickets" :key="ticket.id">
                                <td class="border px-4 py-2">{{ ticket.name }}</td>
                                <td class="border px-4 py-2">{{ ticket.type }}</td>
                                <td class="border px-4 py-2">{{ ticket.transport_mode }}</td>
                                <td class="border px-4 py-2">{{ ticket.product }}</td>
                                <td class="border px-4 py-2">{{ ticket.origin_country }}</td>
                                <td class="border px-4 py-2">{{ ticket.destination_country }}</td>
                                <td class="border px-4 py-2">
                                    <select v-model="ticket.status" id="status" class="mt-1 block w-full" >
                                        <option value="new">New</option>
                                        <option value="in_process">in_process</option>
                                        <option value="completed">completed</option>
                                    </select>
                                </td>
                                <td class="border px-4 py-2"> 
                                    <PrimaryButton class="m-2 p-2" @click="newMessage(ticket.id)" >New Message</PrimaryButton><br>
                                    <PrimaryButton class="m-2 p-2" @click="sabeTicket(ticket.id, ticket.status)" >Save</PrimaryButton>
                                 </td>
                                <td class="border px-4 py-2" colspan="4" style="padding:0;" >
                                    <table class="w-full">
                                        <tbody>
                                            <tr v-for="message in ticket.messages" :key="message.id">
                                                <td class="border px-4 py-2">{{ message.content }}</td>
                                                <td class="border px-4 py-2">{{ message.type }}</td>
                                                <td class="border px-4 py-2">{{ message.is_read ? 'Yes' : 'No' }}
                                                    <PrimaryButton 
                                                        v-if="message.type && message.type.includes('user') && (message.is_read === null || message.is_read === undefined)" 
                                                        class="m-2 p-2" 
                                                        @click="sabeMessage(message.id)"
                                                    >
                                                        Read
                                                    </PrimaryButton>
                                                </td>
                                                <td class="border px-4 py-2">
                                                    <a v-if="message.attachment" :href="message.attachment" target="_blank" class="text-blue-500 hover:underline">View Attachment</a>
                                                    <span v-else class="text-gray-500">No Attachment</span>
                                                </td>
                                            </tr>  
                                        </tbody>
                                    </table>
                                </td>                              
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>

</template>
