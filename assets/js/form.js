$(function () {
    $('#postalCode').bind('input', function () {
        $.post('../../controllers/registerCtrl.php', {
            postalSearch: $(this).val()
        }, function (cities) {
            if (cities !== '') {
                $('#citySelect').empty();
                $('#citySelect').append('<option selected disabled name="0" value="0">Votre code postal</option>');
                $.each(cities, function(cityKey, city){
                    $('#citySelect').append('<option value="' + city.id + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                });
            }
        }, 
        'JSON');
    });
});

$('#citySelect').change(function(){
    $('#postalCode').val($('#citySelect option:selected').attr('zipcode'));
    });