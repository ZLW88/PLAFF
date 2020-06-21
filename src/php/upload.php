<?php
require_once('config.php');
session_start();
if (isset($_POST['submit'])) {
    $ID=$_SESSION['id'];
    $title=$_POST['title'];
    $theme=$_POST['theme'];
    $country=$_POST['country'];
    $city=$_POST['city'];
    $description=$_POST['description'];
    $type = $_FILES['file1']['type'];
    $data = addslashes(file_get_contents($_FILES['file1']['tmp_name']));
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sql = 'INSERT INTO traveluserimage VALUES (:ID,:title,:description,:theme,:country,:city,:data,:type,null )';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id',$ID);
    $statement->bindValue(':title',$title);
    $statement->bindValue(':theme',$theme);
    $statement->bindValue(':country',$country);
    $statement->bindValue(':city',$city);
    $statement->bindValue(':description',$description);
    $statement->bindValue(':data',$data);
    $statement->bindValue(':type',$type);
    $statement->execute();
    if ($statement){
        echo "<script type='text/javascript'>alert('上传成功！');location.href='detail.php';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('上传失败！');location.href='upload.php';</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/upload.css">
    <script>
        function showMyImage(fileInput) {
            var pattern = /(\.*.jpg$)|(\.*.png$)|(\.*.jpeg$)|(\.*.gif$)/;
            if (!pattern.test(fileInput.value)) {
                alert("系统仅支持jpg/jpeg/png/gif格式的照片！");
            } else {
                var files = fileInput.files;
                for (var i = 0; i < files.length; i++) {
                    var file = files[i];
                    var imageType = /image.*/;
                    if (!file.type.match(imageType)) {
                        continue;
                    }
                    var img = document.getElementById("output");
                    img.file = file;
                    var reader = new FileReader();
                    reader.onload = (function (aImg) {
                        return function (e) {
                            aImg.src = e.target.result;
                        };
                    })(img);
                    reader.readAsDataURL(file);
                }
            }
        }
    </script>
</head>
<body>
<header>
    <div id="logo"><a href="../../index.php"><img id="homelogo" src="../../img/logo/logo2.jfif"></a></div>
    <div id="headerleft">
        <ul>
            <li id="homeli"><a href="../../index.php"><strong>主页</strong></a></li>
            <li id="browserli"><a href="browser.php"><strong>浏览页</strong></a></li>
            <li id="searchli"><a href="search.php"><strong>搜索页</strong></a></li>
        </ul>
    </div>
    <?php
    if (isset($_COOKIE['username'])) {
        echo "<div id=\"headerright\">
            <ul>
                <li>
                    <span><strong>个人中心</strong></span>
                    <ul>
                        <a href=\"upload.php\"><li><strong><img class=\"smalllogo\" src=\"../../img/home/upload.jfif\"> 上传</strong></li></a>
                        <a href=\"myphoto.php\"><li><strong><img class=\"smalllogo\" src=\"../../img/home/myphoto.jfif\"> 我的照片</strong></li></a>
                        <a href=\"favor.php\"><li><strong><img class=\"smalllogo\" src=\"../../img/home/favor.jpg\"> 我的收藏</strong></li></a>
                        <a href=\"login.php\"><li><strong><img class=\"smalllogo\" src=\"../../img/home/login.jfif\"> 登入</strong></li></a>
                    </ul>
                </li>
            </ul>
        </div>";
    }
    else{
        echo "
            <div id='headerright'>
                <ul>
                    <li>
                    <a href='login.php'><strong>登录</strong></a>
                    </li>
                </ul>
            </div>";
    };
    ?>
</header>
    <form action="upload.php" method="post">
    <div id="maindiv">
        <h3 id="title">Upload</h3>
        <div id="contain">
            <form method="post" action="uploaded.php" enctype="multipart/form-data">
            <div class="upload">
                <img id="output" alt="图片未上传"><br>
                <input type="file" accept="image/*" onchange="showMyImage(this)" id="file1" name="file1">
            </div>
            <div id="formdiv">
                <p>图片标题: <br>
                <input class="textinput" type="text" name="title"></p>
                <p>图片描述：<br>
                <textarea cols="164" rows="10" name="description"></textarea></p>
                <p>图片主题：</p>
                <input class="textinput" type="text" name="theme">
                <p>拍摄国家：<br>
                <select class="textinput" name="country" id="country" onchange="addOption()">
                    <option selected>按国家筛选</option>
                </select>
                <p>拍摄城市：<br>
                <select class="textinput" name="city" id="city"></select>
                    <br>
                <input type="submit" value="submit" id="submit" name="submit">
            </div>
            </form>
        </div>
    </div>
    </form>
<script type="text/javascript" src="../js/browser.js"></script>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>