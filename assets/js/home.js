$(document).ready(function(){
   $("#connectHome").click(function(){
       $(".connectBlock").show();
       $(".welcome").hide();
       $(".signBlock").hide();
   });
   $('#signHome').click(function(){
       $('.connectBlock').hide();
       $('.welcome').hide();
       $('.signBlock').show();
       $('.errorConnect').hide();
   });
   $('.backHome').click(function(){
        location.reload();
   });
   $('#connectHome').outclick(function(){
       $('.connectBlock').hide();
       $('.welcome').show();
       $('.signBlock').hide();
   });
});

