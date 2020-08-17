'use strict';
/////////////////////////////////////////////////////////////////////////////////////////
// FONCTIONS                                                                           //

function checkForms(){
    
    if(typeof FormValidate  === "function"){

        const formValidate = new FormValidate( $('form') );
        console.log(formValidate);
    }

}

/////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////////////////////////////////////////////////////
//                               Main Code                                             //
/////////////////////////////////////////////////////////////////////////////////////////
$(function(){
    $(".flashbag").delay(1000).fadeOut(1000);

    const errorMessage = $('.error-message');
    if( errorMessage.children('p').length > 0 ){
        errorMessage.fadeIn();
    }

    checkForms();

    $('[data-confirm]').click((event)=>{
        if(!window.confirm('Are you sure you want to delete it ?')){
            event.preventDefault();
        }
    });

    // Burger bar
    function onClickRemoveMenu() {

        $('#main-menu').css('display', 'none');

        location.reload();
    }

    function onClickDisplayMenu(){

        $('#main-menu').css('display', 'flex');

        $('.fa-bars').click(onClickRemoveMenu);
    }

    // Retrieve bars and main menu
    $('.fa-bars').click(onClickDisplayMenu);

});










