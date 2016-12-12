<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       http://awais.example.com/
 * @since      1.0.0
 *
 * @package    Spam_Blocker
 * @subpackage Spam_Blocker/admin/partials
 */
?>

<div class="wrap">
	<div id="dz-spam-blocker" class="dz-spam-blocker container">
		<section class="header">
			<?php if(!empty($message)): ?>
				<div class="notice notice-success is-dismissible spam-blocker-message">
	        		<p><?php echo $message; ?></p>
	    		</div>
	    	<?php endif; ?>
		</section>

		<section class="content">
			<form enctype="application/x-www-form-urlencoded" method="post" id="honeypot-form" name="honeypot-form">
				<h1>Spam Bloker Settings</h1>
				<br/>

				<input type="checkbox" name="honeypot-comments" id="honeypot-comments" <?php
				 if(isset($_POST['honeypot-comments']) == 'on' || $honeypot_options['honeypot-comments'] == true):?>checked="checked"<?php endif; ?>>Enable Honeypot Protection for Comments <br/>
				<input type="checkbox" name="honeypot-login" id="honeypot-login" <?php if(isset($_POST['honeypot-login']) =='on' || $honeypot_options['honeypot-login'] == true):?>checked="checked"<?php endif; ?>>Enable Honeypot Protection on WP Login Page<br/>


				<input type="hidden" name="form" value="honeypot-form" />
				<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
			</form>
		</section>
	</div>
</div>