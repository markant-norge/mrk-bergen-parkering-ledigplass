<?php
/*
Plugin Name: Markant - Bergen pakering - ledige plasser
Plugin URI: http://vc.wpbakery.com
Description: [bergenpledig get="KlosterGarasjen|ByGarasjen|Sist oppdatert"]
Version: 0.0.1
Author: Markant
Author URI: http://markant.no
*/

/**
 * Copyright (C) Markant Norge AS - All Rights Reserved
 * Unauthorized copying of this file, via any medium is strictly prohibited
 * Proprietary and confidential
 *
 * @author petterk
 * @date 1/17/17 12:47 PM
 */

define("PARKERING_FTP_SERVER", "admftpssl2.bergen.kommune.no");
define("PARKERING_FTP_USERNAME", "bkparkering");
define("PARKERING_FTP_PASSWORD", "divan-97MpK");
define("PARKERING_FTP_FILE", "Parkering.txt");


/*
 * Get file on FTP server as a string
 */
function ftp_get_string($ftp, $filename) {
    $temp = fopen('php://temp', 'r+');
    if (@ftp_fget($ftp, $temp, $filename, FTP_BINARY, 0)) {
        rewind($temp);
        return stream_get_contents($temp);
    }
    else {
        return false;
    } 
}

/*
 * Download FTP file
 */
function getFileContentFormFTP() {
    $ftp = ftp_ssl_connect(PARKERING_FTP_SERVER);
    $login_result = @ftp_login($ftp, PARKERING_FTP_USERNAME, PARKERING_FTP_PASSWORD);
    if (!$login_result) {
        return false;
    }
    ftp_pasv($ftp, true);
    $str = ftp_get_string($ftp, PARKERING_FTP_FILE);
    ftp_close($ftp);
    
    return $str;
}

/*
 * Process downloaded CSV file
 */
function processParkeringFile($str) {
    $lines = explode("\n", $str);
    $klostergarasjen = false;
    $bygarasjen = false;
    $sistOppdatert = 0;
    foreach ($lines as $line) {
        if (!empty($line)) {
            $q = explode(";", $line);

            if (is_array($q) && sizeOf($q)>2) {
                if ($q[0]=="01") {
                    $bygarasjen = array(
                        "plasser" => intval($q[1]),
                        "oppdatert" => @strtotime($q[4])
                    );
                } else if ($q[0]=="02") {
                    $klostergarasjen = array(
                        "plasser" => intval($q[1]),
                        "oppdatert" => @strtotime($q[4])
                    );
                }   
            }
        }
    }

    return array($bygarasjen['plasser'], $klostergarasjen['plasser'], date("d.m.Y H:i", $klostergarasjen['oppdatert']));
}

function bergenpledig_shortcode( $atts ){
    $a = shortcode_atts( array(
        /* Can be: KlosterGarasjen  or  ByGarasjen  or "Sist oppdatert" */
        'get' => 'KlosterGarasjen',
        /* Amount of seconds to cache http://bergenparkering.com/ledigeplasser-svg.php in file. Set to 0 to disable. */
        'cache' => 300
    ), $atts );

    $get = $a['get'];
    $cache = (int)$a['cache'];

    $upload = wp_upload_dir();
    $tempFile = $upload['path'] . '/ledigeplasser.csv';

    if ($cache > 0 && file_exists($tempFile) && filemtime($tempFile)+$cache > time()) {
        list($bygarasjen, $klostergarasjen, $sistOppdatert) = explode(";", file_get_contents($tempFile));
    } else {
        list($bygarasjen, $klostergarasjen, $sistOppdatert) = @processParkeringFile(getFileContentFormFTP());
       @file_put_contents($tempFile, implode(";", array($bygarasjen, $klostergarasjen, $sistOppdatert)));
    }
    
    switch ($get) {
        case 'KlosterGarasjen':
            return $klostergarasjen;
        case 'ByGarasjen':
            return $bygarasjen;
        case 'Sist oppdatert':
            return $sistOppdatert;
        default: return "";
    }
    
    return '';
}
add_shortcode( 'bergenpledig', 'bergenpledig_shortcode' );