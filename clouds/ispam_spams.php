<?php

//menu options
function ispam_blocked () {
	if ( !current_user_can( 'manage_options' ) )  {
		wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
	}
	
	?>

	<!-- output ********************************************************************************************** -->
	
	<div class="wrap">
		
		<div id="icon-edit-comments" class="icon32"></div>
		<h2>Blocked users or bots</h2>	
		
		<?php
		
		//Get total items
		global $wpdb; $table_name=$wpdb->prefix."dc_sp_spam";
		$results = $wpdb->get_results("SELECT id FROM $table_name", ARRAY_A);	
		$dc_sp_total_items = count($results);
		
		echo '<p>iSpam has blocked ' . $dc_sp_total_items . ' comments.</p>';
		
		//Initialize the pagination class
		$pag = new dc_sp_pagination();
		$pag->set_total_items( $dc_sp_total_items );//Set the total number of items
		$pag->set_record_per_page( 20 ); //Set records per page
		$pag->set_target_page( "admin.php?page=ispam_spams" );//Set target page
		$pag->set_current_page();//set the current page number from $_GET
		
		?>
		
		<!-- Query the database -->
		<?php
		$table_name=$wpdb->prefix."dc_sp_spam"; $dc_sp_query_limit = $pag->query_limit();
		$results = $wpdb->get_results("SELECT * FROM $table_name ORDER BY id DESC $dc_sp_query_limit ", ARRAY_A); ?>
		
		<?php if( count($results) > 0 ) : ?>
			
			<!-- Display the pagination -->
            <div class="tablenav">
                <div class="tablenav-pages">
                    <span class="displaying-num"><?php echo $pag->total_items; ?> items</span>
                    <?php $pag->show(); ?>
                </div>
            </div>			
		
			<!-- list of playlist -->
			<table class="widefat">
				<thead>
					<tr>
						<th>ID</th>
						<th>Post ID</th>
						<th>User IP</th>
						<th>Date</th>
						<th>Content</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th>ID</th>
						<th>Post ID</th>
						<th>User IP</th>
						<th>Date</th>
						<th>Content</th>
					</tr>
				</tfoot>
				<tbody>
				
				<?php foreach($results as $result) : ?>
					<tr>
						<td><?php echo $result['id']; ?></td>
						<td><?php echo esc_attr( stripslashes( $result['post_id'] ) ); ?></td>
						<td><?php echo esc_attr( stripslashes( $result['user_ip'] ) ); ?></td>
						<td><?php echo mysql2date( get_option('date_format') . ' ' . get_option('time_format') , $result['date'] ); ?></td>
						<td><?php echo substr( esc_attr( stripslashes( $result['content'] ) ), 0, 200); if(strlen(esc_attr( stripslashes( $result['content'] ) ))>200){echo' ...';}?></td>
					</tr>
				<?php endforeach; ?>

				</tbody>
			</table>	
			
		<?php endif; ?>
		</br><h3 class="update-nag">Please visit our own <a href="http://iappi.de/ispam/" target="_blank">support team</a> for any issuses.</h3>		
		</br><h3 class="update-nag">iAppi.de Softwareentwicklung™</h3>
	</div>
		
<?php

}

?>