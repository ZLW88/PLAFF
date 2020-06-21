<?php
require_once('src/php/config.php');
function outputimg(){
     try {
         $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
         $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

         $sql = 'select ImageID, Description, Path ,Title from travelimage ORDER BY  RAND() LIMIT 6';
         $result = $pdo->query($sql);

         $i=0;
         while ($i<6) {
             $row = $result->fetch();
             outputSingleimg($row);
             $i++;
         }
         $pdo = null;
     }
     catch (PDOException $e){
         die( $e->getMessage() );
     }
 }
 function outputsingleimg($row){
     echo '<div >';
     echo constructdetaillink($row['ImageID']);
     echo '<img src="travel-images/large/'.$row['Path'].'"></a>';
     echo '<h3>'.$row['Title'].'</h3>'  ;
     echo ' <p>'.$row['Description'].'</p>' ;
     echo '</div>';
 }
 function constructdetaillink($id){
     return '<a href="src/php/detail.php?id=' . $id . '">';
 }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="src/css/nav.css">
    <link rel="stylesheet" href="src/css/home.css">
    <script type="text/javascript">
        $(document).ready(function(){
            $("#goToTop").hide()
            $(function(){
                $(window).scroll(function(){
                    if($(this).scrollTop()>1){
                        $("#goToTop").fadeIn();
                    } else {
                        $("#goToTop").fadeOut();
                    }
                });
            });
         
            
            $("#goToTop a").click(function(){
                $("html,body").animate({scrollTop:0},800);
                return false;
            });
        });
    </script>
</head>
<body>
    <header>
        <div id="logo"><a href="index.php"><img id="homelogo" src="img/logo/logo2.jfif"></a></div>
        <div id="headerleft">
            <ul>
                <li id="homeli"><a href="index.php"><strong>主页</strong></a></li>
                <li id="browserli"><a href="src/php/browser.php"><strong>浏览页</strong></a></li>
                <li id="searchli"><a href="src/php/search.php"><strong>搜索页</strong></a></li>
            </ul>
        </div>
            <?php
            if (isset($_COOKIE['username'])) {
                echo "<div id=\"headerright\">
            <ul>
                <li>
                    <span><strong>个人中心</strong></span>
                    <ul>
                        <a href=\"src/php/upload.php\"><li><strong><img class=\"smalllogo\" src=\"img/home/upload.jfif\"> 上传</strong></li></a>
                        <a href=\"src/php/myphoto.php\"><li><strong><img class=\"smalllogo\" src=\"img/home/myphoto.jfif\"> 我的照片</strong></li></a>
                        <a href=\"src/php/favor.php\"><li><strong><img class=\"smalllogo\" src=\"img/home/favor.jpg\"> 我的收藏</strong></li></a>
                        <a href=\"src/php/login.php\"><li><strong><img class=\"smalllogo\" src=\"img/home/login.jfif\"> 登入</strong></li></a>
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
                    <a href='src/php/login.php'><strong>登录</strong></a>
                    </li>
                </ul>
            </div>";
            };
            ?>
    </header>
    <div id="mainimage"><a href="src/php/detail.php"><img src="img/home/mainimage.jpg"></a></div>
    <div class="content">
            <?php
            outputimg();
            ?>
    </div>
    <div id="goToTop"><a href="#"><img src="img/home/returntop.jpg" alt="返回顶部"></a></div>
    <div id="refresh" onclick="location.reload()"><a href="#"><img src="img/home/refresh.jpg" alt="刷新页面"></a></div>
    <footer>&copy;19302010045@fudan.edu.cn</footer>
</body>
</html>