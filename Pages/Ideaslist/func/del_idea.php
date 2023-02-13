<?php 
session_start();
if (empty($_SESSION['login'])) {header_safe(SITE_URL.'regform.php');}
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');

//Удаление идеи
if(!$_SESSION['role'] >= 2){
    $q = 'DELETE FROM `ideas` WHERE `id` = '.$id.' AND `IdeaUserId` = '.$_SESSION['id'].''; // Защита от дурака, в запросе есть проверки по айди пользователя
}else{
    $q = 'DELETE FROM `ideas` WHERE `id` = '.$id.''; // Если мы админ то никак проверки нету
}
$res = mysqli_query($link,$q);
if($res){
    $success[] = 'Идея удалена';
}else{
    $errors[] = 'Ошибка, идея не удалена';
}
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
header_safe(SITE_URL.'Pages/Ideaslist/');
?>