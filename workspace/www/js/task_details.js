// Show task details JS package

// Requires <div id="modal-container"> for modal markup
function task_details( task_id, event ){
  var formData = {
    'TDtaskid' : task_id
  };

  $.ajax({
    url: "/action/task_details.php",
    type: "POST", 
    data: formData, 
    dataType: "html"
  })
  .done(function( response ) {          
    $('#modal-container').html( response );
    $('#details-modal').modal('show');
  })
  .fail(function( xhr ) {
    alert("ERROR! Details unavailable, no connection");
  });    

  event.preventDefault();
}

// Handles details' pin <span>
function pin(isPinned, event){     
  isPinned ? $('input[name=pinned').val('0') : $('input[name=pinned').val('1');
  $('#pin-span').toggleClass('pinned unpinned');     
  event.preventDefault();
}

// Handles task update
function task_update( taskid, event ){
  var formData = {
    'TUFtaskid' : taskid, 
    'TUFpinned' : $('input[name=pinned]').val(),
    'TUFstatus' : $('#status-select :selected').val(),
    'TUFdescription' : $('textarea[name=description]').val(),
    'TUFuser' : $('#user-select :selected').text(),
    'TUFuserid' : $('#user-select :selected').val(),
    'TUFdeadline' : $('input[name=deadline]').val(),
    'TUFcomment' : $('textarea[name=comment]').val()
  };

  if( !formData['TUFuserid'] ){
    formData['TUFuser'] = null;
    formData['TUFuserid'] = null;
  }

  $.ajax({
    url: "/action/task_update.php",
    type: "POST", 
    data: formData, 
    dataType: "html"
  })
  .done(function( response ) {
    $('#details-modal').modal('hide');
    table_make();
  })
  .fail(function( xhr ) {
    alert( "ERROR! Database down." );
  });

  event.preventDefault();
}