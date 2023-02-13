<?php 
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';

//Код при отправки формы
if(isset($_POST['go'])){
    if(!empty($_POST['url']) && !empty($_POST['title']) && !empty($_POST['content'])){
        $content = mysqli_real_escape_string($link, $_POST['content']);
        $active = 0;
        if(!empty($_POST['active'])){
            $active = 1;
        }
        $q = 'INSERT INTO `page` (`url`,`title`,`content`,`active`) VALUES ("'.$_POST['url'].'","'.$_POST['title'].'","'.$content.'",'.$active.')';
        $res = mysqli_query($link, $q);
        alerts('success','Страница успешно добавлена');
    }else{
        alerts('danger','Ошибка, не все поля заполнены');
    }
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Добавить страницу</h1>
        <br><br>
        <form method="post">
            <div class="mb-2">
                <lable class="form-lable">page?url=</lable>
                <input type="text" class="form-control" name="url" placeholder="Введите ссылку">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Заголовок</lable>
                <input type="text" class="form-control" name="title" placeholder="Введите заголовок">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Содержание страницы</lable>
                <textarea type="text" class="form-control" name="content" rows="3" placeholder="Введите текст"></textarea>
            </div>
            <div class="form-check">
                <lable class="form-lable">Отображать страницу</lable>
                <input type="checkbox" class="form-check-input" name="active" value="1" checked>
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-success" name='go'>Создать</button>
            <a href="../pages.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<script src="https://cdn.tiny.cloud/1/5kg8i7e1yff7okhyt50ndkc0v0zldtuyoxvalzqjle0y7p6q/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>let docBaseUrl = 'https://web1182.craft-host.ru/540site/';</script>
<script src='../../../Assets/js/tiny.js'></script>
<?php 
require_once '../footer.php';
?>