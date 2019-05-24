


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