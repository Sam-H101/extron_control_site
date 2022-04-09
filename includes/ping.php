<?php





// used to ping ip address because no use in sending commands if it is false

function pingAddressWebpage($ip) {
    $pingresult = exec("/bin/ping -c2 -w2 $ip 2>&1", $outcome, $status);  
    echo $status;
    var_dump($outcome);
    if ($status==0) {
    $status = "alive";
    } else {
    $status = "dead";
    }
    $message = "";
    $message .= '<div id="dialog-block-left">';
    $message .= '<div id="ip-status">The IP address, '.$ip.', is  '.$status.'</div><div style="clear:both"></div>';    
    return $message;
}




function pingAddress($ip) {
    
    $ping = exec("/bin/ping -c 1 -w 1 $ip", $output, $status);
    if ($status == 0)
    {
        return '<span style="color:green;">ONLINE</span>';
        
    } else {
        return '<span style="color:#f00;">OFFLINE</span>';
    }
}

?>
