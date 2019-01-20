$(function () {
  $('[data-toggle="tooltip"]').tooltip()
});

$('#buttonMenu').click(function(){
    //alert('Вы нажали на элемент Меню');
    var data_menu = Number($('#buttonMenu').attr('data-menu'));
    if(data_menu == 0){
        console.log($('#buttonMenu').attr('data-menu'));
        $('#aside_left').css('display', 'none');
        $('#main').css('left', '10px');
        $('#footer').css('padding-left', '0');
        $('#buttonMenu').attr('data-menu','1')
    }else{
        console.log($('#buttonMenu').attr('data-menu'));
        $('#aside_left').css('display', 'block');
        $('#main').css('left', '100px');
        $('#footer').css('padding-left', '85px');
        $('#buttonMenu').attr('data-menu','0')
    }
    return false;
});


