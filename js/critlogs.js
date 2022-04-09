
$(document).ready(function() {
    $('#critlogs1').dataTable({
	aaSorting: [[0, "desc"]],
        "ajax": {
          "url": "../scripts/logcount.php?sec2=crit", 
          "dataSrc": ""
           },
        "columns": [
            { "data": "logid" },
            { "data": "Date" },
            { "data": "log_desc" }
         
        ]
                                   
       
    });
});
