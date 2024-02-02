<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // collecting user inputs
    $email = $_POST["email"];
    $firstName = $_POST["firstName"];
    $lastName = $_POST["lastName"];
    $age = $_POST["age"];
    $password = $_POST["password"];
    
    // display a welcome message 
    echo " <h1>Hi,$firstName $lastName<br></h1>";
    
    // list all user's information.
    echo " <h2> Your Information <br></h2>";
    echo " <select> ";
    echo "<option>$email <br></option>";
    echo "<option>$lastName<br></option>";
    echo "<option>$age<br></option>";
    echo "<option>$password<br></option></select>";
}
?>