<?php 
require_once 'header.php';
require_once '../../Assets/TemplatesPages/functions.php';
require_once '../../Assets/TemplatesPages/cfg.php';

// ЗАПРОСЫ
// Запрос сколько страниц
$q = 'SELECT `id` FROM `page`';
$res = mysqli_query($link,$q);
$pagecount = MyFetch($res);
$pagecount = count($pagecount);

//Запрос сколько комментариев
$q = 'SELECT `id` FROM `comment`';
$res = mysqli_query($link,$q);
$commentcount = MyFetch($res);
$commentcount = count($commentcount);

//Запрос сколько блок меню
$q = 'SELECT `id` FROM `menu`';
$res = mysqli_query($link,$q);
$menucount = MyFetch($res);
$menucount = count($menucount);

//Запрос сколько пользователей
$q = 'SELECT `id` FROM `users`';
$res = mysqli_query($link,$q);
$userscount = MyFetch($res);
$userscount = count($userscount);

//Запрос сколько файлов
$files = scandir('../'.DIRECTORY_SEPARATOR.UPLOAD_DIR);
array_shift($files);
array_shift($files);
$files = count($files);
?>
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Админка</h1>
    <ul>
      <li>Страниц: <?=$pagecount?></li>
      <li>Комментариев: <?=$commentcount?></li>
      <li>Меню блоков: <?=$menucount?></li>
      <li>Пользователей: <?=$userscount?></li>
      <li>Файлов: <?=$files?></li>
    <ul>
  </div>
</main>