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

  // on button click
  $('#p1FireButtonId').click(function(){
     $('#formHiddenInputForP1Choice').attr('value',"fire"); 
  });
});
