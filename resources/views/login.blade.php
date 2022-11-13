<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login</title>

    @include('component.Tagheader')


</head>

<body>
    <div x-data="setup()" x-init="$refs.loading.classList.add('hidden');
    setColors(color);" :class="{ 'dark': isDark }">
        <!-- Loading screen -->
        <div x-ref="loading"
            class="fixed inset-0 z-50 flex items-center justify-center text-2xl font-semibold text-white bg-primary-darker">
            Loading.....
        </div>
        <div
            class="flex flex-col items-center justify-center min-h-screen p-4 space-y-4 antialiased text-gray-900 bg-gray-100 dark:bg-dark dark:text-light">
            <!-- Brand -->
            {{-- <a href="../index.html"
                class="inline-block mb-6 text-3xl font-bold tracking-wider uppercase text-primary-dark dark:text-light">
            </a> --}}
            <main>
                @include('component.ribbon')
                <div class="w-full max-w-sm px-4 py-6 space-y-6 bg-white rounded-md dark:bg-darker">
                    <h1 class="text-xl font-semibold text-center">Login</h1>
                    <form class="space-y-6" id="formLogin">
                        <input
                            class="w-full px-4 py-2 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100 dark:focus:ring-primary-darker"
                            type="text" name="Username" placeholder="Username" />
                        <input
                            class="w-full px-4 py-2 border rounded-md dark:bg-darker dark:border-gray-700 focus:outline-none focus:ring focus:ring-primary-100 dark:focus:ring-primary-darker"
                            type="password" name="password" placeholder="Password" />
                        <div class="flex items-center justify-between">
                            <!-- Remember me toggle -->
                            <label class="flex items-center">
                                <div class="relative inline-flex items-center">
                                    <input type="checkbox" name="remembr_me"
                                        class="w-10 h-4 transition bg-gray-200 border-none rounded-full shadow-inner outline-none appearance-none toggle checked:bg-primary-light disabled:bg-gray-200 focus:outline-none" />
                                    <span
                                        class="absolute top-0 left-0 w-4 h-4 transition-all transform scale-150 bg-white rounded-full shadow-sm"></span>
                                </div>
                                <span class="ml-3 text-sm font-normal text-gray-500 dark:text-gray-400">Remember
                                    me</span>
                            </label>

                            {{-- <a href="forgot-password.html" class="text-sm text-blue-600 hover:underline">Forgot Password?</a> --}}
                        </div>
                        <div>
                            <button type="button" id="btn_submit"
                                class="w-full px-4 py-2 font-medium text-center text-white transition-colors duration-200 rounded-md bg-primary hover:bg-primary-dark focus:outline-none focus:ring-2 focus:ring-primary focus:ring-offset-1 dark:focus:ring-offset-darker">
                                Login
                            </button>
                        </div>
                    </form>

                    <!-- Or -->
                    {{-- <div class="flex items-center justify-center space-x-2 flex-nowrap">
                        <span class="w-20 h-px bg-gray-300"></span>
                        <span>OR</span>
                        <span class="w-20 h-px bg-gray-300"></span>
                    </div> --}}

                    <!-- Social login links -->
                    <!-- Brand icons src https://boxicons.com -->

                    <!-- Register link -->
                    {{-- <div class="text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account yet? <a href="register.html"
                            class="text-blue-600 hover:underline">Register</a>
                    </div> --}}
                </div>
            </main>
        </div>
        <!-- Toggle dark mode button -->
        <div class="fixed bottom-5 left-5">
            <button aria-hidden="true" @click="toggleTheme"
                class="p-2 transition-colors duration-200 rounded-full shadow-md bg-primary hover:bg-primary-darker focus:outline-none focus:ring focus:ring-primary">
                <svg x-show="isDark" class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                </svg>
                <svg x-show="!isDark" class="w-8 h-8 text-white" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
            </button>
        </div>
    </div>

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
                toggleTheme() {
                    this.isDark = !this.isDark
                    setTheme(this.isDark)
                },
                setColors,
            }
        }
        // end setup


        $(document).ready(function () {

            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            const formToObject = (form) => {
                const myFormData = new FormData(form);

                const formDataObj = {};
                myFormData.forEach((value, key) => (formDataObj[key] = value));

                return formDataObj;
            }

            $('#btn_submit').on('click', async (e) => {

                const form = document.getElementById('formLogin');
                var json_data = JSON.stringify(formToObject(form), null, 2);

                fetch('Login_user', {
                        method: 'POST',
                        headers: {
                            "X-CSRF-TOKEN": csrfToken,
                            "Content-Type": "application/json",
                            "Accept": "application/json, text-plain, */*",
                        },
                        body: json_data,
                    })
                    .then((response) => response.json())
                    .then((data) => {

                        if (data.code == '200') {
                            location.reload();
                            // window.location = url_path;
                        } else {
                            alert('Username or Password Invalid')
                        }
                        // console.log('Success:', data.data.Permission);
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                    });
            });


        })

    </script>
</body>

</html>
