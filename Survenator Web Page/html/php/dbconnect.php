<?php

//Connect to the database
//Returns handle
string function db_connect()
{
    $sqlname = "root";
    $sqlpass = "datapass";
    $hostname = "localhost"; 

    $dbhandle = mysql_connect($hostname, $sqlname, $sqlpass);
    
    mysql_select_db("Survinator", $dbhandle);
    
    return $dbhandle;
}

?>
