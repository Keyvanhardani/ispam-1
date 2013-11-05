<?php

//menu options
function ispam_properties() {
	
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	?>
	
	<div class="wrap">
		<div id="icon-tools" class="icon32"></div>
		<h2>Properties</h2>
		
		<!-- process data *************************************************************************** -->
		
		<?php
		
		if(isset($_POST['form_submitted'])){

			//time delay
			if(isset($_POST['time_delay'])){
				update_option('dc_sp_time_delay', abs( intval( $_POST['time_delay'], 10 ) ) );				
			}
			
			//time max
			if(isset($_POST['time_max'])){
				update_option('dc_sp_time_max', abs( intval( $_POST['time_max'], 10 ) ) );				
			}		

			//Custom message
			if(isset($_POST['custom_message'])){
				update_option('dc_sp_custom_message', $_POST['custom_message'] );				
			}	
	
		}

		?>
		
		<!-- output ******************************************************************************* -->
		
		
		<form method="POST" action="">
			
			<table class="form-table">
				
				<input name="form_submitted" type="hidden" value="true">
				
				<!-- Time Delay -->
				<tr valign="top">
					<th scope="row"><label for="dc-sp-time-delay">Time Delay *seconds</label></th>
					<td><input maxlength="4" size="4" name="time_delay" id="dc-sp-time-delay" value="<?php echo esc_attr( stripslashes ( get_option('dc_sp_time_delay') ) ); ?>" ></td>
				</tr>
				
				<!-- Time Max -->
				<tr valign="top">
					<th scope="row"><label for="dc-sp-time-max">Maximum Time Limit *seconds</label></th>
					<td><input maxlength="10" size="10" name="time_max" id="dc-sp-time-max" value="<?php echo esc_attr( stripslashes ( get_option('dc_sp_time_max') ) ); ?>" ></td>
				</tr>
				
				<!-- Custom Message for blocked user -->
				<tr valign="top">
					<th scope="row"><label for="dc-sp-custom-message">Custom Message</label></th>
					<td><input maxlength="200" size="200" name="custom_message" id="dc-sp-custom-message" value="<?php echo esc_attr( stripslashes ( get_option('dc_sp_custom_message') ) ); ?>" ></td>
				</tr>
				
				<!-- Submit Button -->
				<tr valign="top">
					<td>
						<input type="submit" name="save" value="Save" class="button-primary" />
					</td>
				</tr>
			
			</table>
			
		</form>
		</br><h3 class="update-nag"> Please visit our own <a href="http://iappi.de/ispam/" target="_blank">support team</a> for any issues.</h3>
		</br><h3 class="update-nag">iAppi.de Softwareentwicklung™</h3>
		
	</div>

	<?php
	
}

?>