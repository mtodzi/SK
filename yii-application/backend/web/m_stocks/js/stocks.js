$(function() {
    // при нажатии на кнопку scrollup
    $('.scroll_to_up').click(function() {
    // переместиться в верхнюю часть страницы
    $("html, body").animate({
      scrollTop:0
    },500);
  })
})
// при прокрутке окна (window)
$(window).scroll(function() {
  // если пользователь прокрутил страницу более чем на 200px
  if ($(this).scrollTop()>200) {
    // то сделать кнопку scrollup видимой
    $('.scroll_to_up').fadeIn();
  }
  // иначе скрыть кнопку scrollup
  else {
    $('.scroll_to_up').fadeOut();
  }
});

//чтобы tooltip пропадал
$('[data-toggle="tooltip"]').on("click", function() {
    $(this).tooltip('hide');
    $(this).blur();
});



//Обработчик нажатия кнопки добавить склад
$('.my_heders_bloc').on('click', '#btn_create_new_stock', function(){
    $('#input_name_stock').val('');
    $('#input_id_stocks').val(0);
    $('#button_new_update_stocks').text('Добавить');
    $('#button_new_update_stocks').attr('data-position',0);
    formCleaningStock();
    $('#modal_create_new_stock').modal();
    return false;
});
    

//Обработчик нажатия кнопки редоктировать склад
$('.my_heders_bloc').on('click', '#btn_update_new_stock', function(){
    var select_stock = $("#select_stock option:selected").text();
    var id_select_stock = $("#select_stock").val();
    $('#input_name_stock').val(select_stock);
    $('#input_id_stocks').val(id_select_stock);
    $('#button_new_update_stocks').text('Изменить');
    $('#button_new_update_stocks').attr('data-position',1);
    formCleaningStock();
    $('#modal_create_new_stock').modal();
    return false;
});


//Обработчик нажатия кнопки добавить или сохранить склад
$('.modal-footer').on('click', '#button_new_update_stocks', function(){
    var position = Number($(this).attr('data-position'));
    console.log(position);
    switch (position){
        case 0:
            console.log("Сохраняем новый склад");
            createNewStock();
            break;
        case 1:
            console.log("Редактуруем склад");
            updateStock();
            break;
    }
    return false;
});

function createNewStock(){
    if(formValidationStock()){
        console.log("Валидация пройденна");
        var data = $('#form_new_stock').serialize();
        console.log("Данные отправляемые на сервер - "+data);
        formCleaningStock();
        $.ajax({
            url: '/yii-application/backend/web/stock/stocks/createstock',
            type: 'POST',
            data: data,
            success: function(res){
                console.log("Данные пришедшие с сервера");
                console.log(res);
                if(res[0]==200){
                    $("#form_select_stock").remove();
                    $("#index_stock_bloc").remove();
                    $("#btn_stock_group_update").after(res['htmlStocks']);
                    $("#status_card").after(res['htmlSerialNamber']);
                    $('#modal_create_new_stock').modal('hide');
                }else{
                    var text = '';
                    if(res['modelErrors']==0){
                        text = res['msg'];
                    }else{
                        text = res['modelErrors']['name_stock'];
                    }
                    $("#error_name_stock").text(text);
                    $("#error_name_stock").show();
                }
                
            },
            error: function (jqXHR) {
                console.log("Ощибка с сервера"+jqXHR);
                alert(jqXHR.responseText);
            }
        });
    }else{
        console.log("Валидация не пройденна");
        return false;
    }    
}

function updateStock(){
if(formValidationStock()){
        console.log("Валидация пройденна");
        var data = $('#form_new_stock').serialize();
        console.log("Данные отправляемые на сервер - "+data);
        formCleaningStock();
        $.ajax({
            url: '/yii-application/backend/web/stock/stocks/updatestock',
            type: 'POST',
            data: data,
            success: function(res){
                console.log("Данные пришедшие с сервера");
                console.log(res);
                if(res[0]==200){
                    $('#select_option_stock-'+res['id_stocks']).text(res['name_stock']);
                    $('#modal_create_new_stock').modal('hide');
                }else{
                    var text = '';
                    if(res['modelErrors']==0){
                        text = res['msg'];
                    }else{
                        text = res['modelErrors']['name_stock'];
                    }
                    $("#error_name_stock").text(text);
                    $("#error_name_stock").show();
                }
                
            },
            error: function (jqXHR) {
                console.log("Ощибка с сервера"+jqXHR);
                alert(jqXHR.responseText);
            }
        });
    }else{
        console.log("Валидация не пройденна");
        return false;
    }        
}
//функция проверят формыу перед отправкой на сервер
function formValidationStock(){
    var name_stock = $('#input_name_stock').val();
    if(!empty(name_stock)){
        console.log("Переменная сушествует");
        if(name_stock.length<=255){
            console.log("Переменн НОРМАЛЬНОЙ ДЛИНЫ");
            return true;
        }else{
            console.log("Переменн не НОРМАЛЬНОЙ ДЛИНЫ");
            $("#error_name_stock").text("Длина названия не допустима");
            $("#error_name_stock").show();
            return false;
        }
    }else{
        console.log("Переменная не сушествует");
        $("#error_name_stock").text("Необходимо заполнить название склада");
        $("#error_name_stock").show();
        return false;
    }
}

//Функция очишает ошибки формы дабавления и редактирования
function formCleaningStock(){
    $("#error_name_stock").text("");
    $("#error_name_stock").hide();
    return false;
}


//Функция проверяет сушествует ли переменная
function empty(e) {
    switch (e) {
        case "":
        case 0:
        case "0":
        case null:
        case false:
        case typeof this == "undefined":    
            return true;
        default:
            return false;
    }
}


//Обработчик нажатия кнопки добавить продукт на склад
$('.my_heders_bloc').on('click', '#add_new_serialNambers_in_stock', function(){
    alert("Вы пытаетесь добавить продукт на склад");
    if(GetStatusCard()){
        SetStatusCard(0,"");
        $('#Block_add_serialnumbers-0').show();
        $(window).scrollTop(0);
        $(this).tooltip('hide');
        $(this).blur();
        dataKard = GetDataCardOrders(0);
        console.log(dataKard);
        return false;
    }else{
        $(this).tooltip('hide');
        $(this).blur();
        return false;
    }
});

//Обработчик нажатия кнопки редактировать продукта на складе
$('.my_serialnumbers_content_block').on('click', '.serialnambers_edit_button', function () {
    var id = GetId($(this), 1);
    if (GetStatusCard()) {
        //dataKard = GetDataCardOrders(id);
        //console.log(dataKard);
        SetStatusCard(id, "#span_serialnumbers_id_serial_numbers-");
        $('#stock_card_button_edit_delete-' + id).hide();
        $('#serialnumbers_content-' + id).hide();
        $('#serialnambers_cancel_button_card_apply-' + id).show();
        $('#serialnumbers_form-' + id).show();
        return false;
    } else {
        return false;
    }

});


/** 
 * @param {dom element} obg дом элемент
 * @param {int} number число которое характерезует в каком мести мтроки обозначен id
 * @returns Возврашаем id передоваемого елемента
*/
function GetId(obg,number){
    obg = obg.first();
    var buffer = (obg.attr('id')).split('-');
    console.log(buffer);
    var id = buffer[number];
    console.log(id);
    return id;
}
    
/**
 * Функция устанавливает значения 
 * в скрытый статус открытой
 * либо закрытой карты
 */
function SetStatusCard(id,StartSelector){
    var status_card = Number($('#status_card').val());
    console.log(status_card);
    if(status_card == 0){
        if(id!=0){
            var employeename ='Вы уже редактируете '+$(StartSelector+id).text();
        }else{
            var employeename = "Вы добавляете новый продукт на склад";
        }    
        console.log(employeename);
        $('#status_card').val(1);
        $('#status_card').attr('data-user-card', employeename);
    }else{
        $('#status_card').val(0);
        $('#status_card').attr('data-user-card', '');
    }        
}
    
/**
 * Функция проверяет открыта ли карточка если 
 * открыта выводит сообшени какая карточка открыта
 * и возврашает ложь
*/
function GetStatusCard(){
    var status_card = Number($('#status_card').val());
    console.log(status_card);
    if(status_card == 0){
        return true;
    }else{
        var employeename = $('#status_card').attr('data-user-card');
        console.log(employeename);
        alert(employeename);
        return false;
    }
}