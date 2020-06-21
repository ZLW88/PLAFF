<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="../css/register.css">
    <script language="javascript" type="text/javascript">
        var code; //在全局 定义验证码
        function validate() {
            var pw1 = document.getElementById("pw1").value;
            var pw2 = document.getElementById("pw2").value;
            if (pw1 == pw2) {
                return true;
            }else {
                alert("两次密码不同");
                return false;
            }
        }
    </script>
</head>
<body>
    <div id="main">
        <p>
            <img class="images" src="../../img/logo/logo1.jpg"><br>
            <h1><strong>注册新用户</strong></h1>
        </p>
    </div>
    <div id="register1">
        <form action="registed.php" method="POST">
        <strong>用户名/电子邮箱</strong><br>
            <input name="username" pattern="/^([a-zA-Z]|[0-9])(\w|\-)+@[a-zA-Z0-9]+\.([a-zA-Z]{2,4})+(\.([a-zA-Z]{2,4}))?$/" placeholder="请输入用户名或电子邮箱(8-16位数字，字母下划线）" required
                   type="username"><br>
        <strong>密码</strong><br>
            <input id="pw1" name="password" pattern="^[a-zA-Z0-9]{8,}$" placeholder="请设置密码(8-16位数字，字母）"
                   type="password"><br>
        <strong>确认密码</strong><br>
            <input id="pw2" name="password" placeholder="请再次输入密码" type="password"><br>
            <span id="check-result"></span>
        <br>
        <input type="submit" value="注 册" id="submit">
        </form>
        <p>已有账号? <a href="login.php"> 立即登录!</a></p>
    </div>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>