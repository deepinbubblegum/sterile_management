{{-- {{dd($data->data)}} --}}


<div class="mt-3">

    <div class="text-end text-slate-600 mr-2">
        View <span id="txt_firstItem"></span> - <span id="txt_lastItem"></span> of  {{ $data->data->total() }}
    </div>

    <div class="text-center w-full">
        <button
        class="bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
        type="button" id="select_page" type_btn='first_page' url_data="{{ $data->data->path() }}?page=1">
        <<
        </button>
        <button
            class="bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
            type="button" id="select_page" type_btn='prev_page' url_data="{{ $data->data->previousPageUrl() }}">
            <
        </button>
        Page
        <input type="text" id="page_input" value="{{ $data->data->currentPage() }}"
            class="text-center bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-md focus:ring-blue-500 focus:border-blue-500 p-[7px] w-20 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
            required>
        of {{ $data->data->lastPage() }}
        <button
            class="bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
            type="button" id="select_page" type_btn='next_page' url_data="{{ $data->data->nextPageUrl() }}">
            >
        </button>
        <button
            class="bg-teal-500 text-white active:bg-teal-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none ease-linear transition-all duration-150"
            type="button"id="select_page" type_btn='next_page' url_data="{{ $data->data->path() }}?page={{ $data->data->lastPage() }}">
            >>
        </button>
    </div>

</div>


