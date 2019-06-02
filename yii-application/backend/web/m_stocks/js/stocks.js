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
    var data_input_name =  $(this).attr('data-input-name');
    console.log('data_input_name - '+data_input_name);
    var id_brands = $(this).attr('data-id_brands');
    console.log("id_brands - "+id_brands);
    var brand_name = $(this).attr('data-brand_name');
    console.log("brand_name - "+brand_name);
    var id_device_type = $(this).attr('data-id_device_type');
    console.log("id_device_type - "+id_device_type);
    var device_type_name = $(this).attr('data-device_type_name');
    console.log("device_type_name - "+device_type_name);
    var id_input_val = $("#option_"+data_input_name+"-"+id_input).val();
    var name_input_val = $("#option_"+data_input_name+"-"+id_input).text();
    console.log("id_serial_numbers - " + id_serial_numbers);
    console.log("id_input - " + id_input);
    console.log("id_input_val - " + id_input_val);
    console.log("name_input_val - " + name_input_val);
    switch (data_input_name){
        case 'name_brands':
            $('#input_serialnambers_brand_name-'+id_serial_numbers).val(name_input_val);
            $('#serialnambers_id_brands-'+id_serial_numbers).val(id_input_val);
            $("#search_input_name_brands-" + id_serial_numbers).remove();
            break;
        case 'device_type_name':
            $('#input_serialnambers_device_type_name-'+id_serial_numbers).val(name_input_val);
            $('#serialnambers_id_device_type-'+id_serial_numbers).val(id_input_val);
            $("#search_input_device_type_name-" + id_serial_numbers).remove();
            break;
        case 'devices_model':            
            $('#input_serialnambers_brand_name-'+id_serial_numbers).val(brand_name);
            $('#serialnambers_id_brands-'+id_serial_numbers).val(id_brands);
            $('#input_serialnambers_device_type_name-'+id_serial_numbers).val(device_type_name);
            $('#serialnambers_id_device_type-'+id_serial_numbers).val(id_device_type);
            $('#input_serialnambers_devices_model-'+id_serial_numbers).val(name_input_val);
            $('#serialnambers_id_devices-'+id_serial_numbers).val(id_input_val);
            $("#search_input_devices_model-" + id_serial_numbers).remove();
            break;
    }
    
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
                'data-input-name':'device_type_name',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[device_type]': $("#input_serialnambers_device_type_name-" + id).val(),
                '_csrf-backend': $('input[name="_csrf-backend"]').val()
            };
            return data;
            break;
        case 'devices_model':
            data = {
                'data-input-name':'devices_model',
                'SearchInput[id_serial_numbers]': id,
                'SearchInput[devices_model]': $("#input_serialnambers_devices_model-" + id).val(),
                'SearchInput[brands_id]': $("#serialnambers_id_brands-" + id).val(),
                'SearchInput[devices_type_id]': $("#serialnambers_id_device_type-" + id).val(),
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
                            $("#div_serialnambers_" + InputName + "-" + id).after(res['msg']);
                            break;
                        case 'devices_model':
                            $("#div_serialnambers_" + InputName + "-" + id).after(res['msg']);
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
            $("#serialnambers_id_brands-" + id).val(0);
            $("#search_input_" + InputName + "-" + id).remove();
            break;
        case 'device_type_name':
            countSendServer = 0;
            $("#serialnambers_id_device_type-" + id).val(0);
            $("#search_input_" + InputName + "-" + id).remove();
            break;
        case 'devices_model':
            countSendServer = 0;
            $("#serialnambers_id_devices-" + id).val(0);
            $("#search_input_" + InputName + "-" + id).remove();
            break;
        case 'serial_numbers_name':
            $("#orders_hidden_serrial_nambers_id-" + id).val(0);
            break;
    }
}

//Обработчик отслеживает получение фокуса 
$('.my_serialnumbers_content_block').on('focusin', '.input_serialnambers', function () {
    var id_serialnambers = GetId($(this), 1);
    console.log($("search_input_device_type-" + id_serialnambers));
    if ($("#search_input_name_brands-" + id_serialnambers).is("#search_input_name_brands-" + id_serialnambers)) {
        $("#search_input_name_brands-" + id_serialnambers).remove();
    }
    if ($("#search_input_device_type_name-" + id_serialnambers).is("#search_input_device_type_name-" + id_serialnambers)) {
        $("#search_input_device_type_name-" + id_serialnambers).remove();
    }
    if ($("#search_input_devices_model-" + id_serialnambers).is("#search_input_devices_model-" + id_serialnambers)) {
        $("#search_input_devices_model-" + id_serialnambers).remove();
    }
    if ($("#search_input_serial_numbers_name-" + id_serialnambers).is("#search_input_serial_numbers_name-" + id_serialnambers)) {
        $("#search_input_serial_numbers_name-" + id_serialnambers).remove();
    }
});

//Обработчик отслеживает получение фокуса 
$('.my_serialnumbers_content_block').on('change', "input[type='radio']", function () {
    alert("вы сменили");
    console.log($(this));
    var check = $(this).val();
    var htmlOne = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0'"+
                "name='SerialNumbersEdit[serial_numbers_name]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name input_serialnambers input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0' type='hidden' name='SerialNumbersEdit[id_serial_numbers]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>"+    
            "";
    var htmlRange = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_common_body_range-0'"+
                "name='SerialNumbersEdit[serial_numbers_common_body_range]' data-input-name = 'serial_numbers_common_body_range'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_common_body_range input_serialnambers' type='text'"+
                "placeholder='Общая часть'>  "+
                "<input id='input_serialnambers_serial_numbers_start_range-0'"+
                "name='SerialNumbersEdit[serial_numbers_start_range]' data-input-name = 'serial_numbers_start_range'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-2 mx-2 input_serialnambers_serial_numbers_start_range input_serialnambers' type='text'"+
                "placeholder='начало'> - "+
                "<input id='input_serialnambers_serial_numbers_end_range-0'"+
                "name='SerialNumbersEdit[serial_numbers_end_range]' data-input-name = 'serial_numbers_end_range'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-2 mx-2 input_serialnambers_serial_numbers_end_range input_serialnambers' type='text'"+
                "placeholder='конец'>"+
            "</p>"+
            "";
    var htmlSome = ""+
            "<p id = 'p_serialnambers_serial_numbers_name-0-1' class='form-row my-2 input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0-1'"+
                "name='SerialNumbersEdit[serial_numbers_name-1]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name input_serialnambers  input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0-1' type='hidden' name='SerialNumbersEdit[id_serial_numbers-1]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>"+
            "<p id = 'p_add_another_serialnambers_serial_numbers_name-0' class='form-row my-2'>"+
                "<a id ='add_another_serial_numbers_name-0' class='btn btn-dark add_another_serial_numbers_name mx-1' data-count-serial_numbers_name='1' data-toggle='tooltip' data-placement='right' title='Добавить еще один серийный номер'>"+
                    "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_stocks/img/add.svg' alt='Добавить еще один серийный номер'>"+
                "</a>"+
            "</p>"+
            "";
    switch (check){
        case 'one':
            alert("Вы выбрали one");
            $("#p_add_another_serialnambers_serial_numbers_name-0").remove();
            $(".input_serialnambers-0").remove();
            $("#p_type_addition").after(htmlOne);
            break;
        case 'range':
            alert("Вы выбрали range");
            $("#p_add_another_serialnambers_serial_numbers_name-0").remove();
            $(".input_serialnambers-0").remove();
            $("#p_type_addition").after(htmlRange);
            break;
        case 'some':
            alert("Вы выбрали some");
            $(".input_serialnambers-0").remove();
            $("#p_type_addition").after(htmlSome);
            $("#add_another_serial_numbers_name-0").tooltip('enable');
            break;
    }
    
});

//Обработчик нажатия кнопки добавить еше один серийный номер
$('.my_serialnumbers_content_block').on('click', '.add_another_serial_numbers_name', function () {
    var id_serialnambers = GetId($(this), 1);
    var count_serialnambers = Number($(this).attr('data-count-serial_numbers_name'));
    console.log('id_serialnambers: ' + id_serialnambers + " count_serialnambers: " + count_serialnambers);
    addInputSerialNambers(id_serialnambers, count_serialnambers);
    $(this).tooltip('update');
    $(this).tooltip('hide');
    $(this).blur();
    return false;
});

//Функция добавляет поле серийного номера в карточке добавить продукт на склад
function addInputSerialNambers(id, count_serialNambers, value = "") {
    var count = $('.input_serialnambers-0').length;
    console.log("Число добовляемых серийных номеров - " + count);
    var next = Number(count_serialNambers) + 1;
    var buttondelete = "" +
            "<a  id = 'delete_another_serialnambers-" + id + "-" + next + "' class='btn btn-dark delete_another_serialnambers delete_another_serialnambers-" + id + " mx-1'  data-count-serialnambers='" + next + "' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>" +
            "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>" +
            "</a>";
    var buttondeleteFirst = "" +
            "<a  id = 'delete_another_serialnambers-" + id + "-1' class='btn btn-dark delete_another_serialnambers delete_another_serialnambers-" + id + " mx-1'  data-count-serialnambers='" + next + "' data-toggle='tooltip' data-placement='right' title='Удалить телефон'>" +
            "<img id ='menu_navbar_top' class='' src='/yii-application/backend/web/m_orders/img/minus.svg' alt='Удалить телефон'>" +
            "</a>";
    var input = '' +
            "<p id = 'p_serialnambers_serial_numbers_name-0-"+next+"' class='form-row my-2 input_serialnambers-0'>"+
                "<input id='input_serialnambers_serial_numbers_name-0-"+next+"'"+
                "name='SerialNumbersEdit[serial_numbers_name-"+next+"]' data-input-name = 'serial_numbers_name'  form='form_serialnambers_stock-0'"+
                "value='' class='form-control col-4 mx-2 input_serialnambers_serial_numbers_name input_serialnambers  input_serialnambers-0' type='text'"+
                "placeholder='Серийный номер'>"+
                "<input id='serialnambers_id_serial_numbers-0"+next+"' type='hidden' name='SerialNumbersEdit[id_serial_numbers-"+next+"]' value='0' form='form_serialnambers_stock-0'>"+
            "</p>";
 
        //$("#search_input_phone_number-" + id_orders).remove();
        $('#add_another_serial_numbers_name-' + id).attr('data-count-serial_numbers_name', next);
        $('#delete_another_serialnambers-' + id).attr('data-count-serialnambers', next);
        $("#p_serialnambers_serial_numbers_name-" + id + "-" + count_serialNambers).after(input);
        $(("#input_serialnambers_serial_numbers_name-" + id + "-" + next)).after(buttondelete);
        $('[data-toggle="tooltip"]').tooltip();
        if (count_serialNambers == 1) {
            $(("#input_serialnambers_serial_numbers_name-" + id + "-1")).after(buttondeleteFirst);
            $('[data-toggle="tooltip"]').tooltip();
        }
        console.log(count_serialNambers);
        console.log(input);
        return true;

}

//Обработчик нажатия кнопки Удалить еше один серийный номер
$('.my_serialnumbers_content_block').on('click', '.delete_another_serialnambers', function () {
    var id_serialnumbers = GetId($(this), 1);
    var id_delete = GetId($(this), 2);
    var count_serialnambers = Number($(this).attr('data-count-serialnambers'));
    console.log('id_serialnumbers-' + id_serialnumbers + " id_delete-" + id_delete);
    $(this).tooltip('update');
    $(this).tooltip('hide');
    $(this).blur();
    deleteInputPhone(id_serialnumbers, id_delete, count_serialnambers);
    return false;
});

//Функция инпут телефона 
function deleteInputPhone(id, id_delete, count_serialnambers) {
    var count = $('.input_serialnambers-' + id).length;
    console.log(count);
    //$("#search_input_phone_number-" + id_orders).remove();
    if (count > 1) {
        $("#p_serialnambers_serial_numbers_name-" + id + "-" + id_delete).remove();
        $('.input_serialnambers-' + id).each(function (index) {
            console.log($(this));/*
            $(this).attr('id', ("div_orders_clients_phone-" + id_orders + "-" + (index + 1)));
            $(this).find("input").attr('id', ("input_orders_clients_phone-" + id_orders + "-" + (index + 1)));
            $(this).find("input").attr('name', ("ClientsPhonesEdit[phone_number][" + (index + 1) + "]"));
            $(this).find("a").attr('id', ("delete_another_phone-" + id_orders + "-" + (index + 1)));
            $(this).find("p .error_orders_phone").attr('id', ("error_orders_phone-" + id_orders + "-" + (index + 1)));
            $(this).find("p .orders_phone").attr('id', ("p_orders_clients_phone-" + id_orders + "-" + (index + 1)));
            console.log(index + ": ");*/
        });
        $('#add_another_phone-' + id_orders).attr('data-count-phone', (count - 1));
        if (count == 2) {
            $("#delete_another_phone-" + id_orders + "-1").remove();
        }
    }

}