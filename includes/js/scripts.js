var this_location = location.protocol + '//' + window.location.hostname

$(document).ready(function() {
    var height = ($(window).height() - 20);
    $('.nav').css({'height': height});
    $('.alert').css({'display': 'none'});

    $('.alert').click(function() {
        $(this).hide('fast');
    });

    $('.enableModule').click(function() {
        var state = $(this).prop('checked');
        var module = this.id;

        $.ajax({
            url: this_location + "/includes/js/ajax/module_management.php?action=enableModule&current_state=" + state + "&module=" + module
        });

        $('.alert-success').slideToggle('fast');
        $('.alert').addClass('alert-success');
        if (state === true) {
            $('.alert').html('Module Enabled! Refresh to see any changes in navigation.');
        } else {
            $('.alert').html('Module Disabled! Refresh to see any changes in navigation.');
        }
        $('.alert-success').slideToggle('fast');

    });
});


