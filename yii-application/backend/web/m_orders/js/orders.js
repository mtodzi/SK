    //Обработчик нажатия кнопки редактировать в userbox
    $('.my_content_bloc').on('click', '.orders_edit_button', function(){
        var id = GetId(this,1);
        if(GetStatusCard(id)){
            SetStatusCard(id,"#span_orders_id_orders_text-");
            $('#user_card_button_edit_print-'+id).hide();
            $('#orders_content-'+id).hide();        
            $('#orders_cancel_button_card_apply-'+id).show();
        }else{
            return false;
        }
       
    });
    /** 
     * @param {dom element} obg дом элемент
     * @param {int} number число которое характерезует в каком мести мтроки обозначен id
     * @returns Возврашаем id передоваемого елемента
     */
    function GetId(obg,number){
        var buffer = obg.id.split('-');
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
            var employeename = $(StartSelector+id).text();
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
    function GetStatusCard(id){
        var status_card = Number($('#status_card').val());
        console.log(status_card);
        if(status_card == 0){
            return true;
        }else{
            var employeename = $('#status_card').attr('data-user-card');
            console.log(employeename);
            alert('Вы уже редактируете '+employeename);
            return false;
        }
    }