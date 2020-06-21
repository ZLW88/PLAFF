<?php
require_once('config.php');
session_start();
try {
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);

    $sql = 'select * from  travelimage where ImageID=:id';
    $id =  $_GET['id'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $row = $statement->fetch(PDO::FETCH_ASSOC);

    $sql1 = 'select CountryName from geocountries where ISO=:iso';
    $statement1 = $pdo->prepare($sql1);
    $statement1->bindValue(':iso', $row['CountryCodeISO']);
    $statement1->execute();
    $row1 = $statement1->fetch();

    $sql2 = 'select AsciiName from geocities where GeoNameID=:nameid';
    $statement2 = $pdo->prepare($sql2);
    $statement2->bindValue(':nameid', $row['CityCode']);
    $statement2->execute();
    $row2 = $statement2->fetch();

    $pdo = null;
}
catch (PDOException $e) {
    die( $e->getMessage() );
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Details</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/details.css">
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
    <div id="maindetails">
        <h2 id="maintitle">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Details</h2>
        <div>
            <div id="imagetitle"><span><?php echo $row['Title']?></span> by zzz</div>
            <div id="maindiv">
                <img id="detailimg" src="../../travel-images/large/<?php echo $row['PATH']; ?>">
                <div id="detailinfo">
                    <table id="detailtable">
                        <tr><td class="titletd">Image Details</td></tr>
                        <tr><td>Content: <?php echo $row['Content']; ?></td></tr>
                        <tr><td>Country: <?php echo $row1['CountryName']; ?></td></tr>
                        <tr><td>City: <?php echo $row2['AsciiName']; ?></td></tr>
                    </table>
                    <?php
                    if (isset($_COOKIE["username"])) {
                        echo '<a href="addfavor.php?id=' . $_SESSION['id'] . '&ImageID='.$_GET['id'].'">';
                    }
                    ?>
                    <button><img id="likeimg" src="../../img/details/like.png"></button></a>
                </div>
            </div>
            <h3>Description</h3>
            <?php echo $row['Description']; ?>
        </div>
    </div>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>