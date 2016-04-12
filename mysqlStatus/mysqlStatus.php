<?php
require 'vendor/autoload.php';
//Here you can put you servers ips, you are not limeted 
$cluster   = array(
    "Clustera" => "10.1.1.1", //add here an ip
    "clusterb" => "10.1.1.1", //add here more ip
    "clusterc" => "10.0.1.6" //you can add as many as you dlike
);
function sendMail($serverIp, $port)
{
        //initialize new sendgrd class -provide your credencial
        $sendgrid = new SendGrid('********', '********');
    $email = new SendGrid\Email();
    //here add your mail preferences
    $email->addTo('someone@example.com')->setFrom('someone@example.com')->setSubject("the server {$serverIp} is down")->setText("This is a message a to inform you that Server {$serverIp} at port {$port} is down");
    $sendgrid->send($email);
 
    
    
}
function status($host,$port,$timeout=6){
                $fsock = fsockopen($host, $port, $errno, $errstr, $timeout);
                if ( ! $fsock )
                {
                        return FALSE;
                }
                else
                {
                        return TRUE;
                }   
}
//check mysq servers
echo "checking mysql servers...\n";
foreach ($cluster as $serverName => $serverIp) {
    if (!status($serverIp, '3306')) {
        sendMail($serverIp, '3306');
    }
}
