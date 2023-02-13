<?php 
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';

//Код при отправки формы
if(isset($_POST['go'])){
    if(!empty($_POST['title']) && !empty($_POST['href']) && !empty($_POST['sort'])){
        $q = 'INSERT INTO `menu` (`parent_id`,`href`,`title`,`sort`) VALUES ("'.$_POST['parent_id'].'","'.$_POST['href'].'","'.$_POST['title'].'","'.$_POST['sort'].'")';
        $res = mysqli_query($link, $q);
        alerts('success','Элемент меню успешно добавлен');
    }else{
        alerts('danger','Ошибка, не все поля заполнены');
    }
}

$q = 'SELECT `id`,`title` FROM `menu`';
$res = mysqli_query($link,$q);
$menuArr = MyFetch($res);
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Добавить элемент в блок-меню</h1>
        <br><br>
        <form method="post">
            <div class="mb-2">
                <lable class="form-lable">Родитель (ID)</lable>
                <select class="form-select" aria-label="Default select example" name="parent_id">
                    <?php 
                    foreach($menuArr as $m){
                        echo '<option value="'.$m['id'].'">'.$m['title'].' - '.$m['id'].'</option>';
                    }
                    ?>
                    <option value="0" selected>Нет</option>
                </select>
            </div>
            <div class="mb-3">
                <lable class="form-lable">Ссылка</lable>
                <input type="text" class="form-control" name="href" placeholder="Ссылка">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Текст кнопки</lable>
                <input type="text" class="form-control" name="title" placeholder="Введите текст">
            </div>
            <div class="form-check">
                <lable class="form-lable">Порядок</lable>
                <input type="number" class="form-control" min="0" max="9999" name="sort" value="555">
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-success" name='go'>Создать</button>
            <a href="../menu.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<?php 
require_once '../footer.php';
?>