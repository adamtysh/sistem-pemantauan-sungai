<script src="{{asset('assets')}}/js/bootstrap.bundle.min.js"></script>

{{-- ======================= SOLUSI KONFLIK JAVASCRIPT ======================= --}}
{{-- Skrip di bawah ini (terutama jQuery dan app.js) menyebabkan konflik --}}
{{-- dengan halaman grafik. Kita hanya akan memuatnya jika BUKAN halaman grafik. --}}
{{-- Halaman grafik diidentifikasi dari URL-nya yang mengandung kata 'trending'. --}}
@if (!request()->is('trending*'))

    <script src="{{asset('assets')}}/js/jquery.min.js"></script>
    <script src="{{asset('assets')}}/plugins/simplebar/js/simplebar.min.js"></script>
    <script src="{{asset('assets')}}/plugins/metismenu/js/metisMenu.min.js"></script>
    <script src="{{asset('assets')}}/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
    <script src="{{asset('assets')}}/plugins/select2/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/echarts/dist/echarts.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="{{asset('assets')}}/js/app.js"></script>
    <script src="{{asset('assets')}}/plugins/datatable/js/jquery.dataTables.min.js"></script>
    <script src="{{asset('assets')}}/plugins/datatable/js/dataTables.bootstrap5.min.js"></script>
    <script src="{{asset('assets')}}/plugins/apexcharts-bundle/js/apexcharts.min.js"></script>
    {{-- <script src="{{asset('assets')}}/plugins/apexcharts-bundle/js/apex-custom.js"></script> --}}
    <script>
        // Skrip inisialisasi plugin juga hanya dimuat jika bukan halaman grafik
        $('.single-select').select2({
            theme: 'bootstrap4',
            width: $(this).data('width') ? $(this).data('width') : $(this).hasClass('w-100') ? '100%' : 'style',
            placeholder: $(this).data('placeholder'),
            allowClear: Boolean($(this).data('allow-clear')),
        });

        $('.single-select').select2({
            dropdownParent: $('#exampleModal')
        });

        const logout = () => {
            axios.post('/logout')
                .then(function (response) {
                    console.log('Logged out successfully:', response.data);
                    window.location.href = '/login';
                })
                .catch(function (error) {
                    console.error('Error during logout:', error);
                });
        }
    </script>
@endif
{{-- ======================================================================= --}}

{{-- @stack('js') akan selalu dijalankan untuk memuat skrip spesifik per halaman, --}}
{{-- seperti skrip Chart.js di halaman grafik Anda. --}}
@stack('js')