<?php
require_once('config.php');
session_start();
function select1(){
    image();
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
        $ID=$_COOKIE['ID'];
        $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $sql = 'select ImageID, UOL from travelimagefavor where UID=:id ';
        $statement = $pdo->prepare($sql);
        $statement->bindValue(':id', $ID);
        $statement->execute();
        if($statement->rowCount() == 0){
            echo '<h2>have no photo!</h2>';
        }
        else if($statement->rowCount()>4){
            $i=0;
            while (($row = $statement->fetch(PDO::FETCH_ASSOC))&&$i<4) {
                if($row['UOL']==0) {
                    outputSingleimg($row);
                }
                else{
                    outuserimage($row);
                }
                $i++;
            }
            $_SESSION['page']=0;
            $_SESSION['number']=$statement->rowCount();
        }
        else {
            while ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
                if($row['UOL']==0) {
                    outputSingleimg($row);
                }
                else{
                    outuserimage($row);
                }
            }
        }
        $pdo = null;
    } catch (PDOException $e) {
        die($e->getMessage());
    }
}
function outputsingleimg($row){
    $id=$row['ImageID'];
    $pdo2 = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql2 = 'select Path,ImageID,Title,Description from  travelimage where ImageID=:imageid';
    $statement2 = $pdo2->prepare($sql2);
    $statement2->bindValue(':imageid', $id);
    $statement2->execute();
    $row2 = $statement2->fetch();
    echo '<div >';
    echo constructdetaillink($row2['ImageID']);
    echo '<img src="../../travel-images/large/'.$row2['Path'].'"></a></div>';
    echo '<div><h2>'.$row2['Title'].'</h2>'  ;
    echo ' <p>'.$row2['Description'].'</p>' ;
    echo '<a href="delete.php?id=' . $row2['ImageID'] . '"><button onclick="">Delete</button></a>';
    echo '<hr></div>';
}
function constructdetaillink($id){
    return '<a href="detail.php?id=' . $id . '">';
}
function outuserimage($row){
    $imageid=$row['ImageID'];
    $pdo1 = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql1 = 'select Image, type,Title,Description,ImageID from  traveluserimage where ImageID=:imageid';
    $statement1 = $pdo1->prepare($sql1);
    $statement1->bindValue(':imageid', $imageid);
    $statement1->execute();
    $row1 = $statement1->fetch();
    echo '<div >';
    echo  detaillink($_SESSION['id'],$row1['ImageID']);
    echo '<img src="data:image/png;base64,'.base64_encode(stripslashes($row1['Image'])).'"></a></div>';
    echo '<div><h2>'.$row1['Title'].'</h2>'  ;
    echo ' <p>'.$row1['Description'].'</p>' ;
    echo '<a href="delete.php?id=' . $row1['ImageID'] . '"><button onclick="">Delete</button></a>';
    echo '<hr></div>';

}
function detaillink($id,$ImageID){
    return '<a href="detail.php?id=' . $id . '&ImageID='.$ImageID.'">';
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Favor</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/favor.css">
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
<div id="favordiv">
    <h3>My Favorite</h3>
    <?php select1();?>
</div>
<footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>