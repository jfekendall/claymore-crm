$(function() {
    $('.clientAdd').click(function() {
        $('.clientAddForm').slideToggle();
    });
    $('input[name=postal_code]').blur(function() {
        var correct = $.ajax({
            url: this_location +"/includes/js/ajax/setCorrectCityState.php?zip=" + $(this).val(),
            async: false
        }).responseText;
        if (correct) {
            var correctArray = correct.split(',');
            $('input[name=city]').val(correctArray[0]);
            $('select[name=state] option[value=' + correctArray[1] + ']').attr('selected', true);
        }
    });
    $('.addNewClient').click(function() {
        var required = new Array('business_name', 'password', 'email', 'phone', 'street_1', 'city', 'postal_code');
        var stop = 0;
        var ohCrap = '';
        var ajaxUrl = this_location + "/includes/modules/clients/js/clients.php?i=newClient";
        required.forEach(function(req) {
            if (!$('input[name=' + req + ']').val()) {
                req = req.replace('_', ' ');
                req = req.replace(/\w\S*/g, function(txt) {
                    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
                });
                ohCrap = ohCrap + "Required field " + req + " is empty.<br>";
                stop = 1;
            } else {
                if (req === 'phone') {
                    var phone = phoneFormat($('input[name=' + req + ']').val());
                    ajaxUrl = ajaxUrl + "&" + req + "=" + escape(phone);
                } else {
                    ajaxUrl = ajaxUrl + "&" + req + "=" + escape($('input[name=' + req + ']').val());
                }
            }
        });
        if (stop === 1) {
            $('.alert-danger').slideToggle('fast');
            $('.alert').addClass('alert-danger');
            $('.alert').html(ohCrap);
            $('.alert-danger').slideToggle('fast');
            return;
        }
        ajaxUrl = ajaxUrl + "&is_main_office=1";
        ajaxUrl = ajaxUrl + "&street_2=" + escape($('input[name=street_2]').val());
        ajaxUrl = ajaxUrl + "&state=" + $('select[name=state]').val();

        var error = $.ajax({
            url: ajaxUrl,
            async: false
        }).responseText;
        if (error) {
            $('.alert-success').slideToggle('fast');
            $('.alert').addClass('alert-success');
            $('.alert').removeClass('alert-danger');
            $('.alert').html(error);
            $('.alert-success').slideToggle('fast');
        }
    });
}
);