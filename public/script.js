$(document).ready(function($) {
    $(".table-row").click(function() {
        window.location.href = $(this).data("href");
    });

    $(function() {
        $('#datetimepickerstart').datetimepicker({
            locale: 'pt'
        });
    });

    $(function() {
        $('#datetimepickerend').datetimepicker({
            locale: 'pt'
        });
    });

    // Material Select Initialization
    $('#cars-multipleselect').multiselect();

    $('#workers-multipleselect').multiselect();

});