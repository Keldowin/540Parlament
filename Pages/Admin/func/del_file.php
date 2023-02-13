<?php 
session_start();
require_once '../../../Assets/TemplatesPages/cfg.php';

$name = isset($_GET['name']) ? $_GET['name'] : exit('Ошибка | Отсуствует name');
if(unlink(UPLOAD_PATH.$name)){
    $_SESSION['success'][] = 'Файл уcпешно удалён';
    $q = 'DELETE FROM `files` WHERE `FileDir` = "'.$name.'"';
    $res = mysqli_query($link,$q);
}else{
    $_SESSION['errors'][] = 'Ошибка удаления';
}
header('Location: ../files.php');
?>