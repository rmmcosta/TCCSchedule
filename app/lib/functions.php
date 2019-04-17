<?php
    function get($name, $def='') {
        return isset($_REQUEST[$name]) ? $_REQUEST[$name] : $def;
    }

    function isActive($page,$activePage) {
        return ($page==$activePage)?'active':'';
    }

    function connectDB($dbInfo) {
        $con = mysqli_connect($dbInfo["host"],$dbInfo["username"],$dbInfo["password"],$dbInfo["dbname"],$dbInfo["port"],$dbInfo["socket"]);
        if (mysqli_connect_errno())
        {
            echo "Falha na ligação a Base de Dados: " . mysqli_connect_error();
        }
        return $con;
    }
?>