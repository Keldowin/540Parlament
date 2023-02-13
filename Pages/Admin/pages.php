<?php 
require_once 'header.php';
require_once '../../Assets/TemplatesPages/cfg.php';
require_once '../../Assets/TemplatesPages/functions.php';

$q = 'SELECT * FROM `page`';
$data = mysqli_query($link,$q);
$data = MyFetch($data);

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

?>
<main class="flex-shrink-0">
    <div class="container">
    <?php
	require '../../Assets/TemplatesPages/alerts.php';
	alert('danger', $errors);
	alert('success', $success);
	?>
        <h1 class="mt-5">Страницы ИдеиТГ</h1>
        <a href="func/add_page.php" class="btn btn-success">Добавить страницу</a>
        <table class="table table-striped">
            <!--Begin main block-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>URL</th>
                    <th>Заголовок</th>
                    <th>Содержание</th>
                    <th>Отображать</th>
                    <th>Операции</th>
                </tr>
            </thead>
            <!--End main block-->
            <tbody>
                <?php 
                foreach($data as $d){
                    if($d['active'] != 1){
                        $active = 'Закрыто';
                    }else{
                        $active = 'Открыто';
                    }
                    $content = htmlspecialchars($d['content']);
                    if(mb_strlen($content) > 120){ // Функция для показания сколько символов в тексте
                        $content = mb_substr($content,0,120); // Функция берёт и отрезает часть строки
                        $content .= '...';
                    }
                    echo '<tr>
                    <td>'.$d['id'].'</td>
                    <td><a href="../page.php?url='.$d['url'].'">'.$d['url'].'</a></td>
                    <td>'.$d['title'].'</td>
                    <td>'.$content.'</td>
                    <td>'.$active.'</td>
                    <td><a href="func/edit_page.php?id='.$d['id'].'" class="mb-3 btn btn-warning">Редактировать</a><a href="func/del_page.php?id='.$d['id'].'" class="mb-3 btn btn-danger" onclick="return confirm(\'Подтвердите удаление\')">Удалить</a></td>
                    </tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
</main>