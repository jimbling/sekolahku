@extends('themes.' . getActiveTheme() . '.app')

@section('title', $post->title)


@section('sidebar')

    @include('themes.' . getActiveTheme() . '.components.frontend.partials.sidebar')
@endsection

@section('content')
    @php
        // Mendapatkan URL saat ini
        $currentUrl = request()->path();
        $shareUrl = url()->full();
    @endphp

    <div id="post-detail" class="container mx-auto">
        <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">

            {{-- Judul dan Meta --}}
            <header class="mb-8">
                <h1 class="text-2xl md:text-3xl font-bold tracking-tight text-gray-900">{{ $post->title }}</h1>

                {{-- Garis Gradien --}}
                <div class="relative mt-4">
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full h-1 bg-gradient-to-r from-teal-700 via-teal-400 to-emerald-400"></div>
                    </div>
                </div>


                {{-- Meta Info --}}
                <div class="flex flex-wrap items-center gap-4 text-xs text-gray-600 mt-8">
                    @php
                        use Carbon\Carbon;
                        $createdAt = Carbon::parse($post->published_at);
                        $formattedDate = $createdAt->translatedFormat('l, d F Y');
                    @endphp

                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
                        <path
                            d=" M12.75 12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5
                                                                        0ZM7.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM8.25 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM9.75
                                                                        15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM10.5 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12 15.75a.75.75 0 1 0
                                                                        0-1.5.75.75 0 0 0 0 1.5ZM12.75 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM14.25 15.75a.75.75 0 1 0 0-1.5.75.75 0 0
                                                                        0 0 1.5ZM15 17.25a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 15.75a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5ZM15
                                                                        12.75a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM16.5 13.5a.75.75 0 1 0 0-1.5.75.75 0 0 0 0 1.5Z" />
                        <path fill-rule="evenodd"
                            d="M6.75 2.25A.75.75 0 0 1 7.5 3v1.5h9V3A.75.75 0 0 1 18 3v1.5h.75a3 3 0 0 1 3 3v11.25a3 3 0 0 1-3 3H5.25a3 3 0 0 1-3-3V7.5a3 3 0 0 1 3-3H6V3a.75.75 0 0 1 .75-.75Zm13.5 9a1.5 1.5 0 0 0-1.5-1.5H5.25a1.5 1.5 0 0 0-1.5 1.5v7.5a1.5 1.5 0 0 0 1.5 1.5h13.5a1.5 1.5 0 0 0 1.5-1.5v-7.5Z"
                            clip-rule="evenodd" />
                    </svg>

                    {{-- Tanggal --}}
                    <time datetime="{{ $createdAt->format('Y-m-d') }}" class="flex items-center">
                        <svg class="w-4 h-4 mr-1 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 7v5l4 2"></path>
                        </svg>
                        {{ $formattedDate }}
                    </time>

                    {{-- Author --}}
                    @if ($post->author)
                        <div class="flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                <path fill-rule="evenodd"
                                    d="M7.5 6a4.5 4.5 0 1 1 9 0 4.5 4.5 0 0 1-9 0ZM3.75 20.1a8.25 8.25 0 0 1 16.5 0 .75.75 0 0 1-.44.7A18.7 18.7 0 0 1 12 22.5c-2.79 0-5.44-.61-7.81-1.7a.75.75 0 0 1-.44-.7Z"
                                    clip-rule="evenodd" />
                            </svg>

                            {{ $post->author->name }}

                            <span>{{ $post->author->role }}</span>
                        </div>
                    @endif

                    {{-- View Counter --}}
                    <div class="flex items-center gap-1">
                        <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                            <path fill-rule="evenodd"
                                d="M1.3 11.4C2.8 7 7 3.75 12 3.75s9.2 3.22 10.68 7.69a1.76 1.76 0 0 1 0 1.12c-1.49 4.47-5.7 7.7-10.68 7.7S2.8 17.3 1.3 12.83a1.76 1.76 0 0 1 0-1.12ZM17.25 12a5.25 5.25 0 1 1-10.5 0 5.25 5.25 0 0 1 10.5 0Z"
                                clip-rule="evenodd" />
                        </svg>
                        {{ $post->post_counter }}
                    </div>
                </div>
            </header>

            {{-- Post Image --}}
            @if ($post->image)
                <div class="relative overflow-hidden rounded-lg shadow-md mb-6">
                    <img src="{{ Storage::url('uploads/posts/' . $post->image) }}" alt="{{ $post->title }}" loading="lazy"
                        class="object-cover w-full h-auto max-h-[450px] mx-auto rounded-lg">
                </div>
            @endif

            {{-- Konten Utama --}}
            <div class="prose max-w-none mt-6">
                {!! $post->content !!}
            </div>

            {{-- Footer --}}
            <footer class="mt-8 border-t border-gray-200 pt-4">
                <div class="flex items-center">
                    <!-- Kategori -->
                    <div class="flex-1">
                        <div class="flex items-center">
                            <!-- Ikon Kategori -->
                            <span class="font-semibold text-gray-800 mr-2 text-gray-600">

                                <svg version="1.1" viewBox="0 0 2048 2048" class="w-6 h-6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path transform="translate(343,224)"
                                        d="m0 0h465l18 2 18 5 23 11 15 11 13 12 12 16 8 14 6 14 4 14 2 11 1 13v452l-1 18-3 15-6 18-8 16-9 13-9 10-10 10-13 9-10 6-20 8-17 4-7 1-17 1h-444l-19-1-20-4-16-6-15-8-11-8-10-9-5-5-8-9-10-15-8-17-5-16-3-20v-470l3-18 5-16 6-14 10-16 9-11 9-9 13-10 15-9 14-6 18-5z"
                                        fill="#00DF86" />
                                    <path transform="translate(343,1120)"
                                        d="m0 0h465l18 2 18 5 23 11 15 11 13 12 12 16 8 14 6 14 4 14 2 11 1 13v452l-1 18-3 15-6 18-8 16-9 13-9 10-10 10-13 9-10 6-20 8-17 4-7 1-17 1h-444l-19-1-20-4-16-6-15-8-11-8-10-9-5-5-8-9-10-15-8-17-5-16-3-20v-470l3-18 5-16 6-14 10-16 9-11 9-9 13-10 15-9 14-6 18-5z"
                                        fill="#00DF86" />
                                    <path transform="translate(1239,224)"
                                        d="m0 0h465l18 2 18 5 23 11 15 11 13 12 12 16 8 14 6 14 4 14 2 11 1 13v452l-1 18-3 15-6 18-8 16-9 13-9 10-10 10-13 9-10 6-20 8-17 4-7 1-17 1h-444l-19-1-20-4-16-6-15-8-11-8-10-9-5-5-8-9-10-15-8-17-5-16-3-21v-469l3-18 5-16 6-14 10-16 9-11 9-9 13-10 15-9 14-6 18-5z"
                                        fill="#00DF86" />
                                    <path transform="translate(1451,1120)"
                                        d="m0 0h41l31 3 31 6 25 7 20 7 21 9 16 8 15 8 20 13 11 8 14 11 14 12 25 25 9 11 12 15 16 24 13 23 11 23 9 24 8 26 6 28 4 31 1 19v20l-2 31-4 26-6 26-8 26-10 25-9 19-13 23-8 12-13 18-14 17-3 4h-2l-2 4-20 20-11 9-8 7-19 14-19 12-18 10-16 8-21 9-27 9-34 8-29 4-28 2h-18l-30-2-27-4-29-7-33-11-29-13-22-12-14-9-17-12-10-8-13-11-12-11-15-15-9-11-10-12-13-18-13-21-12-23-9-20-10-28-6-23-6-31-3-29v-44l3-28 6-31 7-25 10-28 12-26 13-23 10-15 11-15 8-10 12-14 8-8 5-6 8-7 13-12 17-13 19-13 13-8 24-13 25-11 30-10 25-6 30-5z"
                                        fill="#5F605F" />
                                    <path transform="translate(1335,922)"
                                        d="m0 0h309l20 2 43 2v1l-13 1h-444l-14-1v-1l29-1 41-1z" fill="#0EB76A" />
                                    <path transform="translate(447,1818)" d="m0 0h300l21 2 43 2v1l-13 1h-444l-14-1v-1l70-2z"
                                        fill="#0FB66A" />
                                    <path transform="translate(456,922)"
                                        d="m0 0h291l19 2 33 1 12 1v1l-13 1h-444l-14-1v-1l29-1 41-1z" fill="#0FB66A" />
                                    <path transform="translate(1265,925)" d="m0 0m-5 0 5 1-3 2h-12l-14-1v-1z"
                                        fill="#00C76D" />
                                    <path transform="translate(369,925)" d="m0 0m-5 0 5 1-3 2h-12l-14-1v-1z"
                                        fill="#00C76D" />
                                </svg>

                            </span>
                            <div class="flex flex-wrap gap-1">
                                @foreach ($post->category as $category)
                                    <a href="{{ url('/kategori/' . $category->slug) }}"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-blue-500 rounded-full hover:bg-blue-600">
                                        {{ $category->name }}
                                    </a>
                                @endforeach
                            </div>
                            <div class="border-l border-gray-300 h-8 mx-4"></div>

                            <span class="font-semibold text-gray-800 mr-2">
                                <svg version="1.1" viewBox="0 0 2048 2048" class="w-6 h-6"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path transform="translate(1977,32)"
                                        d="m0 0h11l11 4 10 9 6 11 1 4v10l-4 10-9 11-80 80-2 1 1 4 14 27 11 28 9 30 8 36 6 35 5 41 3 35 2 44v86l-2 48-4 53-5 46-6 46-9 54-12 60-9 37-8 31-13 43-12 36-15 39-13 30-14 29-10 19-10 17-11 17-8 12-13 17-9 11-12 13-25 25-6 10-14 40-12 36-19 56-15 43-16 47-8 16-7 18-26 77-14 41-22 64-21 62-15 44-15 43-10 29-10 21-10 15-8 10-9 10-13 12-14 10-16 9-15 7-19 6-19 4-9 1h-32l-19-3-15-4-22-8-36-15-39-16-92-38-15-6-5 1-81 81-11 9-10 7-16 9-15 7-15 5-17 4-14 2-20 1-23-2-25-6-20-8-14-7-15-10-11-9-12-11-691-691-7-8-12-16-9-16-7-15-6-18-4-19-1-14v-21l1-16 5-22 7-20 12-23 14-19 12-13 737-737h2l1-3 8-7 10-9 14-11 16-12 24-16 22-13 23-13 16-8 35-16 32-13 42-15 42-13 45-12 39-9 51-10 50-8 47-6 41-4 46-3 23-1 59-1 50 1 48 3 40 4 41 6 36 7 38 10 30 10 23 10 23 12 4-1 88-88 9-5z"
                                        fill="#55A0FD" />
                                    <path transform="translate(479,646)"
                                        d="m0 0 5 1 2 4 4 2 3 3v2l4 2 5 6 7 6 5 6 7 6 5 6 6 5 6 7 6 5 6 7 6 5 7 8 819 819 8 7 15 15 7 1 7-7 1-2h2l2-4h2l2-4h2l2-4h2l2-4 4-4h2l2-4h2v-2h2v-2h2l2-4 16-16h2v-2l8-7 4-5h2l1-3 258-258 9-7 2 1-14 40-12 36-19 56-15 43-16 47-8 16-7 18-26 77-14 41-22 64-21 62-15 44-15 43-10 29-10 21-10 15-8 10-9 10-13 12-14 10-16 9-15 7-19 6-19 4-9 1h-32l-19-3-15-4-22-8-36-15-39-16-92-38-15-6-5 1-81 81-11 9-10 7-16 9-15 7-15 5-17 4-14 2-20 1-23-2-25-6-20-8-14-7-15-10-11-9-12-11-691-691-7-8-12-16-9-16-7-15-6-18-4-19-1-14v-21l1-16 5-22 7-20 12-23 14-19 12-13 349-349 5-3z"
                                        fill="#FDC766" />
                                    <path transform="translate(1752,1230)"
                                        d="m0 0 2 1-14 40-12 36-19 56-15 43-16 47-8 16-7 18-26 77-14 41-22 64-21 62-15 44-15 43-10 29-10 21-10 15-8 10-9 10-13 12-14 10-16 9-15 7-19 6-19 4-9 1h-32l-19-3-15-4-22-8-36-15-39-16-92-38-10-4-1-4 3-8 4-2v-2l8-7 16-16h2l2-4 10-10 7-8 9-9 2-3h2l2-4h2l2-4 12-12h2l2-4h2l2-4h2l2-4h2l2-4h2l1-3 6-5 1-2h2v-2h2l1-3 6-5 2-4h2l3-6h2l2-4h2v-2l7-6 7-8 4-4h2l2-4 118-118 2-5-2-3 7-2 7-7 1-2h2l2-4h2l2-4h2l2-4h2l2-4 4-4h2l2-4h2v-2h2v-2h2l2-4 16-16h2v-2l8-7 4-5h2l1-3 258-258z"
                                        fill="#FCA863" />
                                    <path transform="translate(1977,32)"
                                        d="m0 0h11l11 4 10 9 6 11 1 4v10l-4 10-9 11-80 80-2 1-2 4-9 7-83 83-7 8-5 4-98 98-7 8-18 18-3 2 2 6 6 10 8 17 7 18 5 20 3 23v27l-3 23-6 23-9 22-11 20-12 17-12 14-7 7-11 9-14 10-15 9-20 9-24 8-20 4-9 1h-29l-22-3-26-7-16-6-20-11-15-10-9-7-13-12-6-7-5-5-9-11-9-14-11-21-8-24-4-20-2-19v-31l4-24 6-20 8-20 11-19 10-14 12-14 11-11 11-9 14-10 18-10 11-5 19-7 20-5 14-2 13-1h13l24 3 14 3 20 6 18 8 14 7 11 7 1 1h5l103-103 6-5 6-7 6-5 6-7 8-7 41-41 7-8h2l2-4 34-34 4-5 2-4 4-1 88-88 9-5z"
                                        fill="#FDC766" />
                                    <path transform="translate(1755,465)"
                                        d="m0 0h16l13 4 10 5 9 7 9 9 9 15 3 11 1 13-1 17-5 30-4 15-10 31-5 12-11 22-10 17-7 10-5 8h-2l-2 5-15 16-1 2h-2l-2 4-10 9-3 3h-2v2l-14 11-9 7-12 8-16 10-18 10-16 7-18 7-34 9-17 3-36 3h-36l-28-4-21-5-26-9-12-5-19-10-6-4v-2l-4-2-10-9-10-12-5-12-1-5v-23l3-12 6-12 11-13 8-7 1-2 9-1 1-2-5-10v-3h-2l-1-3 4 2 10 10 11 9 15 10 17 10 14 6 18 6 22 5 16 2h29l20-3 19-5 19-7 16-8 14-8 14-10 15-13 11-12 13-18 12-21 9-21 5-17 4-22 1-10 1-1v-31l3-13 1-5 7-4 11-4z"
                                        fill="#488BFE" />
                                    <path transform="translate(1752,1230)"
                                        d="m0 0 2 1-14 40-12 36-19 56-15 43-16 47-10 20-5 4-6 10-3 3h-3v2l-10 5-14 12-5 4-23 23-8 7-14 14h-2l-2 4h-2v2l-8 7-16 16-8 7h-2v2l-8 7-10 10h-2v2h-2v2h-2v2l-8 7-37 37h-2v2h-2l-2 4h-2l-2 4h-2v2l-8 7-17 17-8 7-13 13h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2l-2 4-11 10h-2v2l-11 8-10 5-18 5h-19l-20-5-15-7-10-6-11-9v-2l-5-2-1-2v-8l4-2v-2l7-6 7-8 4-4h2l2-4 118-118 2-5-2-3 7-2 7-7 1-2h2l2-4h2l2-4h2l2-4h2l2-4 4-4h2l2-4h2v-2h2v-2h2l2-4 16-16h2v-2l8-7 4-5h2l1-3 258-258z"
                                        fill="#FC8F66" />
                                    <path transform="translate(333,1074)"
                                        d="m0 0h12l10 4 11 9 31 31 7 8 16 16 7 8 7 7 7 8 7 7 7 8 22 22 7 8 16 16 7 8 7 7 7 8 7 7 7 8 21 21 7 8 17 17 7 8 16 17 14 15 19 19 7 8 16 16 9 11 10 13 3 5 2 8v7l-7 14-7 7-12 6-10 1-11-4-10-8-9-9v-2l-4-2v-2l-3-1-7-8-16-16-7-8-5-5v-2l-4-2-7-8-9-9v-2h-2l-7-8-17-17-7-8-12-12-7-8-8-8-7-8-12-12-7-8-16-16-7-8-15-15-7-8-6-7-19-19v-2l-3-1-7-8-16-16-7-8-11-11v-2h-2l-7-8-21-21-8-10-5-7-3-8v-14l4-10 8-9z"
                                        fill="#FC8F66" />
                                    <path transform="translate(477,943)"
                                        d="m0 0h9l8 3 11 8 12 11 165 165 9 11 6 10 1 3v11l-6 12-7 8-11 6-3 1h-10l-10-4-10-8-180-180-7-10-3-8-1-9 3-12 6-8 6-5 8-4z"
                                        fill="#FC8F66" />
                                    <path transform="translate(467,655)"
                                        d="m0 0 1 2-4 5h-2l-2 4h-2l-1 3h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4-9 9h-2l-1 3-8 7-11 11-2 3h-2l2-4z"
                                        fill="#C0DBFE" />
                                    <path transform="translate(191,931)"
                                        d="m0 0 1 2-3 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4-9 9h-2l-1 3-8 7-11 11-2 3h-2l2-4z"
                                        fill="#B8D7FE" />
                                    <path transform="translate(1407,1573)"
                                        d="m0 0 4 1-5 8-13 13h-2l-1 3-8 7-2 3h-2l-1 3-8 7-25 25-2-1 63-63 2-5z"
                                        fill="#FCA863" />
                                    <path transform="translate(1751,343)"
                                        d="m0 0 1 2-4 4h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2h-2v2l-2-1 3-5 25-25z"
                                        fill="#4E94FE" />
                                    <path transform="translate(467,655)"
                                        d="m0 0 1 2-4 5h-2l-2 4h-2l-1 3h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4-4 1 6-7z"
                                        fill="#A4CCFE" />
                                    <path transform="translate(144,978)" d="m0 0 3 1-11 11h-2l-1 3-8 7-11 11-2 3h-2l2-4z"
                                        fill="#D7E8FE" />
                                    <path transform="translate(432,690)"
                                        d="m0 0 3 1-4 2-2 4h-2l-2 4h-2l-2 4h-2l-2 4h-2l-2 4-4 1 6-7z" fill="#BBD8FE" />
                                    <path transform="translate(1473,1924)" d="m0 0 3 1-16 9-10 5-3-1 15-9 9-4z"
                                        fill="#FEC766" />
                                    <path transform="translate(164,958)"
                                        d="m0 0 3 1-4 2-2 4h-2l-2 4h-2l-2 4h-2l-2 4-4 1 6-7z" fill="#B1D3FE" />
                                    <path transform="translate(467,655)" d="m0 0 1 2-4 5h-2l-2 4h-2l-1 3h-2l-2 4-1-3z"
                                        fill="#B1D3FE" />
                                    <path transform="translate(1493,1909)" d="m0 0 2 1-10 9-7 4 2-4z" fill="#FEC766" />
                                    <path transform="translate(314,1088)" d="m0 0 1 3-3 6-1 6v13l-2-3v-14l4-10z"
                                        fill="#FCA863" />
                                    <path transform="translate(1764,328)" d="m0 0 3 1-5 2zm-3 3 1 3-6 5-3 3 1-4z"
                                        fill="#5098FE" />
                                </svg>
                            </span>
                            <div class="flex flex-wrap gap-1">
                                @foreach ($post->tags as $tag)
                                    <a href="{{ url('/tags/' . $tag->slug) }}"
                                        class="inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-green-500 rounded-full hover:bg-green-600">
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                            </div>

                            <div class="border-l border-gray-300 h-8 mx-4"></div>

                            <div class="flex flex-col sm:flex-row space-y-2 md:space-y-0 md:space-x-3 lg:space-x-4">
                                <!-- Facebook -->
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ $shareUrl }}"
                                    target="_blank"
                                    class="text-gray-500 hover:text-blue-600 transition-transform transform hover:scale-105 active:scale-95">
                                    <svg class="h-6 w-6 sm:h-4 sm:w-4 lg:h-6 lg:w-6" fill="currentColor"
                                        viewBox="0 0 24 24" aria-hidden="true">
                                        <path
                                            d="M22.675 0H1.325C.595 0 0 .595 0 1.325v21.351C0 23.406.595 24 1.325 24H12.82V14.706h-3.22v-3.62h3.22V8.691c0-3.18 1.946-4.915 4.788-4.915 1.36 0 2.526.1 2.864.146v3.321h-1.965c-1.542 0-1.841.733-1.841 1.806v2.367h3.684l-.48 3.62h-3.204V24h6.283C23.406 24 24 23.406 24 22.676V1.325C24 .595 23.406 0 22.675 0z" />
                                    </svg>
                                </a>

                                <!-- WhatsApp -->
                                <a href="https://api.whatsapp.com/send?text={{ $shareUrl }}" target="_blank"
                                    class="text-gray-500 hover:text-blue-600 transition-transform transform hover:scale-105 active:scale-95">
                                    <svg class="h-6 w-6 sm:h-4 sm:w-4 lg:h-6 lg:w-6" fill="currentColor"
                                        viewBox="0 0 24 24">
                                        <path
                                            d="M20.52 3.479A11.934 11.934 0 0012 0a11.934 11.934 0 00-8.52 3.479A11.934 11.934 0 000 12c0 2.119.553 4.191 1.604 6.018L.039 24l6.129-1.592A11.934 11.934 0 0012 24c2.119 0 4.191-.553 6.018-1.604A11.934 11.934 0 0024 12a11.934 11.934 0 00-3.479-8.521zm-8.52 19.044c-1.898 0-3.729-.518-5.328-1.498l-.381-.228-3.637.946.97-3.541-.248-.389a10.544 10.544 0 01-1.485-5.34c0-5.822 4.736-10.559 10.559-10.559 2.818 0 5.468 1.1 7.442 3.075a10.523 10.523 0 013.074 7.442c0 5.822-4.736 10.559-10.559 10.559zm5.455-7.886c-.297-.149-1.758-.867-2.03-.967-.273-.099-.473-.148-.672.149-.198.297-.767.967-.94 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.392-1.475-.883-.788-1.48-1.762-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.372-.025-.521-.074-.149-.673-1.613-.922-2.206-.242-.581-.487-.502-.672-.51l-.572-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.214 3.074c.149.198 2.098 3.2 5.081 4.487.71.307 1.262.491 1.694.628.713.227 1.361.196 1.873.119.571-.085 1.758-.719 2.007-1.413.248-.694.248-1.291.173-1.413-.074-.124-.273-.198-.571-.347z" />
                                    </svg>
                                </a>

                                <!-- URL Share -->
                                <a href="#"
                                    onclick="navigator.clipboard.writeText(window.location.href); alert('URL copied to clipboard!');"
                                    class="text-gray-500 hover:text-red-600 transition-transform transform hover:scale-105 active:scale-95">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                        class="h-6 w-6 sm:h-4 sm:w-4 lg:h-6 lg:w-6">
                                        <path fill-rule="evenodd"
                                            d="M15.75 4.5a3 3 0 1 1 .825 2.066l-8.421 4.679a3.002 3.002 0 0 1 0 1.51l8.421 4.679a3 3 0 1 1-.729 1.31l-8.421-4.678a3 3 0 1 1 0-4.132l8.421-4.679a3 3 0 0 1-.096-.755Z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </a>
                            </div>

                        </div>

                    </div>
            </footer>
        </div>

        {{-- Komentar --}}
        @if ($post->komentar_status === 'open')
            @php
                $engine = get_setting('komentar_engine');
            @endphp

            {{-- DISQUS COMMENT --}}
            @if ($engine === 'disqus')
                <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">
                    <article class="prose max-w-none">
                        <div id="disqus_thread"></div>

                        {{-- Error Handling --}}
                        <div id="disqus_error" class="hidden text-center text-red-600 p-4 bg-red-100 rounded-lg mt-4">
                            <img src="{{ asset('storage/images/illustrasi/no-internet.png') }}" alt="No Internet"
                                loading="lazy" class="max-w-full max-h-32 object-contain mb-4 mx-auto">
                            <p class="text-lg font-bold">Tidak ada koneksi internet atau Disqus belum diset dengan benar.
                            </p>
                        </div>
                    </article>
                </div>

                {{-- Disqus Script --}}
                <script>
                    var disqus_config = function() {
                        this.page.url = "{{ Request::url() }}";
                        this.page.identifier = "{{ $post->slug }}";
                    };
                    (function() {
                        var d = document,
                            s = d.createElement('script');
                        s.src = 'https://{{ get_setting('disqus_shortname', 'example') }}.disqus.com/embed.js';
                        s.setAttribute('data-timestamp', +new Date());
                        s.onerror = function() {
                            document.getElementById('disqus_error').classList.remove('hidden');
                        };
                        (d.head || d.body).appendChild(s);
                    })();
                </script>
            @endif

            {{-- NATIVE COMMENT --}}
            @if ($engine === 'native')
                {{-- Comment Form --}}
                <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow-lg mb-8">
                    <h3 class="text-xl font-semibold text-gray-800 mb-6">Tinggalkan Komentar</h3>

                    <form action="{{ route('comments.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                        <input type="hidden" name="parent_id" value="">

                        @guest
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="guest_name" class="block text-sm font-medium text-gray-700 mb-1">Nama*</label>
                                    <input type="text" id="guest_name" name="guest_name"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Nama Anda" required>
                                </div>
                                <div>
                                    <label for="guest_email"
                                        class="block text-sm font-medium text-gray-700 mb-1">Email*</label>
                                    <input type="email" id="guest_email" name="guest_email"
                                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                        placeholder="Email Anda" required>
                                </div>
                            </div>
                        @endguest

                        <div>
                            <label for="comment-content"
                                class="block text-sm font-medium text-gray-700 mb-1">Komentar*</label>
                            <textarea id="comment-content" name="content" rows="4"
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                placeholder="Tulis komentar Anda di sini..." required></textarea>
                        </div>

                        <div class="flex justify-end">
                            <button type="submit"
                                class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-2 focus:ring-blue-500">
                                Kirim Komentar
                            </button>
                        </div>
                    </form>
                </div>

                {{-- Comment List --}}
                <div class="max-w-5xl mx-auto space-y-8">
                    <h3 class="text-2xl font-semibold text-gray-800 mb-6 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-2 text-blue-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                        Komentar ({{ $totalComments }})
                    </h3>

                    @forelse ($comments as $comment)
                        @include('themes.' . getActiveTheme() . '.components.frontend.partials.comment', [
                            'comment' => $comment,
                        ])
                    @empty
                        <div class="text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400"
                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                            </svg>
                            <p class="mt-2">Belum ada komentar. Jadilah yang pertama berkomentar!</p>
                        </div>
                    @endforelse
                </div>
            @endif
        @endif

        {{-- Related Posts --}}
        @if (!str_starts_with($currentUrl, 'profil/'))
            <div class="max-w-5xl mx-auto mt-12">
                <h2
                    class="text-2xl font-semibold mb-4 relative pb-2 after:absolute after:left-0 after:bottom-0 after:w-full after:h-1 after:bg-gradient-to-r after:from-blue-400 after:via-purple-500 after:to-pink-500">
                    Berita Terkait
                </h2>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    @foreach ($relatedPosts as $relatedPost)
                        <div class="bg-white rounded-lg shadow-md overflow-hidden">
                            <a href="{{ route('posts.show', ['id' => $relatedPost->id, 'slug' => $relatedPost->slug]) }}">
                                @if (!empty($relatedPost->image))
                                    <img src="{{ Storage::url('uploads/posts/' . $relatedPost->image) }}"
                                        alt="{{ $relatedPost->title }}" loading="lazy" class="w-full h-48 object-cover">
                                @else
                                    <div class="w-full h-48 bg-gray-100 flex items-center justify-center">
                                        <img src="{{ Storage::url('images/settings/' . get_setting('logo')) }}"
                                            alt="No Image Available" loading="lazy" class="h-16 opacity-70">
                                    </div>
                                @endif

                                <div class="p-4">
                                    <h3 class="text-lg font-bold">{{ $relatedPost->title }}</h3>
                                </div>
                            </a>
                        </div>
                    @endforeach

                </div>
            </div>
        @endif


        {{-- Flash Success (misal: Komentar Berhasil) --}}
        @if (session('success'))
            <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show" x-transition.duration.300ms
                class="fixed bottom-4 right-4 flex items-center space-x-3 bg-green-600 text-white px-4 py-3 rounded-lg shadow-lg z-50">
                <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" stroke-width="2"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                <span class="text-sm font-medium">{{ session('success') }} Komentar Anda akan ditinjau oleh admin.</span>
            </div>
        @endif
    </div>




@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handle reply button clicks
            document.querySelectorAll('.reply-button').forEach(button => {
                button.addEventListener('click', function() {
                    const commentId = this.dataset.commentId;
                    const replyForm = document.getElementById(`reply-form-${commentId}`);

                    // Toggle reply form visibility with animation
                    if (replyForm) {
                        replyForm.classList.toggle('hidden');
                        replyForm.classList.toggle('animate-fadeIn');

                        // Scroll to the form if it's being shown
                        if (!replyForm.classList.contains('hidden')) {
                            replyForm.scrollIntoView({
                                behavior: 'smooth',
                                block: 'nearest'
                            });
                        }
                    }
                });
            });

            // Smooth focus for reply forms
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('reply-button')) {
                    const form = e.target.nextElementSibling;
                    if (form) {
                        const textarea = form.querySelector('textarea');
                        if (textarea) {
                            setTimeout(() => textarea.focus({
                                preventScroll: true
                            }), 100);
                        }
                    }
                }
            });
        });
    </script>
@endpush
