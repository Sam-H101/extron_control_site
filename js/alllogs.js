
$(document).ready(function() {
    var t = $('#logs').dataTable({
        aaSorting: [[0, "desc"]],
        "ajax": {
          "url": '../scripts/logcount.php?sec1=all_log', 
          "dataSrc": ""
           },
        "columns": [
            { "data": "logid" },
            { "data": "Date" },
            { "data": "log_desc" }
         
        ]
                                 
       
    });
    
});
