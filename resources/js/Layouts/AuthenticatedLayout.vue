<script setup>
import { ref } from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';
import { usePage } from '@inertiajs/vue3';


const page = usePage();
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav class="bg-white border-b border-gray-100">
                <!-- Primary Navigation Menu -->
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex justify-between h-16">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="shrink-0 flex items-center">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"  />
                            </div>

                            <!-- Navigation Links -->
                            <template v-if="page.props.auth.user && page.props.auth.user.permissions == 'user'">
                                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                    <NavLink :href="route('ticket.create')" :active="route().current('ticket.create')">
                                        User Create Ticket
                                    </NavLink>
                                    <NavLink :href="route('ticket.user')" :active="route().current('ticket.user')">
                                        Tickets Show user
                                    </NavLink>
                                </div>
                            </template>
                            <template v-else-if="page.props.auth.user && page.props.auth.user.permissions == 'agent'">
                                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                    <NavLink :href="route('ticket.agent')" :active="route().current('ticket.agent')">
                                        Agent ticket edit
                                    </NavLink>
                                   
                                </div>
                            </template>
                          
                        </div>
                        <div class="hidden sm:flex sm:items-center sm:ms-6">
                            <!-- Settings Dropdown -->
                            <template v-if="!page.props.auth.user">
                                <Link :href="route('login')"
                                    class="text-xl p-4 font-semibold text-gray-900 bg-blue-900 border border-blue-600 rounded-xl hover:text-gray-600 hover:bg-blue-600"
                                    >Log in
                                </Link>
                                <Link :href="route('register')"
                                    class="ml-5 text-xl p-4 font-semibold text-gray-900 bg-blue-900 border border-blue-600 rounded-xl hover:text-gray-600 hover:bg-blue-600"
                                    >Register
                                </Link>
                            </template> 
                            <template v-else>
                                   
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <span class="inline-flex rounded-md">
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-xl leading-4 font-medium rounded-md text-gray-900 bg-gray-200 hover:text-gray-700 focus:outline-none transition ease-in-out duration-150"
                                                >  
                                                    
                                                    {{ page.props.auth.user.name }}

                                                    <svg
                                                        class="ms-2 -me-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        viewBox="0 0 20 20"
                                                        fill="currentColor"
                                                    >
                                                        <path
                                                            fill-rule="evenodd"
                                                            d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                                            clip-rule="evenodd"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <DropdownLink :href="route('profile.edit')"> Profile </DropdownLink>
                                            <DropdownLink :href="route('logout')" method="post" as="button">
                                                Log Out
                                            </DropdownLink>
                                        </template>
                                    </Dropdown>
                                </div>
                            
                            </template>
                            
                        </div>

                    
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header class="bg-white shadow" v-if="$slots.header">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot />
            </main>
        </div>
    </div>
</template>
