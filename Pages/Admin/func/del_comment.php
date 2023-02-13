<?php 
session_start();
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');

if(!empty($id)){
//Удаление коментов
$q = 'DELETE FROM `comment` WHERE `id` = '.$id.'';
$res = mysqli_query($link,$q);
if($res){
    $success[] = 'Комментарий удалён';
}else{
    $errors[] = 'Ошибка, комментарий не удалён';
}
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
header_safe('../comments.php');
}else{
    $errors[] = 'Ошибка id';
}
?>