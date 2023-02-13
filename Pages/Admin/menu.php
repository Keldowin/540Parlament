<?php 
require_once 'header.php';
require_once '../../Assets/TemplatesPages/functions.php';
require_once '../../Assets/TemplatesPages/cfg.php';

$q = 'SELECT * FROM `menu` ORDER BY `sort` DESC';
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
        <h1 class="mt-5">Блок-меню ИдеиТГ</h1>
        <a href="func/add_menu.php" class="btn btn-success">Добавить элемент в меню</a>
        <table class="table table-striped">
            <!--Begin main block-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Родитель</th>
                    <th>href</th>
                    <th>Текст</th>
                    <th>Порядок</th>
                    <th>Операции</th>
                </tr>
            </thead>
            <!--End main block-->
            <tbody>
                <?php 
                    foreach($data as $d){
                        echo '<tr>
                        <td>'.$d['id'].'</td>
                        <td>'.$d['parent_id'].'</td>
                        <td>'.$d['href'].'</td>
                        <td>'.$d['title'].'</td>
                        <td>'.$d['sort'].'</td>
                        <td><a href="func/edit_menu.php?id='.$d['id'].'" class="btn btn-warning">Редактировать</a><a href="func/del_menu.php?id='.$d['id'].'" class="btn btn-danger" onclick="return confirm(\'Подтвердите удаление\')">Удалить</a></td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</main>