<?php
require_once("inc/db.php");
if(isset($_SESSION['token'])){
    $id = $db->prepare("SELECT * FROM `tokens` WHERE `token`=:token");
    $id->execute([
        "token" => $_SESSION['token']
    ]);
    $idresult = $id->fetch();
    $user = $db->prepare("SELECT * FROM `users` WHERE `id`=:id");
    $user->execute([
        "id" => $idresult['forid']
    ]);
    $userresult = $user->fetch();
}
?>
<html>
    <head>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <script src="assets/bootstrap.bundle.min.js"></script>
        <title>Project Silver</title>
    </head>
    <body>
        <div style="position: absolute; top: 25%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Project Silver</h3>
        </div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h3>
            <span style="float:left;">Welcome<?php if(isset($_SESSION['token'])){ echo " " .$userresult['username']; } ?>!</span><?php if(isset($_SESSION['token'])){ ?>><a href="/logout.php">Logout</a> <?php } ?>
            <a style="float:right;text-align:right;margin-left: 80px;">Feed</a>
            </h3>
            <span style="float:left;"<p> ... to project silver!</p></span>
            <span style="float:left;"<p>You will get to this site when you click a button named 'Sign In with Project Silver'</p></span>
            <span style="float:right;text-align:right;margin-left: 80px;"<p>12/11/21 - Project Silver authenticates with Silver Club!</p></span>
            <span style="float:right;text-align:right;margin-left: 80px;"<p>Project Silver has gotten it's first application to authenticate with: Silver Club! Go enjoy!</p></span>
        </div>
    </body>
</html>