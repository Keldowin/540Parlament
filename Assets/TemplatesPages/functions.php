<?php 
function header_safe($url){
	//header('Location: '.$url.'');
	echo '<script>window.location.href = "'.$url.'"</script>';
	exit();
}
function varDump($data){
	echo "<pre>";
	var_dump($data);
	echo "</pre>";
}
function MyFetch($res){
	return mysqli_fetch_all($res, MYSQLI_ASSOC);
}
function cheak_login(){
	if(isset($_SESSION['login'])){
		header_safe('regform.php');
	}
}
function getUsers($link, $arrayID){
	if (empty($arrayID)){
		return array();
	}
	$str = implode(',', $arrayID);
	$q = 'SELECT * FROM `users` WHERE `id` IN ('.$str.')';
	$res = mysqli_query($link,$q);
	$users = mysqli_fetch_all($res, MYSQLI_ASSOC);
	$newusers = array();
	foreach ($users as $user) {
		$newusers[$user['id']] = $user;
	}
	return $newusers;
}
function getPages($link){
	$q = 'SELECT * FROM `page`';
	$res = mysqli_query($link,$q);
	$data = MyFetch($res);
	$pages = array();
	foreach($data as $d){
		$pages[$d['id']] = $d['title'];
	}
	return $pages;
}
function getPagesUrl($link){
	$q = 'SELECT * FROM `page`';
	$res = mysqli_query($link,$q);
	$data = MyFetch($res);
	$pagesUrl = array();
	foreach($data as $d){
		$pagesUrl[$d['id']] = $d['url'];
	}
	return $pagesUrl;
}
function GetDomain(){
	return $_SERVER['SERVER_NAME'];
}
function getFileExt($name){
	$nameArr = explode('.',$name); // Разделяет файл
	$ext = array_pop($nameArr); // Взять последний элемент массива
	$ext = mb_strtolower($ext); // Преобразует высокие буквы в низки и так наоборот
	return $ext;
}
function genFileName($name){
	$ext = getFileExt($name);
	$time = time();
	$newName = md5($time.$name) . '.' .$ext;
	return $newName;
}

function GetUserRole($RoleNum){ // Функция получает номер роли игрока (4 - Педагог ,3 - Президент,2 - Админ, 1 - Министр, 0 - Пользователь)
	$userRole = array('Нет роли','secondary');
		switch ($RoleNum) {
			case 0: // Пользователь
				$userRole = array('Пользователь','secondary');
				break;
			case 1: // Министр
				$userRole = array('Министр','primary');
				break;
			case 2: // Админ
				$userRole = array('Админ','danger');
				break;
			case 3: // Президент
				$userRole = array('Президент','primary-emphasis');
				break;
			case 4: // Педагог
				$userRole = array('Педагог','danger-emphasis');
				break;
		}
	return $userRole;
}
?>