<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <title>Sterile traceability</title>

    @include('component.Tagheader')

</head>

<body id="body_html">
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
                                        Process
                                    </a>
                                </li>
                            </ol>
                        </nav>
                    </div>
                    {{-- Breadcrumb end --}}

                    <div
                        class="mx-auto h-auto w-full rounded-md bg-white dark:bg-darker dark:text-light shadow-sm p-4 leading-6">

                        Process

                        <div class="mt-5">
                            <form>
                                <div class="grid gap-6 mb-6 md:grid-cols-2">
                                    <div>
                                        <input type="text" id="txt_search"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Oder ID" value="">
                                    </div>

                                </div>
                                <button type="button" id="btn_search"
                                    class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Search
                                </button>
                                <button type="button" id="btn_clear_search"
                                    class="text-white bg-orange-700 hover:bg-orange-800 focus:ring-4 focus:outline-none focus:ring-orange-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-orange-600 dark:hover:bg-orange-700 dark:focus:ring-orange-800">Clear
                                </button>
                            </form>
                        </div>

                        <section id="section_table">

                            <div class="overflow-x-auto relative shadow-md sm:rounded-lg mt-5">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 table-auto">
                                    <thead
                                        class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="py-3 px-6">
                                                Oder_id
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Status_Oder
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Notes
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Approve_by
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Approve_at
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Create_by
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Create_at
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Update_by
                                            </th>
                                            <th scope="col" class="py-3 px-6">
                                                Update_at
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="oder_TBody">
                                        {{-- @foreach ($data->data as $oder)
                                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 clickable-row cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600"
                                                data-href='/Onprocess/{{ $oder->Oder_id }}'>
                                                <th scope="row"
                                                    class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                                    {{ $oder->Oder_id }} </a>
                                                </th>
                                                <td class="py-4 px-6">
                                                    {{ $oder->StatusOder }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->Notes }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->userApprove }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->Approve_at }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->userCreate }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->Create_at }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->userUpdate }}
                                                </td>
                                                <td class="py-4 px-6">
                                                    {{ $oder->Update_at }}
                                                </td>
                                            </tr>
                                        @endforeach --}}
                                    </tbody>
                                </table>
                            </div>
                            {{-- {{ $users->links('pagination::tailwind') }} --}}


                            <div class="mt-3">

                                <div class="text-end text-slate-600 mr-2">
                                    View <span id="txt_firstItem"></span> - <span id="txt_lastItem"></span> of <span
                                        id="txt_total"></span>
                                </div>

                                <div class="text-center w-full">
                                    <button
                                        class="btn_first_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                        type="button" id="select_page" url_data="">
                                        <<
                                    </button>
                                    <button
                                        class="btn_prev_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                        type="button" id="select_page" url_data="">
                                        <
                                    </button>
                                            Page
                                    <input type="text" id="page_input" value=""
                                        class="text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 p-[7px] w-20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        required>
                                    of <span id="lastPage"></span>
                                    <button
                                        class="btn_next_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                        type="button" id="select_page" url_data="nextPageUrl">
                                        >
                                    </button>
                                    <button
                                        class="btn_last_page bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
                                        type="button"id="select_page" url_data="lastPage">
                                        >>
                                    </button>
                                </div>
                            </div>

                        </section>


                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- All javascript code in this project for now is just for demo DON'T RELY ON IT  -->

</body>


<script>
    $(document).ready(function() {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        function getParameterByName(name, url) {
            name = name.replace(/[\[\]]/g, '\\$&');
            let regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
                results = regex.exec(url);
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }


        // function Start
        list_oder();

        $(function() {
            $('#oder_TBody').on("click", "tr.table-tr", function() {
                window.location = $(this).data("href");
                // alert($(this).data("href"));
            });
        });


        $(document).on('click', '#select_page', function() {
            let type_btn = $(this).attr("type_btn")
            let url_data = $(this).attr("url_data")

            let page = getParameterByName('page', url_data)

            let txt_search = $('#txt_search').val();

            list_oder(page, txt_search);
        })


        $('#btn_search').on('click', function(){
            let txt_search = $('#txt_search').val();

            list_oder( 1, txt_search);
        })

        $('#btn_clear_search').on('click', function(){
            let txt_search = '';
            $('#txt_search').val('');

            list_oder( 1, txt_search);
        })

        function changPage(input, last_page) {

            let txt_search = $('#txt_search').val();

            if (input != parseInt(input)) {
                input = 1;
            } else if (input > last_page) {
                input = last_page
            }

            list_oder(input, txt_search);
        }


        function list_oder(page , txt_search) {

            if (!txt_search) txt_search = '';
            if (page == null || page == '') page = 1;

            html_oder = ''
            $.ajax({
                type: "POST",
                url: `/process/GetOder?page=${page}`,
                data:{
                    txt_search : txt_search
                },
                dataType: "json",
                success: function(response) {

                    $('#txt_firstItem').text(response.orders.from)
                    $('#txt_lastItem').text(response.orders.to)
                    $('#txt_total').text(response.orders.total)
                    $('#lastPage').text(response.orders.last_page)
                    $('#page_input').val(response.orders.current_page)


                    const btn_first_page = document.querySelector(".btn_first_page");
                    btn_first_page.setAttribute("url_data", response.orders.first_page_url);

                    const btn_prev_page = document.querySelector(".btn_prev_page");
                    btn_prev_page.setAttribute("url_data", response.orders.prev_page_url);

                    const btn_next_page = document.querySelector(".btn_next_page");
                    btn_next_page.setAttribute("url_data", response.orders.next_page_url);

                    const btn_last_page = document.querySelector(".btn_last_page");
                    btn_last_page.setAttribute("url_data", response.orders.last_page_url);

                    console.log(response.orders.data)
                    response.orders.data.forEach(function(item) {
                        html_oder += `
                        <tr class="table-tr bg-white border-b dark:bg-gray-800 dark:border-gray-700 clickable-row cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-600" data-href='/Onprocess/${item.Order_id}'>
                            <th scope="row"
                                class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                ${item.Order_id}
                            </th>
                            <td class="py-4 px-6">
                                ${item.StatusOrder}
                            </td>
                            <td class="py-4 px-6">
                                ${item.Order_id}
                            </td>
                            <td class="py-4 px-6">
                                ${item.userApprove}
                            </td>
                            <td class="py-4 px-6">
                                ${item.Approve_at}
                            </td>
                            <td class="py-4 px-6">
                                ${item.userCreate}
                            </td>
                            <td class="py-4 px-6">
                                ${item.Create_at}
                            </td>
                            <td class="py-4 px-6">
                                ${item.userUpdate}
                            </td>
                            <td class="py-4 px-6">
                                ${item.Update_at}
                            </td>
                        </tr>
                        `
                    });

                    $('#oder_TBody').html(html_oder)


                    document.querySelector('#page_input').addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            // code for enter
                            let input = $('#page_input').val()

                            changPage(input, response.orders.last_page)
                        }
                    });

                },
            });
        }

        $(".clickable-row").click(function() {
            window.location = $(this).data("href");
            // alert($(this).data("href"))
        });

    })
</script>

</html>
