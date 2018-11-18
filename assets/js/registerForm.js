//Affichage des ville dans proRegisterCtrl.php et proRegister.php
$(function () {
    $('#postalCode').bind('input', function () {
        $.post('../../controllers/proRegisterCtrl.php', {
            postalSearch: $('#postalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#citySelect').empty();
                $('#citySelect').append('<option selected disabled name="0" value="0">Votre ville</option>');
                $.each(cities, function (cityKey, city) {
                    $('#citySelect').append('<option value="' + city.id + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                });
            }
        },
                'JSON');
    });
    $('#citySelect').change(function () {
        $('#postalCode').val($('#citySelect option:selected').attr('zipcode'));
    });
});
//Affichage des ville dans proRegisterCtrl.php et proRegister.php
$(function () {
    $('#postalCode').bind('input', function () {
        $.post('../../controllers/proRegisterCtrl.php', {
            postalSearch: $('#postalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#citySelect').empty();
                $('#citySelect').append('<option selected disabled name="0" value="0">Votre ville</option>');
                $.each(cities, function (cityKey, city) {
                    $('#citySelect').append('<option value="' + city.id + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                });
            }
        },
                'JSON');
    });
    $('#citySelect').change(function () {
        $('#postalCode').val($('#citySelect option:selected').attr('zipcode'));
    });
});
//Affichage des ville dans musicianRegisterCtrl.php et musicianRegister.php
$(function () {
    $('#postalCode').bind('input', function () {
        $.post('../../controllers/musicianRegisterCtrl.php', {
            postalSearch: $('#postalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#citySelect').empty();
                $('#citySelect').append('<option selected disabled name="0" value="0">Votre ville</option>');
                $.each(cities, function (cityKey, city) {
                    $('#citySelect').append('<option value="' + city.id + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                });
            }
        },
                'JSON');
    });
    $('#citySelect').change(function () {
        $('#postalCode').val($('#citySelect option:selected').attr('zipcode'));
    });
});

//Le même code que le premier servant cette fois-ci au remplissage du changement de l'adresse postale
$(function () {
    $('#newPostalCode').bind('input', function () {
        $.post('../../controllers/optionsCtrl.php', {
            newPostalSearch: $('#newPostalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#newCitySelect').empty();
                $('#newCitySelect').append('<option selected disabled name="0" value="0">Votre code postal</option>');
                $.each(cities, function (cityKey, city) {
                    console.log(cities);
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