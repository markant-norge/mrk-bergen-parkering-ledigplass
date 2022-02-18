<?php
/*
Plugin Name: Markant - Bergen Parkering
Plugin URI: http://vc.wpbakery.com
Description: [bergenpledig get="KlosterGarasjen|ByGarasjen|Nordnes|ByGarasjenLadepunkter|KlosterGarasjenLadepunkter|NordnesLadepunkter|ByGarasjenPris|KlosterGarasjenPris|NordnesPris|Sist oppdatert"]
Version: 1.0.2
Author: Markant
Author URI: http://markant.no
*/

function upload_dir() {
    $upload_dir   = wp_upload_dir();
    return isset($upload_dir['basedir'])?$upload_dir['basedir']:".";
}

/**
 * Create admin Page to list unsubscribed emails.
 */
add_action('admin_menu', 'mlpwp_pages');

/**
 * Adds a new top-level page to the administration menu.
 */
function mlpwp_pages() {
    add_menu_page(
       __( 'Bergen Parkering', 'textdomain' ),
       __( 'Bergen Parkering','textdomain' ),
       'manage_options',
       'mlpwp-admin',
       'mlpwp_pages_callback',
       ''
   );
}

/**
 * Disply callback for the Unsub page.
 */
function mlpwp_pages_callback() {
    ?>
    <style>
        body {background-color: #d0cece; }
        .widefat tfoot tr td, .widefat tfoot tr th, .widefat thead tr td, .widefat thead tr th {
            font-weight: 600;
        }
        #homelinksss {
            color: #fff;
        }
    </style>
    
    <div style="width: 70%; margin: 0 auto; padding: 20px; margin-bottom: 30px;">
        <center>
            <img src="https://ledig-parkering.no/wp-content/uploads/logo-bergen-parkering-04-200x66.png" />
            <h3 style="color: #fff; display: none;">Ledige plasser</h3>
        </center>
    </div>
    
    <div class="" style="margin: 0 auto; width: 70%; min-height: 300px; background-color: #fff; box-shadow: 2px 2px 8px 0px #ccc; padding: 20px;">
        <h2>Authentication</h2>
        <form method="post" action="options.php">
          <?php settings_fields( 'myplugin_options_group' ); ?>
          <p>API token and token key. <a href="https://api.ledig-parkering.no/signup/" target="_blank">Request access</a></p>
          <table>
          <tr valign="top">
            <th scope="row"><label for="myplugin_option_name">Token</label></th>
            <td><input type="text" id="lp_option_token" name="lp_option_token" value="<?php echo get_option('lp_option_token'); ?>" /></td>
          </tr>
          <tr valign="top">
              <th scope="row"><label for="myplugin_option_name">Token key</label></th>
              <td><input type="password" id="lp_option_tokenkey" name="lp_option_tokenkey" value="<?php echo get_option('lp_option_tokenkey'); ?>" /></td>
          </tr>
          </table>
          <?php  submit_button(); ?>
          </form>
        <h2>Shortcodes</h2>

        <table class="widefat fixed" cellspacing="0" style="border-collapse: collapse;">
            <thead>
                <tr style="font-weight: 600;">
                    <td>Facility</td>
                    <td>Information</td>
                    <td>Shortcode</td>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><b>Klostergarasjen</b></td>
                    <td>Available parking spots</td>
                    <td>[bergenpledig get="KlosterGarasjen"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Available chargepoints</td>
                    <td>[bergenpledig get="KlosterGarasjenLadepunkter"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Price for parking</td>
                    <td>[bergenpledig get="KlosterGarasjenPris"]</td>
                </tr>

                <tr style="border-top: 1px solid #ccc;">
                    <td><b>Bygarasjen</b></td>
                    <td>Available parking spots</td>
                    <td>[bergenpledig get="ByGarasjen"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Available chargepoints</td>
                    <td>[bergenpledig get="ByGarasjenLadepunkter"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Price for parking</td>
                    <td>[bergenpledig get="ByGarasjenPris"]</td>
                </tr>

                <tr style="border-top: 1px solid #ccc;">
                    <td><b>Nordnes</b></td>
                    <td>Available parking spots</td>
                    <td>[bergenpledig get="NordnesGarasjen"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Available chargepoints</td>
                    <td>[bergenpledig get="NordnesGarasjenLadepunkter"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Price for parking</td>
                    <td>[bergenpledig get="NordnesGarasjenPris"]</td>
                </tr>
                <tr style="border-top: 1px solid #ccc;">
                    <td><b>GriegGarasjen</b></td>
                    <td>Available parking spots</td>
                    <td>[bergenpledig get="GriegGarasjen"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Available chargepoints</td>
                    <td>[bergenpledig get="GriegGarasjenLadepunkter"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Price for parking</td>
                    <td>[bergenpledig get="GriegGarasjenPris"]</td>
                </tr>


                <!-- <tr style="border-top: 1px solid #ccc;">
                    <td><b>GriegGarasjen</b></td>
                    <td>Available parking spots</td>
                    <td>[grieggarasjen get="freespaces"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Available chargepoints</td>
                    <td>[grieggarasjen get="charger"]</td>
                </tr>
                <tr>
                    <td></td>
                    <td>Price for parking</td>
                    <td>[grieggarasjen get="price"]</td>
                </tr> -->
            </tbody>
            
        </table>
    </div>
    <center style="margin-top: 50px; color: #fff;">Utviklet av <a id="homelinksss" href="https://markant.no">Markant Norge AS</a>
    <?php

}

function DownloadNewInfo() {
    $headr = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: basic ' . base64_encode(get_option('lp_option_token').":".get_option('lp_option_tokenkey'));

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

    $ch = curl_init("https://api.ledig-parkering.no/freespaces");
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);

    curl_close($ch);

    $tempFile = upload_dir() . '/ledigeplasser.ser';
    
    file_put_contents($tempFile, serialize(json_decode($content, true)));
}

/*public function setup_fields() {
    add_settings_field( 'apitokenfield', 'Field Name', array( $this, 'field_callback' ), 'api_fields', 'our_first_section' );
}
public function field_callback( $arguments ) {
    echo '<input name="apitokenfield" id="apitokenfield" type="text" value="' . get_option( 'apitokenfield' ) . '" />';
}*/
//add_action( 'admin_init', array( $this, 'setup_fields' ) );

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
        'cache' => 0
    ), $atts );

    $data = GetFileData((int) $a['cache']);
    switch (!empty($a['get'])?$a['get']:"") {
        
        case 'ByGarasjen':
            if ($data['data']['bygarasjen']['NumFreeSpaces'] == "Midlertidig utilgjengelig") {
                return '<h2 style="text-align: center; color: #fff; margin-bottom: 20px;">'.$data['data']['bygarasjen']['NumFreeSpaces'].'</h2>';
            } else {
                return $data['data']['bygarasjen']['NumFreeSpaces'];
            }
            
        case 'KlosterGarasjen':
            if ($data['data']['klostergarasjen']['NumFreeSpaces'] == "Midlertidig utilgjengelig") {
                return '<h2 style="text-align: center; color: #fff; margin-bottom: 20px;">'.$data['data']['klostergarasjen']['NumFreeSpaces'].'</h2>';
            } else {
                return $data['data']['klostergarasjen']['NumFreeSpaces'];
            }
        case 'NordnesGarasjen':
            if ($data['data']['nordnes']['NumFreeSpaces'] == "Midlertidig utilgjengelig") {
                return '<h2 style="text-align: center; color: #fff; margin-bottom: 20px;">'.$data['data']['nordnes']['NumFreeSpaces'].'</h2>';
            } else {
                return $data['data']['nordnes']['NumFreeSpaces'];
            }
        case 'GriegGarasjen':
            if ($data['data']['edvard']['NumFreeSpaces'] == "Midlertidig utilgjengelig") {
                return '<h2 style="text-align: center; color: #fff; margin-bottom: 20px;">'.$data['data']['edvard']['NumFreeSpaces'].'</h2>';
            } else {
                return $data['data']['edvard']['NumFreeSpaces'];
            }
            
        case 'ByGarasjenLadepunkter':
            return $data['data']['bygarasjen']['NumAvailableChargepoints'];
        case 'KlosterGarasjenLadepunkter':
            return $data['data']['klostergarasjen']['NumAvailableChargepoints'];
        case 'NordnesLadepunkter':
            return $data['data']['nordnes']['NumAvailableChargepoints'];
        case 'GriegGarasjenLadepunkter':
            return $data['data']['edvard']['NumAvailableChargepoints'];
            
        case 'ByGarasjenPris':
            return $data['data']['bygarasjen']['CurrentPrice'];
        case 'KlosterGarasjenPris':
            return $data['data']['klostergarasjen']['CurrentPrice'];
        case 'NordnesPris':
            return $data['data']['nordnes']['CurrentPrice'];
        case 'GriegGarasjenPris':
            return $data['data']['edvard']['CurrentPrice'];
            
        case 'Sist oppdatert':
            return $sistOppdatert;
        default: return "";
    }
    
    return '';
}

add_shortcode( 'bergenpledig', 'bergenpledig_shortcode' );

//*****************By Ali*******************
function GetNewInfo() {
    //HTTP username.
    $username = '87HMa8gtLvR3';
    //HTTP password.
    $password = '958XrzLvXJNLo77dBEDQ';
    $headr = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Basic ' . base64_encode("$username:$password");

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

    $ch = curl_init("https://api.ledig-parkering.no/klostergarasjen/");
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);

    curl_close($ch);

    return json_decode($content, true);
}

function bergenpledignew_shortcode( $atts ){
    $a = shortcode_atts( array(
        
        /* Can be: KlosterGarasjen  or  ByGarasjen  or "Sist oppdatert" */
        'get' => 'KlosterGarasjen'
    ), $atts );

    $data = GetNewInfo();
    $occupied=(int)$data['data']['Zones'][0]['OccupiedBays'];
    $TotalBays=(int)$data['data']['Zones'][0]['TotalBays'];
    $freespaces=$TotalBays-$occupied;
    switch (!empty($a['get'])?$a['get']:"") {
        
        case 'KlosterGarasjen':
            return $freespaces;
        default: return "";
    }
    
    return '';
}

add_shortcode( 'bergenpledignew', 'bergenpledignew_shortcode' );
//NEW LOCATION
function grieggarasjen_shortcode( $atts ){
     $a = shortcode_atts( array(
        
        /* Can be: KlosterGarasjen  or  ByGarasjen  or "Sist oppdatert" */
        'get' => 'freespaces'
    ), $atts );

    $arg= (!empty($a['get']))?$a['get']:"";
    $headr = array();
    $headr[] = 'Content-length: 0';
    $headr[] = 'Content-type: application/json';
    // $headr[] = 'Authorization: basic ' . base64_encode("7NKfKTOOxWgo:IODPqXWLpbN2619X0tj7");
    $headr[] = 'Authorization: basic ' . base64_encode(get_option('lp_option_token').":".get_option('lp_option_tokenkey'));

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

    $ch = curl_init("https://api.ledig-parkering.no/api/v3/grieggarasjen");
    curl_setopt_array($ch, $options);
    $content = curl_exec($ch);

    curl_close($ch);
    $result=json_decode($content);
    $freespace= $result->TotalBays-$result->OccupiedBays;
    $price=$result->cuurentPrice;
    

    if($arg=="price"){
        $display= $price;
    }elseif($arg=="charger"){
        $display= 0;
    }else{
        $display= $freespace;    
    }

    return $display;
    
}

add_shortcode( 'grieggarasjen', 'grieggarasjen_shortcode' );


function myplugin_register_settings() {
   add_option( 'lp_option_token', '');
   add_option( 'lp_option_tokenkey', '');
   register_setting( 'myplugin_options_group', 'lp_option_token', 'myplugin_callback' );
   register_setting( 'myplugin_options_group', 'lp_option_tokenkey', 'myplugin_callback' );
}
add_action( 'admin_init', 'myplugin_register_settings' );


add_shortcode( 'available-charger', 'available_charger_shortcode' );
function available_charger_shortcode($atts){
    $a = shortcode_atts( array(
        'get' => 'klostergarasjen'
    ), $atts );
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://prod.cloudcharge.se/services/ext/extapi/bergenparkering-api/allChargePoints',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'GET',
      CURLOPT_HTTPHEADER => array(
        'Authorization: Basic YmVyZ2VucGFya2VyaW5nLWFwaTpNUDdRTkZ0YUhHYnRRcmVu',
        'Cookie: INGRESSCOOKIE=1634288235.818.11465.830217; JSESSIONID=C8B048983C904CF4343E5236B327A427'
      ),
    ));

    $response = curl_exec($curl);

    curl_close($curl);

    $result=json_decode($response,true);
    $bygarasjen=0;
    $klostergarasjen=0;
    $grieggarasjen=0;
    foreach($result as $res){
        switch ($res['location']) {
            case 'Fjøsangerveien 4':
                foreach($res['aliasMap'] as $map){
                    if($map['status']=='AVAILABLE'){
                        $bygarasjen++;
                    }
                }
                break;
            case 'Vestre Murallmenningen 14':
                foreach($res['aliasMap'] as $map){
                    if($map['status']=='AVAILABLE'){
                        $klostergarasjen++;
                    }
                }
                break;
            case 'Edvard Griegs plass 1 5015 Bergen':
                foreach($res['aliasMap'] as $map){
                    if($map['status']=='AVAILABLE'){
                        $grieggarasjen++;
                    }
                }
                break;
            
            default:
                # code...
                break;
        }
    }

    $location= (!empty($a['get']))?$a['get']:"";
    if($location=='bygarasjen')
        $availableChargers=$bygarasjen;
    if($location=='klostergarasjen')
        $availableChargers=$klostergarasjen;
    if($location=='grieggarasjen')
        $availableChargers=$grieggarasjen;

    return $availableChargers;
}

// Creating outer API for charger points

add_action( 'rest_api_init', function () {
  register_rest_route( 'cloudcharger/v1', '/availablechargers/', array(
    'methods' => 'GET',
    'callback' => 'gettingChargers',
  ) );
} );
function gettingChargers($data){
    $curl = curl_init();

            curl_setopt_array($curl, array(
              CURLOPT_URL => 'https://prod.cloudcharge.se/services/ext/extapi/bergenparkering-api/allChargePoints',
              CURLOPT_RETURNTRANSFER => true,
              CURLOPT_ENCODING => '',
              CURLOPT_MAXREDIRS => 10,
              CURLOPT_TIMEOUT => 0,
              CURLOPT_FOLLOWLOCATION => true,
              CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
              CURLOPT_CUSTOMREQUEST => 'GET',
              CURLOPT_HTTPHEADER => array(
                'Authorization: Basic YmVyZ2VucGFya2VyaW5nLWFwaTpNUDdRTkZ0YUhHYnRRcmVu',
                'Cookie: INGRESSCOOKIE=1634288235.818.11465.830217; JSESSIONID=C8B048983C904CF4343E5236B327A427'
              ),
            ));

            $response = curl_exec($curl);

            curl_close($curl);
    return $response;
}
// add_action( "rest_api_init", "register_rest_route_custom");
// function register_rest_route_custom(){
//     register_rest_route( 'chargerpoints/v1', '/getall/', array(
//         'methods' => 'GET',
//         'callback' => function ($data){
            // $request=$data->get_params();
            // $curl = curl_init();

            // curl_setopt_array($curl, array(
            //   CURLOPT_URL => 'https://prod.cloudcharge.se/services/ext/extapi/bergenparkering-api/allChargePoints',
            //   CURLOPT_RETURNTRANSFER => true,
            //   CURLOPT_ENCODING => '',
            //   CURLOPT_MAXREDIRS => 10,
            //   CURLOPT_TIMEOUT => 0,
            //   CURLOPT_FOLLOWLOCATION => true,
            //   CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            //   CURLOPT_CUSTOMREQUEST => 'GET',
            //   CURLOPT_HTTPHEADER => array(
            //     'Authorization: Basic YmVyZ2VucGFya2VyaW5nLWFwaTpNUDdRTkZ0YUhHYnRRcmVu',
            //     'Cookie: INGRESSCOOKIE=1634288235.818.11465.830217; JSESSIONID=C8B048983C904CF4343E5236B327A427'
            //   ),
            // ));

            // $response = curl_exec($curl);

            // curl_close($curl);
//             echo  "this is test response";
//         },
//         'args' => array(
//           'token' => array(
//             'validate_callback' => function($param, $request, $key) {
//               // $check=($param=="12345")?true:false;
//               // return $check;
//             }
//           ),
//         ),
//     ));
// }

