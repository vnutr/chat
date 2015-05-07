<div class="col-xs-12 no-padding">
    <a href="/admin/room/create" class="btn btn-xs btn-success"><?= lang('room_create_btn') ?></a>
</div>
<div class="separator"></div>
<table class="table table-striped table-bordered table-hover">
<thead>
<tr>
    <th><?= lang('room_db_id') ?></th>
    <th><?= lang('room_db_name') ?></th>
    <th></th>
</tr>
</thead>
<tbody>
<? if(!empty($rooms)): ?>
    <? foreach($rooms as $room): ?>
        <tr>
            <td><?= $room['id'] ?></td>
            <td><a href="/admin/room/update/<?= $room['id'] ?>"><?= $room['name'] ?></a></td>
            <td>
                <div class="hidden-sm hidden-xs btn-group">
                   <a href="/admin/room/delete/<?= $room['id'] ?>" class="btn btn-xs btn-danger">
                        <i class="ace-icon fa fa-trash-o bigger-120"></i>
                    </a>
                </div>
            </td>
        </tr>
    <? endforeach; ?>
<? else: ?>
    <tr>
        <td colspan="3"><?= lang('room_no_results') ?></td>
    </tr>
<? endif; ?>


</tbody>
</table>