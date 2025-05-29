<footer class="main-footer">
    <strong>Copyright &copy; 2023-{{ $currentYear }} <a
            href="{{ get_setting('website') }}">{{ get_setting('school_name') }}</a>.</strong>
    All rights reserved.
    <div class="float-right d-none d-sm-inline-block">
        <b>Didukung dengan <i class='fas fa-heart' style='color:red'></i> oleh <a href="https://www.jimbling.my.id">CMS
                Sinau</a></b>
    </div>

</footer>

<div class="modal fade" id="aboutModal" data-backdrop="static" tabindex="-1" role="dialog"
    aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel">Tentang Sistem</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong>Nama Sistem:</strong> CMS Sinau</p>
                <p><strong>Tahun Rilis:</strong> 2024</p>
                <p><strong>Version:</strong> V.01.01</p>
                <p><strong>Framework:</strong> Laravel 11</p>

                <h6>Aturan dan Batasan Penggunaan</h6>
                <ul>
                    <li>Gunakan sistem ini sesuai dengan kebijakan yang berlaku.</li>
                    <li>Hindari melakukan perubahan yang dapat merusak data atau fungsionalitas sistem.
                    </li>
                    <li>Laporkan bug atau masalah kepada tim dukungan teknis.</li>
                    <li>Penggunaan sistem ini hanya untuk keperluan yang sah dan tidak melanggar hukum.
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

</aside>

</div>


<script src="{{ asset('lte/plugins/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('lte/plugins/jquery-ui/jquery-ui.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('lte/plugins/chart.js/Chart.min.js') }}"></script>

<script src="{{ asset('lte/plugins/moment/moment.min.js') }}"></script>
<script src="{{ asset('lte/plugins/daterangepicker/daterangepicker.js') }}"></script>
<script src="{{ asset('lte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/adminlte.js?v=3.2.0') }}"></script>
<script src="{{ asset('lte/plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('lte/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('lte/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('lte//plugins/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>


<script src="{{ asset('lte/plugins/inputmask/jquery.inputmask.min.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ asset('lte/plugins/jszip/jszip.min.js') }}"></script>
<script src="{{ asset('lte/plugins/pdfmake/pdfmake.min.js') }}"></script>
<script src="{{ asset('lte/plugins/pdfmake/vfs_fonts.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
<script src="{{ asset('lte/plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('lte/plugins/summernote/summernote-bs4.min.js') }}"></script>
<script src="{{ asset('lte/dist/js/backend/yajra-id.js') }}"></script>
<script src="{{ asset('lte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js') }}"></script>
<script src="{{ asset('lte/plugins/dropzone/min/dropzone.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
    $(function() {
        $('#rombelTable').DataTable({
            "paging": true,
            "lengthChange": true,
            "searching": true,
            "ordering": false,
            "info": false,
            "autoWidth": false,
            "responsive": true,
        });
    });
</script>

<script>
    $(document).ready(function() {
        $('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
            todayHighlight: true,
            autoclose: true,
            language: 'id'
        });
    });
</script>

<script>
    $(document).ready(function() {

        function initializeSelect2(selector, options = {}) {
            $(selector).select2({
                theme: 'bootstrap4',
                minimumResultsForSearch: options.disableSearch ? Infinity : 0
            });
        }


        initializeSelect2('.select2', {
            disableSearch: true
        });

        $('#addRombels, #editRombels').on('shown.bs.modal', function() {
            initializeSelect2('.select2', {
                disableSearch: true
            });
        });
    });
</script>

<script>
    $(function() {

        $('#summernote').summernote({
            tabsize: 2,
            height: 600,
            callbacks: {
                onImageUpload: function(files) {
                    for (var i = 0; i < files.length; i++) {
                        uploadImage(files[i]);
                    }
                }
            }
        });
    });

    function uploadImage(file) {
        var data = new FormData();
        data.append("file", file);
        data.append("_token", "{{ csrf_token() }}");

        // Ambil judul post dari input untuk slug
        var postTitle = $('#post_title').val();
        data.append("post_title", postTitle);

        $.ajax({
            url: '{{ route('image.upload') }}',
            cache: false,
            contentType: false,
            processData: false,
            data: data,
            type: "POST",
            success: function(url) {
                $('#summernote').summernote("insertImage", url);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {

        var accordionState = {};

        $('#accordion .collapse').on('show.bs.collapse', function() {
            var active = $(this).attr('id');
            accordionState[active] = true;
        });

        $('#accordion .collapse').on('hide.bs.collapse', function() {
            var active = $(this).attr('id');
            accordionState[active] = false;
        });


        $('#accordion .collapse').each(function() {
            var id = $(this).attr('id');
            if (accordionState[id]) {
                $(this).collapse('show');
            }
        });


        $('#menuForm').on('submit', function(e) {
            e.preventDefault();

            var checkedData = [];
            $('input[name="posts[]"]:checked').each(function() {
                var postData = {
                    id: $(this).val(),
                    title: $(this).data('title'),
                    slug: $(this).data('slug')
                };
                checkedData.push(postData);
            });

            console.log(checkedData);


            this.submit();
        });
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        var nestedSortables = [].slice.call(document.querySelectorAll('.nested-menu'));

        nestedSortables.forEach(function(el) {
            new Sortable(el, {
                group: 'nested',
                animation: 150,
                fallbackOnBody: true,
                swapThreshold: 0.65
            });
        });

        var el = document.getElementById('menu-list');
        new Sortable(el, {
            group: 'nested',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65
        });

        document.getElementById('save-order').addEventListener('click', function() {
            var order = [];

            function getOrder(el, parentId = null) {
                Array.from(el.children).forEach((item, index) => {
                    var id = item.getAttribute('data-id');
                    var children = item.querySelector('.nested-menu');
                    order.push({
                        id: id,
                        order: index,
                        parent_id: parentId
                    });

                    if (children) {
                        getOrder(children, id);
                    }
                });
            }

            getOrder(el);

            axios.post('{{ route('menus.updateOrder') }}', {
                    order: order,
                    _token: '{{ csrf_token() }}'
                })
                .then(function(response) {
                    toastr.success('Struktur menu berhasil disimpan');
                })
                .catch(function(error) {
                    console.error(error);
                    toastr.error('Gagal menyimpan struktur menu.');
                });
        });
    });
</script>

<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>


@include('components.backend.route-vars')
</body>

</html>
