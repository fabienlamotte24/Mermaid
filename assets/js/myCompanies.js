//Affichage des ville dans proRegisterCtrl.php et proRegister.php
$(function () {
    $('#postalCode').bind('input', function () {
        $.post('../../controllers/myCompaniesCtrl.php', {
            postalSearch: $('#postalCode').val()
        }, function (cities) {
            if (cities !== '') {
                $('#city').empty();
                $('#city').append('<option selected disabled name="0" value="0">Votre ville</option>');
                $.each(cities, function (cityKey, city) {
                    $('#city').append('<option value="' + city.city + '" zipCode="' + city.postalCode + '">' + city.city + '</option>');
                });
            }
        },
                'JSON');
    });
    $('#city').change(function () {
        $('#postalCode').val($('#city option:selected').attr('zipcode'));
    });
});
$('.custom-file-input').on('change', function() {
    let fileName = $(this).val().split('\'').pop();
    $(this).siblings('.custom-file-label').addClass("selected").html(fileName);
});