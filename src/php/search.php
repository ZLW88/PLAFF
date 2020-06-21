<?php
require_once('config.php');
session_start();
function checkSearch(){
    if ($_POST['title']!=""||$_POST['description']!=""){
        if (isset($_POST['search'])){
            if ($_POST['search']=='title'&&$_POST['title']!=""){
                searchBytitle();
            }
            else if ($_POST['search']=='description'&&$_POST['description']!="") {
                searchBydes();
            }
            else {
                echo '请正确输入搜索条件';
            }
        }
        else{
            echo '<h3>No result!</h3>';
        }
    }else{
        echo '请输入搜索条件';}
}
$GLOBALS['search']='';

function searchBytitle(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql = 'select Path,ImageID,Title,Description  from  travelimage where Title LIKE "%'.$_POST['title'].'%"';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>4){
        $i=0;
        while (($row = $statement->fetch())&&$i<4) {
            outPutImage($row);
            $i++;
        }
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='title1='.$_POST['title'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outPutImage($row);
        }
    }
    $pdo=null;
}
function searchBydes(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID,Title,Description  from  travelimage where Description LIKE "%'.$_POST['description'].'%"';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>4){
        $i=0;
        while (($row = $statement->fetch())&&$i<4) {
            outPutImage($row);
            $i++;
        }
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='des='.$_POST['description'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outPutImage($row);
        }
    }
    $pdo=null;
}
function outPutImage($row){
    echo '<div><a href="detail.php?id=' . $row['ImageID'] . '"><img src="../../travel-images/large/'.$row['Path'].'"></a> </div>';
    echo '<div><h2>'.$row['Title'].'</h2>';
    echo '<p>'.$row['Description'].'</p><hr></div>';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/search.css">
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
    <div id="searchdiv">
        <h4>Search</h4>
        <form method="post" action="search.php">
            <input type="radio" name="search" checked="checked" value="title">Search by title <br><br>
            <input type="text"  name="title"><br><br>
            <input type="radio" name="search" value="description">Search by description <br><br>
            <input type="text" name="description" id="des"><br><br>
            <input type="submit" value="搜索" id="submit">
         </form>
    </div>
    <div id="resultdiv">
        <h3>Result</h3>
        <div class="content">
            <?php checkSearch(); ?>
        </div>
    </div>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>