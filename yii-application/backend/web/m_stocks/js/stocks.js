//Глобальные переменные
var countSendServer = 0;//Счетчик запросов который дал отрицательный результат в поиске подстановки

$(function() {
    // при нажатии на кнопку scrollup
    $('.scroll_to_up').click(function() {
    // переместиться в верхнюю часть страницы
    $("html, body").animate({
      scrollTop:0
    },500);
  })
});

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

//функция для отправки на сервер данных для создания нового склада
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

//функция для отправки на сервер данных для редоктирования склада 
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
        //dataKard = GetDataCardOrders(0);
        //console.log(dataKard);
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

$('.my_serialnumbers_content_block').on('keyup', '.input_serialnambers', function (eventObject) {
    //alert("я работаю");
    var inputName = $(this).attr('data-input-name');
    var notInput = ['clients_address', 'appearance', 'special_notes'];//массив в котором храняться поля которые не нужно отслеживать
    if (notInput.indexOf(inputName) == -1) {
        var x = eventObject.which;
        switch (true) {
            case (x == 9):
                break;
            case (x == 13):
                break;
            case (x >= 16 && x<=20):
                break;
            case (x >= 112 && x<=123):
                break;    
            case (x == 27):
                //EscInputOrders($(this));
                break;
            case (x == 8):
                DeleteLetterInput($(this));
                break;
            case (x == 46):
                DeleteLetterInput($(this));
                break;
            default:
                var data = {};
                data = GetDataKeyUP($(this));
                if (data) {
                    console.log(data);
                    SendToServerSelected($(this), data);
                }
                break;
        }
    }
});

//Обработчик нажатия на option в подсказке clients_name в userbox для всех option
$('.my_serialnumbers_content_block').on('click', '.input_serial_numbers_option', function () {
    var id_serial_numbers = GetId($(this).parent(), 1);
    var id_input = GetId($(this), 1);
    var id_brands = $("#option_name_brands-"+id_input).val();
    var name_brands = $("#option_name_brands-"+id_input).text();
    console.log("id_serial_numbers - " + id_serial_numbers);
    console.log("id_input - " + id_input);
    console.log("id_brands - " + id_brands);
    console.log("name_brands - " + name_brands);
    $('#input_serialnambers_brand_name-'+id_serial_numbers).val(name_brands);
    $('#serialnambers_id_brands-'+id_serial_numbers).val(id_brands);
    $("#search_input_name_brands-" + id_serial_numbers).remove();
    return false;
});

//Функция формирует данные для отправки на сервер для формирования списка выбора
function GetDataKeyUP(setInput) {
    setInput = setInput.first();
    var id = GetId(setInput, 1);
    var InputName = setInput.attr('data-input-name');
    var data = {};
    switch (InputName) {       
        case 'name_brands':
            data = {
                'data-input-name':'name_brands',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[brand_name]': $("#input_serialnambers_brand_name-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'device_type_name':
            data = {
                'SearchInputOrders[id_orders]': id,
                'SearchInputOrders[device_type]': $("#input_orders_device_type_name-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'devices_model':
            data = {
                'SearchInputOrders[id_orders]': id,
                'SearchInputOrders[devices_model]': $("#input_orders_devices_model-" + id).val(),
                'SearchInputOrders[brands_id]': $("#orders_id_brands-" + id).val(),
                'SearchInputOrders[devices_type_id]': $("#orders_id_device_type-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'serial_numbers_name':
            data = {
                'SearchInputOrders[id_orders]': id,
                'SearchInputOrders[devise_id]': $("#orders_id_devices-" + id).val(),
                'SearchInputOrders[serial_numbers_name]': $("#input_orders_serial_numbers_name-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'malfunction':
            var id_malfunction_card = GetId(setInput, 2);
            var valHidden = Number($("#orders_claimed_malfunction_id-" + id + "-" + id_malfunction_card).val());
            if (valHidden == 0) {
                data = {
                    'SearchInputOrders[id_orders]': id,
                    'SearchInputOrders[id_malfunction_card]': id_malfunction_card,
                    'SearchInputOrders[claimed_malfunction_name]': setInput.val(),
                    '_csrf-backend': $('input[name="_csrf-backend"]').val()
                };
                return data;
            } else {
                var a = $("#input_orders_malfunction-" + id + "-" + id_malfunction_card).attr('data-input');
                $("#input_orders_malfunction-" + id + "-" + id_malfunction_card).val(a);
                alert("В одно поле нельзя добавлять несколько заявленных неисправностей");
                return false;
            }
            break;
    }
}

function SendToServerSelected(setInput, data) {
    setInput = setInput.first();
    var id = GetId(setInput, 1);
    var InputName = setInput.attr('data-input-name');
    console.log(countSendServer);
    if(countSendServer == 0){
        $.ajax({
            url: '/yii-application/backend/web/stock/stocks/taketxtinput',
            type: 'POST',
            data: data,
            success: function (res) {
                console.log(res);
                if (res[0] != 0) {
                    $("#search_input_" + InputName + "-" + id).remove();
                    switch (InputName) {
                        case 'name_brands':
                            $("#div_serialnambers_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'device_type_name':
                            //$("#div_orders_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'devices_model':
                            //$("#div_orders_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'serial_numbers_name':
                            //$("#div_orders_" + InputName + "-" + id).after(res['msg']);
                            break;
                    }
                } else {
                    countSendServer++;
                    $("#search_input_" + InputName + "-" + id).remove();
                    return false;
                }
            },
            error: function (jqXHR) {
                console.log(jqXHR);
                alert(jqXHR.responseText);
            }
    });}else{
        return false;
    }
}

//Функциия следить за действиями при удалении в input
function DeleteLetterInput(setInput) {
    setInput = setInput.first();
    var id = GetId(setInput, 1);
    var InputName = setInput.attr('data-input-name');
    switch (InputName) {
        case 'name_brands':
            countSendServer = 0;
            //$("#orders_id_brands-" + id).val(0);
            //$("#orders_id_devices-"+id).val(0);
            //$("#input_orders_devices_model-"+id).val('');
            break;
        case 'device_type_name':
            $("#orders_id_device_type-" + id).val(0);
            //$("#orders_id_devices-"+id).val(0);
            //$("#input_orders_devices_model-"+id).val('');
            break;
        case 'devices_model':
            $("#orders_id_devicse-" + id).val(0);
            //$("#orders_id_device_type-"+id).val(0);
            //$("#input_orders_brand_name-"+id).val('');
            //$("#input_orders_device_type_name-"+id).val('');
            break;
        case 'serial_numbers_name':
            $("#orders_hidden_serrial_nambers_id-" + id).val(0);
            break;
        case 'malfunction':
            var id_malfunction_card = GetId(setInput, 2);
            $("#orders_claimed_malfunction_id-" + id + "-" + id_malfunction_card).val(0);
            break;
    }
}