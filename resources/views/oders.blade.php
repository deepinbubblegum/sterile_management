<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>
    <link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;600;700;900&display=swap"
        rel="stylesheet" />
    <script src="{{ asset('assets/component.min.js') }}"></script>
    <script src="{{ asset('assets/alpine.min.js') }}" defer></script>
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
    <style>
        * {
            font-family: 'Bai Jamjuree', sans-serif;
        }
    </style>
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

                {{-- Breadcrumb --}}
                <div class="flex flex-col flex-1 h-full min-h-screen p-4 overflow-x-hidden overflow-y-auto">
                    <div class="mx-auto rounded-md w-full bg-white dark:bg-darker dark:text-light p-4 mb-4 leading-6 ">
                        <nav class="flex" aria-label="Breadcrumb">
                            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                                <li class="inline-flex items-center">
                                    <a
                                        class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z">
                                            </path>
                                        </svg>
                                        Oders
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    <div
                        class="mx-auto h-full w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">
                        <div class="flex justify-end">
                            <button href="https://github.com/Kamona-WD/kwd-dashboard" target="_blank"
                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-primary inline-flex items-center hover:bg-primary-dark focus:outline-none focus:ring focus:ring-primary focus:ring-offset-1 focus:ring-offset-white dark:focus:ring-offset-dark">
                                <svg class="mr-2 -ml-1 w-4 h-4 fill-white" aria-hidden="true" focusable="false"
                                    data-prefix="fab" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                                    <path
                                        d="M8,24H9a1,1,0,0,0,0-2H8a3,3,0,0,1-3-3V5A3,3,0,0,1,8,2h8a3,3,0,0,1,3,3V9a1,1,0,0,0,2,0V5a5.006,5.006,0,0,0-5-5H8A5.006,5.006,0,0,0,3,5V19A5.006,5.006,0,0,0,8,24Z" />
                                    <path
                                        d="M16 5H8A1 1 0 0 0 8 7h8a1 1 0 0 0 0-2zM17 10a1 1 0 0 0-1-1H8a1 1 0 0 0 0 2h8A1 1 0 0 0 17 10zM8 13a1 1 0 0 0 0 2h4a1 1 0 0 0 0-2zM18.879 12.879l-5.657 5.657a1 1 0 0 0-.264.467l-.929 3.757a1 1 0 0 0 .264.947 1.013 1.013 0 0 0 .947.264L17 23.042a.992.992 0 0 0 .467-.264l5.656-5.656a3 3 0 1 0-4.242-4.243zm-2.632 8.288l-1.879.465.465-1.879 3.339-3.339 1.414 1.414zm5.46-5.46L21 16.414 19.586 15l.707-.707a1 1 0 0 1 1.414 0A1.012 1.012 0 0 1 21.707 15.707z" />
                                </svg>
                                สร้าง ออเดอร์
                            </button>

                            <button href="https://github.com/Kamona-WD/kwd-dashboard" target="_blank"
                                class="px-4 mr-2 py-2 text-base text-white rounded-md bg-info inline-flex items-center hover:bg-info-dark focus:outline-none focus:ring focus:ring-info focus:ring-offset-1 focus:ring-offset-white darker:focus:ring-offset-dark">
                                <svg class="mr-2 -ml-1 w-4 h-4 fill-white" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                    viewBox="0 0 6.35 6.35">
                                    <path
                                        d="M4.497 0a.265.265 0 0 0-.264.263v1.06c0 .435.358.793.793.793h1.06a.265.265 0 0 0 0-.529h-1.06a.26.26 0 0 1-.263-.264V.263A.265.265 0 0 0 4.497 0Z"
                                        color="#000" />
                                    <path
                                        d="M2.117 0a.798.798 0 0 0-.795.793V2.91a.265.265 0 0 0 .266.266.265.265 0 0 0 .264-.266V.793a.26.26 0 0 1 .265-.264H4.39L5.82 1.961v3.596a.26.26 0 0 1-.263.263h-3.44a.26.26 0 0 1-.265-.263v-.53a.265.265 0 0 0-.264-.265.265.265 0 0 0-.266.265v.53c0 .435.36.793.795.793h3.44a.796.796 0 0 0 .793-.793V1.852a.265.265 0 0 0-.077-.188L4.686.078A.265.265 0 0 0 4.498 0Z"
                                        color="#000" />
                                    <path d="M.264 4.234a.265.265 0 0 1 0-.529h3.175a.265.265 0 1 1 0 .53z"
                                        color="#000" />
                                    <path style="-inkscape-stroke:none"
                                        d="M2.723 2.988a.265.265 0 0 0 0 .373l.607.608-.607.607a.265.265 0 0 0 0 .373.265.265 0 0 0 .375 0l.793-.793a.265.265 0 0 0 0-.375l-.793-.793a.265.265 0 0 0-.375 0z"
                                        color="#000" />
                                </svg>
                                รับ ออเดอร์
                            </button>
                        </div>

                        {{-- table --}}
                        <h1>222</h1>

                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->
</body>

</html>
