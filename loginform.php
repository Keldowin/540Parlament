<?php
require_once "Assets/TemplatesPages/header.php";
?> 

<main class="flex-shrink-0">
  <div class="container">
    <?php
    require_once "Assets/TemplatesPages/alerts.php";
if(isset($_POST['go'])){
    if(empty($_POST['login']) || empty($_POST['password'])){
        alerts('danger', $errors[0]);
    }else{
        $q = 'SELECT * FROM `users` WHERE `login` = "'.$_POST['login'].'"';
        $res = mysqli_query($link, $q);
        $cheak_user = MyFetch($res);
        if($cheak_user){
            $hash = $cheak_user[0]['pass'];
            $pass = $_POST['password'];
            if(password_verify($pass, $hash)){
                if($cheak_user[0]['active'] != 1){
                  alerts('danger','Вы были забанены админом');
                }else{
                $_SESSION['login'] = $_POST['login'];
                $_SESSION['id'] = $cheak_user[0]['id'];
                $_SESSION['role'] = $cheak_user[0]['role'];
                header_safe('index.php');
              }
            }else{
                alerts('danger', 'Не правильный пароль или логин');
            }
        }else{
            alerts('danger', 'Такого пользователя нет');
        }
    }
}
    ?>
    <h1 class="mt-5">Вход</h1>
    <p class="lead">Войдите в свой аккаунт</p>

    <form method="post">
	  <div class="mb-3">
	    <label for="login" class="form-label">Логин</label>
	    <input type="text" class="form-control" id="login" name="login">
	  </div>
	  <div class="mb-3">
	    <label for="password1" class="form-label">Пароль</label>
	    <input type="password" class="form-control" id="password" name="password">
	  </div>		  	  	  
	  <button type="submit" class="btn btn-primary" name = 'go'>Войти</button>
      <div class="mb-3">
	    <a href="regform.php">Нет аккаунта</a>
	  </div>
	</form>

  </div>
</main>

<?php
  require_once "Assets/TemplatesPages/footer.php";
?> 