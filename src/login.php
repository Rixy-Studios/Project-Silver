<?php
// libs
require_once "inc/db.php";
require_once "inc/tokengen.php";
if(isset($_SESSION['token'])){
    header("Location: /");
}
?>
<html>
    <head>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <script src="assets/bootstrap.bundle.min.js"></script>
        <title>Project Silver - Login</title>
    </head>
    <body>
        <div style="position: absolute; top: 25%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Project Silver</h3>
        </div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Login</h3>
            <p>Please enter your username and password.</p>
            <form method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Username</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Username" name="username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                    </div>
                    <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="basic-addon1">
                </div>
                <input type="submit" name="submit" class="btn btn-outline-success" value="Login">
            </form>
            <?php
                if(isset($_POST['submit'])){
                    if(!empty($_POST['username']) && !empty($_POST['password'])){
                        $query = $db->prepare("SELECT * FROM `users` WHERE `username`=:username");
                        $query->execute([
                            "username" => $_POST['username']
                        ]);
                        $result = $query->fetch();
                        if($result==true){
                            if(password_verify($_POST['password'], $result['password'])){
                                $token = tokenGen(20);
                                $query = $db->prepare("INSERT INTO `tokens`(`forid`, `token`) VALUES (:id, :token)");
                                $query->execute([
                                    "id" => $result['id'],
                                    "token" => $token
                                ]);
                                $_SESSION['token'] = $token;
                                if(isset($_GET['redirect'])){
                                    header("Location: " . $_GET['redirect']);
                                }else{
                                    header("Location: /");
                                }
                            }else{
                                echo "<div class='alert alert-danger' role='alert'>
                                Wrong username/password!
                            </div>";
                            }
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                            Wrong username/password!
                        </div>";
                        }
                    }else{
                        echo "<div class='alert alert-danger' role='alert'>
                            Some fields are incomplete!
                        </div>";
                    }
                }
            ?>
        </div>
    </body>
</html>