$('.chosen-select').chosen();

//updating
setInterval(function(){
    $.ajax({
        url: '/message/fetch',
        context: this,
        type: 'POST',
        dataType: 'JSON',
        data: {
            chat_type: chat_type,
            chat_id:   chat_id
        },
        success: function(data){
            if(data.status)
                $('.dialogs').html(data.html_rows)
        }
    })
}, 2000)

// select user
$('.users-select, .room-select').click(function(){

    $.each($('.users-select, .room-select'), function(index, item){
        $(item).closest('.select-item').removeClass('active');
    })
    $(this).closest('.select-item').addClass('active');
    chat_type = $(this).data('type');
    var id = $(this).val();
    var title = $(this).siblings('.select-text').text();
    chat_id = id;
    $('.dialogs').html('<div class="loading"></div>');
    $('.chat-title').html('Chat ('+chat_type+' - '+title+')');
})

//sending
$('.send-message').click(function(){
    $('.dialogs').html('<div class="loading"></div>');
    var text = $('.text-message').val();
    $('.text-message').val('')
    $.ajax({
        url: '/message/create',
        context: this,
        type: 'POST',
        dataType: 'JSON',
        data: {
            chat_type: chat_type,
            chat_id:   chat_id,
            text: text
        },
        success: function(data){
            if(data.status){
                $('.dialogs').html(data.html_rows)
            }
        }
    })
})

// remove
$(document).on('click', '.delete-message', function(e){
    e.preventDefault();
    var $this = $(this);
    $('.dialogs').html('<div class="loading"></div>');
    $.ajax({
        url: '/message/delete',
        context: this,
        type: 'POST',
        dataType: 'JSON',
        data: {
            chat_type: chat_type,
            chat_id:   chat_id,
            message_id: $this.data('id')
        },
        success: function(data){
            if(data.status)
                $('.dialogs').html(data.html_rows)
        }
    })
})