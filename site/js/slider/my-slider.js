/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    $('#product_gallery_thumbs .thumb').click(function(){
        
        index = $(this).index();
        
        $('#slider').animate({ left: index * 450 * -1 + 'px'});
        
    });
    
});