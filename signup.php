<!DOCTYPE html>


<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
    html {
        background-image: url(DesktopBackground\(1\).jpg);
        background-repeat: no-repeat;
        background-size: cover;
        width: 100vw;
        height: 100vh;
       
    }

    div {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100%;
     
    }

    form {
        background-color: rgba(116, 115, 115, 0.059);
        display: flex;
        flex-direction: column;
        width: 30%;
        justify-content: space-around;
        align-content: center;
        align-items: center;
        backdrop-filter: blur(8px);
        border: 2px solid white;
        padding: 20px;
        min-width: 200px;
        border-radius: 50px 8px 30px 15px;
        position: absolute;
        top:40%;
    }

    input {
        padding: 5px 10px;
        width: 60%;
        background-color: rgba(0, 255, 255, 0);
        color: rgb(255, 255, 255);
        border-top: 0px;
        border-right: 0px;
        border-left: 0px;
        border-color: aliceblue;
        height: 30px;
        margin: 10px;
        font-size: 12pt;
    }

    h1 {
        color: white;
    }

    .button {
        font-size: 14pt;
        background-color: rgba(16, 20, 63, 0.333);
        height: 40px;
        border-radius: 5px;
        color: aliceblue;
        border: 0;
        margin-top: 20px;
        border: 1px solid white;
    }
    p{
        color:white;
    }
    </style>

</head>

<body>
    <div class="sign_up">
    <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required><br><br>
        
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br><br>
        
        <input type="submit" value="Sign Up" class="button">
    </form>
    </div>
</body>


<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST["username"]);
    $pass = htmlspecialchars($_POST['password']);
    $hashed = md5($pass);

    require_once 'config.php';
    $conn = new PDO($dsn, $username, $password, $options);

    // Check if the username already exists
    $checkexist = "SELECT COUNT(*) FROM customer WHERE username = :username";
    $stmt = $conn->prepare($checkexist);
    $stmt->execute(array(':username' => $name));
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        echo "<p>Username already exists. Please choose a different username.</p>";
    } else {
        $sql = "INSERT INTO customer (username, password) VALUES (:uname, :pass);";
        $stmt = $conn->prepare($sql);
        $stmt->execute(array(':uname' => $name, ':pass' => $hashed));

        echo "Registration successful!...";
        echo '<script>
        setTimeout(function() {
            window.location.href = "login.php";
        }, 2000);
      </script>'; 
    }
}
?>
</html>