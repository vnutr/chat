<form method="post">

    <? if(!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <? foreach($errors as $error): ?>
                <p><?= $error ?></p>
            <? endforeach; ?>
        </div>
    <? endif; ?>

    <div class="form-group">
        <label for="Room_name"><?= lang('room_db_name') ?></label>
        <input type="text" class="form-control" id="Room_name" name="Room[name]">
    </div>

    <button type="submit" class="btn btn-default"><?= lang('room_create_submit') ?></button>
</form>