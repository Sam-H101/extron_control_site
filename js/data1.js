 function format ( d ) {
	
    return '<h4>Description:  '+d.dt_desc+'</h4> <br> <center><button class="btn btn-primary" onClick="window.open(\'modifypart.php?id='+d.dt_id+'\')"> View and Edit </button> <button class="btn btn-primary" onClick="window.open(\'updateCount.php?id='+d.dt_id+'\')"> Update Count </button>  </center>';}

$(document).ready(function() {

    var dt = $('#showParts').DataTable( {
        "processing": true,
        "serverSide": true,
        "ajax": "scripts/get-data.php",
        "columns": [
            {
                "class":          "details-control",
                "orderable":      false,
                "data":           null,
                "defaultContent": ""
            },
            { "data": "dt_id" },
            { "data": "dt_partName" },
            { "data": "dt_barcode" },
			{ "data": "dt_toe" }
			
        ],
        "order": [[1, 'asc']]
    } );
 
    // Array to track the ids of the details displayed rows
    var detailRows = [];
	
    $('#showParts tbody').on( 'click', 'tr', function () {
        var tr = $(this).closest('tr');
        var row = dt.row( tr );
        var idx = $.inArray( tr.attr('dt_id'), detailRows );
 
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
                detailRows.push( tr.attr('dt_id') );
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

$(function(){
    $('.dropdown').hover(function() {
        $(this).addClass('open');
    },
    function() {
        $(this).removeClass('open');
    });
});
