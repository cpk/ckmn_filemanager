/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(function() {
    $(document).on('click', '.viewPermission', function(){
        var role_permissions = $(this).parents('tr:first').find('.role_permissions').html()
        $('.modal-body').html(role_permissions);
    });
});

