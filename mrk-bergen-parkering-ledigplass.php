<?php
/*
Plugin Name: Markant - Bergen pakering - ledige plasser
Plugin URI: http://vc.wpbakery.com
Description: [bergenpledig get="KlosterGarasjen|ByGarasjen|Nordnes|ByGarasjenLadepunkter|KlosterGarasjenLadepunkter|NordnesLadepunkter|ByGarasjenPris|KlosterGarasjenPris|NordnesPris|Sist oppdatert"]
Version: 0.0.2
Author: Markant
Author URI: http://markant.no
*/

function upload_dir() {
    $upload_dir   = wp_upload_dir();
    return isset($upload_dir['basedir'])?$upload_dir['basedir']:".";
}

function DownloadNewInfo() {
    $headr = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: basic ' . base64_encode("test:test");

     $options = array(
        CURLOPT_RETURNTRANSFER => true,   // return web page
        CURLOPT_HEADER         => false,  // don't return headers
        CURLOPT_FOLLOWLOCATION => true,   // follow redirects
        CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
        CURLOPT_ENCODING       => "",     // handle compressed
        CURLOPT_USERAGENT      => "test", // name of client
        CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
        CURLOPT_CONNECTTIMEOUT => 120,    // time-out on connect
        CURLOPT_TIMEOUT        => 120,    // time-out on response
        CURLOPT_HTTPHEADER     => $headr
    ); 

    $ch = curl_init("http://api.ledig-parkering.no/freespaces");
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);

    curl_close($ch);

    $tempFile = upload_dir() . '/ledigeplasser.ser';
    
    file_put_contents($tempFile, serialize(json_decode($content, true)));
}


function GetFileData($cache = 0) {
    if (!isset($GLOBALS['bergeparkering-cache'])) {
        $tempFile = upload_dir() . '/ledigeplasser.ser';

        if ($cache > 0 && file_exists($tempFile) && filemtime($tempFile)+$cache > time()) {
            $GLOBALS['bergeparkering-cache'] = unserialize(file_get_contents($tempFile));
        } else {
            DownloadNewInfo();
            $GLOBALS['bergeparkering-cache'] = unserialize(file_get_contents($tempFile));
        }
    }
    
    return $GLOBALS['bergeparkering-cache'];
}

function bergenpledig_shortcode( $atts ){
    $a = shortcode_atts( array(
        
        /* Can be: KlosterGarasjen  or  ByGarasjen  or "Sist oppdatert" */
        'get' => 'KlosterGarasjen',
        
        /* Amount of seconds to cache http://bergenparkering.com/ledigeplasser-svg.php in file. Set to 0 to disable. */
        'cache' => 300
    ), $atts );

    $data = GetFileData((int) $a['cache']);
    switch (!empty($a['get'])?$a['get']:"") {
        
        case 'ByGarasjen':
            return $data['data']['bygarasjen']['NumFreeSpaces'];
        case 'KlosterGarasjen':
            return $data['data']['klostergarasjen']['NumFreeSpaces'];
        case 'Nordnes':
            return $data['data']['nordnes']['NumFreeSpaces'];
            
        case 'ByGarasjenLadepunkter':
            return $data['data']['bygarasjen']['NumAvailableChargepoints'];
        case 'KlosterGarasjenLadepunkter':
            return $data['data']['klostergarasjen']['NumAvailableChargepoints'];
        case 'NordnesLadepunkter':
            return $data['data']['nordnes']['NumAvailableChargepoints'];
            
        case 'ByGarasjenPris':
            return $data['data']['bygarasjen']['CurrentPrice'];
        case 'KlosterGarasjenPris':
            return $data['data']['klostergarasjen']['CurrentPrice'];
        case 'NordnesPris':
            return $data['data']['nordnes']['CurrentPrice'];
            
        case 'Sist oppdatert':
            return $sistOppdatert;
        default: return "";
    }
    
    return '';
}

add_shortcode( 'bergenpledig', 'bergenpledig_shortcode' );