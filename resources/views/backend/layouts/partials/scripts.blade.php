




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

<!--Password show & hide js -->
<script>
    $(document).ready(function () {
        $("#show_hide_password a").on("click", function (event) {
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
</script>
