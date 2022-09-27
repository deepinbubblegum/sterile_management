<meta name="csrf-token" content="{{ csrf_token() }}">
{{-- <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@100;200&display=swap" rel="stylesheet"> --}}
<link href="https://fonts.googleapis.com/css2?family=Bai+Jamjuree:wght@200;300;400;600;700;900&display=swap" rel="stylesheet" />
{{-- <link rel="stylesheet" href="{{ asset('css/tailwind.css') }}" /> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" rel="stylesheet" />

<script src="{{ asset('assets/component.min.js') }}"></script>
<script src="{{ asset('assets/alpine.min.js') }}" defer></script>
<script src="{{ asset('assets/jquery-3.6.1.min.js') }}"></script>

<style>
    body {
        /* font-family: 'Kanit', sans-serif !important; */
        font-family: 'Bai Jamjuree', sans-serif !important;
    }
</style>

@vite('resources/js/app.js')
@vite('resources/css/app.css')