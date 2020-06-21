<?php
require_once('config.php');
session_start();

function checksearch(){
    if(isset($_POST['title'])){
        searchByTitle();
    }
    else if (isset($_GET['theme'])){
        searchByContent();
    }
    else if(isset($_GET['country'])){
        searchByCountry();
    }
    else if(isset($_GET['city'])){
        searchByCity();
    }
    else if(isset($_POST['theme'])){
        searchByMore();
    }
    else if(isset($_GET['title1'])){
        searchByTitleagain();
    }
    else if(isset($_GET['theme1'])){
        searchByContentagain();
    }
    else if(isset($_GET['country1'])){
        searchByCountryagain();
    }
    else if(isset($_GET['city1'])){
        searchByCityagain();
    }
    else if(isset($_GET['country2'])){
        searchByMoreagain();
    }
    else{
        echo '<h3>No result!</h3>';
    }
}

$GLOBALS['search']='';
if (isset($_GET['page'])) {
    $_SESSION['page'] = $_GET['page'];
}
else{
    $_SESSION['page']=0;
    $_SESSION['number']=0;
}

function searchByTitle(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID  from  travelimage where Title LIKE "%'.$_POST['title'].'%"';
    $statement = $pdo->prepare($sql);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='title1='.$_POST['title'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByTitleagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='title1='.$_GET['title1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $like='%'.$_GET['title1'].'%';

    $sql = "select Path,ImageID  from  travelimage where Title LIKE :like LIMIT $num,16";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':like',$like);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}

function searchByContent(){
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'select Path,ImageID  from  travelimage where Content=:theme';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':theme',$_GET['theme']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='theme1='.$_GET['theme'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByContentagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='theme1='.$_GET['theme1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "select Path,ImageID  from  travelimage where Content=:theme LIMIT $num,16";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':theme',$_GET['theme1']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCountry(){

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'SELECT ImageID,Path  FROM travelimage JOIN geocountries ON travelimage.CountryCodeISO=geocountries.ISO WHERE CountryName=:countryname  ';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_GET['country']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='country1='.$_GET['country'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCountryagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='country1='.$_GET['country1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "SELECT ImageID,Path  FROM travelimage JOIN geocountries ON travelimage.CountryCodeISO=geocountries.ISO WHERE CountryName=:countryname LIMIT $num,16 ";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_GET['country1']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCity(){

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = 'SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname  ';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':cityname',$_GET['city']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else if($statement->rowCount()>16){
        outputlimitimage($statement);
        $_SESSION['page']=0;
        $_SESSION['number']=$statement->rowCount();
        $GLOBALS['search']='city1='.$_GET['city1'].'';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByCityagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='city1='.$_GET['city1'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);

    $sql = "SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname LIMIT $num,16 ";
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':cityname',$_GET['city1']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        while ($row = $statement->fetch()) {
            outputImage($row);
        }
    }
    $pdo=null;
}
function searchByMore(){

    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql ='SELECT ISO FROM geocountries WHERE CountryName=:countryname';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_POST['country']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        $row =$statement->fetch();
        $countrycode= $row['ISO'];
        $sql1 = 'SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname and Content=:content and travelimage.CountryCodeISO=:country';
        $statement1 = $pdo->prepare($sql1);
        $statement1->bindValue(':cityname', $_POST['city']);
        $statement1->bindValue(':content', $_POST['theme']);
        $statement1->bindValue(':country',$countrycode );
        $statement1->execute();
        if ($statement1->rowCount() == 0) {
            echo '<h3>Search no result!</h3>';
        }
        else if($statement->rowCount()>16){
            outputlimitimage($statement);
            $_SESSION['page']=0;
            $_SESSION['number']=$statement->rowCount();
            $GLOBALS['search']='country2='.$_POST['country'].'&cityname2='.$_POST['city'].'&content2='. $_POST['theme'].'';
        }
        else {
            while ($row1 = $statement1->fetch()) {
                outputImage($row1);
            }
        }
    }
    $pdo=null;
}
function searchByMoreagain(){
    $num=$_SESSION['page']*16;
    $GLOBALS['search']='country2='.$_GET['country2'].'&cityname2='.$_GET['city2'].'&content2='. $_GET['content2'].'';
    $pdo = new PDO(DBCONNSTRING, DBUSER, DBPASS);
    $sql ='SELECT ISO FROM geocountries WHERE CountryName=:countryname';
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':countryname',$_GET['country2']);
    $statement->execute();
    if ($statement->rowCount()==0){
        echo '<h3>Search no result!</h3>';
    }
    else {
        $row =$statement->fetch();
        $countrycode= $row['ISO'];
        $sql1 = "SELECT ImageID,Path FROM travelimage JOIN geocities ON travelimage.CityCode=geocities.GeoNameID WHERE AsciiName LIKE :cityname and Content=:content and travelimage.CountryCodeISO=:country LIMIT $num,16";
        $statement1 = $pdo->prepare($sql1);
        $statement1->bindValue(':cityname', $_GET['city2']);
        $statement1->bindValue(':content', $_GET['content2']);
        $statement1->bindValue(':country',$countrycode );
        $statement1->execute();
        if ($statement1->rowCount() == 0) {
            echo '<h3>Search no result!</h3>';
        }
        else {
            while ($row1 = $statement1->fetch()) {
                outputImage($row1);
            }
        }
    }
    $pdo=null;
}
function outputImage($row){
    echo '<div><a href="detail.php?id=' . $row['ImageID'] . '" >';
    echo '<img src="../../travel-images/large/'.$row['Path'].'"></a></div>';
}
function outputlimitimage($result){
    $i=0;
    while (($row = $result->fetch())&&$i<16){
        echo '<div><a href="detail.php?id=' . $row['ImageID'] . '" >';
        echo '<img src="../../travel-images/large/'.$row['Path'].'"></a></div>';
        $i++;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Browser</title>
    <link rel="stylesheet" href="../css/nav.css">
    <link rel="stylesheet" href="../css/browser.css">
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
    <div id="contain">
        <div id="tablerow">
            <div id="side">
                <div id="searchdiv">
                    <form method="post" action="browser.php">
                        <h4>请输入筛选条件</h4>
                        <input type="text" name="title">
                        <input type="submit" id="submit" value="筛选">
                    </form>
                </div>
                <div id="hotcontent">
                    <h4>Hot Content</h4>
                    <a href="browser.php?theme=scenery" >Scenery</a><br>
                    <a href="browser.php?theme=city" >City</a><br>
                    <a href="browser.php?theme=people" >People</a><br>
                    <a href="browser.php?theme=animal" >Animal</a><br>
                </div>
                <div id="hotcountry">
                    <h4>Hot Country</h4>
                    <a href="browser.php?country=China" >China</a><br>
                    <a href="browser.php?country=Italy" >Italy</a><br>
                    <a href="browser.php?country=Japan" >Japan</a><br>
                    <a href="browser.php?country=American" >American</a><br>
                </div>
                <div id="hotcountry">
                    <h4>Hot Country</h4>
                    <a href="browser.php?city=beijing" >Beijing</a><br>
                    <a href="browser.php?city=paris" >Paris</a><br>
                    <a href="browser.php?city=london" >London</a><br>
                    <a href="browser.php?city=newyork" >New York</a><br>
                </div>
            </div>
            <div id="main">
                <div id="require">
                        <h4>筛选</h4>
                        <form action="browser.php" class="selects" method="post">
                            <select name="theme">
                                <option value="placeholder" selected>按主题筛选</option>
                                <option value="scenery">scenery</option>
                                <option value="city">city</option>
                                <option value="people">people</option>
                                <option value="animal">animal</option>
                                <option value="building">building</option>
                                <option value="wonder">wonder</option>
                                <option value="other">other</option>
                            </select><select name="country" id="country" onchange="addOption()">
                                <option selected>按国家筛选</option>
                            </select>
                            <select name="city" id="city"></select>

                            <input id="submit" type="submit" value="筛 选">
                        </form>
                <div id="picture">
                    <?php checksearch(); ?>
                </div>
            </div>
        </div>
    </div>
        <script type="text/javascript" src="../js/browser.js"></script>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>