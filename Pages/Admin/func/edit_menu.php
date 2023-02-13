<?php 
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';

$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');

//Код при отправки формы
if(isset($_POST['go'])){
    if((!empty($_POST['title']) && !empty($_POST['href']) && !empty($_POST['sort']))){
        $q = 'UPDATE `menu` SET `parent_id`='.$_POST['parent_id'].',`title`="'.$_POST['title'].'",`href`="'.$_POST['href'].'",`sort`='.$_POST['sort'].' WHERE `id` = '.$id.'';
        $res = mysqli_query($link, $q);
        alerts('success','Элемент меню успешно отредактирован');
    }else{
        alerts('danger','Ошибка, не все поля заполнены');
    }
}

$q = 'SELECT * FROM `menu` WHERE `id` = '.$id.'';
$res = mysqli_query($link,$q);
$data = MyFetch($res);

$q = 'SELECT `id`,`title` FROM `menu`';
$res = mysqli_query($link,$q);
$menuArr = MyFetch($res);
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Редактировать элемент в блок-меню</h1>
        <br><br>
        <form method="post">
            <div class="mb-2">
                <lable class="form-lable">Родитель (ID)</lable>
                <select class="form-select" aria-label="Default select example" name="parent_id">
                    <?php 
                    foreach($menuArr as $m){
                        $s = '';
                        if($m['id'] == $data[0]['parent_id']){
                            $s = 'selected';
                        }
                        echo '<option value="'.$m['id'].'" '.$s.'>'.$m['title'].' - '.$m['id'].'</option>';
                    }
                    ?>
                    <option value="0">Нет</option>
                </select>
            </div>
            <div class="mb-3">
                <lable class="form-lable">Ссылка</lable>
                <input type="text" class="form-control" name="href" value="<?=$data[0]['href']?>" placeholder="Ссылка">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Текст кнопки</lable>
                <input type="text" class="form-control" name="title" value="<?=$data[0]['title']?>" placeholder="Введите текст">
            </div>
            <div class="form-check">
                <lable class="form-lable">Порядок</lable>
                <input type="number" class="form-control" min="0" max="9999" name="sort" value="<?=$data[0]['sort']?>">
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-warning" name='go'>Обновить</button>
            <a href="../menu.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<?php 
require_once '../footer.php';
?>