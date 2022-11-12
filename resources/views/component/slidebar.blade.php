@php
    use App\Http\Controllers\UsersPermission_Controller;
    $users_permit = new UsersPermission_Controller();
    $permissions = $users_permit->UserPermit();
@endphp
<!-- Sidebar -->
<!-- Backdrop -->
<div x-show="isSidebarOpen" @click="isSidebarOpen = false" class="fixed inset-0 z-10 bg-primary-darker lg:hidden"
    style="opacity: 0.5" aria-hidden="true"></div>

<!-- Sidebar content -->
<aside x-show="isSidebarOpen" x-transition:enter="transition-all transform duration-300 ease-in-out"
    x-transition:enter-start="-translate-x-full opacity-0" x-transition:enter-end="translate-x-0 opacity-100"
    x-transition:leave="transition-all transform duration-300 ease-in-out"
    x-transition:leave-start="translate-x-0 opacity-100" x-transition:leave-end="-translate-x-full opacity-0"
    x-ref="sidebar" @keydown.escape="window.innerWidth <= 1024 ? isSidebarOpen = false : ''" tabindex="-1"
    class="fixed inset-y-0 z-10 flex flex-shrink-0 overflow-hidden bg-white border-r lg:static dark:border-primary-darker dark:bg-darker focus:outline-none">
    <!-- Mini column -->
    <div class="flex flex-col flex-shrink-0 h-full px-2 py-4 border-r dark:border-primary-darker">

        <!-- Brand -->
        {{-- <div class="flex-shrink-0">
             <a href="../index.html"
                 class="inline-block text-xl font-bold tracking-wider uppercase text-primary-dark dark:text-light">
                 Sterile
             </a>
         </div> --}}
        <div class="flex flex-col items-center justify-center flex-1 space-y-4">
            <!-- ScanQR button -->
            <button id="scan_qr_order"
                class="p-2 transition-colors duration-200 rounded-full text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                <span class="sr-only">Open ScanQR panel</span>
                <svg class="w-6 h-6" width="24px" height="24px" stroke="currentColor" aria-hidden="true"
                    fill="none" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">
                    {{-- <title>ionicons-v5-k</title> --}}
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="55"
                        d="M342,444h46a56,56,0,0,0,56-56V342" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="55"
                        d="M444,170V124a56,56,0,0,0-56-56H342" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="55"
                        d="M170,444H124a56,56,0,0,1-56-56V342" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="55"
                        d="M68,170V124a56,56,0,0,1,56-56h46" />
                </svg>
            </button>

            @include('component.Order_Scan_QRcode')

            <!-- Notification button -->
            {{-- <button @click="openNotificationsPanel"
                class="p-2 transition-colors duration-200 rounded-full text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                <span class="sr-only">Open Notification panel</span>
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
            </button> --}}


            <button type="button" @click="openNotificationsPanel"
                class="inline-flex relative items-center p-2 transition-colors duration-200 rounded-full text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="sr-only">Notifications</span>
                <div id="div_noti"
                    class="invisible inline-flex absolute -top-2 -right-2 justify-center items-center w-6 h-6 text-xs font-semibold text-white bg-red-500 rounded-full border-2 border-white dark:border-dark">
                    <span id="num_noti">0</span>
                </div>
            </button>

            <!-- Settings button -->
            <button @click="openSettingsPanel"
                class="p-2 transition-colors duration-200 rounded-full text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark focus:outline-none focus:bg-primary-100 dark:focus:bg-primary-dark focus:ring-primary-darker">
                <span class="sr-only">Open settings panel</span>
                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>
        <!-- Mini column footer -->
        <div class="relative flex items-center justify-center flex-shrink-0">
            <!-- User avatar button -->
            <div class="" x-data="{ open: false }">
                <button @click="open = !open; $nextTick(() => { if(open){ $refs.userMenu.focus() } })" type="button"
                    aria-haspopup="true" :aria-expanded="open ? 'true' : 'false'"
                    class="block transition-opacity duration-200 rounded-full dark:opacity-75 dark:hover:opacity-100 focus:outline-none focus:ring dark:focus:opacity-100">
                    <span class="sr-only">User menu</span>
                    <div class="overflow-hidden relative w-10 h-10 bg-gray-100 rounded-full dark:bg-gray-600">
                        <svg class="absolute -left-1 w-12 h-12 text-gray-400" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </div>
                </button>

                <!-- User dropdown menu -->
                <div x-show="open" x-ref="userMenu" x-transition:enter="transition-all transform ease-out"
                    x-transition:enter-start="-translate-y-1/2 opacity-0"
                    x-transition:enter-end="translate-y-0 opacity-100"
                    x-transition:leave="transition-all transform ease-in"
                    x-transition:leave-start="translate-y-0 opacity-100"
                    x-transition:leave-end="-translate-y-1/2 opacity-0" @click.away="open = false"
                    @keydown.escape="open = false"
                    class="absolute w-56 py-1 mb-4 bg-white rounded-md shadow-lg min-w-max left-5 bottom-full ring-1 ring-black ring-opacity-5 dark:bg-dark focus:outline-none"
                    tabindex="-1" role="menu" aria-orientation="vertical" aria-label="User menu">
                    <a href="{{ url('/logout') }}" role="menuitem"
                        class="block px-4 py-2 text-sm text-gray-700 transition-colors hover:bg-gray-100 dark:text-light dark:hover:bg-primary">
                        Logout
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!-- Sidebar links -->
    <nav aria-label="Main" class="flex-1 w-56 px-2 py-4 space-y-2 overflow-y-hidden hover:overflow-y-auto">
        <!-- Dashboards links -->
        <div x-data="{ isActive: false, open: false }">
            <!-- active & hover classes 'bg-primary-100 dark:bg-primary' -->
            {{-- <a href="/a" @click="$event.preventDefault(); open = !open" --}}
            <a href="/"
                class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button" aria-haspopup="true"
                :aria-expanded="(open || isActive) ? 'true' : 'false'">
                <span aria-hidden="true">
                    <i class="fa-solid fa-gauge fa-lg"></i>
                </span>
                <span class="ml-2 text-sm"> Dashboards </span>
                <span class="ml-auto" aria-hidden="true">
                </span>
            </a>
        </div>


        <!-- Orders links -->
        @if ($permissions->Orders == 1)
            <div x-data="{ isActive: false, open: false }">
                <a href="/orders"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button"
                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span class="ml-2 text-sm"> Orders </span>
                </a>
            </div>
        @endif

        @if ($permissions->Process == 1)
            <div x-data="{ isActive: false, open: false }">
                <a href="/process"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button"
                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <i class="fa-solid fa-microchip fa-lg"></i>
                    </span>
                    <span class="ml-2 text-sm">Process</span>
                </a>
            </div>
        @endif

        {{-- COA Report --}}
        @if ($permissions->{'COA Report'} == 1)
            <div x-data="{ isActive: false, open: false }">
                <a href="/coa_report"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button"
                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                    </span>
                    <span class="ml-2 text-sm">COA Report</span>
                </a>
            </div>
        @endif

        {{-- Stock --}}
        @if ($permissions->Stock == 1)
            <div x-data="{ isActive: false, open: false }">
                <a href="/stock"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button"
                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <i class="fa-solid fa-box fa-lg"></i>
                    </span>
                    <span class="ml-2 text-sm">Stock</span>
                </a>
            </div>
        @endif

        <!-- Reports links -->
        @if ($permissions->Reports == 1)
            <div x-data="{ isActive: false, open: false }">
                <a href="/reports"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button"
                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <i class="fa-regular fa-file-lines fa-lg"></i>
                    </span>
                    <span class="ml-2 text-sm">Reports</span>
                </a>
            </div>
        @endif

        <!-- Setting links -->
        @if ($permissions->Settings == 1)
            <div x-data="{ isActive: false, open: false }">
                <!-- active & hover classes 'bg-primary-100 dark:bg-primary' -->
                <a href="#" @click="$event.preventDefault(); open = !open"
                    class="flex items-center p-2 text-gray-500 transition-colors rounded-md dark:text-light hover:bg-primary-100 dark:hover:bg-primary"
                    :class="{ 'bg-primary-100 dark:bg-primary': isActive || open }" role="button"
                    aria-haspopup="true" :aria-expanded="(open || isActive) ? 'true' : 'false'">
                    <span aria-hidden="true">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </span>
                    <span class="ml-2 text-sm"> Setting </span>
                    <span aria-hidden="true" class="ml-auto">
                        <!-- active class 'rotate-180' -->
                        <svg class="w-4 h-4 transition-transform transform" :class="{ 'rotate-180': open }"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </span>
                </a>
                <div x-show="open" class="mt-2 space-y-2 px-7" role="menu" aria-label="Layouts">
                    <!-- active & hover classes 'text-gray-700 dark:text-light' -->
                    <!-- inActive classes 'text-gray-400 dark:text-gray-400' -->
                    @if ($permissions->Customers == 1)
                        <a href="/settings/customers" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Customers
                        </a>
                    @endif
                    @if ($permissions->Equipments == 1)
                        <a href="/settings/equipments" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Equipments
                        </a>
                    @endif
                    @if ($permissions->{'Machines Washings'} == 1)
                        <a href="/settings/machineswashings" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Machines Washings
                        </a>
                    @endif
                    @if ($permissions->{'Machines Sterlie'} == 1)
                        <a href="/settings/machinessterile" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Machines Sterlie
                        </a>
                    @endif
                    @if ($permissions->{'Programs Sterlie'} == 1)
                        <a href="/settings/programs" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Programs Sterlie
                        </a>
                    @endif
                    @if ($permissions->Groups == 1)
                        <a href="/settings/groups" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Groups
                        </a>
                    @endif
                    @if ($permissions->Users == 1)
                        <a href="/settings/users" role="menuitem"
                            class="block p-2 text-sm text-gray-400 transition-colors duration-200 rounded-md dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                            Users
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </nav>
</aside>

<!-- Sidebar button -->
<div class="fixed flex items-center space-x-4 top-5 right-10 lg:hidden">
    <button @click="isSidebarOpen = true; $nextTick(() => { $refs.sidebar.focus() })"
        class="p-1 transition-colors duration-200 rounded-md text-primary-lighter bg-primary-50 hover:text-primary hover:bg-primary-100 dark:hover:text-light dark:hover:bg-primary-dark dark:bg-dark focus:outline-none focus:ring">
        <span class="sr-only">Toggle main manu</span>
        <span aria-hidden="true">
            <svg x-show="!isSidebarOpen" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <svg x-show="isSidebarOpen" class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </span>
    </button>
</div>


<!-- Panels -->

<!-- Settings Panel -->
<!-- Backdrop -->
<div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="isSettingsPanelOpen"
    @click="isSettingsPanelOpen = false" class="fixed inset-0 z-10 bg-primary-darker" style="opacity: 0.5"
    aria-hidden="true"></div>
<!-- Panel -->
<section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
    x-transition:enter-start="translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="translate-x-full" x-ref="settingsPanel"
    tabindex="-1" x-show="isSettingsPanelOpen" @keydown.escape="isSettingsPanelOpen = false"
    class="fixed inset-y-0 right-0 z-20 w-full max-w-xs bg-white shadow-xl dark:bg-darker dark:text-light sm:max-w-md focus:outline-none"
    aria-labelledby="settinsPanelLabel">
    <div class="absolute left-0 p-2 transform -translate-x-full">
        <!-- Close button -->
        <button @click="isSettingsPanelOpen = false" class="p-2 text-white rounded-md focus:outline-none focus:ring">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <!-- Panel content -->
    <div class="flex flex-col h-screen">
        <!-- Panel header -->
        <div
            class="flex flex-col items-center justify-center flex-shrink-0 px-4 py-8 space-y-4 border-b dark:border-primary-dark">
            <span aria-hidden="true" class="text-gray-500 dark:text-primary">
                <svg class="w-8 h-8" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4" />
                </svg>
            </span>
            <h2 id="settinsPanelLabel" class="text-xl font-medium text-gray-500 dark:text-light">Settings
            </h2>
        </div>
        <!-- Content -->
        <div class="flex-1 overflow-hidden hover:overflow-y-auto">
            <!-- Theme -->
            <div class="p-4 space-y-4 md:p-8">
                <h6 class="text-lg font-medium text-gray-400 dark:text-light">Mode</h6>
                <div class="flex items-center space-x-8">
                    <!-- Light button -->
                    <button @click="setLightTheme"
                        class="flex items-center justify-center px-4 py-2 space-x-4 transition-colors border rounded-md hover:text-gray-900 hover:border-gray-900 dark:border-primary dark:hover:text-primary-100 dark:hover:border-primary-light focus:outline-none focus:ring focus:ring-primary-lighter focus:ring-offset-2 dark:focus:ring-offset-dark dark:focus:ring-primary-dark"
                        :class="{
                            'border-gray-900 text-gray-900 dark:border-primary-light dark:text-primary-100':
                                !
                                isDark,
                            'text-gray-500 dark:text-primary-light': isDark
                        }">
                        <span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                            </svg>
                        </span>
                        <span>Light</span>
                    </button>

                    <!-- Dark button -->
                    <button @click="setDarkTheme"
                        class="flex items-center justify-center px-4 py-2 space-x-4 transition-colors border rounded-md hover:text-gray-900 hover:border-gray-900 dark:border-primary dark:hover:text-primary-100 dark:hover:border-primary-light focus:outline-none focus:ring focus:ring-primary-lighter focus:ring-offset-2 dark:focus:ring-offset-dark dark:focus:ring-primary-dark"
                        :class="{
                            'border-gray-900 text-gray-900 dark:border-primary-light dark:text-primary-100': isDark,
                            'text-gray-500 dark:text-primary-light':
                                !isDark
                        }">
                        <span>
                            <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                            </svg>
                        </span>
                        <span>Dark</span>
                    </button>
                </div>
            </div>

            <!-- Colors -->
            <div class="p-4 space-y-4 md:p-8">
                <h6 class="text-lg font-medium text-gray-400 dark:text-light">Colors</h6>
                <div>
                    <button @click="setColors('cyan')" class="w-10 h-10 rounded-full"
                        style="background-color: var(--color-cyan)"></button>
                    <button @click="setColors('teal')" class="w-10 h-10 rounded-full"
                        style="background-color: var(--color-teal)"></button>
                    <button @click="setColors('green')" class="w-10 h-10 rounded-full"
                        style="background-color: var(--color-green)"></button>
                    <button @click="setColors('fuchsia')" class="w-10 h-10 rounded-full"
                        style="background-color: var(--color-fuchsia)"></button>
                    <button @click="setColors('blue')" class="w-10 h-10 rounded-full"
                        style="background-color: var(--color-blue)"></button>
                    <button @click="setColors('violet')" class="w-10 h-10 rounded-full"
                        style="background-color: var(--color-violet)"></button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Notification panel -->
<!-- Backdrop -->
<div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
    x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="isNotificationsPanelOpen"
    @click="isNotificationsPanelOpen = false" class="fixed inset-0 z-10 bg-primary-darker" style="opacity: 0.5"
    aria-hidden="true"></div>
<!-- Panel -->
<section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
    x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
    x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
    x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full" x-ref="notificationsPanel"
    x-show="isNotificationsPanelOpen" @keydown.escape="isNotificationsPanelOpen = false" tabindex="-1"
    aria-labelledby="notificationPanelLabel"
    class="fixed inset-y-0 z-20 w-full max-w-xs bg-white dark:bg-darker dark:text-light sm:max-w-md focus:outline-none">
    <div class="absolute right-0 p-2 transform translate-x-full">
        <!-- Close button -->
        <button @click="isNotificationsPanelOpen = false"
            class="p-2 text-white rounded-md focus:outline-none focus:ring">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>
    </div>
    <div class="flex flex-col h-screen" x-data="{ activeTabe: 'action' }">
        <!-- Panel header -->
        <div class="flex-shrink-0">
            <div class="flex items-center justify-between px-4 pt-4 border-b dark:border-primary-darker">
                <h2 id="notificationPanelLabel" class="pb-4 font-semibold">Notifications</h2>
                <div class="space-x-2">
                    <button @click.prevent="activeTabe = 'action'"
                        class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                        :class="{
                            'border-primary-dark dark:border-primary': activeTabe ==
                                'action',
                            'border-transparent': activeTabe != 'action'
                        }">
                        Action
                    </button>
                    {{-- <button @click.prevent="activeTabe = 'user'"
                        class="px-px pb-4 transition-all duration-200 transform translate-y-px border-b focus:outline-none"
                        :class="{
                             'border-primary-dark dark:border-primary': activeTabe ==
                                 'user',
                             'border-transparent': activeTabe != 'user'
                         }">
                        User
                    </button> --}}
                </div>
            </div>
        </div>

        <!-- Panel content (tabs) -->
        <div class="flex-1 pt-4 overflow-y-hidden hover:overflow-y-auto">
            <!-- Action tab -->
            <div class="space-y-4" x-show.transition.in="activeTabe == 'action'" id="sidebar_notifications">
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <p class="hidden pt-1 text-sm font-semibold text-right">อ่านแล้ว</p>
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <p class="hidden pt-1 text-sm font-semibold text-right">อ่านแล้ว</p>
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <p class="hidden pt-1 text-sm font-semibold text-right">อ่านแล้ว</p>
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <p class="hidden pt-1 text-sm font-semibold text-right">อ่านแล้ว</p>
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <p class="hidden pt-1 text-sm font-semibold text-right">อ่านแล้ว</p>
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
                <div
                    class="px-4 cursor-pointer transition-colors dark:text-gray-400 dark:hover:text-light hover:text-gray-700">
                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam facere quasi, distinctio voluptatum
                    minima totam odit hic vitae? Magni delectus corporis itaque aperiam nesciunt ea consectetur quaerat
                    dolorem vero quam.
                    <p class="hidden pt-1 text-sm font-semibold text-right">อ่านแล้ว</p>
                    <hr class="mx-auto w-full h-1 bg-gray-100 rounded border-0 md:my-4 dark:bg-gray-700">
                </div>
            </div>

            <!-- User tab -->
            {{-- <div class="space-y-4" x-show.transition.in="activeTabe == 'user'">
                <p class="px-4">User tab content</p>
                <!--  -->
                <!-- User tab content -->
                <!--  -->
            </div> --}}
        </div>
    </div>
</section>

    <!-- Search panel -->
    <!-- Backdrop -->
    <div x-transition:enter="transition duration-300 ease-in-out" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition duration-300 ease-in-out"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" x-show="isSearchPanelOpen"
        @click="isSearchPanelOpen = false" class="fixed inset-0 z-10 bg-primary-darker" style="opacity: 0.5"
        aria-hidden="ture"></div>
    <!-- Panel -->
    <section x-transition:enter="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
        x-transition:leave="transition duration-300 ease-in-out transform sm:duration-500"
        x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
        x-show="isSearchPanelOpen" @keydown.escape="isSearchPanelOpen = false"
        class="fixed inset-y-0 z-20 w-full max-w-xs bg-white shadow-xl dark:bg-darker dark:text-light sm:max-w-md focus:outline-none">
        <div class="absolute right-0 p-2 transform translate-x-full">
            <!-- Close button -->
            <button @click="isSearchPanelOpen = false"
                class="p-2 text-white rounded-md focus:outline-none focus:ring">
                <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <h2 class="sr-only">Search panel</h2>
        <!-- Panel content -->
        <div class="flex flex-col h-screen">
            <!-- Panel header (Search input) -->
            <div
                class="relative flex-shrink-0 px-4 py-8 text-gray-400 border-b dark:border-primary-darker dark:focus-within:text-light focus-within:text-gray-700">
                <span class="absolute inset-y-0 inline-flex items-center px-4">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </span>
                <input x-ref="searchInput" type="text"
                    class="w-full py-2 pl-10 pr-4 border rounded-full dark:bg-dark dark:border-transparent dark:text-light focus:outline-none focus:ring"
                    placeholder="Search..." />
            </div>

            <!-- Panel content (Search result) -->
            <div class="flex-1 px-4 pb-4 space-y-4 overflow-y-hidden h hover:overflow-y-auto">
                <h3 class="py-2 text-sm font-semibold text-gray-600 dark:text-light">History</h3>
                <p class="px=4">Search resault</p>
                <!--  -->
                <!-- Search content -->
                <!--  -->
            </div>
        </div>
    </section>



    <script>
        const setup = () => {
            const getTheme = () => {
                if (window.localStorage.getItem('dark')) {
                    return JSON.parse(window.localStorage.getItem('dark'))
                }
                return !!window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
            }

            const setTheme = (value) => {
                window.localStorage.setItem('dark', value)
            }

            const getColor = () => {
                if (window.localStorage.getItem('color')) {
                    return window.localStorage.getItem('color')
                }
                return 'cyan'
            }

            const setColors = (color) => {
                const root = document.documentElement
                root.style.setProperty('--color-primary', `var(--color-${color})`)
                root.style.setProperty('--color-primary-50', `var(--color-${color}-50)`)
                root.style.setProperty('--color-primary-100', `var(--color-${color}-100)`)
                root.style.setProperty('--color-primary-light', `var(--color-${color}-light)`)
                root.style.setProperty('--color-primary-lighter', `var(--color-${color}-lighter)`)
                root.style.setProperty('--color-primary-dark', `var(--color-${color}-dark)`)
                root.style.setProperty('--color-primary-darker', `var(--color-${color}-darker)`)
                this.selectedColor = color
                window.localStorage.setItem('color', color)
            }

            return {
                loading: true,
                isDark: getTheme(),
                color: getColor(),
                selectedColor: 'cyan',
                toggleTheme() {
                    this.isDark = !this.isDark
                    setTheme(this.isDark)
                },
                setLightTheme() {
                    this.isDark = false
                    setTheme(this.isDark)
                },
                setDarkTheme() {
                    this.isDark = true
                    setTheme(this.isDark)
                },
                setColors,
                watchScreen() {
                    if (window.innerWidth <= 1024) {
                        this.isSidebarOpen = false
                    } else if (window.innerWidth >= 1024) {
                        this.isSidebarOpen = true
                    }
                },
                isSidebarOpen: window.innerWidth >= 1024 ? true : false,
                toggleSidbarMenu() {
                    this.isSidebarOpen = !this.isSidebarOpen
                },
                isNotificationsPanelOpen: false,
                openNotificationsPanel() {
                    this.isNotificationsPanelOpen = true
                    this.$nextTick(() => {
                        this.$refs.notificationsPanel.focus()
                    })
                },
                isSettingsPanelOpen: false,
                openSettingsPanel() {
                    this.isSettingsPanelOpen = true
                    this.$nextTick(() => {
                        this.$refs.settingsPanel.focus()
                    })
                },
                isSearchPanelOpen: false,
                openSearchPanel() {
                    this.isSearchPanelOpen = true
                    this.$nextTick(() => {
                        this.$refs.searchInput.focus()
                    })
                },
            }
        }
    </script>

{{-- modal --}}
<div class="fixed z-[99] inset-0 w-full invisible overflow-y-auto" aria-labelledby="modal-title" role="dialog"
    aria-modal="true" id="notificationModal">
    <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" aria-hidden="true"></div>
        <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">​</span>
        <div
            class="inline-block align-bottom bg-white dark:bg-darker dark:text-light rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-top sm:max-w-2xl w-full">
            <div class="bg-white dark:bg-darker dark:text-light px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                <div class="sm:flex sm:items-start">
                    <div
                        class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100 sm:mx-0 sm:h-10 sm:w-10">
                        {{-- <i class="fa-regular fa-building"></i> --}}
                        <i class="fa-regular fa-bell text-gray-700"></i>
                    </div>
                    <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                        <h3 class="text-lg mt-2 leading-6 font-medium bg-white dark:bg-darker dark:text-light"
                            id="modal-title">
                            Notifications details
                        </h3>
                    </div>
                </div>
                <p class="mt-2">
                <div class="text-sm dark:text-light">
                    <div class="detail_edit_show w-full mt-3">
                    </div>
                </div>
                </p>
            </div>
            <div class="bg-white dark:bg-darker dark:text-light px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                <button type="button"
                    class="closeModal mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-black hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                    ปิด
                </button>
            </div>
        </div>
    </div>
</div>