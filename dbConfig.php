<?php
    function connectDatabase()
    {
        $dbHostname='192.168.1.215';
        $dbUsername='root';
        $dbPassword='cms-8341';
        $db='mysql';
    
        $conn=new mysqli($dbHostname,$dbUsername,$dbPassword,$db);
    
        if(!$conn){
            die('Error In connection'.mysqli_connect_error());
        }else{
            echo 'Connection Success<br>';
        }
        mysqli_close($conn);
    }
    connectDatabase();
?>