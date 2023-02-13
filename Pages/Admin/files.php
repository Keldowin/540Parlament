<?php 
require_once 'header.php';
require_once '../../Assets/TemplatesPages/cfg.php';
require_once '../../Assets/TemplatesPages/functions.php';

$errors = array();
$success = array();

if(!empty($_SESSION['success'])){
	$success = $_SESSION['success'];
	unset($_SESSION['success']);
}
if(!empty($_SESSION['errors'])){
	$error = $_SESSION['errors'];
	unset($_SESSION['errors']);
}
$files = scandir('../'.DIRECTORY_SEPARATOR.UPLOAD_DIR);
array_shift($files);
array_shift($files);
?>
<main class="flex-shrink-0">
    <?php
	require '../../Assets/TemplatesPages/alerts.php';
	alert('danger', $errors);
	alert('success', $success);
	?>
    <div class="container">
        <h1 class="mt-5">Загруженные файлы</h1>
        <a href="func/add_file.php" class="btn btn-success">Добавить файл</a>
        <table class="table table-striped mt-2">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Миниатюра</th>
                    <th>Путь</th>
                    <th>Операции</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $i = 1;
                $imgExt = array('jpg','gif','png','jpeg');
                foreach ($files as $f) {
                    $preview = 'Нет';
                    $fileExt = getFileExt($f);
                    if(in_array($fileExt, $imgExt)){
                        $preview = '<img width="75" src="../'.UPLOAD_DIR.'/'.$f.'">';
                    }
                    echo '<tr>
                    <td>'.$i.'</td>
                    <td>'.$preview.'</td>
                    <td>'.UPLOAD_DIR.'/'.$f.'</td>
                    <td><a href="func/del_file.php?name='.$f.'" class="btn btn-danger" onclick="return confirm(\'Подтвердите удаление\')">Удалить</a></td>
                    </tr>';
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
</main>