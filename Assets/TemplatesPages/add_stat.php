<?php 
/* add_stat.php - установить реакцию для страницы (лайки и тд) */


// $stat - 0 лайк, 1 дизлайк, 2 - одобрено, 3 - неодобренно
session_start();
if (empty($_SESSION['login'])) {header_safe(SITE_URL.'regform.php');}
require_once 'functions.php';
require_once 'cfg.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');
$stat = isset($_GET['stat']) ? $_GET['stat'] : exit('Ошибка | Отсуствует stat');
$type = isset($_GET['type']) ? $_GET['type'] : exit('Ошибка | Отсуствует type');

//Удаление идеи
if($_SESSION['role'] >= 2 && ($stat == 2 || $stat == 3)){
    $q = 'SELECT `LikeUserId` FROM `likes` WHERE `LikeUserId` = '.$_SESSION['id'].' AND `LikePageId` = '.$id.' AND `PageType` = '.$type.'';
    $res = mysqli_query($link,$q);
    $ifuser = MyFetch($res);
    if(!$ifuser){
        $q = 'INSERT INTO `likes` (`LikeUserId`, `LikeType`, `LikePageId`,`PageType`) VALUES ('.$_SESSION['id'].','.$stat.','.$id.','.$type.')';
        $res = mysqli_query($link,$q);
        $success[] = 'Установлена реакция';
    }else{
        $q = 'UPDATE `likes` SET `LikeType`='.$stat.' WHERE `LikePageId` ='.$id.' AND `LikeUserId` = '.$_SESSION['id'].' AND `PageType` = '.$type.'';
        $res = mysqli_query($link,$q);
        $success[] = 'Обновлена реакция';
    }
}elseif($stat == 0 || $stat == 1){
    $q = 'SELECT `LikeUserId` FROM `likes` WHERE `LikeUserId` = '.$_SESSION['id'].' AND `LikePageId` = '.$id.' AND `PageType` = '.$type.'';
    $res = mysqli_query($link,$q);
    $ifuser = MyFetch($res);
    if(!$ifuser){
        $q = 'INSERT INTO `likes` (`LikeUserId`, `LikeType`, `LikePageId`, `PageType`) VALUES ('.$_SESSION['id'].','.$stat.','.$id.','.$type.')';
        $res = mysqli_query($link,$q);
        if($stat == 0){
            $success[] = 'Вы поставили лайк';
        }else{
            $success[] = 'Вы поставили дизлайк';
        }
    }else{
        if($stat == 0){
            $q = 'UPDATE `likes` SET `LikeType`= 0 WHERE `LikePageId` ='.$id.' AND `LikeUserId` = '.$_SESSION['id'].' AND `PageType` = '.$type.'';
            $res = mysqli_query($link,$q);
            $success[] = 'Вы поставили лайк';
        }else{
            $q = 'UPDATE `likes` SET `LikeType`= 1 WHERE `LikePageId` ='.$id.' AND `LikeUserId` = '.$_SESSION['id'].' AND `PageType` = '.$type.'';
            $res = mysqli_query($link,$q);
            $success[] = 'Вы поставили дизлайк';
        }
    }
}
$_SESSION['success'] = $success;
header_safe(SITE_URL.'Pages/Idea/'.$id);
?>