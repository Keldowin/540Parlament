<?php
require_once '../../../Assets/TemplatesPages/header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';
if (empty($_SESSION['login'])) {
    header_safe(SITE_URL.'regform.php');
}
// Загрузка
$id = isset($_GET['id']) ? $_GET['id'] : exit('Ошибка | Отсуствует id');

$q = 'SELECT * FROM `ideas` WHERE `id` = ' . $id . '';
$res = mysqli_query($link, $q);
$data = MyFetch($res);

$IdeaTitle = $data[0]['IdeaTitle'];
$IdeaDesc = $data[0]['IdeaDescription'];

$q = 'SELECT * FROM `files` WHERE `FilePlaceId` = "idea_' . $id . '"';
$res = mysqli_query($link, $q);
$files = MyFetch($res);

function reArrayFiles(&$file_post)
{

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i = 0; $i < $file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
//Код при отправки формы
$alloweFileExt = array('jpg', 'gif', 'png', 'txt', 'zip', 'jpeg');
if (isset($_POST['go'])) {
    if (!empty($_POST['title'])) {
        $date = date('Y-m-d H:i:s - ред.');
        $q = 'UPDATE `ideas` SET `IdeaTitle`="'.$_POST['title'].'",`IdeaDescription`="'.$_POST['content'].'",`IdeaDate`="'.$date.'" WHERE `id` = '.$id.'';
        $res_main = mysqli_query($link, $q);

        if ($_FILES['userfile'] && count($_FILES['userfile']) > 0) {
            $file_ary = reArrayFiles($_FILES['userfile']);
            foreach ($file_ary as $file) {
                $fileName = $file['name'];
                $fileExt = getFileExt($fileName);
                if ($file['error'] != 1 || $file['error'] != 2) {
                    if (!in_array($fileExt, $alloweFileExt) && !isset($fileExt)) { // in_array() - определяет есть ли значение в массиве
                        alerts('danger','Недопустимый формат файла');
                    } else {
                        // Если всё правильно
                        $newFileName = genFileName($fileName);
                        
                        // Путь куда файл загружается
                        $destPath = UPLOAD_PATH . $newFileName;
                        if (move_uploaded_file($file['tmp_name'], $destPath)) {
                            $AlertText = 'Файл ' . $file['name'] . ' успешно скопирован';
                            alerts('success', $AlertText);
                            // Добалвение в базу данных
                            $q = 'INSERT INTO `files`(`FileTitle`,`FileDir`,`FilePlaceId`) VALUES ("' . $file['name'] . '","' . $newFileName . '","idea_' . $id . '")';
                            $res = mysqli_query($link, $q);
                        }
                    }
                }
            }
        }
        if($res_main){
            alerts('success','Идея отредактирована!');
            header_safe(SITE_URL.'Pages/Ideaslist/func/edit_idea.php?id='.$id);
        }
    } else {
        alerts('danger','Ошибка, не все поля заполнены');
    }
}


// При удалении фотографии
if(isset($_GET['del'])){
    $idimg = $_GET['imgid'];
    // Получаем то самое фото чтобы убедиться что оно есть
    $q = 'SELECT `FileDir` FROM `files` WHERE `id` = '.$idimg.'';
    $res = mysqli_query($link, $q);
    $filedata = MyFetch($res);
    $filename = $filedata[0]['FileDir'];

    if($filedata){
        if(unlink(UPLOAD_PATH.$filename)){
            alerts('success','Файл уcпешно удалён');
            $q = 'DELETE FROM `files` WHERE `FileDir` = "'.$filename.'"';
            $res = mysqli_query($link,$q);
            header_safe(SITE_URL.'Pages/Ideaslist/func/edit_idea.php?id='.$id);
        }else{
            alerts('danger','Ошибка удаления');
        }
    }else{
        alerts('danger','Файла не существует');
    }
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Редактировать идею</h1>
        <br><br>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <lable class="form-lable">Заголовок идеи</lable>
                <input type="text" class="form-control" name="title" value="<?= $IdeaTitle ?>" placeholder="Введите заголовок">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Содержание страницы</lable>
                <textarea type="text" class="form-control" name="content" rows="4" placeholder="Введите текст"><?= $IdeaDesc ?></textarea>
            </div>
            <div class="mb-3">
                <lable class="form-lable">Загруженные файлы</lable>
                <div class="card mt-2 fs-5 fs-normal">
                    <div class="card-body">
                            <?php // Файлы 
                                if ($files) {
                                    foreach ($files as $f) {
                                        echo '
                                    <div class="card mb-3">
                                <div class="card-body">
                                    <h5 class="card-title">' . $f['FileTitle'] . '</h5>
                                    <a href="../../../Files/' . $f['FileDir'] . '" class="card-link text-success" download>Скачать</a>
                                    <a href="../../../Files/' . $f['FileDir'] . '" class="card-link" target="_blank">Открыть</a>
                                    <a href="?del&imgid='.$f['id'].'&id='.$id.'" class="card-link text-danger">Удалить</a>
                                </div>
                            </div>
                                    ';
                                    }
                                } else {
                                    echo '<p>Файлов никаких нет</p>';
                                }
                            ?>
                    </div>
                </div>
            </div>
            <div class="mb-3">
                <lable class="form-lable">Загрузить ещё файлы (txt,png,gif,png,zip,jpg) не больше 10мб</lable>
                <input name="userfile[]" class="form-control" type="file" multiple accept=".jpg, .jpeg, .png, .txt, .gif, .zip" />
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-success" name='go'>Обновить</button>
            <a href="<?=SITE_URL?>Pages/Idea/<?=$id ?>" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<script src="https://cdn.tiny.cloud/1/5kg8i7e1yff7okhyt50ndkc0v0zldtuyoxvalzqjle0y7p6q/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>let docBaseUrl = '<?=SITE_URL?>';</script>
<script src='<?=SITE_URL?>Assets/js/tiny.js'></script>
<?php
require_once '../../../Assets/TemplatesPages/footer.php';
?>