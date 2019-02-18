$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});
//Обрабтывает нажатие кнопки на свернуть и развернуть главное меню
$('#buttonMenu').click(function(){
    //alert('Вы нажали на элемент Меню');
    var data_menu = Number($('#buttonMenu').attr('data-menu'));
    if(data_menu == 0){
        console.log($('#buttonMenu').attr('data-menu'));
        $('#aside_left').hide()//css('display', 'none');
        $('.container-fluid').css('padding-left','15px');
        $('#footer').css('padding-left', '0');
        $('#buttonMenu').attr('data-menu','1')
    }else{
        console.log($('#buttonMenu').attr('data-menu'));
        $('#aside_left').show()//css('display', 'block');
        $('.container-fluid').css('padding-left','100px');
        $('#footer').css('padding-left', '85px');
        $('#buttonMenu').attr('data-menu','0')
    }
    return false;
});
