<?php
require_once '../../Assets/TemplatesPages/header.php';
$q = 'SELECT `id`,`IdeaTitle`,`IdeaDescription`,`IdeaDate`,`IdeaActive` FROM `ideas` ORDER BY `IdeaDate` DESC';
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
if(empty($_SESSION['login'])){
  header_safe(SITE_URL.'regform.php');
}else{
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
    <h1 class="mt-5">Список всех идей</h1>
    <p class="lead">Идеи которые пишут пользователи, создавайте и просматривайте идеи друих пользователей!</p>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
      <a href="func/add_idea.php" class="btn btn-success"><i class="bi bi-plus-square mx-1"></i>Добавить идею</a>
      <?php 
      if($_SESSION['role'] > 0){
        echo '<a href="func/" class="btn btn-danger"><i class="bi bi-dash-square mx-1"></i>Удалить все идеи</a>';
      }
      ?>
    </div>

    <!-- Main -->

    <!-- Start card -->
    <?php 
    if($data){
      foreach($data as $d){
        if($d['IdeaActive'] == 1){
          $IdeaDescription = $d['IdeaDescription'];
          if(mb_strlen($IdeaDescription) > 80){ // Функция для показания сколько символов в тексте
            $IdeaDescription = mb_substr($IdeaDescription,0,80); // Функция берёт и отрезает часть строки
            $IdeaDescription .= '...';
          }
          echo '
          <div class="mt-3">
            <div class="card">
        <div class="card-body">
          <p class="float-end text-break">'.$d['IdeaDate'].'</p>
          <h5 class="card-title fs-2 pr-2">'.$d['IdeaTitle'].'</h5>
          <!--h6 class="card-subtitle mb-3">
            <span class="badge bg-secondary">Тег идеи</span>
          </h6-->
          <p class="card-text">'.strip_tags($IdeaDescription).'</p>
          <a href="../Idea/'.$d['id'].'" class="btn btn-primary float-end">Открыть идею</a>
        </div>
      </div>
    </div>
          ';
        }
      }
    }else{
      echo '<h1 class="text-center mt-5">Идей пока нету :(</h1>';
    }
    ?>
    <!-- End card -->

  </div>
</main>
<?php
require '../../Assets/TemplatesPages/footer.php';
?>