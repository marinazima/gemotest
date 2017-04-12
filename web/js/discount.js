$(document).ready(function () {	
    if(!$('#discount-phone_exists').prop('checked')){
        $('.field-discount-phone_tail').hide();
    }
    
    $('#discount-phone_exists').click(function(){
        if($(this).prop('checked')){
            $('.field-discount-phone_tail').show();            
        }else{
            $('.field-discount-phone_tail').hide();
            $('#discount-phone_tail').val('');
        }
    })
});


