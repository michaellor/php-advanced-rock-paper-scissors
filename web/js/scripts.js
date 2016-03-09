$(document).ready(function() {
  // Needed for material design to work
  $('select').material_select();

  // Stats page function
  $('#computer').hide();

  $('#player_stats').click(function() {
    console.log("Triggered Click Callback!");
    $('#player').show();
    $('#computer').hide();
  });

  $('#computer_stats').click(function() {
    console.log("Triggered Click Callback!");
    $('#player').hide();
    $('#computer').show();
  });
  
});
