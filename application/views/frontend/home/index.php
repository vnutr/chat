<div class="col-xs-8 main">
    <div class="widget-box">
        <div class="widget-header">
            <h4 class="widget-title lighter smaller">
                <i class="ace-icon fa fa-comment blue"></i>
                <span class="chat-title"><?= sprintf(lang('home_chat'), 'private', $users[0]['first_name'], $users[0]['last_name']) ?></span>
            </h4>
        </div>
        <div class="widget-body">
            <div class="widget-main no-padding">
                <!-- #section:pages/dashboard.conversations -->
                <div class="dialogs ace-scroll">
                    <div class="loading"></div>
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
</div>
<div class="col-xs-4 sidebar">
    <div class="form-group">
        <label><?= lang('home_sidebar_private') ?></label>
        <? foreach($users as $index => $user): ?>
            <div class="select-item <?= $index == 0? 'active': '' ?>">
                <div class="select-text"><?= $user['first_name'] . ' ' . $user['last_name'] ?></div>
                <input name="select-user[]" <?= $index == 0? 'checked': '' ?> type="radio" class="users-select" data-type="private" value="<?= $user['id'] ?>"/>
            </div>
        <? endforeach; ?>
    </div>

    <div class="form-group">
        <label><?= lang('home_sidebar_room') ?></label>
        <? foreach($rooms as $index => $room): ?>
            <div class="select-item">
                <div class="select-text"><?= $room['name'] ?></div>
                <input name="select-room[]" <?= $index == 0? 'checked': '' ?> type="radio" class="room-select" data-type="room" value="<?= $room['id'] ?>"/>
            </div>
        <? endforeach; ?>
    </div>
</div>