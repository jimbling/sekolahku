<x-header>{{ $judul }}</x-header>
<div class="content-wrapper">
    <x-breadcrumb>{{ $judul }}</x-breadcrumb>

    <section class="content">
        <div class="container-fluid">

            <form action="{{ route('sambutan.update') }}" method="POST">
                @csrf
                <div class="row">

                    <div class="col-lg-12">
                        <div class="card card-primary card-outline shadow-lg">
                            <div class="card-header">
                                <input class="form-control" type="text" placeholder="Tambahkan judul berita"
                                    name="post_title" id="post_title" value="{{ $sambutan->title }}">
                            </div>
                            <div class="card-body">
                                <textarea id="summernote" name="post_content">{{ $sambutan->content }}</textarea>
                                </textarea>
                            </div>
                            <div class="card-footer">

                                <div class="btn-group mr-2" role="group" aria-label="Second group">
                                    <button type="submit" class="btn btn-success btn-sm"><i
                                            class='fas fa-paper-plane spaced-icon'></i>Simpan Sambutan</button>
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
    {{ Session::forget('success') }}
@endif
