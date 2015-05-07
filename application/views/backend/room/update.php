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
        <input type="text" class="form-control" id="Room_name" name="Room[name]" value="<?= $room['name'] ?>">
    </div>

    <div class="form-group">
        <select name="UserRoom[user_id][]" multiple class="chosen-select">
            <? foreach($users as $user): ?>
                <option <?= $this->Room_model->has_user($user['id'], $user_room)? "selected": "" ?> value="<?= $user['id'] ?>"><?= $user['first_name'] ?> <?= $user['last_name'] ?></option>
            <? endforeach; ?>
        </select>
    </div>

    <div class="form-group">
        <div class="widget-box">
            <div class="widget-header">
                <h4 class="widget-title lighter smaller">
                    <i class="ace-icon fa fa-comment blue"></i>
                    <?= lang('room_chat') ?>
                </h4>
            </div>
            <div class="widget-body">
                <div class="widget-main no-padding">
                    <!-- #section:pages/dashboard.conversations -->
                    <div class="dialogs ace-scroll">
                        <? $this->load->view('backend/message/rows', $messages); ?>
                    </div>

                    <!-- /section:pages/dashboard.conversations -->
                    <form>
                        <div class="form-actions">
                            <div class="input-group">
                                <input placeholder="Type your message here ..." type="text" class="form-control text-message" name="message">
                                <span class="input-group-btn">
                                    <button class="btn btn-sm btn-info no-radius send-message" type="button">
                                        <i class="ace-icon fa fa-share"></i>
                                        Send
                                    </button>
                                </span>
                            </div>
                        </div>
                    </form>
                </div>
                <!-- /.widget-main -->
            </div>
            <!-- /.widget-body -->
        </div>

    <button type="submit" class="btn btn-default"><?= lang('room_create_submit') ?></button>
</form>