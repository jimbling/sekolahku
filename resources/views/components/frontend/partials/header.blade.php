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
            {{ $schoolName }}
        @endif
    </title>

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description"
        content="{{ isset($post) ? Str::limit($post->excerpt, 160) : get_setting('meta_description') }}">
    <meta name="keywords" content="{{ get_setting('meta_keywords') }}">
    <meta name="robots" content="index, follow">
    <meta name="author" content="jimbling, jimbling05@gmail.com">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="{{ isset($post) ? $post->title : get_setting('site_name') }}">
    <meta property="og:description" content="{{ isset($post) ? $post->excerpt : get_setting('meta_description') }}">
    <meta property="og:image"
        content="{{ isset($post) ? asset('storage/uploads/posts/' . $post->image) : asset('storage/images/settings/' . get_setting('default_og_image')) }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="{{ isset($post) ? 'article' : 'website' }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ isset($post) ? $post->title : get_setting('site_name') }}">
    <meta name="twitter:description"
        content="{{ isset($post) ? $post->meta_description : get_setting('meta_description') }}">
    <meta name="twitter:image"
        content="{{ isset($post) ? asset('storage/uploads/posts/' . $post->image) : asset('storage/images/settings/' . get_setting('default_twitter_image')) }}">
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

    @vite('resources/css/app.css')

</head>
