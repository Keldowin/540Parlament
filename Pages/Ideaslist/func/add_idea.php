<?php 
require_once '../../../Assets/TemplatesPages/header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../../Assets/TemplatesPages/cfg.php';
require_once '../../../Assets/TemplatesPages/alerts.php';
if (empty($_SESSION['login'])) {header_safe(SITE_URL.'regform.php');}
function reArrayFiles(&$file_post) {

    $file_ary = array();
    $file_count = count($file_post['name']);
    $file_keys = array_keys($file_post);

    for ($i=0; $i<$file_count; $i++) {
        foreach ($file_keys as $key) {
            $file_ary[$i][$key] = $file_post[$key][$i];
        }
    }

    return $file_ary;
}
//Код при отправки формы
$alloweFileExt = array('jpg', 'gif', 'png', 'txt', 'zip', 'jpeg');
$Accept = 0;
if(isset($_POST['go'])){
    if(!empty($_POST['title']) && !empty($_POST['content'])){
        $date = date('Y-m-d H:i:s');
        $q = 'INSERT INTO `ideas` (`IdeaTitle`,`IdeaDescription`,`IdeaDate`,`IdeaUserId`) VALUES ("'.$_POST['title'].'","'.$_POST['content'].'","'.$date.'",'.$_SESSION['id'].')';
        $res_main = mysqli_query($link, $q);

        $lastid = mysqli_insert_id($link);

        if ($_FILES['userfile'] && count($_FILES['userfile']) > 0) {
            $file_ary = reArrayFiles($_FILES['userfile']);
            foreach ($file_ary as $file) {
                $fileName = $file['name'];
                $fileExt = getFileExt($fileName);

                if($file['error'] != 1 || $file['error'] != 2){
                    if(!in_array($fileExt, $alloweFileExt) && !isset($fileExt)){ // in_array() - определяет есть ли значение в массиве
                        $errors[] = 'Недопустимый формат файла';
                    }else{
                        // Если всё правильно
                        $newFileName = genFileName($fileName);
                    
                        // Путь куда файл загружается
                        $destPath = UPLOAD_PATH.$newFileName;
                        if(move_uploaded_file($file['tmp_name'], $destPath)){
                            $AlertText = 'Файл '.$file['name'].' успешно скопирован';
                            alerts('success',$AlertText);

                            // Добалвение в базу данных
                            $q = 'INSERT INTO `files`(`FileTitle`,`FileDir`,`FilePlaceId`) VALUES ("'.$file['name'].'","'.$newFileName.'","idea_'.$lastid.'")';
                            $res = mysqli_query($link, $q);
                        }
                    }
            }
        }
        if($res_main){
            $success[] = 'Идея создана!';
            header_safe(SITE_URL.'Pages/Idea/'.$lastid);
        }
    }
}else{
    alerts('danger','Ошибка, не все поля заполнены');
}
}
$_SESSION['errors'] = $errors;
$_SESSION['success'] = $success;
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Добавить идею</h1>
        <br><br>
        <form method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <lable class="form-lable">Заголовок идеи</lable>
                <input type="text" class="form-control" name="title" placeholder="Введите заголовок">
            </div>
            <div class="mb-3">
                <lable class="form-lable">Содержание страницы</lable>
                <textarea type="text" class="form-control" name="content" rows="4" placeholder="Введите текст"></textarea>
            </div>
            <div class="mb-3">
                <lable class="form-lable">Файлы (txt,png,gif,png,zip,jpg) не больше 10мб</lable>
                <input name="userfile[]" class="form-control" type="file" multiple accept=".jpg, .jpeg, .png, .txt, .gif, .zip"/>
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-success" name='go'>Создать</button>
            <a href="<?=SITE_URL?>Pages/Ideaslist/" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<script src="https://cdn.tiny.cloud/1/5kg8i7e1yff7okhyt50ndkc0v0zldtuyoxvalzqjle0y7p6q/tinymce/5/tinymce.min.js" referrerpolicy="origin"></script>
<script>let docBaseUrl = '<?=SITE_URL?>';</script>
<script src='<?=SITE_URL?>Assets/js/tiny.js'></script>
<?php 
require_once '../../../Assets/TemplatesPages/footer.php';
?>