
$(document).ready(function() {
    $('#allcountlogs').dataTable({
        "ajax": {
          "url": "../scripts/logcount.php?sec=log_count", 
          "dataSrc": ""
           },
        "columns": [
            { "data": "id" },
            { "data": "ipaddr" },
            { "data": "recCount" },
            { "data": "timestamp" }
        ]
                                   
       
    });
});
