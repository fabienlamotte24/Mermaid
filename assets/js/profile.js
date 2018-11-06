//Gestion de l'affichage pour profile.php
//Changement de la présentation de l'utilisateur 
$(document).ready(function () {
    $('.changePresentation').click(function () {
        $('.showPresentation').show();
        $('.changePresentation').hide();
    });
});
//Ajout de photo utilisateur
$(document).ready(function () {
    $('.addPhotoLink').click(function () {
        $('#formPhoto').show();
        $('#photos').hide();
        $('.addPhotoLink').hide();
    });
});
//Changement de la photo de groupe
$(document).ready(function(){
   $('.changePhoto').click(function(){
       $('#formPhoto').show();
       $('.changeGroupPhotos').hide();
       $('#groupDescription').hide();
       $('.changePhoto').hide();
       $('.bandRemove').hide();
   }) ;
});
//Paramètres changement nom et photo de profil compte entreprise
$(document).ready(function(){
    $('.linkProParameters1').click(function(){
        $('#changeNameForm').show();
        $('#proParametersList').hide();
        $('#changePhotoForm').hide();
    });
    $('.linkProParameters2').click(function(){
        $('#changePhotoForm').show();
        $('#changeNameForm').hide();
        $('#proParametersList').hide();
    });
});