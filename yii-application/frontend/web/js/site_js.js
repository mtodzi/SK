/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {

  var toggleAffix = function(affixElement, scrollElement, wrapper) {
  
    var height = affixElement.outerHeight(),
        top = wrapper.offset().top;
    
    if (scrollElement.scrollTop() >= top){
        wrapper.height(height);
        affixElement.addClass("affix");
        affixElement.addClass("navbar-dark");
    $('.img_nav').show();    
    }
    else {
        affixElement.removeClass("affix");
        affixElement.removeClass("navbar-dark");
        wrapper.height('auto');
        $('.img_nav').hide(); 
    }
      
  };
  

  $('[data-toggle="affix"]').each(function() {
    var ele = $(this),
        wrapper = $('<div></div>');
    ele.before(wrapper);
    $(window).on('scroll resize', function() {
        toggleAffix(ele, $(this), wrapper);
    });
    // init
    toggleAffix(ele, $(window), wrapper);
  });
});

//разворачивание текста в p за span по клику
$(function() {
    $('.letter_info').on('click', function() {
        $(this).next().toggle(1000);
    });
});

//предотвращение перехода по ссылке для проверки
$( "a" ).click(function( event ) {
  event.preventDefault();
  $( "<div>" )
    .append( "default " + event.type + " prevented" )
    .appendTo( "#log" );
});