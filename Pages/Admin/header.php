<?php session_start();?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <?php
  // Система изменения тайтла в зависимости от страницы
  $titles = array('index.php' => 'Главная страница',
                  'comments.php' => 'Комментарии на сайте',
                  'menu.php' => 'Блок-элементы меню', 
                  'users.php' => 'Пользователи', 
                  'pages.php' => 'Страницы',
                  'files.php' => 'Файлы'
  );
  $url = $_SERVER['REQUEST_URI']; // Получаем юрл на котором щас
  $url = explode('/', $url); // Разделяем всё
  $url = array_pop($url); // Получаем только сам файл
  if(isset($titles[$url])){ // Проверка если в массиве есть такой файл то устанавливаем, если нет то устанавливаем стандартое значение
    $title = $titles[$url];
  }else{
    $title = 'Парламент 540 - Админка';
  }
  ?>
  <title><?=$title?></title>
  <link rel="shortcut icon" href="https://web1182.craft-host.ru/540site/Assets/img/EarthGlobe_60px.png" type="image/png">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</head>
<?php 
if(!empty($_SESSION['login'])){
  if($_SESSION['role'] != 2){
    echo '<script>window.location.href = "https://web1182.craft-host.ru/540site/"</script>';
  }
}else{
  echo '<script>window.location.href = "https://web1182.craft-host.ru/540site/"</script>';
}
if(empty($_SESSION['login'])){
  header_safe('https://web1182.craft-host.ru/540site/regform.php');
}else{
  $login = $_SESSION['login'];
}
?>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container">
    <a class="navbar-brand" href="../index.php">ИдеиТГ - Админка</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup" aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
      <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
         <ul class="navbar-nav">
         <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/" target="_blank">Сайт</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/Pages/Admin/">Админка</a>
          </li>  
          <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/Pages/Admin/pages.php">Страницы</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/Pages/Admin/comments.php">Комментарии</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/Pages/Admin/menu.php">Меню</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/Pages/Admin/users.php">Пользователи</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="https://web1182.craft-host.ru/540site/Pages/Admin/files.php">Файлы</a>
          </li>
      </div>
  </div>
</nav>