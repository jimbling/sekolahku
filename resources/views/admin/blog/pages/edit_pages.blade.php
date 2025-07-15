<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('admin.pages.update', $post->id) }}" method="post" id="formEditPages">
                @method('PUT')
                @csrf
                <div class="row">

                    <div class="col-lg-8">
                        <div class="card card-primary card-outline shadow-lg">
                            <div class="card-header">
                                <input class="form-control" type="text" placeholder="Tambahkan judul halaman"
                                    name="post_title" id="post_title" value="{{ $post->title }}">
                            </div>
                            <div class="card-body">
                                <textarea id="summernote" name="post_content">{{ $post->content }}</textarea>
                                </textarea>
                            </div>

                        </div>


                    </div>
                    <div class="col-lg-4">
                        <div class="card card-primary card-outline shadow-lg">
                            <div class="card-header">
                                <h6 class="m-0"><i class='fas fa-shield-alt spaced-icon'></i>Publikasi</h6>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label>Status</label>
                                            <select class="form-control select2bs4" style="width: 100%;"
                                                name="post_status" id="post_status">
                                                <option value="Publish"
                                                    {{ $post->status == 'Publish' ? 'selected' : '' }}>
                                                    Diterbitkan</option>
                                                <option value="Draft" {{ $post->status == 'Draft' ? 'selected' : '' }}>
                                                    Konsep
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label>Komentar</label>
                                        <select class="form-control select2bs4" style="width: 100%;"
                                            name="post_comment_status" id="post_comment_status">
                                            <option value="open"
                                                {{ $post->komentar_status == 'open' ? 'selected' : '' }}>Diizinkan
                                            </option>
                                            <option value="close"
                                                {{ $post->komentar_status == 'close' ? 'selected' : '' }}>Tidak
                                                diizinkan
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm">

                                    <div class="btn-group mr-2" role="group" aria-label="First group">
                                        <a href="{{ route('admin.blog.pages') }}" class="btn btn-warning btn-sm">
                                            <i class='fas fa-times spaced-icon'></i>Batal
                                        </a>
                                    </div>
                                    <div class="btn-group mr-2" role="group" aria-label="Second group">
                                        <button type="submit" class="btn btn-success btn-sm"><i
                                                class='fas fa-paper-plane spaced-icon'></i>Simpan Post</button>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </form>

        </div>
    </section>

</div>

<x-footer></x-footer>

@if (Session::has('success'))
    <script>
        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": true,
            "positionClass": "toast-top-right",
            "preventDuplicates": false,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.success('{{ Session::get('success') }}');
    </script>
    {{ Session::forget('success') }} <!-- Hapus session flash success setelah ditampilkan -->
@endif
