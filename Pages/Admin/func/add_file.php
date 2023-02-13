<?php 
require_once '../header.php';
require_once '../../../Assets/TemplatesPages/functions.php';
require_once '../../template/cfg.php';
require_once '../../template/alerts.php';


$alloweFileExt = array('jpg','gif','png','txt','zip');
//Код при отправки формы
if(isset($_POST['go'])){
    $fileTmpName = $_FILES['ufile']['tmp_name'];
    $fileName = $_FILES['ufile']['name'];
    $fileExt = getFileExt($fileName);
    $fileError = $_FILES['ufile']['error'];
    if($fileError != 1 || $fileError != 2){
        if(!in_array($fileExt, $alloweFileExt)){ // in_array() - определяет есть ли значение в массиве
            alerts('danger','Недопустимый формат файла');
        }else{
            // Если всё правильно
            $newFileName = genFileName($fileName);

            // Путь куда файл загружается
            $destPath = UPLOAD_PATH.$newFileName;
            if(move_uploaded_file($fileTmpName, $destPath)){
                alerts('success','Файл успешно скопирован');

            }
        }   
    }elseif($fileError != 0){
        alerts('danger','Ошибка отправки файла');
    }else{
        alerts('danger','Превышен размер файла');
    }
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <h1 class="mt-5">Загрузить файл</h1>
        <br><br>
        <form method="post" enctype='multipart/form-data'>
            <div class="mb-2">
                <lable class="form-lable">Выберете файл (2МБ максимум)</lable>
                <input type='file' name='ufile' class="form-control" >
            </div>
            <button type="submit" class="mt-3 mb-3 btn btn-success" name='go'>Загрузить</button>
            <a href="../files.php" class="btn btn-danger">Назад</a>
        </form>
    </div>
</main>
<?php 
require_once '../footer.php';
?>