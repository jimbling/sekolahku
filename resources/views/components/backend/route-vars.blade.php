<script>
    var routeVars = {
        baseUrl: "{{ url('/') }}",
        dataKategoriUrl: "{{ route('admin.kategori.data') }}",
        dataPostUrl: "{{ route('admin.posts.data') }}",
        dataTagsUrl: "{{ route('admin.admin.tags.data') }}",
        dataKutipanUrl: "{{ route('admin.kutipan.data') }}",
        dataTautanUrl: "{{ route('admin.tautan.data') }}",
        dataTemaUrl: "{{ route('admin.tema.data') }}",
    };
</script>
