$(document).ready(function($) {
    $(".table-row").click(function() {
        console.log($(this).data("href"));
        window.location.href = $(this).data("href");
    });

    $(function() {
        $('#datetimepicker1').datetimepicker();
    });

    $(function() {
        $('#datetimepicker2').datetimepicker();
    });

    $(function () {
        $('#datetimepicker4').datetimepicker();
    });
});