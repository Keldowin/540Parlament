<?php 
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');

//Код при отправки формы
if(isset($_POST['go'])){
    if(!empty($_POST['login'])){
        $active = 0;
        if(!empty($_POST['active'])){
            $active = 1;
        }
        $role = 0;
        if(!empty($_POST['role'])){
            $role = $_POST['role'];
        }
        $q = 'UPDATE `users` SET `login`="'.$_POST['login'].'",`active`="'.$active.'",`role`='.$role.' WHERE `id` = '.$id.'';
        $res = mysqli_query($link, $q);
        alerts('success','Пользователь успешно отредактирован');
    }else{
        alerts('danger','Ошибка, не все поля заполнены');
    }
}

$q = 'SELECT * FROM `users` WHERE `id` = '.$id.'';
$res = mysqli_query($link,$q);
$data = MyFetch($res);
if(!$data){
    exit('Пользователь был удалён');
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Редактировать пользователя - <b><?=$data[0]['login'] ?></b></h1>
        <br><br>
        <form method="post">
            <div class="mb-3">
                <lable class="form-lable">Логин</lable>
                <input type="text" class="form-control" name="login" value="<?=$data[0]['login']?>" placeholder="Ссылка">
            </div>
            <div class="form-check">
                <lable class="form-lable">Роль</lable>
                <input type="number" class="form-control" min="0" max="4" name="role" value="<?=$data[0]['role']?>">
            </div>
            <div class="form-check">
                <lable class="form-lable">Активен</lable>
                <input type="checkbox" class="form-check-input" name="active" <?php if($data[0]['active'] != 0){echo 'checked';} ?>>
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-warning" name='go'>Обновить</button>
            <a href="../users.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<?php 
require_once '../footer.php';
?>