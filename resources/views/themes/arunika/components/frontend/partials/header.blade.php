<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=0">
    <link rel="icon" href="{{ asset('storage/images/settings/' . get_setting('favicon')) }}" type="image/x-icon">
    <title>
        @hasSection('title')
            @yield('title') | {{ $schoolName }}
        @else
            {{ $schoolName }} - {{ get_setting('sub_district') }} {{ get_setting('district') }}
        @endif
    </title>


    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ isset($post) ? cleanMetaDescription($post->excerpt) : get_setting('meta_description') }}">
    <meta name="keywords" content="{{ get_setting('meta_keywords') }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="jimbling, jimbling05@gmail.com">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ isset($post) ? $post->title : get_setting('site_name') }}">
    <meta property="og:description" content="{{ isset($post) ? $post->excerpt : get_setting('meta_description') }}">
    @if (isset($post))
        @if ($post->post_type === 'video')
            <meta property="og:image"
                content="{{ 'https://img.youtube.com/vi/' . trim($post->content) . '/hqdefault.jpg' }}">
        @else
            <meta property="og:image" content="{{ asset('storage/uploads/posts/' . $post->image) }}">
        @endif
    @else
        <meta property="og:image" content="{{ asset('storage/images/settings/' . get_setting('default_og_image')) }}">
    @endif
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="{{ isset($post) ? 'article' : 'website' }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($post) ? $post->title : get_setting('site_name') }}">
    <meta name="twitter:description"
        content="{{ isset($post) ? $post->meta_description : get_setting('meta_description') }}">
    @if (isset($post))
        @if ($post->post_type === 'video')
            <meta name="twitter:image"
                content="{{ 'https://img.youtube.com/vi/' . trim($post->content) . '/hqdefault.jpg' }}">
        @else
            <meta name="twitter:image" content="{{ asset('storage/uploads/posts/' . $post->image) }}">
        @endif
    @else
        <meta name="twitter:image"
            content="{{ asset('storage/images/settings/' . get_setting('default_twitter_image')) }}">
    @endif

    <link rel="canonical" href="{{ url()->current() }}">

    @if (isset($post))
        <script type="application/ld+json">
{
  "@context": "https://schema.org",
  "@type": "Article",
  "headline": "{{ $post->title }}",
  "description": "{{ $post->meta_description ?? Str::limit(strip_tags($post->content), 160) }}",
  "image": "{{ asset('storage/uploads/posts/' . $post->image) }}",
  "author": {
    "@type": "Person",
    "name": "{{ $post->author->name }}"
  },
  "publisher": {
    "@type": "Education",
    "name": "{{ get_setting('school_name') }}",
    "logo": {
      "@type": "ImageObject",
      "url": "{{ asset('storage/images/settings/' . get_setting('logo')) }}"
    }
  },
  "datePublished": "{{ $post->created_at->toIso8601String() }}",
  "dateModified": "{{ $post->updated_at->toIso8601String() }}"
}
</script>
    @endif


    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick-theme.css" />
    {{-- <script src="https://cdn.jsdelivr.net/npm/slick-carousel@1.8.1/slick/slick.min.js"></script> --}}

    @if (app()->environment('local'))
        @vite(['resources/css/app.css', 'resources/js/app.js', getActiveTheme() !== 'default' ? 'resources/themes/' . getActiveTheme() . '/src/app.css' : null, getActiveTheme() !== 'default' ? 'resources/themes/' . getActiveTheme() . '/src/app.js' : null])
    @else
        <link rel="stylesheet" href="{{ asset('themes/' . getActiveTheme() . '/assets/app.css') }}">
        <script src="{{ asset('themes/' . getActiveTheme() . '/assets/app.js') }}" defer></script>
    @endif
    <style>
        [contenteditable]:focus {
            outline: 2px solid #3b82f6;
        }
    </style>

</head>
