$(document).ready(function() {
    $('#btnCancel').click(function(){
            if(action == 'create') {
                location.href = webroot + 'permissions/index';
            } else {
                location.href = webroot + 'permissions/show/' + id;
            }
        });
});