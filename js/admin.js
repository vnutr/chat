$('.chosen-select').chosen();

//updating
setInterval(function(){
    $.ajax({
        url: '/admin/message/by_room',
        context: this,
        type: 'POST',
        dataType: 'JSON',
        data: {
            room_id: room_id
        },
        success: function(data){
            if(data.status)
                $('.dialogs').html(data.html_rows)
        }
    })
}, 2000)

//sending
$('.send-message').click(function(){
    $.ajax({
        url: '/admin/message/create',
        context: this,
        type: 'POST',
        dataType: 'JSON',
        data: {
            room_id: room_id,
            text: $('.text-message').val()
        },
        success: function(data){
            if(data.status)
                $('.dialogs').html(data.html_rows)
        }
    })
})

// remove
$(document).on('click', '.delete-message', function(e){
    e.preventDefault();
    var $this = $(this);
    $.ajax({
        url: '/admin/message/delete',
        context: this,
        type: 'POST',
        dataType: 'JSON',
        data: {
            room_id: room_id,
            id: $this.data('id')
        },
        success: function(data){
            if(data.status)
                $('.dialogs').html(data.html_rows)
        }
    })
})