/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function() {
    // For registering
    if(action == 'create' || action == 'edit' ){
        $('form#UserCreateForm').validate({
            rules: {
                'data[User][first_name]': {
                    required: true,
                },
                'data[User][last_name]': {
                    required: true,
                },
                'data[User][email]': {
                    required: true,
                    emailAddress: true,
                    remote: {
                        param : {
                            url: webroot + 'users/ajaxCheckExistence',
                            type: "post",
                            data: {
                                'field': function() { return 'email'; },
                                'value': function() { return $('#UserEmail').val(); }
                            },
                        },
                    }
                },
                'data[User][username]': {
                    required: true,
                    remote: {
                        param : {
                            url: webroot + 'users/ajaxCheckExistence',
                            type: "post",
                            data: {
                                'field': function() { return 'username'; },
                                'value': function() { return $('#UserUsername').val(); }
                            },
                        },
                    }
                },
                'data[User][password]': {
                    required: true,
                },
                'data[User][retype_password]': {
                    equalTo: ('#UserPassword'),
                },
                'agreeTermsAndConditions': {
                    required: true,
                },
            },
            messages: {
                'data[Account][first_name]': {
                    required: 'First Name is required.',
                },
                'data[Account][last_name]': {
                    required: 'Last Name is required.',
                },
                'data[User][email]': {
                    required: 'Email is required.',
                    emailAddress: 'Invalid email.',
                    remote : 'This email is already used by another person.',
                },
                'data[User][username]': {
                    required: 'Username is required.',
                    remote : 'This username is already used by another person.',
                },
                'data[User][password]': {
                    required: 'Password is required.',
                },
                'data[User][retype_password]': {
                    equalTo: 'Confirm password does not match.',
                },
                'agreeTermsAndConditions': {
                    required: 'You must agree with our Terms and Conditions.',
                },
            },
            onkeyup: false,
//            errorContainer: $('#signupForm').find('.errorContainer'),
//            errorLabelContainer: $('#signupForm').find('.errorContainer ul'),
//            wrapper: 'li'
        });
        
        // Enable to drag dialogs
        $('#termsDialog, #privacyDialog').draggable({cursor: "move"});

        $('#termsAndConditions').click(function(){
            scheduler.startLightbox(null, document.getElementById('termsDialog'));
            center($('#termsDialog'), $(window));
            return false;
        });
        
        $('#closeTermsDialog').click(function(){
            scheduler.endLightbox(false, document.getElementById('termsDialog'));
            return false;
        });
        
        $('#showPrivacy').click(function(){
            $('#termsDialog').hide();
            $('#privacyDialog').show();
            center($('#privacyDialog'), $(window));
            return false;
        });
        
        $('#closePrivacyDialog').click(function(){
            scheduler.endLightbox(false, document.getElementById('privacyDialog'));
            return false;
        });
    }
});

