<?php 
session_start();
date_default_timezone_set('Europe/Moscow');
require_once "functions.php";
require_once 'cfg.php';
 // Система изменения тайтла в зависимости от страницы
if(!empty($_SESSION['page_url']) && !empty($_SESSION['page_title'])){
  $titles = array('index.php' => 'Главная страница',
                  'regform.php' => 'Регистрация на сайте',
                  'loginform.php' => 'Вход на сайт', 
                  'page.php?url='.$_SESSION['page_url'] => 'Страница - '.$_SESSION['page_title'],
                  'page.php?url=' => 'Страница - '.$_SESSION['page_title'],
                  'page.php' => $_SESSION['page_title']
  );
}else{
  $titles = array('index.php' => 'Главная страница',
                  'regform.php' => 'Регистрация на сайте',
                  'loginform.php' => 'Вход на сайт');
}
$url = $_SERVER['REQUEST_URI']; // Получаем юрл на котором щас
$url = explode('/', $url); // Разделяем всё
$url = array_pop($url); // Получаем только сам файл (имя)
if(isset($titles[$url])){ // Проверка если в массиве есть такой файл то устанавливаем, если нет то устанавливаем стандартое значение
  $title = $titles[$url];
}else{
  $title = 'Парламент 540 - Страница';
}
?>
<!-- Site made by PeterIvanov (Keldowin) 2022 -->
<!DOCTYPE html>
<html lang="ru" class="h-100">
<head>
    <link rel="shortcut icon" href="<?=SITE_URL?>Assets/img/EarthGlobe_60px.png" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?=$title?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.2/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
    <style>
    pre {
        overflow: visible;
    }
    </style>
</head>

<body class="d-flex flex-column h-100">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="<?=SITE_URL?>">Парламент 540</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <ul class="navbar-nav">
                    <?php 
          $q = 'SELECT * FROM `menu` WHERE `parent_id` = 0 ORDER BY `sort` ';
          $res = mysqli_query($link, $q);
          $menu = mysqli_fetch_all($res, MYSQLI_ASSOC);
          foreach ($menu as $key) {
            $q = 'SELECT * FROM `menu` WHERE `parent_id` = '.$key['id'].' ';
            $res = mysqli_query($link,$q);
            $sub_menu = mysqli_fetch_all($res, MYSQLI_ASSOC);
            if(!empty($sub_menu)){
              echo ' <li class="nav-item dropdown">  
            <a class="nav-link dropdown-toggle" href="'.$key['href'].'" data-bs-toggle="dropdown">'.$key['title'].'</a>
            <ul class="dropdown-menu" aria-labelledby="dropdownXxl">';
            foreach($sub_menu as $sm){
              echo '<li class="nav-item"><a class="nav-link" style="color:black;" aria-current="page" href="'.$sm['href'].'">'.$sm['title'].'</a></li>';
            }
           echo ' </ul>
          </li>';


            }else{
            echo '<li class="nav-item">
            <a class="nav-link" aria-current="page" href="'.$key['href'].'">'.$key['title'].'</a>
          </li>';
            }
          }
          ?>
                </ul>
            </div>
            <?php 
        $logintext = '';
        $logintext2 = '';
        if (!empty($_SESSION['login'])){
          $logintext = '<a class="navbar-brand btn btn-danger p-2 fs-6 fw-normal" href="'.SITE_URL.'exit.php">'.$_SESSION['login'].' (Выйти)</a>';
          if($_SESSION['role'] == 2){
            $logintext2 = '<a href="'.SITE_URL.'Pages/Admin/index.php" class="navbar-brand btn btn-primary p-2 fs-6 fw-normal">Войти в админку</a>';
          }else{
            $logintext2 = '';
          }
        }
      ?>
            <?=$logintext?><?=$logintext2?>
        </div>
    </nav>