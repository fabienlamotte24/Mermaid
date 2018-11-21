$('.removeNotif').click(function(){
       $.post('../../controllers/navCtrl.php', {
           messageToUpdate:$(this).attr('idMessage'),
           notifToRemove: $(this).attr('idNotif')
       }, function(){
           ;
       });
   });