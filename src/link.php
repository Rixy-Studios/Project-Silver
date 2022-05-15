<?php
//libs
require_once "inc/db.php";

if(!isset($_GET['appid'])){
    echo "appID not found.";
    exit;
}
$appId = $_GET['appid'];
if(!isset($_SESSION['token'])){
    header("Location: /login.php?redirect=/link.php?appid=".$_GET['appid']);
}
$request = $db->prepare("SELECT * FROM `app_link` WHERE `appid`=:appid");
$request->execute([
    "appid" => $appId
]);
$result = $request->fetch();
if($result != true){
    echo "appID not valid.";
    exit;
}
?>
<html>
    <head>
        <link rel="stylesheet" href="assets/bootstrap.min.css">
        <script src="assets/bootstrap.bundle.min.js"></script>
        <title>Project Silver - Link</title>
    </head>
    <body>
        <div style="position: absolute; top: 25%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Project Silver</h3>
        </div>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%);">
            <h3>Authorize application</h3>
            <h4><?php echo $result['name'] ?></h4>
            <p><?php echo $result['description'] ?></p>
            <form method="post">
                <input type="submit" name="submit" class="btn btn-outline-success" value="Authorize & Redirect">
            </form>
            <?php
            if(isset($_POST['submit'])){
                $url = $result['redirecturl'] . "?userToken=" .$_SESSION['token'];
                header("Location: ". $url);
            }
            ?>
        </div>
    </body>
</html>