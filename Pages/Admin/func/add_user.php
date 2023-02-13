<?php 
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';

//Код при отправки формы
if(isset($_POST['go'])){
    if(!empty($_POST['login']) && !empty($_POST['password'])){
        $hash = password_hash($_POST['password'], PASSWORD_DEFAULT);
        $active = 0;
        if(!empty($_POST['active'])){
            $active = 1;
        }
        $admin = 0;
        if(!empty($_POST['admin'])){
            $admin = 1;
        }
        $date = date('Y-m-d');
        $q = 'INSERT INTO `users` (`login`,`pass`,`active`,`admin`,`date`) VALUES ("'.$_POST['login'].'","'.$hash.'","'.$active.'",'.$admin.',"'.$date.'")';
        $res = mysqli_query($link, $q);
        if($res){
            alerts('success','Пользователь успешно добавлен');
        }
    }else{
        alerts('danger','Ошибка, не все поля заполнены');
    }
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Добавить пользователя</h1>
        <br><br>
        <form method="post">
            <div class="mb-2">
                <lable class="form-lable">Логин</lable>
                <input type="text" class="form-control" name="login" placeholder="Введите имя">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Пароль</lable>
                <input type="text" class="form-control" name="password" placeholder="Введите пароль">
            </div>
            <div class="form-check">
                <lable class="form-lable">Админ</lable>
                <input type="checkbox" class="form-check-input" name="admin" value="0">
            </div>
            <div class="form-check">
                <lable class="form-lable">Активен</lable>
                <input type="checkbox" class="form-check-input" name="active" value="1" checked>
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-success" name='go'>Создать</button>
            <a href="../users.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<?php 
require_once '../footer.php';
?>