<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Photo</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/myphoto.css">
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
    <div id="photodiv">
        <h3>My Photo</h3>
        <?php select2(); ?>
    </div>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>

<?php
require_once('config.php');
session_start();
function select2(){
    if (isset( $_GET['page'])){
        imageagain();
    }
    else{
        image();
    }
}
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
else{
    $_SESSION['page']=0;
    $_SESSION['number']=0;
}
function image()
{
    try {
        $UID=$_SESSION['id'];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $sql = 'select Image, Description,Title,type,UID,ImageID  from  traveluserimage where UID=:id';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $UID);
        $statement->execute();
        if($statement->rowCount() == 0){
            echo '<h2>have no photo!</h2>';
        }
        else if($statement->rowCount()>4){
            $i=0;
            while (($row = $statement->fetch())&&$i<4) {
                outputSingleimg($row);
                $i++;
            }
            $_SESSION['page']=0;
            $_SESSION['number']=$statement->rowCount();
        }
        else {
            while ($row = $statement->fetch()) {
                outputSingleimg($row);
            }
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function imageagain()
{
    try {
        $num=$_SESSION['page'];
        $UID=$_SESSION['id'];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $sql = "select Image, Description,Title,type,UID,ImageID  from  traveluserimage where UID=:id LIMIT $num,4 ";
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $UID);
        $statement->execute();
        if($statement->rowCount() == 0){
            echo '<h2>have no photo!</h2>';
        }
        else {
            while ($row = $statement->fetch()) {
                outputSingleimg($row);
            }
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function outputsingleimg($row){
    echo '<div>';
    echo constructdetaillink($row['UID'], $row['ImageID']);
    echo '<img src="data:image/png;base64,'.base64_encode(stripslashes($row['Image'])).'"></a></div>';
    echo '<div><h2>'.$row['Title'].'</h2>'  ;
    echo ' <p>'.$row['Description'].'</p>' ;
    /*echo '<a href="Modigy.php?id='.$row['ImageID'].'"><button>Modify</button></a>';*/
    echo '<a href=""><button onclick="alert(\'Be sure to delete your photo!\')">Delete</button></a>';
    echo '<hr></div>';
}
function constructdetaillink($id,$ImageID){
    return '<a href="detail.php?id=' . $id . '&ImageID='.$ImageID.'">';
}
?>