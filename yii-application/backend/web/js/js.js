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

// Оставляем кнопки главного меню нажатыми при выборе раздела
//  $(document).ready(function(){
  //alert('Вы нажали на элемент Меню');
//  $("#aside_left .btn").click(function(){
    //Метод "toogle"
//    $(this).button('toggle');
//  });
//});

//$(document).ready(function(){ 
 // $("#aside_left .btn").click(function(){
    // Метод "loading"
 //   $(this).button('loading').delay(1000).queue(function(){
 //     $(this).dequeue();
 //   });        
 // });
//});   

//$('#aside_left').on('click', '.btn', function(){
//   $('.btn').removeClass('hover');
//    $(this).addClass('hover');
//    alert('Вы нажали на элемент Меню');
//    $(this).button('toggle');
// });

//$(function() {
 //переменная выбранной ранее кнопки
 //var selected = [];
 //Выбор кнопки
 //$('.aside_left').button().click(function() { 
 //Включение предыдущей кнопки
 //if(selected[0]) {
 //selected.button('enable').removeClass('hover'); 
 //} 
 //кеширование
 //selected = $(this);
 //alert(selected);
 //Отключение этой кнопки и применение аттрибутов
 //selected.button('disable').addClass('ui-state-active').removeClass('ui-state-disabled');
 //$('#btn').click();
//});
// блять хуета какая-то!!!!!!!!!!!!!!!!!!!!!!!
//$(document).ready(function(){
//    $('.aside_left').click(function(){
 //       var clickId = this.id;
//        alert(clickId);
//    });
//});