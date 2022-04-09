
 
$(document).ready(function() {
    var dt = $('#removeRecorders').DataTable( {
        "processing": true,
        "serverSide": true,
		"autoWidth": true,
        "ajax": "../scripts/allnodetojson.php",
        "columns": [

            { "data": "dt_ipaddr" },
            { "data": "dt_location" },
            { "data": "dt_commonname" },
            {data : null, "title" : "Modify Node?", "render" : function(data, type, row, meta) {
				      
              var ip = row['dt_ipaddr'];
              console.log(ip);
              data = '<input type="button" class="btn btn-default" value="Modify ?" onclick="window.location.href='+'\'modifynode.php?ip='+ip+'\'" ></input>';
              
				  //console.log(date);
			
			
				 return data;
        },}
            
        ],
        "order": [[1, 'asc']]
    } );
 
    // Array to track the ids of the details displayed rows
    var detailRows = [];
 
   $('#updateNode').on('click', function(){
     var ip = document.getElementById("ipAddressField").value;
     var loc = document.getElementById("locationText").value;
     var Building = document.getElementById("buildingText").value;
     var user = document.getElementById("AdminUsername").value;
     var pass = document.getElementById("adminPassword").value;
     var in1 = document.getElementById("TopInput").value;
     var in2 = document.getElementById("bottomInput").value;
     var oldip = document.getElementById("oldipAddressField").value;
   
    $.ajax({
             url: '/scripts/processmodify.php',                 
             method : 'POST',
            
             async: false,
             data: { ip : ip, loc : loc, Building : Building, user : user, pass : pass, in1 : in1, in2 : in2, oldip : oldip },
              // serializes the form's elements.
            success : function(data) {
              alert("Successful Update");
            window.location.href = "modifynode.php";
            },
         
        });
   
   });
  
   
} );