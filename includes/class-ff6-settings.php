<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class FF6_Settings {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'add_menu' ) );
		add_action( 'admin_init', array( $this, 'register_settings' ) );
	}

	public function add_menu() {
		add_options_page(
			__( 'Force Font Awesome 6', 'force-fontawesome-6' ),
			__( 'Force FA6', 'force-fontawesome-6' ),
			'manage_options',
			'ff6-settings',
			array( $this, 'settings_page' )
		);
	}

	public function register_settings() {
		register_setting( 'ff6_settings_group', 'ff6_fa_version', array( 'default' => '6.5.1' ) );
		register_setting( 'ff6_settings_group', 'ff6_load_solid', array( 'default' => 'yes' ) );
		register_setting( 'ff6_settings_group', 'ff6_load_brands', array( 'default' => 'yes' ) );
	}

	public function settings_page() {
		?>
		<div class="wrap">
			<h1><?php esc_html_e( 'Force Font Awesome 6 Settings', 'force-fontawesome-6' ); ?></h1>
			<form method="post" action="options.php">
				<?php settings_fields( 'ff6_settings_group' ); ?>
				<?php do_settings_sections( 'ff6_settings_group' ); ?>

				<table class="form-table">
					<tr>
						<th scope="row"><?php esc_html_e( 'Font Awesome Version', 'force-fontawesome-6' ); ?></th>
						<td>
							<input type="text" name="ff6_fa_version" value="<?php echo esc_attr( get_option( 'ff6_fa_version', '6.5.1' ) ); ?>" />
							<p class="description"><?php esc_html_e( 'Enter the Font Awesome version to load (e.g., 6.5.1).', 'force-fontawesome-6' ); ?></p>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Load Solid Icons?', 'force-fontawesome-6' ); ?></th>
						<td>
							<select name="ff6_load_solid">
								<option value="yes" <?php selected( get_option( 'ff6_load_solid', 'yes' ), 'yes' ); ?>><?php esc_html_e( 'Yes', 'force-fontawesome-6' ); ?></option>
								<option value="no" <?php selected( get_option( 'ff6_load_solid', 'yes' ), 'no' ); ?>><?php esc_html_e( 'No', 'force-fontawesome-6' ); ?></option>
							</select>
						</td>
					</tr>
					<tr>
						<th scope="row"><?php esc_html_e( 'Load Brand Icons?', 'force-fontawesome-6' ); ?></th>
						<td>
							<select name="ff6_load_brands">
								<option value="yes" <?php selected( get_option( 'ff6_load_brands', 'yes' ), 'yes' ); ?>><?php esc_html_e( 'Yes', 'force-fontawesome-6' ); ?></option>
								<option value="no" <?php selected( get_option( 'ff6_load_brands', 'yes' ), 'no' ); ?>><?php esc_html_e( 'No', 'force-fontawesome-6' ); ?></option>
							</select>
						</td>
					</tr>
				</table>

				<?php submit_button(); ?>
			</form>
		</div>
		<?php
	}
}

new FF6_Settings();