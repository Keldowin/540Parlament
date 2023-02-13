<?php 
require_once 'header.php';
require_once '../../Assets/TemplatesPages/functions.php';
require_once '../../Assets/TemplatesPages/cfg.php';

$q = 'SELECT * FROM `users`';
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
        <h1 class="mt-5">Пользователи</h1>
        <!--a href="func/add_user.php" class="btn btn-success">Добавить пользователя</a-->
        <table class="table table-striped">
            <!--Begin main block-->
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Логин</th>
                    <th>Дата регистрации</th>
                    <th>Бан</th>
                    <th>Роль</th>
                    <th>Операции</th>
                </tr>
            </thead>
            <!--End main block-->
            <tbody>
                <?php 
                    foreach($data as $d){
                        $userRole = GetUserRole($d['role']);

                        $ban = 'Нет';
                        if($d['active'] != 1){
                            $ban = 'Да';
                        }
                        echo '<tr>
                        <td>'.$d['id'].'</td>
                        <td>'.$d['login'].'</td>
                        <td>'.$d['date'].'</td>
                        <td>'.$ban.'</td>
                        <td><span class="text-'.$userRole[1].'">'.$userRole[0].'</span></td>
                        <td><a href="func/edit_user.php?id='.$d['id'].'" class="btn btn-warning mb-3">Редактировать</a><br><a href="func/del_user.php?id='.$d['id'].'" class="btn btn-danger" onclick="return confirm(\'Подтвердите удаление\')">Удалить</a></td>
                        </tr>';
                    }
                ?>
            </tbody>
        </table>
    </div>
</main>