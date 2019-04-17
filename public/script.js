$(document).ready(function($) {
    $(".table-row").click(function() {
        console.log($(this).data("href"));
        window.location.href = $(this).data("href");
    });
});