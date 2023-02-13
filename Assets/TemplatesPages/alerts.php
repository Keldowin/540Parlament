<?php
// Локальный алерт
function alerts($type, $title){
    echo '<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <!--img src="" class="rounded me-2" alt="..."-->
        <strong class="me-auto">Уведомление</strong>
        <!--small>Уведомление</small-->
        <button type="button" id="liveToastBtn" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body text-'.$type.'">
      '.$title.'
      </div>
    </div>
  </div>';
  }

// Глобальный алерт
function alert($type, $array){
  foreach($array as $a){
      echo '<div class="toast-container position-fixed bottom-0 end-0 p-3">
    <div id="liveToast" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
      <div class="toast-header">
        <!--img src="" class="rounded me-2" alt="..."-->
        <strong class="me-auto">Уведомление</strong>
        <!--small>Уведомление</small-->
        <button type="button" id="liveToastBtn" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
      </div>
      <div class="toast-body text-'.$type.'">
      '.$a.'
      </div>
    </div>
  </div>';
  }
}

$error = array('Заполнены не все поля формы','Неверные логин или пароль','Пользователь с таким логином уже существует','Один из полей с паролем не верны','Человека с таким логином и паролем не существует');
?>