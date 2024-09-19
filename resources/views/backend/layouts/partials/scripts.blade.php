<!-- LOGIN SCRIPT -->
<script src="{{ asset('admin-assets/js/bootstrap.bundle.min.js') }}"></script>
<!--plugins-->
<script src="{{ asset('admin-assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/chartjs/js/chart.js') }}"></script>
<script src="{{ asset('admin-assets/js/index.js') }}"></script>
<!-- SELECT -->
<script src="{{ asset('admin-assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/select2/js/select2-custom.js') }}"></script>

<!--notification js -->
<script src="{{ asset('admin-assets/plugins/notifications/js/lobibox.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/notifications/js/notifications.min.js') }}"></script>
<script src="{{ asset('admin-assets/plugins/notifications/js/notification-custom-script.js') }}"></script>

<!-- TABLES-->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script> --}}
{{-- <script src="{{ asset('admin-assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script> --}}
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/dt/jszip-3.10.1/b-3.1.2/b-colvis-3.1.2/b-html5-3.1.2/b-print-3.1.2/datatables.min.js"></script>

<script src="https://cdn.datatables.net/responsive/3.0.3/js/dataTables.responsive.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.3/js/responsive.dataTables.js"></script>
<script src="https://cdn.datatables.net/2.1.6/js/dataTables.bootstrap5.js"></script>
<script src="{{ asset('admin-assets/plugins/datatable/js/dataTables.bootstrap5.min.js') }}"></script>
<!--Password show & hide js -->
<script>
    $(document).ready(function() {
        $("#show_hide_password a").on("click", function(event) {
            event.preventDefault();
            if ($("#show_hide_password input").attr("type") == "text") {
                $("#show_hide_password input").attr("type", "password");
                $("#show_hide_password i").addClass("bx-hide");
                $("#show_hide_password i").removeClass("bx-show");
            } else if (
                $("#show_hide_password input").attr("type") == "password"
            ) {
                $("#show_hide_password input").attr("type", "text");
                $("#show_hide_password i").removeClass("bx-hide");
                $("#show_hide_password i").addClass("bx-show");
            }
        });
    });
</script>
<!--app JS-->
<script src="{{ asset('admin-assets/js/app.js') }}"></script>
<script>
    new PerfectScrollbar(".app-container")

    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
</script>
