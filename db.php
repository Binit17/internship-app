<!-- this file establishes a connection to mySQL database using the credentials 
from the config.php file. It can also contain helper functions for executing
database queries.  -->

<?php 
require_once "config.php";
?>

<?php
//create a database connection
$conn = mysqli_connect($servername, $username, $password, $database);

//check connection
if(!$conn){
    die("database-connection failed. ". mysqli_connect_error());
}

//function to execute a query and return the result .
function executeQuery($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    return $result ;
}

//function to sanitize user input
function sanitizeInput($input)
{
    global $conn;
    $sanitizedInput = mysqli_real_escape_string($conn, $input);
    return $sanitizedInput;
}

//function to get the last inserted ID
function getLastInsertedId()
{
    global $conn;
    return mysqli_insert_id($conn);
}
?>