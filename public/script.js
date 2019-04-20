$(document).ready(function($) {
    $(".table-row").click(function() {
        window.location.href = $(this).data("href");
    });

    function findGetParameter(parameterName) {
        var result = false,
            tmp = [];
        location.search
            .substr(1)
            .split("&")
            .forEach(function (item) {
              tmp = item.split("=");
              if (tmp[0] === parameterName) result = true;
            });
        return result;
    }

    $(function() {
        $('#datetimepickerstart').datetimepicker({
            locale: 'pt'
        });
    });

    $("#datetimepickerstart").on("dp.change", function (e) {
        carsMultipleRefresh();
        workersMultipleRefresh();
    });

    $(function() {
        $('#datetimepickerend').datetimepicker({
            locale: 'pt'
        });
    });

    $("#datetimepickerend").on("dp.change", function (e) {
        carsMultipleRefresh();
        workersMultipleRefresh();
    });

    // Material Select Initialization
    $('#cars-multipleselect').multiselect();

    $('#workers-multipleselect').multiselect();

    //ajax refreshes
    function carsMultipleRefresh() {
        var ajaxRequest;  // The variable that makes Ajax possible!
        
        try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
        }catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){
                // Something went wrong
                alert("O Browser não está a responder!");
                return false;
            }
        }
        }
        
        // Create a function that will receive data 
        // sent from the server and will update
        // div section in the same page.
            
        ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var ajaxDisplay = document.getElementById('carsOptions');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            $('#cars-multipleselect').multiselect();
        }
        }
        
        // Now get the value (the start date and end date) from user and pass it to
        // server script.
            
        var datetimeStart = document.getElementById('datetimepickerstart').value;
        var datetimeEnd = document.getElementById('datetimepickerend').value;
        var queryString = "?datetimeStart=" + datetimeStart + "&datetimeEnd=" + datetimeEnd;
        ajaxRequest.open("GET", "schedulesEditCarsByDate.php" + queryString, true);
        ajaxRequest.send(null); 
    }

    function workersMultipleRefresh() {
        var ajaxRequest;  // The variable that makes Ajax possible!
        
        try {
        // Opera 8.0+, Firefox, Safari
        ajaxRequest = new XMLHttpRequest();
        }catch (e) {
        // Internet Explorer Browsers
        try {
            ajaxRequest = new ActiveXObject("Msxml2.XMLHTTP");
        }catch (e) {
            try{
                ajaxRequest = new ActiveXObject("Microsoft.XMLHTTP");
            }catch (e){
                // Something went wrong
                alert("O Browser não está a responder!");
                return false;
            }
        }
        }
        
        // Create a function that will receive data 
        // sent from the server and will update
        // div section in the same page.
            
        ajaxRequest.onreadystatechange = function(){
        if(ajaxRequest.readyState == 4){
            var ajaxDisplay = document.getElementById('workersOptions');
            ajaxDisplay.innerHTML = ajaxRequest.responseText;
            $('#workers-multipleselect').multiselect();
        }
        }
        
        // Now get the value (the start date and end date) from user and pass it to
        // server script.
            
        var datetimeStart = document.getElementById('datetimepickerstart').value;
        var datetimeEnd = document.getElementById('datetimepickerend').value;
        var queryString = "?datetimeStart=" + datetimeStart + "&datetimeEnd=" + datetimeEnd;
        ajaxRequest.open("GET", "schedulesEditWorkersByDate.php" + queryString, true);
        ajaxRequest.send(null); 
    }
});