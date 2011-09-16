<?php
/*
Plugin Name: S3Slider Manager
Plugin URI: http://caseystrouse.com/s3slider_manager
Description: Allows you to manage the S3Slider jquery plugin.
Version: 1.0
Author: Casey Strouse
Author URI: http://caseystrouse.com/
License: FreeBSD
*/

// TODO: Make the sizing dynamic based on the image sizes
// TODO: Support borders on images

wp_enqueue_script('s3slider', plugins_url('s3Slider.js', __FILE__), array('jquery'));
add_action('wp_head', 'include_s3slider');

if ( function_exists('register_uninstall_hook') )
    register_uninstall_hook(__FILE__, 's3slider_manager_uninstall_hook');
 
function s3slider_manager_uninstall_hook()
{
    delete_option('slider_image1');
	delete_option('slider_image2');
	delete_option('slider_image3');
	delete_option('slider_image4');
	
	delete_option('slider_link1');
	delete_option('slider_link2');
	delete_option('slider_link3');
	delete_option('slider_link4');
	
	delete_option('transition_speed');
	
	remove_action('s3slider_manager_menu');
}

function include_s3slider()
{
?>
<style type="text/css">
	#s3slider { 
	   width: 894px; /* important to be same as image width */
	   height: 275px; /* important to be same as image height */
	   position: relative; /* important */
	   overflow: hidden; /* important */
	   background: #fff;
	}

	#s3sliderContent {
	   width: 894px; /* important to be same as image width or wider */
	   position: absolute; /* important */
	   top: 0; /* important */
	   margin-left: 0; /* important */
	}

	.s3sliderImage {
	   float: left; /* important */
	   position: relative; /* important */
	   display: none; /* important */
	}

	.clear {
	   clear: both;
	}
</style>
<script type="text/javascript">
	var $j = jQuery.noConflict();
	
	$j(document).ready(function() {
	   $j('#s3slider').s3Slider({ 
	      timeOut: <?php echo get_option('transition_speed', '4000');  ?>
	   });
	});
</script>
<?php
}

if(is_admin())
{
	add_action('admin_menu', 's3slider_manager_menu');
	add_action('admin_init', 's3slider_manager_register');

	function s3slider_manager_menu()
	{
		add_options_page('S3Slider Manager', 'S3Slider Manager', 'manage_options', 's3slider_manager', 's3slider_manager_options');
	}
	
	function s3slider_manager_register()
	{
		register_setting('s3slider_manager_optiongroup', 'slider_image1');
		register_setting('s3slider_manager_optiongroup', 'slider_image2');
		register_setting('s3slider_manager_optiongroup', 'slider_image3');
		register_setting('s3slider_manager_optiongroup', 'slider_image4');
		
		register_setting('s3slider_manager_optiongroup', 'slider_link1');
		register_setting('s3slider_manager_optiongroup', 'slider_link2');
		register_setting('s3slider_manager_optiongroup', 'slider_link3');
		register_setting('s3slider_manager_optiongroup', 'slider_link4');
		
		register_setting('s3slider_manager_optiongroup', 'transition_speed');
	}

	function s3slider_manager_options()
	{
		if (!current_user_can('manage_options'))
		{
			wp_die( __('You do not have sufficient permissions to access this page.') );
		}
?>
		<div class="wrap">
			<h2>S3Slider Manager Settings</h2>
			<form method="post" action="options.php">
			<?php settings_fields('s3slider_manager_optiongroup'); ?>
			
			<table class="form-table">
			<tr valign="top">
				<th scope="row">Slide Transition Speed: </th>
				<td><input id="transition_speed" name="transition_speed" type="text" value="<?php echo get_option('transition_speed'); ?>" /></td>
			</tr>
			
			<tr valign="top">
				<th scope="row">Slider Image 1: </th>
				<td><input id="slider_image1" name="slider_image1" type="text" size="64" value="<?php echo get_option('slider_image1'); ?>" /></td>
			</tr>
			<tr>
				<th scope="row">Slider Link 1: </th>
				<td><input id="slider_link1" name="slider_link1" type="text" size="64" value="<?php echo get_option('slider_link1'); ?>"></td>
			</tr>
			<tr valign="top">
				<th scope="row">Slider Image 2: </th>
				<td><input id="slider_image2" name="slider_image2" type="text" size="64" value="<?php echo get_option('slider_image2'); ?>" /></td>
			</tr>
			<tr>
				<th scope="row">Slider Link 2: </th>
				<td><input id="slider_link2" name="slider_link2" type="text" size="64" value="<?php echo get_option('slider_link2'); ?>"></td>
			</tr>
			
			<tr valign="top">
				<td scope="row">Slider Image 3: </td>
				<td><input id="slider_image3" name="slider_image3" type="text" size="64" value="<?php echo get_option('slider_image3'); ?>" /></td>
			</tr>
			<tr>
				<td scope="row">Slider Link 3: </td>
				<td><input id="slider_link3" name="slider_link3" type="text" size="64" value="<?php echo get_option('slider_link3'); ?>"></td>
			</tr>
			
			<tr valign="top">
				<td scope="row">Slider Image 4: </td>
				<td><input id="slider_image4" name="slider_image4" type="text" size="64" value="<?php echo get_option('slider_image4'); ?>" /></td>
			</tr>
			<tr>
				<td scope="row">Slider Link 4: </td>
				<td><input id="slider_link4" name="slider_link4" type="text" size="64" value="<?php echo get_option('slider_link4'); ?>"></td>
			</tr>
			<tr valign="top"><td colspan="2"><input type="submit" class="button-primary" value="<?php _e('Save Changes') ?>" /></td></tr>
			</table>
			</form>
		</div>
<?
	}
}

function s3slider_display()
{
?>
<div id="s3slider">
	<ul id="s3sliderContent">
		<li class="s3sliderImage"><a href="<?php echo get_option('slider_link1'); ?>"><img src="<?php echo get_option('slider_image1'); ?>" /></a><span>Your text comes here</span></li>
		<li class="s3sliderImage"><a href="<?php echo get_option('slider_link2'); ?>"><img src="<?php echo get_option('slider_image2'); ?>" /></a><span>Your text comes here</span></li>
		<li class="s3sliderImage"><a href="<?php echo get_option('slider_link3'); ?>"><img src="<?php echo get_option('slider_image3'); ?>" /></a><span>Your text comes here</span></li>
		<li class="s3sliderImage"><a href="<?php echo get_option('slider_link4'); ?>"><img src="<?php echo get_option('slider_image4'); ?>" /></a><span>Your text comes here</span></li>
	</ul>
</div>
<?php
}

?>