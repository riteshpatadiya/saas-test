import './bootstrap'; 
import './admin/product-variants-form';

$(function(){
    setTimeout(function(){
        $('[data-flash-message]').remove();
    }, 4000);

    $('[data-flash-message] button').on('click', function(){
        $(this).parent().remove();
    });
    
});