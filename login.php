<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LOGIN</title>
</head>

<body>
    <!DOCTYPE html>
    <html>

    <head>
        <title>Login</title>
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
            top: 40%;
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

        p {
            color: white;
        }

        .t {
            margin-left: 20;
            text-decoration: none;
            color: white;
        }

        .t:hover {
            color: orange;
        }
        </style>
    </head>

    <body>
        <div class="container">

            <form method="POST" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
                <h1>Login <a href="signup.php" class="t">Sign-Up</a>
                </h1>
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required><br><br>

                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required><br><br>

                <input type="submit" value="Login"> <br> <br>

            </form>
            <br> <br>

        </div>
    </body>
    <?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'config.php';
    $conn = new PDO($dsn, $username, $password, $options);
    $name = htmlspecialchars($_POST["username"]);
    $pass = htmlspecialchars($_POST["password"]);
    $hashed = md5($pass);
    echo "$hashed";
    $sql = "SELECT * FROM customer WHERE username=:n AND password=:p";
    $stmt = $conn->prepare($sql);
    $stmt->execute(array(
        ':n' => $name,
        ':p' => $hashed
    ));
    $checkeduser = $stmt->fetch(PDO::FETCH_ASSOC);

        if($checkeduser)
        {
            
                    
        $_SESSION['user_id'] = $checkeduser['id_customer'];
        $_SESSION['username'] = $checkeduser['username'];
        $_SESSION['role'] = $checkeduser['role'];
            echo "Login Successfull! You will be redirect to your Tasks sooon!";
            echo '<script>
        setTimeout(function() {
            window.location.href = "task.php";
        }, 2000);
        </script>'; 
        }
        else
        {
            echo"Login Faild!";
        }
        
    }
    
    ?>

    </html>