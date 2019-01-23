$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
//Обрабтывает нажатие кнопки на свернуть и развернуть главное меню
$('#buttonMenu').click(function(){
    //alert('Вы нажали на элемент Меню');
    var data_menu = Number($('#buttonMenu').attr('data-menu'));
    if(data_menu == 0){
        console.log($('#buttonMenu').attr('data-menu'));
        $('#aside_left').css('display', 'none');
        $('#main').css('margin-left', '10px');
        $('#footer').css('padding-left', '0');
        $('#buttonMenu').attr('data-menu','1')
    }else{
        console.log($('#buttonMenu').attr('data-menu'));
        $('#aside_left').css('display', 'block');
        $('#main').css('margin-left', '100px');
        $('#footer').css('padding-left', '85px');
        $('#buttonMenu').attr('data-menu','0')
    }
    return false;
});

//начало оброботки данных модуля user
    //Обработчик нажатия кнопки редактировать в userbox
    $('.userbox').on('click', '.user_edit_button', function(){
        console.log(this);
        var buffer = this.id.split('-');
        console.log(buffer);
        var id = buffer[1];
        console.log(id);
        $('#user_card_button_edit_archive-'+id).css('display', 'none');
        $('#user_data-'+id).css('display', 'none');
        $('#user_cancel_button_card_apply-'+id).css('display', 'flex');
        $('#user_data_edit-'+id).css('display', 'block');
        return false;
    });
    //Обработчик нажатия кнопки отмена в userbox
    $('.userbox').on('click', '.user_cancel_button', function(){
        console.log(this);
        var buffer = this.id.split('-');
        console.log(buffer);
        var id = buffer[1];
        console.log(id);
        $('#user_card_button_edit_archive-'+id).css('display', 'flex');
        $('#user_data-'+id).css('display', 'block');
        $('#user_cancel_button_card_apply-'+id).css('display', 'none');
        $('#user_data_edit-'+id).css('display', 'none');
        return false;
    });
    //Обработчик нажатия кнопки применить в userbox
    $('.userbox').on('click', '.user_apply_button', function(){
        console.log(this);
        var buffer = this.id.split('-');
        console.log(buffer);
        var id = buffer[1];
        console.log(id);
        $('#user_card_button_edit_archive-'+id).css('display', 'flex');
        $('#user_data-'+id).css('display', 'block');
        $('#user_cancel_button_card_apply-'+id).css('display', 'none');
       $('#user_data_edit-'+id).css('display', 'none');
        return false;
    });
//конец обработки данных модуля user
