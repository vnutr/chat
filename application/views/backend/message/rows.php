<? if(!empty($messages)): ?>
    <? foreach($messages as $message): ?>
        <div class="itemdiv dialogdiv">
            <div class="user">
                <img alt="" src="/images/user.jpg">
            </div>

            <div class="body">
                <div class="time">
                    <i class="ace-icon fa fa-clock-o"></i>
                    <span class="green"><?= date('Y/m/d H:i:s', $message['date']) ?></span>
                </div>

                <div class="name">
                    <a href="#"><?= $message['first_name'] . ' ' . $message['last_name'] ?></a>
                </div>
                <div class="text"><?= $message['text'] ?></div>

                <div class="tools">
                    <a href="#" data-id="<?= $message['id'] ?>" class="btn btn-minier btn-danger delete-message">
                        <i class="icon-only ace-icon fa fa-times"></i>
                    </a>
                </div>
            </div>
        </div>
    <? endforeach; ?>
<? else: ?>
    <p><?= lang('message_no_messages') ?><?= lang('room_no_messages') ?></p>
<? endif; ?>