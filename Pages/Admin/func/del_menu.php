<?php 
session_start();
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');

//Удаление коментов
$q = 'DELETE FROM `menu` WHERE `id` = '.$id.'';
$res = mysqli_query($link,$q);
if($res){
    $success[] = 'Элемент-меню удалён';
}else{
    $errors[] = 'Ошибка, элемент-меню  не удалён';
}
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
header_safe('../menu.php');
?>