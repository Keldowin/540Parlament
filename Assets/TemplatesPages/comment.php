<div class="container mt3 mb-5">
    <label for="exampleFormControlTextarea1" class="form-label">Оставить комментарий</label>
    <form method="POST" action="<?=SITE_URL?>Assets/TemplatesPages/add_comment.php">
        <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
        <input type="hidden" name="page_url" value="<?=$url?>">
        <input type="hidden" name="page_id" value="<?=$id?>">
        <button type="submit" class="mt-3 btn btn-primary">Отправить</button>
    </form>
</div>