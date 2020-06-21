<!DOCTYPE html>
<?php
setcookie("username", "", -1);
?>
<html>
<head>
    <meta charset="utf8">
    <title>登录</title>
    <link href="../css/login.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="main">
    <p>
        <img class="images" src="../../img/logo/logo1.jpg"><br>
    <h1><strong>欢迎登陆</strong></h1>
    </p>
</div>
<div id="register1">
    <form action="log.php"  method="POST">
        <strong>用户名</strong><br>
        <input name="username" placeholder="Username" required type="text"><br>
        <strong>密码</strong><br>
        <input name="password" placeholder="Password" required type="password"><br>
        <br>
        <input name="continue" type="submit" value="登录">
        <p>新用户？
            <a href="register.php">注册一个新账号</a>
        </p>
    </form>
</div>
</body>
</html>