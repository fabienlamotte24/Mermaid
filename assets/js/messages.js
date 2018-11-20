$(document).ready(function () {
    $('#newMessage').click(function () {
        $('#messageSelected').hide();
        $('#newMessageBlock').show();
    });
    $('#messageSent').click(function(){
        $('#messagesSentBox').show();
        $('#receptionBox').hide();
    });
    $('#reception').click(function(){
        $('#messagesSentBox').hide();
        $('#receptionBox').show();
    });
   $('.linkChangeInstrument').click(function(){
       $('.changeInstrument').show();
       $('.showRoleOfMusician').hide();
   });
   $('#answerMessage').click(function(){
       $('#messageAnswer').show();
       $('#messageSelected').hide();
   });
   $('.messageReading').click(function(){
       $.post('../../controllers/messagesCtrl.php', {
           idToRead: $(this).attr('idMessage')
       }, function(){
           
       });
   });
});
