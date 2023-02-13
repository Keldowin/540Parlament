<?php 
$link = mysqli_connect("localhost", "keldowin", "70435691P","users");
if(!$link){
	exit("Ошибка 540"); // 540 ошибка базы данныз
}

/*ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);*/ // Вывод ошибок

define('SITE_URL',"https://web1182.craft-host.ru/540site/"); // Ссылка на сайт

define('UPLOAD_DIR','../Files');
define('UPLOAD_PATH', dirname(__DIR__).DIRECTORY_SEPARATOR.UPLOAD_DIR.DIRECTORY_SEPARATOR);
?>