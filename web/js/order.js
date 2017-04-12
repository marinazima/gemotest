$(document).ready(function () {	

$('#order-form').on('beforeSubmit', function(e) {
     var form = $(this);
     var formData = form.serialize();
     
     // return false if form still have some validation errors
     if (form.find('.has-error').length) {
          return false;
     }

     //console.log(formData);
    // submit form
     $.ajax({
        url: form.attr('action'),
        type: 'post',
        data: formData,
        beforeSend: function (xhr) {
            return xhr.setRequestHeader('X-PJAX', 'true'); // IMPORTANT
        },          
        success: function (data) {
            var message = data.discount == 0 ? 'Скидка не предоставляется' : 'Скидка на заказ '+data.discount+'%';
            $('#modDiscount .x-discount').html(message);
            
            $('#b-discount-ok').bind('click', function() {
                document.location.href = data.view_url;
            });            
            
            $('#modDiscount').modal('show');
        },
        error: function(err){
            console.log(err);
            alert('error');
        }
     });
     
     return false;
}).on('submit', function(e){
    e.preventDefault();
});

});

