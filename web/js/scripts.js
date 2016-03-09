$(document).ready(function() {
  // Needed for material design to work
  $('select').material_select();

  // Stats page function
  $('#computer').hide();

  $('#player_stats').click(function() {
    $('#player').show();
    $('#computer').hide();
  });

  $('#computer_stats').click(function() {
    $('#player').hide();
    $('#computer').show();
  });

 // on button click Player1

 $('#player_two_options').hide();
 $('#pVpSubmit').hide();

  $('#p1_rock').click(function(){
     $('#p1_hiddenInput').attr('value',"rock");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

  $('#p1_paper').click(function(){
     $('#p1_hiddenInput').attr('value',"paper");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

  $('#p1_scissors').click(function(){
     $('#p1_hiddenInput').attr('value',"scissors");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

  $('#p1_air').click(function(){
     $('#p1_hiddenInput').attr('value',"air");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

  $('#p1_fire').click(function(){
     $('#p1_hiddenInput').attr('value',"fire");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

  $('#p1_water').click(function(){
     $('#p1_hiddenInput').attr('value',"water");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

  $('#p1_sponge').click(function(){
     $('#p1_hiddenInput').attr('value',"sponge");
     $('#player_one_options').hide();
     $('#player_two_options').show();
  });

// on button click Player 2

$('#p2_rock').click(function(){
   $('#p2_hiddenInput').attr('value',"rock");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});

$('#p2_paper').click(function(){
   $('#p2_hiddenInput').attr('value',"paper");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});

$('#p2_scissors').click(function(){
   $('#p2_hiddenInput').attr('value',"scissors");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});

$('#p2_air').click(function(){
   $('#p2_hiddenInput').attr('value',"air");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});

$('#p2_fire').click(function(){
   $('#p2_hiddenInput').attr('value',"fire");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});

$('#p2_water').click(function(){
   $('#p2_hiddenInput').attr('value',"water");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});

$('#p2_sponge').click(function(){
   $('#p2_hiddenInput').attr('value',"sponge");
   $('#player_two_options').hide();
   $('#pVpSubmit').show();
});


});
