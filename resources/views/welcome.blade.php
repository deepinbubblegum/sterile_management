<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>K-WD Dashboard | Mini + One Columns Sidebar</title>

    @include('component.Tagheader')

</head>

<body>
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');
    setColors(color);" :class="{ 'dark': isDark }" @resize.window="watchScreen()">
        <div class="flex h-screen antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Loading screen -->
            <div x-ref="loading"
                class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-primary-darker">
                Loading.....
            </div>
            @include('component.slidebar')
            <!-- Main content -->
            <main class="flex-1">
                <div class="flex flex-col flex-1 h-full min-h-screen p-4 overflow-x-hidden overflow-y-auto">
                    <div class="mx-auto rounded-md w-full bg-white dark:bg-darker dark:text-light p-4 mb-4 leading-6 ">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a href="#"
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Dashboards
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>



                    <div class="grid grid-cols-1 gap-8 lg:grid-cols-2 xl:grid-cols-4">
                        
                        <!-- Users card -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <div>
                                <h6
                                    class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                                    Users
                                </h6>
                                <span class="text-xl font-semibold">50,021</span>
                                <span
                                    class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                                    +2.6%
                                </span>
                            </div>
                            <div>
                                <span>
                                    <svg class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Orders card -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <div>
                                <h6
                                    class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                                    Orders
                                </h6>
                                <span class="text-xl font-semibold">45,021</span>
                                <span
                                    class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                                    +3.1%
                                </span>
                            </div>
                            <div>
                                <span>
                                    <svg class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- Pending card -->
                        <div class="flex items-center justify-between p-4 bg-white rounded-md dark:bg-darker">
                            <div>
                                <h6
                                    class="text-xs font-medium leading-none tracking-wider text-gray-500 uppercase dark:text-primary-light">
                                    Pending
                                </h6>
                                <span class="text-xl font-semibold">20,516</span>
                                <span
                                    class="inline-block px-2 py-px ml-2 text-xs text-green-500 bg-green-100 rounded-md">
                                    +3.1%
                                </span>
                            </div>
                            <div>
                                <span>
                                    <svg class="w-12 h-12 text-gray-300 dark:text-primary-dark"
                                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z">
                                        </path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

            </div>
        </div>
    </div>
    </div>
    </main>
    </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>

</html>
