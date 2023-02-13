<?php 
require_once '../Assets/TemplatesPages/header.php';
$url = isset($_GET['url']) ? $_GET['url'] : '';
$q = 'SELECT * FROM `page` WHERE `url` = "'.$url.'"';
$res = mysqli_query($link, $q);
$page = mysqli_fetch_all($res, MYSQLI_ASSOC);


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

if(empty($page) || empty($url)) {
	header("HTTP/1.1 404 Not Found");
	$title = 'Ошибка 404';
	$cont = 'Страница не найдена';
	$comment = 1;
}elseif ($page[0]['active'] == 0){
	$title = 'Страница закрыта';
	$cont = '';
	$comment = 1;
}else{
	$title = $page[0]['title'];
	$cont = $page[0]['content'];
	$id = $page[0]['id'];
	$comment = 1; //0
}
$_SESSION['page_title'] = $title;
$_SESSION['page_url'] = $url;

// Получение пользователей
?>
<main class="flex-shrink-0">
	<div class="container mt-5">
	<?php
	require_once '../Assets/TemplatesPages/alerts.php';
	alert('danger', $errors);
	alert('success', $success);
	?>
	</div>
    <div class="container">
      <h1 class="mt-5"><?= $title ?></h1>
      <p class="lead"><?= $cont ?></p>
    </div>
	<div class="container mt-5">
	<?php 
	// Запрос получение коментов
	if(!empty($_SESSION['login']) && $comment != 1){
		require_once '../Assets/TemplatesPages/comment.php';
	}elseif(empty($_SESSION['login'])){
		echo '<h4><a href="regform.php">Что-бы оставлять комментарий - войдите на сайт</a><h4><br><br>';
	}
	if($comment != 1){
		echo '<h5>Комментарии пользователей:</h5>';
		$q = 'SELECT * FROM `comment` WHERE `page_id` = '.$id.' ORDER BY `date` DESC';
		$res = mysqli_query($link,$q);
		$comments = MyFetch($res);
		
		$usersID = array();
		foreach($comments as $c){
			$usersID[] = $c['user_id'];
		}
		$usersID = array_unique($usersID);
		$users = getUsers($link,$usersID);
		foreach($comments as $c){
			$userName = 'Пользователь удалён.';
			if(!empty($users[$c['user_id']]['login'])){
				$userName = $users[$c['user_id']]['login'];
			}
			echo '<div class="card container mt3 mb-5">
			<div class="card-header">
			  '.$userName.' - '.$c['date'].'
			</div>
			<div class="card-body">
			  <h5 class="card-title">'.$c['comment'].'</h5>
			</div>
		  </div>
			';
		}
	}
	?>
	</div>
  </main>
<?php 
require_once '../Assets/TemplatesPages/footer.php';
?>