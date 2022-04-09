function format ( d ) {
    return  '<form class="form-inline" role="form" name="delGroup" id="delGroup" method="post" action="../scripts/delGroup.php">'+
                                        '<center>'+                           
                                                  '<input  type="hidden"class="btn btn-primary" type="submit" name="Delete" value="Delete?" type="button" />'+
                                                   '<input type="hidden" name="GroupID" value="'+d.dt_groupID+'" />'+
                                                   '<input class="btn" type = "button" value="Modify" onCLick=modifyPermGroup('+ d.dt_groupID  +')> </>' +
                                            
                                       '</center>'+
                                       '</form>';

}

var dt;

function modifyPermGroup(groupID)
{
  window.location.href = "modifypermroles.php?group="+groupID;

}

function bindtable() {

  dt = $('#modroles').DataTable( {
        "processing": true,
        "serverSide": true,
		"autoWidth": true,
        "ajax": "../scripts/allroles.php",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
           
           
            { "data": "dt_GCN" }
         
            

        ],
        "order": [[1, 'asc']]
    } );
    
    }

	
$(document).ready(function() {
    bindtable();
 
    // Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#modroles tbody').on( 'click', 'tr td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('id'), detailRows );
 
        if ( row.child.isShown() ) {
            tr.removeClass( 'details' );
            row.child.hide();
 
            // Remove from the 'open' array
            detailRows.splice( idx, 1 );
        }
        else {
            tr.addClass( 'details' );
            row.child( format( row.data() ) ).show();
 
            // Add to the 'open' array
            if ( idx === -1 ) {
                detailRows.push( tr.attr('id') );
            }
        }
    } );
 
    // On each draw, loop over the `detailRows` array and show any child rows
    dt.on( 'draw', function () {
        $.each( detailRows, function ( i, id ) {
            $('#'+id+' td.details-control').trigger( 'click' );
        } );
    } );
} );


    // on form submit do add and redraw
    $("#addGroup").submit(function(e) {
     e.preventDefault(); // avoid to execute the actual submit of the form.
    var url = $(this).attr("action"); // the script where you handle the form input.
    var request = $(this).attr("method"); // get get or post
    var form_data = $(this).serialize();
    $.ajax({
           type: request,
           url: url,
           data: form_data, // serializes the form's elements.
              }).done(function(response){ //
        $("#server-results").html(response);
        var table = $('#modroles').DataTable();
        table.ajax.reload();
   });
   
});

    // on form submit do add and redraw
    $("#addGroupPerm").submit(function(e) {
     e.preventDefault(); // avoid to execute the actual submit of the form.
    var url = $(this).attr("action"); // the script where you handle the form input.
    var request = $(this).attr("method"); // get get or post
    var form_data = $(this).serialize();
    $.ajax({
           type: request,
           url: url,
           data: form_data, // serializes the form's elements.
              }).done(function(response){ //
        $("#server-results").html(response);
        var table = $('#modgroupperms').DataTable();
        table.ajax.reload();
   });
   
});




  // on form submit do delete and redraw
    $("#delGroup").submit(function(e) {
     e.preventDefault(); // avoid to execute the actual submit of the form.
    var url = $(this).attr("action"); // the script where you handle the form input.
    var request = $(this).attr("method"); // get get or post
    var form_data = $(this).serialize();
    $.ajax({
           type: request,
           url: url,
           data: form_data, // serializes the form's elements.
              }).done(function(response){ //
        $("#server-results").html(response);
        var table = $('#modroles').DataTable();
        table.ajax.reload();
   });
   
});


    
