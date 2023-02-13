<?php 
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';

// Получаем данные страницы
$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');
$q = 'SELECT * FROM `page` WHERE `id` = '.$id.'';
$res = mysqli_query($link,$q);
$page_data = MyFetch($res);

//Код при отправки формы
if(isset($_POST['go'])){
    $content = mysqli_real_escape_string($link, $_POST['content']);
    $active = 0;
    if(!empty($_POST['active'])){
        $active = 1;
    }
    $q = 'UPDATE `page` SET `url`="'.$_POST['url'].'",`title`="'.$_POST['title'].'",`content`="'.$content.'",`active`='.$active.' WHERE `id` = '.$id.'';
    $res = mysqli_query($link, $q);
    if($res){
        alerts('success','Страница обновлена');
    }else{
        alerts('danger','Ошибка, страница не обновлена');
        $error = mysqli_error($link);
        echo $error;
    }
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Редактировать страницу</h1>
        <br><br>
        <form method="post">
            <div class="mb-2">
                <lable class="form-lable">page?url=</lable>
                <input type="text" class="form-control" value="<?=$page_data[0]['url']?>" name="url" placeholder="Введите ссылку">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Заголовок</lable>
                <input type="text" class="form-control" name="title" value="<?=$page_data[0]['title']?>" placeholder="Введите заголовок">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Содержание страницы</lable>
                <textarea type="text" class="form-control" name="content" rows="3"><?=$page_data[0]['content']?></textarea>
            </div>
            <div class="form-check">
                <lable class="form-lable">Отображать страницу</lable>
                <input type="checkbox" class="form-check-input" name="active" value="1" <?php if($page_data[0]['active'] = 1){echo 'checked';}?>>
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-warning" name='go'>Обновить</button>
            <a href="../pages.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<script src="https://cdn.tiny.cloud/1/5kg8i7e1yff7okhyt50ndkc0v0zldtuyoxvalzqjle0y7p6q/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>let docBaseUrl = 'https://web1182.craft-host.ru/540site/';</script>
<script src='<?=SITE_URL?>Assets/js/tiny.js'></script>
<?php 
require_once '../footer.php';
?>