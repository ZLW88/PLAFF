<?php
require_once('config.php');
session_start();
try {
    $UID=$_SESSION['id'];
    $pdo = new PDO(DBCONNSTRING,DBUSER,DBPASS);
    $sql = 'DELETE FROM travelimagefavor where ImageID=:id and UID=:UID';
    $id =  $_GET['id'];
    $statement = $pdo->prepare($sql);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':UID', $UID);
    $statement->execute();
    $pdo = null;
    if ($statement){
        echo "<script type='text/javascript'>alert('The image has been removed from the collection！');location.href='favor.php';</script>";
    }
    else{
        echo "<script type='text/javascript'>alert('上传失败！');location.href='upload.php';</script>";
    }
}
catch (PDOException $e) {
    die( $e->getMessage() );
}
?>