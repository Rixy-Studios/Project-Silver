<?php
// libs
require_once "inc/db.php";
require_once "inc/tokengen.php";
if(isset($_SESSION['token'])){
    header("Location: /");
}
if(!isset($_GET['signupcode'])){
    header("Location: /");
}
$request = $db->prepare("SELECT * FROM `signup_code` WHERE `code`=:code");
$request->execute([
    "code" => $_GET['signupcode']
]);
$result = $request->fetch();
if($result != true){
    echo "Do you think is that easy to bypass sign up code protection? You're so funny!";
    exit;
}
?>
<html>
    <head>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <script src="assets/bootstrap.bundle.min.js"></script>
        <title>Project Silver - Sign Up</title>
    </head>
    <body>
        <div style="position: absolute; top: 25%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Project Silver</h3>
        </div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Sign Up</h3>
            <p>You have luck! If you are here, then you've got a very rare <strong>valid signup code</strong>!</p>
            <form method="post">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Username</span>
                    </div>
                    <input type="text" class="form-control" placeholder="Username" name="username" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Email</span>
                    </div>
                    <input type="email" class="form-control" placeholder="Email" name="email" aria-describedby="basic-addon1">
                </div>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <span class="input-group-text" id="basic-addon1">Password</span>
                    </div>
                    <input type="password" class="form-control" placeholder="Password" name="password" aria-describedby="basic-addon1">
                </div>
                <input type="submit" name="submit" class="btn btn-outline-success" value="Sign Up">
            </form>
            <?php
                if(isset($_POST['submit'])){
                    if(!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['email'])){
                        $query = $db->prepare("SELECT * FROM `users` WHERE `username`=:username");
                        $query->execute([
                            "username" => $_POST['username']
                        ]);
                        $result = $query->fetch();
                        $query2 = $db->prepare("SELECT * FROM `users` WHERE `email`=:email");
                        $query2->execute([
                            "email" => $_POST['email']
                        ]);
                        $result2 = $query2->fetch();
                        if($result != true | $result2 != true){
                            $hashpass = password_hash($_POST['password'], PASSWORD_BCRYPT);
                            $query3 = $db->prepare("INSERT INTO `users`(`id`, `username`, `password`, `email`) VALUES (NULL, :username,:password,:email)");
                            $query3->execute([
                                "username" => $_POST['username'],
                                "password" => $hashpass,
                                "email" => $_POST['email']
                            ]);
                            header("Location: /login.php");
                            $request = $db->prepare("DELETE FROM `signup_code` WHERE `code`=:code");
                            $request->execute([
                                "code" => $_GET['signupcode']
                            ]);
                        }else{
                            echo "<div class='alert alert-danger' role='alert'>
                                An user with one of these details already exists!
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