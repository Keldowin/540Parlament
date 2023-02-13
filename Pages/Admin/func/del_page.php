<?php 
session_start();
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошбика | Отсуствует id');

if(!empty($id)){
//Удаление страницы
$q = 'DELETE FROM `page` WHERE `id` = '.$id.'';
$res = mysqli_query($link,$q);

//Удаление коментов
$q = 'DELETE FROM `comment` WHERE `page_id` = '.$id.'';
$res = mysqli_query($link,$q);
if($res){
    $success[] = 'Страница удалена';
}else{
    $errors[] = 'Ошибка, страница не удалена';
}
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
header_safe('../pages.php');
}else{
    $errors[] = 'Ошибка id';
}
?>