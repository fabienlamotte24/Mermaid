//Gestion de l'affichage pour profile.php
//Changement de la présentation de l'utilisateur 
$(document).ready(function () {
    $('.changePresentation').click(function () {
        $('.showPresentation').show();
        $('.changePresentation').hide();
    });
});
//Ajout photo de groupe
$(document).ready(function () {
    $('#linkAddPhotos').click(function () {
        $('#linkAddPhotos').hide();
        $('.displayPhotos').hide();
        $('.formAddPhotos').show();
    });
});
//============================================================================ Paramètre band =========================================================
//Paramètres changement nom et photo de profil et suppression du groupe
$(document).ready(function () {
    $('.linkBandModalParameters1').click(function () {
        $('#changeNameBandParameters').show();
        $('#changePhotoBandParameters').hide();
        $('#changePresentationBandParameters').hide();
        $('#removeBandParameters').hide();
        $('#listBandPhoto').hide();
        $('.listBandModal').hide();
    });
    $('.linkBandModalParameters2').click(function () {
        $('#changeNameBandParameters').hide();
        $('#changePhotoBandParameters').show();
        $('#changePresentationBandParameters').hide();
        $('#removeBandParameters').hide();
        $('#listBandPhoto').hide();
        $('.listBandModal').hide();
    });
    $('.linkBandModalParameters3').click(function () {
        $('#changeNameBandParameters').hide();
        $('#changePhotoBandParameters').hide();
        $('#changePresentationBandParameters').show();
        $('#removeBandParameters').hide();
        $('#listBandPhoto').hide();
        $('.listBandModal').hide();
    });
    $('.linkBandModalParameters4').click(function () {
        $('#changeNameBandParameters').hide();
        $('#changePhotoBandParameters').hide();
        $('#changePresentationBandParameters').hide();
        $('#removeBandParameters').show();
        $('#listBandPhoto').hide();
        $('.listBandModal').hide();
    });
    $('#linkAddPhotos').click(function () {
        $('#formAddPhotos').show();
        $('#blockAddPhotos').hide();
        $('#listBandPhoto').hide();
        $('#linkAddPhotos').hide();
        $('.bandPhoto').hide();
    });
});
//====================================================================== Paramètre entreprise ======================================================
//Paramètres changement nom et photo de profil et suppression du compte entreprise
$(document).ready(function () {
    $('.linkProParameters1').click(function () {
        $('#changeNameForm').show();
        $('#proParametersList').hide();
        $('#changePhotoForm').hide();
        $('#removeCompany').hide();
    });
    $('.linkProParameters2').click(function () {
        $('#changePhotoForm').show();
        $('#changeNameForm').hide();
        $('#proParametersList').hide();
        $('#removeCompany').hide();
    });
    $('.linkProParameters3').click(function () {
        $('#removeCompany').show();
        $('#changePhotoForm').hide();
        $('#changeNameForm').hide();
        $('#proParametersList').hide();
    });
});
//Carousel pour photo
$(document).ready(function () {
    $('#carousel').owlCarousel({
        stagePadding: 50,
        autoplay:true,
        loop: false,
        margin: 10,
        nav: true,
        dots:true,
        responsive: {
            0: {
                items: 2
            },
            600: {
                items: 4
            },
            1000: {
                items: 10
            }
        }
    });
    $('#blockBand').owlCarousel({
        stagePadding: 5,
        autoplay:false,
        loop: false,
        margin: 1,
        nav: true,
        dots:true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 2
            }
        }
    });
    $('.blockEstablishement').owlCarousel({
        stagePadding: 5,
        autoplay:false,
        loop: false,
        margin: 1,
        nav: true,
        dots:true,
        responsive: {
            0: {
                items: 1
            },
            600: {
                items: 3
            },
            1000: {
                items: 2
            }
        }
    });
//Gestion de la suppression des photos pour l'utilisateur
   $('.remove').click(function(){
     var a = $(this);
     $.post('../../controllers/profileCtrl.php', {
        photoGalery: $(this).prev().children().attr('idphoto')
     }, function(){
         a.parent().remove();
     });
   });
   $('.linkChangeInstrument').click(function(){
       $('.changeInstrument').show();
       $('.showRoleOfMusician').hide();
   });
});