<?php
function emeon_emeoninfopage() {
	//check is such subpage is registered
	if ( isset( $_GET['subpage'] ) ) {
		$function_name = 'emeon_sktwb_'.sanitize_text_field( wp_unslash( $_GET['subpage'] ) );
		if( $function_name !== __FUNCTION__ && function_exists( $function_name )){
			//process with subpage
			$function_name();
		}
		else{
			//go to default page
			emeon_sktwb_info();
		}
	}
	else{
		//go to default page
		emeon_sktwb_info();
	}
}



function emeon_theme_requirements_table(){
	?>
	<div class="server-config">
		<table class="status_table widefat" cellspacing="0">
			<thead>
			<tr>
				<th colspan="3"><?php esc_html_e( 'Server/WordPress Environment', 'emeon' ); ?></th>
			</tr>
			</thead>

			<tbody>
			<?php if(defined('EMEON_IMPORTER_TMP_DIR')) { ?>
			<tr>
				<td><?php esc_html_e( 'Demo Data Directory', 'emeon' ); ?>:</td>
				<td class="help"><?php emeon_input_help_tip( __( 'The directory must be writable so downloaded demo data could be saved for the import process.', 'emeon' ) ); ?></td>
				<td><?php
					if ( is_writable( EMEON_IMPORTER_TMP_DIR ) ) {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> <code>' . esc_html( EMEON_IMPORTER_TMP_DIR ) . '</code></mark> ';
					} else {
						/* translators: %s: directory name */
						printf( '<mark class="error"><span class="dashicons dashicons-no"></span> ' . esc_html__( 'To allow import, make %s writable.', 'emeon' ) . '</mark>', '<code>'.esc_html( EMEON_IMPORTER_TMP_DIR ).'</code>' );
					}
					?></td>
			</tr>
			<?php } ?>
			<tr>
				<td><?php esc_html_e( 'WP Memory Limit', 'emeon' ); ?>:</td>
				<td class="help"><?php emeon_input_help_tip( __( 'The maximum amount of memory (RAM) that your site can use at one time.', 'emeon' ) ); ?></td>
				<td><?php
//					$memory = wp_convert_hr_to_bytes( WP_MEMORY_LIMIT );

					$system_memory = wp_convert_hr_to_bytes( ini_get( 'memory_limit' ) );
					$memory        = $system_memory;//max( $memory, $system_memory );

					if ( $memory <= 0 ) {//0MB
						/* translators:  %1$s is memory available and %2$s is link to "Increasing memory allocated to PHP" article */
						echo '<mark class="error"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - We can not determine the true memory limit that is set on your server. It is possible that your server admin blocked manipulating this limit. See: %2$s', 'emeon' ), esc_html( size_format( $memory ) ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'emeon' ) . '</a>' ) . '</mark>';
					}
					elseif ( $memory < 100663296 ) {//96MB
						/* translators:  %1$s is memory available and %2$s is link to "Increasing memory allocated to PHP" article */
						echo '<mark class="error"><span class="dashicons dashicons-no"></span> ' . sprintf( esc_html__( '%1$s - Having memory lower than 96 MB(we recommend 128 MB or more) can produce errors while importing demo data, depending on how many plugins you have active. See: %2$s', 'emeon' ), esc_html( size_format( $memory ) ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'emeon' ) . '</a>' ) . '</mark>';
					}
					elseif ( $memory < 134217728 ) {//128MB
						/* translators:  %1$s is memory available and %2$s is link to "Increasing memory allocated to PHP" article */
						echo '<mark class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - You should be fine with so much memory, however, depending on how many plugins you have active you should change it to 128 MB or more. See: %2$s', 'emeon' ), esc_html( size_format( $memory ) ), '<a href="https://codex.wordpress.org/Editing_wp-config.php#Increasing_memory_allocated_to_PHP" target="_blank">' . esc_html__( 'Increasing memory allocated to PHP', 'emeon' ) . '</a>' ) . '</mark>';
					}
					else {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> ' . esc_html( size_format( $memory ) ) . '</mark>';
					}
					?></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'PHP Version', 'emeon' ); ?>:</td>
				<td class="help"><?php emeon_input_help_tip( __( 'The version of PHP installed on your hosting server.', 'emeon' ) ); ?></td>
				<td><?php
					// Check if phpversion function exists.
					if ( function_exists( 'phpversion' ) ) {
						$php_version = phpversion();

						if ( version_compare( $php_version, '5.3', '<' ) ) {
							echo '<mark class="error"><span class="dashicons dashicons-no"></span> ' . sprintf(esc_html__('We recommend a minimum PHP version of 5.6. Having version 7 or higher is even better.', 'emeon')) . '</mark>';
						}
						elseif ( version_compare( $php_version, '5.6', '<' ) ) {
							echo '<mark class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf(esc_html__('We recommend a minimum PHP version of 5.6. Having version 7 or higher is even better.', 'emeon')) . '</mark>';
						}
						else {
							echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> ' . esc_html( $php_version ) . '</mark>';
						}
					} else {
						esc_html_e( "Couldn't determine PHP version because phpversion() doesn't exist.", 'emeon' );
					}
					?></td>
			</tr>
			<tr>
				<td><?php esc_html_e( 'PHP Time Limit', 'emeon' ); ?>:</td>
				<td class="help"><?php emeon_input_help_tip( __( 'The amount of time (in seconds) that your site will spend on a single operation before timing out (to avoid server lockups). Recommended 60 seconds or more for the import process.', 'emeon' ) ); ?></td>
				<td><?php
					$max_execution_time = intval( ini_get( 'max_execution_time' ) );

					if ( $max_execution_time > 0 ){
						if ( $max_execution_time < 30 ) {
							/* translators: %1$s - time in seconds, %2$s - max_execution_time */
							echo '<mark class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%1$s - Having %2$s less than 30 can hurt the import process. We recommend setting it to at least 60 if possible, even if only for the import process.', 'emeon' ), esc_html( $max_execution_time ), '<code>max_execution_time</code>' ) . '</mark>';
						}
						else {
							echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> ' . esc_html( $max_execution_time ) . '</mark>';
						}
					}
					else{
						echo '<mark>' . esc_html( $max_execution_time ) . '</mark>';
					}
					?>
				</td>
			</tr>
			<tr>
				<td data-export-label="PHP Post Max Size"><?php esc_html_e( 'PHP Post Max Size', 'emeon' ); ?>:</td>
				<td class="help"><?php emeon_input_help_tip( esc_html__( 'The largest file size that can be contained in one post. Recommended 64 MB or more.', 'emeon' ) ); ?></td>
				<td><?php
					$post_max_size = wp_convert_hr_to_bytes( ini_get( 'post_max_size' ) );

					if ( $post_max_size < 33554432 ) {//32MB
						/* translators: %s: Post size limit value */
						echo '<mark class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s - too low value for this setting might cause problems. Recommended 64MB or more.', 'emeon' ), esc_html( size_format( $post_max_size ) ) ) . '</mark>';
					}
					else {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> ' . esc_html( size_format( $post_max_size ) ) . '</mark>';
					}
					?></td>
			</tr>
			<tr>
				<td data-export-label="Max Upload Size"><?php esc_html_e( 'Max Upload Size', 'emeon' ); ?>:</td>
				<td class="help"><?php emeon_input_help_tip( esc_html__( 'The largest file size that can be uploaded to your WordPress installation. Recommended 64 MB or more.', 'emeon' ) ); ?></td>
				<td><?php
					$max_upload_size = wp_convert_hr_to_bytes( wp_max_upload_size() );

					if ( $max_upload_size < 33554432 ) {//32MB
						/* translators: %s: Max upload size limit value */
						echo '<mark class="warning"><span class="dashicons dashicons-warning"></span> ' . sprintf( esc_html__( '%s - too low value for this setting might cause problems. Recommended 64MB or more.', 'emeon' ), esc_html( size_format( $max_upload_size ) ) ) . '</mark>';
					}
					else {
						echo '<mark class="yes"><span class="dashicons dashicons-yes"></span> ' . esc_html( size_format( $max_upload_size ) ) . '</mark>';
					}
					?></td>
			</tr>
			</tbody>
		</table>
	</div>
	<?php
}



function emeon_is_companion_plugin_ready($fail_message = false, $silent = false){
	global $emeon_a13;
	return $emeon_a13->emeon_is_companion_plugin_ready($fail_message, $silent);
}