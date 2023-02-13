<?php
require_once 'Assets/TemplatesPages/header.php';
if(empty($_SESSION['login'])){
  header_safe(SITE_URL.'regform.php');
}else{
  $login = $_SESSION['login'];
}
?>
<main class="flex-shrink-0">
  <div class="container">
    <h1 class="mt-5">Приветствуем тебя пользователь - <?= $login ?></h1>
    <h5>Используй меню сайта чтобы открыть нужную страницу!</h5>
  </div>
</main>
<?php
require 'Assets/TemplatesPages/footer.php';
?>