   
   $('form').on('beforeSubmit', function(){
        var data = $(this).serialize();
        $.ajax({
                url: '/advanced/backend/web/user/posts/createposts',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    $('#posts-body_post').val("");
                    console.log('отработала конструкция');
                    
                    showNewMessage();
                },
                error: function(){
                    alert('Ошибка');
                }
        });
        return false;
    });
    function showMessage() {
        console.log('Сработал таймер');
    }
    function showNewMessage() {        
        var data = {};   
        data['count'] = $('#count').text();
        data['id_user_to_whom'] = $('#posts-id_user_to_whom').val()
        data['_csrf-backend'] =  $('input[name=_csrf-backend]').val()
       
        $.ajax({
                url: '/advanced/backend/web/user/posts/getnewposts',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    //$('#posts-body_post').val("");
                    $('#ulpost').append(res);
                    $('#count').text($('.content_input').last().val());
                    console.log('отработала конструкция');
                    
                },
                error: function(){
                    alert('Ошибка');
                }
        });
        //alert( data['count'] );
        return false;
    }
    var timerId = setInterval(function() {
        var data = {};   
        data['count'] = $('#count').text();
        data['id_user_to_whom'] = $('#posts-id_user_to_whom').val()
        data['_csrf-backend'] =  $('input[name=_csrf-backend]').val()
       
        $.ajax({
                url: '/advanced/backend/web/user/posts/getnewposts',
                type: 'POST',
                data: data,
                success: function(res){
                    console.log(res);
                    //$('#posts-body_post').val("");
                    $('#ulpost').append(res);
                    $('#count').text($('.content_input').last().val());
                    console.log('отработала конструкция');
                    
                },
                error: function(){
                    alert('Ошибка');
                }
        });
        //alert( data['count'] );
        return false;
    }, 20000);