@section('breadcrumb')
    <section style="background: linear-gradient(90deg, #0d5c52, #1b7b74);" class="w-full text-white">
        <div class="container mx-auto px-4 py-3">
            <nav aria-label="Breadcrumb">
                <ol class="list-none p-0 inline-flex items-center space-x-2 text-sm">
                    <li class="flex items-center">
                        <a href="{{ route('web.home') }}" class="hover:underline text-white">Home</a>
                        <svg class="fill-current w-3 h-3 mx-2 text-white/70" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('category.posts', ['slug' => $category->slug]) }}"
                            class="hover:underline text-white">
                            {{ $category->name }}
                        </a>
                        <svg class="fill-current w-3 h-3 mx-2 text-white/70" viewBox="0 0 24 24">
                            <path d="M9 18l6-6-6-6"></path>
                        </svg>
                    </li>
                    <li>
                        <span class="breadcrumb-title text-white">{{ $post->title }}</span>
                    </li>
                </ol>
            </nav>
        </div>
    </section>
@endsection
