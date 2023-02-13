<?php
require_once "Assets/TemplatesPages/header.php";

function cheak_session(){
    if(empty($_SESSION['password1']) || empty($_SESSION['login'])){
        $_SESSION['password1'] = '';
        $_SESSION['login'] = '';
        $_SESSION['role'] = '';
    }
}
cheak_session();
function clear_session(){
    $_SESSION['password1'] = '';
    $_SESSION['login'] = '';
    $_SESSION['role'] = '';
}
?> 

<main class="flex-shrink-0">
  <div class="container">
    <?php
require_once "Assets/TemplatesPages/alerts.php";
if(isset($_POST['go'])){
    $login = $_POST['login'];
    $Password1 = $_POST['password1'];
    $Password2 = $_POST['password2'];
    $SecPassword = $_POST['security-password'];



    if(empty($login) || empty($Password1) || empty($Password2) || empty($SecPassword)){
        alerts('danger', $error[0]);
    }else{
        if($Password1 != $Password2){
            $_SESSION['password1'] = $Password1;
            $_SESSION['login'] = $login;
            alerts('danger', $error[3]);
        }else{
            if($SecPassword == 12345){
              $q = 'SELECT * FROM `users` WHERE `login` = "'.$login.'"';
              $res = mysqli_query($link, $q);
              $cheak_login = MyFetch($res);
              if(!$cheak_login){;
                  $date = date('Y-m-d');
                  $passwordHASH = password_hash($Password1, PASSWORD_DEFAULT);
                  $q = 'INSERT INTO `users` (`login`,`pass`,`date`,`active`,`role`) VALUES ("'.$login.'","'.$passwordHASH.'","'.$date.'",1,0)';
                  $res = mysqli_query($link, $q);
                  if(!$res) {
                      $error = mysqli_error($link); // Возвращает последнюю ошибку выполнения SQL запроса
                      exit("Ошибка MySQL: " . $error);
                  }
                  header_safe('loginform.php');
              }else{
                  clear_session();
                  alerts('danger', $error[2]);
              }
            }
        }
    }
}
    ?>
    <h1 class="mt-5">Регистрация</h1>
    <p class="lead">Чтобы оставлять создавать идеи, писать комментарии, вам необходимо пройти регистрацию</p>

    <form method="post">
	  <div class="mb-3">
	    <label for="login" class="form-label">Логин</label>
	    <input type="text" class="form-control" id="login" name="login" value="<?=$_SESSION['login']?>">
	  </div>
	  <div class="mb-3">
	    <label for="password1" class="form-label">Пароль</label>
	    <input type="password" class="form-control" id="password1" name="password1" value="<?=$_SESSION['password1']?>">
	  </div>
	  <div class="mb-3">
	    <label for="password2" class="form-label">Подтверждение пароля</label>
	    <input type="password" class="form-control" id="password2" name="password2">
	  </div>		  	  	
    <div class="mb-3">
	    <label for="security-password" class="form-label">Код защита</label>
	    <input type="password" class="form-control" id="security-password" name="security-password" placeholder="Код можно узнать в телеграмм канале">
	  </div>		   
	  <button type="submit" class="btn btn-primary" name="go">Зарегистрироваться</button>
      <div class="mb-3">
	    <a href="loginform.php">Уже есть аккаунт</a>
	  </div>
	</form>

  </div>
</main>

<?php
  require_once "Assets/TemplatesPages/footer.php";
?> 