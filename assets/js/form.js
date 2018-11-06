//Code Jquery pour afficher les villes en liste déroulantes
//qui correspondent à la valeur du code postale rentrée
//utilisé dans register.php et registerCtrl.php
$(function () {
    $('#postalCode').bind('input', function () {
        $.post('../../controllers/registerCtrl.php', {
            postalSearch: $('#postalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#citySelect').empty();
                $('#citySelect').append('<option selected disabled name="0" value="0">Votre code postal</option>');
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
//Code jQuery utilisé dans optionsPublic.php et publicCtrl.php
//Sert à l'affichage des formulaires dans la modification des informations générales de l'utilisateur
$(document).ready(function () {
    $('.eMailOptionTitle').click(function () {
        $('#eMailOptionForm').toggle();
        $('#addressOptionForm').hide();
        $('#phoneNumberOptionForm').hide();
    });
    $('.addressOptionTitle').click(function () {
        $('#addressOptionForm').toggle();
        $('#eMailOptionForm').hide();
        $('#phoneNumberOptionForm').hide();
    });
    $('.phoneNumberOptionTitle').click(function () {
        $('#phoneNumberOptionForm').toggle();
        $('#addressOptionForm').hide();
        $('#eMailOptionForm').hide();
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