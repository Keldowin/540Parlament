<?php 
session_start();
require_once 'cfg.php';
require_once 'functions.php';

if(empty($_SESSION)){
    header_safe(SITE_URL.'regform.php');
}
$date = date('Y-m-d H:i:s');
$comment = $_POST['comment'];

$q = 'INSERT INTO `comment` (`page_id`, `user_id`, `comment`, `date`) VALUES ("'.$_POST['page_id'].'","'.$_SESSION['id'].'","'.$comment.'","'.$date.'")';
$res = mysqli_query($link,$q);
if($res){
    $success[] = 'Комментарий добавлен';
}else{
    $errors[] = 'Ошибка, комментарий не добавлен';
}
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
header_safe('../../Pages/Idea/'.$_POST['page_url']);
?>