<?php
require_once '../../Assets/TemplatesPages/header.php';
$errors = array();
$success = array();

if (!empty($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
}
if (!empty($_SESSION['errors'])) {
    $error = $_SESSION['errors'];
    unset($_SESSION['errors']);
}
$url = isset($_GET['id']) ? $_GET['id'] : '';
$q = 'SELECT * FROM `ideas` WHERE `id` = ' . $url . '';
$res = mysqli_query($link, $q);
$page = mysqli_fetch_all($res, MYSQLI_ASSOC);

if (empty($_SESSION['login'])) {
    header_safe(SITE_URL.'regform.php');
} else {
    $q = 'UPDATE `ideas` SET `IdeaViews`=`IdeaViews`+1 WHERE `id` = ' . $url . '';
    $res = mysqli_query($link, $q);
}
if (empty($page) || empty($url)) {
    header("HTTP/1.1 404 Not Found");
    $title = 'Ошибка 404 | Такой идеи нету';
    $creator = '-';
    $cont = 'Идея не найдена';

    $views = '-';

    $comment = 1;
} elseif ($page[0]['IdeaActive'] == 0) {
    $title = 'Страница закрыта';
    $creator = '-';
    $cont = '';

    $views = '-';

    $comment = 1;
} else {
    $title = $page[0]['IdeaTitle'];
    $creator = $page[0]['IdeaUserId'];
    $cont = $page[0]['IdeaDescription'];
    $id = $page[0]['id'];

    $views = $page[0]['IdeaViews'];

    $comment = 0;
}
$_SESSION['page_title'] = $title;
$_SESSION['page_id'] = $url;

// Лайки дизлайки просмотры и вся инфа
$q = 'SELECT `LikeType` FROM `likes` WHERE `LikePageId` = ' . $url . ' AND `PageType` = 0';
$res = mysqli_query($link, $q);
$stats = MyFetch($res);

$likes = 0;
$dlikes = 0;

foreach ($stats as $s) {
    if ($s['LikeType'] == 0) {
        $likes++;
    } elseif ($s['LikeType'] == 1) {
        $dlikes++;
    }
}
?>
<main class="flex-shrink-0">
    <div class="container">
        <?php
        require '../../Assets/TemplatesPages/alerts.php';
        alert('danger', $errors);
        alert('success', $success);
        ?>
        <h1 class="mt-5">Идея - <?= $title ?></h1>
        <!--h6 class="card-subtitle mb-3">
            <span class="badge bg-secondary">Тег идеи</span>
        </h6-->
        <h5 class="text-muted mt-4">Создатель идеи:
            <?php
            if ($creator != '-') {
                $usersID = array();
                $usersID[] = $creator;
                $usersID = array_unique($usersID);
                $users = getUsers($link, $usersID);
                $userName = 'Пользователь удалён :)';
                if (!empty($users[$usersID[0]]['login'])) {
                    $userName = $users[$usersID[0]]['login'];
                }
            } else {
                $userName = 'Пользователь не найден :(';
            }
            $userRole = GetUserRole($users[$usersID[0]]['role']);
            echo $userName.'<span class="m-1 badge text-bg-'.$userRole[1].'">'.$userRole[0].'</span>';
            ?>
        </h5>

        <ul class="nav nav-tabs mt-5" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
                <button class="nav-link active" id="desc-tab" data-bs-toggle="tab" data-bs-target="#desc-tab-pane" type="button" role="tab" aria-controls="desc-tab-pane" aria-selected="true">Описание идеи</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files-tab-pane" type="button" role="tab" aria-controls="files-tab-pane" aria-selected="false">Фотографии/файлы</button>
            </li>
            <li class="nav-item" role="presentation">
                <button class="nav-link" id="stat-tab" data-bs-toggle="tab" data-bs-target="#stat-tab-pane" type="button" role="tab" aria-controls="stat-tab-pane" aria-selected="false">Информация</button>
            </li>
        </ul>

        <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="desc-tab-pane" role="tabpanel" aria-labelledby="desc-tab" tabindex="0">
                <div class="card mt-2 fs-5 fs-normal">
                    <div class="card-body">
                        <p><?= $cont ?></p>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="files-tab-pane" role="tabpanel" aria-labelledby="files-tab" tabindex="0">
                <div class="card mt-2 fs-5 fs-normal">
                    <div class="card-body">
                        <?php
                        $q = 'SELECT `FileTitle`,`FileDir` FROM `files` WHERE `FilePlaceId` = "idea_' . $url . '"';
                        $res = mysqli_query($link, $q);
                        $files = mysqli_fetch_all($res, MYSQLI_ASSOC);
                        $alloweFileImage = array('jpg','gif','png','jpeg','PNG','JPEG','JPG');
                        if ($files) {
                            foreach ($files as $f) {
                                echo '
                                <div class="card m-2">
                            <div class="card-body">
                                <h5 class="card-title">' . $f['FileTitle'] . '</h5>
                                <a href="../../Files/' . $f['FileDir'] . '" class="card-link text-success" download>Скачать</a>
                                <a href="../../Files/' . $f['FileDir'] . '" class="card-link" target="_blank">Открыть</a>
                                ';
                                if(in_array(getFileExt($f['FileTitle']), $alloweFileImage)){
                                    echo '<img src="../../Files/' . $f['FileDir'] . '" class="rounded float-end" alt="Изображение)" style="max-width: 25%;">';
                                }/*else{
                                    echo '<i class="bi bi-file-earmark-binary m-3" style="font-size: 3rem;"></i>';
                                }*/
                            echo '</div>
                            </div>';
                            }
                        } else {
                            echo '<p>Файлов никаких нет</p>';
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="stat-tab-pane" role="tabpanel" aria-labelledby="stat-tab" tabindex="0">
                <div class="card mt-2 fs-5 fs-normal">
                    <div class="card-body">
                        <table class="table table-striped">
                            <!--Begin main block-->
                            <thead>
                                <tr>
                                    <th>ID идеи</th>
                                    <th>Статус решения</th>
                                </tr>
                            </thead>
                            <!--End main block-->
                            <tbody>
                                <?php // Статус и другая инфа

                                //ID
                                echo '<td>' . $url . '</td>';

                                //Stat
                                $ideastat = array('color' => 'secondary', 'text' => 'Просматривается');
                                foreach ($stats as $s) {
                                    if ($s['LikeType'] == 2) {
                                        $ideastat['color'] = 'success';
                                        $ideastat['text'] = 'Одобрено';
                                    } elseif ($s['LikeType'] == 3) {
                                        $ideastat['color'] = 'danger';
                                        $ideastat['text'] = 'Неодобрено';
                                    }
                                }
                                echo '<td><span class="text-' . $ideastat['color'] . '">' . $ideastat['text'] . '</span></td>'
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php // Лайки, дизлайки, просмотры
            echo '<p>Понравилось: ' . $likes . ' | Не понравилось: ' . $dlikes . ' | Просмотров: ' . $views . '</p>'
            ?>
            <br>
            <?php
            if ($comment != 1) {
                if ($_SESSION['role'] > 0) {
                    echo '
                <a href="../../Assets/TemplatesPages/add_stat.php?id=' . $url . '&stat=2&type=0" class="btn btn-success mb-1">Одобрить</a>
                <a href="../../Assets/TemplatesPages/add_stat.php?id=' . $url . '&stat=3&type=0" class="btn btn-danger mb-1">Отклонить</a>
                <a href="../Ideaslist/func/del_idea.php?id=' . $url . '" class="btn btn-danger mb-1" onclick="return confirm(\'Подтвердите удаление\')">Удалить</a>
                <a href="../Ideaslist/func/edit_idea.php?id=' . $url . '" class="btn btn-warning mb-1">Редактировать</a>
                ';
                } else {
                    echo '
                <a href="../../Assets/TemplatesPages/add_stat.php?id=' . $url . '&stat=0&type=0" class="btn btn-primary mb-1">Нравится</a>
                <a href="../../Assets/TemplatesPages/add_stat.php?id=' . $url . '&stat=1&type=0" class="btn btn-danger mb-1">Не нравится</a>
                ';
                    if ($creator == $_SESSION['id']) {
                        echo '
                <a href="../Ideaslist/func/del_idea.php?id=' . $url . '" class="btn btn-danger mb-1" onclick="return confirm(\'Подтвердите удаление\')">Удалить</a>
                <a href="../Ideaslist/func/edit_idea.php?id=' . $url . '" class="btn btn-warning mb-1">Редактировать</a>
                ';
                    }
                }
                echo '<a href="../Ideaslist/" class="btn btn-danger mb-1">Назад</a>';
            }
            ?>
            <div class="container mt-5">
                <?php
                // Запрос получение коментов
                if (!empty($_SESSION['login']) && $comment != 1) {
                    require_once '../../Assets/TemplatesPages/comment.php';
                }
                if ($comment != 1) {
                    echo '<h5>Комментарии пользователей:</h5>';
                    $q = 'SELECT * FROM `comment` WHERE `page_id` = ' . $id . ' ORDER BY `date` DESC';
                    $res = mysqli_query($link, $q);
                    $comments = MyFetch($res);

                    $usersID = array();
                    foreach ($comments as $c) {
                        $usersID[] = $c['user_id'];
                    }
                    $usersID = array_unique($usersID);
                    $users = getUsers($link, $usersID);
                    foreach ($comments as $c) {
                        $userName = 'Пользователь удалён.';
                        $userRole = array('Нет роли','muted');
                        if (!empty($users[$c['user_id']]['login'])) {
                            $userName = $users[$c['user_id']]['login'];
                            $userRole = GetUserRole($users[$c['user_id']]['role']);
                        }
                        echo '<div class="card container mt2 mb-2">
			<div class="card-header">
			  ' . $userName . ' (<span class="text-'.$userRole[1].'">'.$userRole[0].'</span>) - ' . $c['date'] . '
			</div>
			<div class="card-body">
			  <h5 class="card-title">' . $c['comment'] . '</h5>
			</div>
		  </div>
			';
                    }
                }
                ?>
                <div class="container mt-5">
                </div>
</main>
<?php
require '../../Assets/TemplatesPages/footer.php';
?>