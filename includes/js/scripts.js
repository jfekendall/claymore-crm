var this_location = location.protocol + '//' + window.location.hostname

$(document).ready(function() {
    var height = ($(window).height() - 20);
    $('.nav').css({'height': height});

    $('.enableModule').click(function() {
        var state = $(this).prop('checked');
        var module = this.id;

        $.ajax({
            url: this_location + "/includes/js/ajax/module_management.php?action=enableModule&current_state=" + state + "&module=" + module
        });
    });
});


