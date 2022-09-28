<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>

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
            <main class="flex-1 overflow-x-hidden">

                <div class="flex flex-col flex-1 h-full min-h-screen p-4 overflow-x-hidden overflow-y-auto">

                    {{-- Breadcrumb --}}
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
                                        Create Oders
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    {{-- <div
                        class="mx-auto h-full w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">
                        <section class="overflow-x-auto">
                            <div>
                                <select class="js-example-basic-single" name="state">
                                    <option value="AL">Alabama</option>
                                    <option value="WY">Wyoming</option>
                                </select>
                            </div>
                        </section>
                    </div> --}}
                    <div class="mt-10 text-base sm:mt-0">
                        <div class="mt-5 md:mt-0 md:col-span-2">
                            <form action="#" method="POST">
                                <div class="shadow overflow-hidden sm:rounded-md">
                                    <div class="px-4 py-5 bg-white dark:bg-darker dark:text-light sm:p-6">
                                        <div class="grid grid-cols-6 gap-6">
                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="first_name"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">สถานพยาบาล หรือ ศูนย์การแพทย์ </label>
                                                <select id="country" name="country" autocomplete="country"
                                                    class="js-example-basic-single mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                                    <option>United States</option>
                                                    <option>Canada</option>
                                                    <option>Mexico</option>
                                                </select>
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="last_name"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Last
                                                    name</label>
                                                <input type="text" name="last_name" id="last_name"
                                                    autocomplete="family-name"
                                                    class="mt-1 border h-10 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-4">
                                                <label for="email_address"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Email
                                                    address</label>
                                                <input type="text" name="email_address" id="email_address"
                                                    autocomplete="email"
                                                    class="mt-1 border focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-3">
                                                <label for="country"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Country
                                                    /
                                                    Region</label>
                                            </div>

                                            <div class="col-span-6">
                                                <label for="street_address"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">Street
                                                    address</label>
                                                <input type="text" name="street_address" id="street_address"
                                                    autocomplete="street-address"
                                                    class="mt-1 border focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-6 lg:col-span-2">
                                                <label for="city"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">City</label>
                                                <input type="text" name="city" id="city"
                                                    class="mt-1 border focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <label for="state"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">State
                                                    /
                                                    Province</label>
                                                <input type="text" name="state" id="state"
                                                    class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md sm:text-sm border-gray-300 rounded-md">
                                            </div>

                                            <div class="col-span-6 sm:col-span-3 lg:col-span-2">
                                                <label for="postal_code"
                                                    class="block text-base font-medium dark:bg-darker dark:text-light mb-2">ZIP
                                                    / Postal</label>
                                                <input type="text" name="postal_code" id="postal_code"
                                                    autocomplete="postal-code"
                                                    class="mt-1 border focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-md sm:text-sm border-gray-300 rounded-md">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                        <button type="submit"
                                            class="inline-flex border justify-center py-2 px-4 border border-transparent shadow-md text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>


<script>
    $(document).ready(function() {
        $('.js-example-basic-single').select2();
    });
</script>

</html>
