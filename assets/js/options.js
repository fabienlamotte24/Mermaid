//Affichage des villes à l'aide du code postal
$(function () {
    $('#newPostalCode').bind('input', function () {
        $.post('../../controllers/optionsCtrl.php', {
            newPostalSearch: $('#newPostalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#newCitySelect').empty();
                $('#newCitySelect').append('<option selected disabled name="0" value="0">Votre ville</option>');
                $.each(cities, function (cityKey, city) {
                    $('#newCitySelect').append('<option value="' + city.id + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                });
            }
        },
                'JSON');
    });
    $('#newCitySelect').change(function () {
        $('#newPostalCode').val($('#newCitySelect option:selected').attr('zipcode'));
    });
});