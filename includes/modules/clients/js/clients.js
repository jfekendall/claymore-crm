$(function() {
    $('.clientAdd').click(function() {
        $('.clientAddForm').slideToggle();
    });
    $('input[name=postal_code]').blur(function() {
        var correct = $.ajax({
            url: this_location + "/includes/js/ajax/setCorrectCityState.php?zip=" + $(this).val(),
            async: false
        }).responseText;
        if (correct) {
            var correctArray = correct.split(',');
            $('input[name=city]').val(correctArray[0]);
            $('select[name=state] option[value=' + correctArray[1] + ']').attr('selected', true);
        }
    });
}
);

