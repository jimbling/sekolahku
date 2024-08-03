<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <title>@yield('title', 'Home Page')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ get_setting('meta_description') }}">
    <meta name="keywords" content="{{ get_setting('meta_keywords') }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="jimbling, jimbling05@gmail.com">

    @vite('resources/css/app.css')
    <style>
        /* Tambahkan gaya latar belakang di sini */
        .background {
            background-image: url('{{ asset('assets/dist/login/img/back.png') }}');
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
