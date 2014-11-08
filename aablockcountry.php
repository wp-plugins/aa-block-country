<?php 
/**
 * Plugin Name: AA Block Country
 * Plugin URI: http://wordpress.org/.../
 * Description: Go to setting
 * Version: 1.0
 * Developer + Idea: A. Roy / A. Mahmud
 * Author URI: http://webdesigncr3ator.com
 * Support Email : contactus.aa@gmail.com
 * License: GPL2
 **/
	
	
	
		
function aa_block_getUserIP()
{
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];

    if(filter_var($client, FILTER_VALIDATE_IP))
    {
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP))
    {
        $ip = $forward;
    }
    else
    {
        $ip = $remote;
    }

    return $ip;
}

$ip = aa_block_getUserIP();


$json = file_get_contents('http://ip-api.com/json/'.aa_block_getUserIP());
			
$obj = json_decode($json);
//get user country	
$usr_country = $obj->countryCode;


$block_country = get_option('block_country') ;

$block_country = explode(",", $block_country);


if(isset($block_country[$usr_country])){
	wp_die("Your country is blocked");
}























// create custom plugin settings menu
add_action('admin_menu', 'aa_add_menu_block_con');

function aa_add_menu_block_con() {

	//create new top-level menu
	add_menu_page('Block Country', 'Block Settings', 'administrator', __FILE__, 'aa_ba_baw_settings_page');

	//call register settings function
	add_action( 'admin_init', 'aa_register_mysettings' );
}


function aa_register_mysettings() {

	register_setting( 'baw-settings-group', 'block_country' );

}

function aa_ba_baw_settings_page() {


?>
<div class="wrap">
<h2>Comming soon</h2>

<form method="post" action="options.php">
    <?php settings_fields( 'baw-settings-group' ); ?>
    <?php do_settings_sections( 'baw-settings-group' ); ?>
 
	Enter Block country name (Country code) with comma to sepparate
	<input type="text" name="block_country" value="<?php echo esc_attr( get_option('block_country') ); ?>" />
         
     

    
    <?php submit_button(); ?>

</form>
</div>
<?php }