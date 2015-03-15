<?php
/**
 * Plugin Name: Reminder Mail System 
 * Plugin URI: http://savents.com
 * Description: A Simple Reminder Mail system used to send mails from admin panel.
 * Version: 1.0
 * Author: Nagaraju Musini
 * Author URI: http://savents.com
 * License: GPL2
 */
 /*  Copyright 2015  Nagaraju Musini  (email : nagaraju6911@gmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

 defined( 'ABSPATH' ) or die( 'No script kiddies please!' );
 

// Mail Function
	if(isset($_POST['rem_to_email']) && !empty($_POST['rem_to_email'])){
		add_action( 'plugins_loaded', 'renderMail' );
		function renderMail(){
			$user_email=$_POST['rem_to_email'];
			$subject=$_POST['rem_subject'];
			$message=$_POST['rem_message'];
			$headers[] = 'From: '.$_POST['rem_from_name'].' <'.$_POST['rem_from_email'].'>';
			$sendm = wp_mail( $user_email, $subject, $message,$headers ); 
			if($sendm){
				wp_redirect( "admin.php?page=remindermails.php&sent=true" );
				exit;
			}else {
				wp_redirect( "admin.php?page=remindermails.php&error=true");
				exit;
			}
		}
	}

	// create custom plugin settings menu
	add_action('admin_menu', 'rms_create_menu');

	function rms_create_menu() {

		//create new top-level menu
		add_menu_page('Reminder Mail', 'Reminder Mail', 'administrator',basename(__FILE__), 'rms_settings_page');

		//call register settings function
		add_action( 'admin_init', 'rms_settings_reg' );
	}


	function rms_settings_reg() {
		//register our settings
		register_setting( 'rms-settings-group', 'new_option_name' );
		register_setting( 'rms-settings-group', 'some_other_option' );
		register_setting( 'rms-settings-group', 'option_etc' );
	}

	function rms_settings_page() {

	if ( isset($_REQUEST['sent']) && !empty($_REQUEST['sent'] ) ) {
	 echo '<div id="message" class="updated fade"><p><strong> Sent Successfully.</strong></p></div>'; }
	if ( isset($_REQUEST['error']) && !empty($_REQUEST['error'] ) ) { 
	echo '<div id="message" class="updated fade"><p><strong> Not sent.</strong></p></div>';  }
	 
?>
	<div class="wrap">
	<h2>Reminder Mail System</h2>

	<form action="" method="POST" name="remindermail">
		<table class="form-table">
			<tr>
			<th scope="row"><label for="FromMail">From Email</label></th>
			<td><input type="text" class="regular-text" placeholder="Enter email id." id="from_email" value="<?php echo get_option( 'admin_email' ) ?>" name="rem_from_email"></td>
			</tr>
			<tr>
			<th scope="row"><label for="FromName">From Name</label></th>
			<td><input type="text" class="regular-text" placeholder="Enter to email id." id="to_email" value="<?php echo get_option( 'blogname' ); ?>" name="rem_from_name"></td>
			</tr>
			<tr>
			<th scope="row"><label for="To">To</label></th>
			<td><input type="text" class="regular-text" placeholder="Enter email id." id="to_email" name="rem_to_email"></td>
			</tr>
			<tr>
			<th scope="row"><label for="Subject">Subject</label></th>
			<td><input type="text" class="regular-text" placeholder="Enter subject." id="rem_subject" name="rem_subject"></td>
			</tr>
			<tr>
			<th scope="row"><label for="Message">Message</label></th>
			<td><textarea class="mceEditor" name="rem_message" cols="38" rows="10"> </textarea></td>
			</tr>
			<tr>
			<td><input class="button button-primary" type="submit" name="send" value="send"/></td>
			</tr>
		</table>
	</form>
	</div>
<?php } 
