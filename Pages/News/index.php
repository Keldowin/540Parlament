<?php
require_once '../../Assets/TemplatesPages/header.php';
$q = 'SELECT `id`,`NewsTitle`,`NewsDesc`,`NewsDate`,`NewsActive`,`NewsUserId` FROM `news` ORDER BY `NewsDate` DESC';
$data = mysqli_query($link,$q);
$data = MyFetch($data);

$errors = array();
$success = array();

if (!empty($_SESSION['success'])) {
  $success = $_SESSION['success'];
  unset($_SESSION['success']);
}
if (!empty($_SESSION['errors'])) {
  $error = $_SESSION['errors'];
  unset($_SESSION['errors']);
}
if (empty($_SESSION['login'])) {
  header_safe(SITE_URL . 'regform.php');
} else {
  $login = $_SESSION['login'];
}
?>
<main class="flex-shrink-0">
  <div class="container">
    <?php
    require '../../Assets/TemplatesPages/alerts.php';
    alert('danger', $errors);
    alert('success', $success);
    ?>
    <h1 class="mt-5">Новости</h1>
    <p class="lead">Объявления и новости в парламенте 540</p>
    <div class="container">
      <div class="row row-cols-3">

        <div class="col mt-3">
          <div class="card">
            <img src="https://web1182.craft-host.ru/540site/Files/7dcc7d5461b665569f083c45724949bf.png" class="card-img-top" alt="...">
            <div class="card-body">
              <h4 class="card-title">Заголовок новости</h4>
              <p class="card-text">Краткое содержание новости бла бла бла бла</p>
              <a href="#" class="btn btn-primary">Перейти</a>
            </div>
            <div class="card-footer mt-2">
                <small class="text-muted">Создатель: Кто-то | 2022-12-13 22:16:48</small>
              </div>
          </div>
        </div>
      </div>
    </div>
</main>
<?php
require '../../Assets/TemplatesPages/footer.php';
?>