<?php
    $host = "localhost";

    $dbname = "cleanblog";

    $user = "root";

    $password = "";

    try {
        $con = new PDO("mysql:host=$host;dbname=$dbname;port=3307",$user, $password);
        $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        // echo "Connected successfully \n";
    }
    catch(Exception $e){
        echo "Connected Failed" . $e->getMessage();
    }

    
?>