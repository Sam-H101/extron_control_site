function format ( d ) {
    return '<center>'+
    '<form>'+
    '<input type="button" class="btn btn-default" value="Delete ?" onclick="window.location.href='+'\'removenode.php?ip='+d.dt_ipaddr+'\'" ></input>'+
    '<input type="button" class="btn btn-default" value="Modify ?" onclick="window.location.href='+'\'modifynode.php?ip='+d.dt_ipaddr+'\'" ></input>'+
    '</form>'+
    '</center>';

}
 
$(document).ready(function() {
    var dt = $('#listRecorders').DataTable( {
        "processing": true,
        "serverSide": true,
		"autoWidth": true,
        "ajax": "../scripts/allnodetojson.php",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
           
            { "data": "dt_ipaddr" },
            { "data": "dt_location" },
            { "data": "dt_commonname" },
            { "data": "status"}
           
        ],
        "order": [[1, 'asc']]
    } );
 
    // Array to track the ids of the details displayed rows
    var detailRows = [];
 
    $('#listRecorders tbody').on( 'click', 'tr td.details-control', function () {
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