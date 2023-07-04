<!-- this file includes the necessary configuration settings for our app,
such as database credentials and other global variables. It is usually
included at the beginning of the other PHP files. -->

<?php
//database configuration
$servername = "localhost";
$username = "gautam";
$password = "gautam";
$database = "intern_app";

//create database connection
$conn = mysqli_connect($servername, $username, $password, $database );

//check connection
if(!$conn) 
{
    die("Connection failed ". mysqli_connect-error());
}

//if there are any other global variables or configurations , define here.

?>