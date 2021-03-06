<?php
/**
 * Handle WP Emerge version checking to make sure a compatible version is loaded.
 *
 * @package Depicter
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! function_exists( 'depicter_get_loaded_framework' ) ) {
	/**
	 * Get the currently loaded WP Emerge version, if any.
	 *
	 * @return array|false
	 */
	function depicter_get_loaded_framework() {
		/**
		 * Filters the loaded WP Emerge version.
		 *
		 * @param array|false $loaded
		 */
		return apply_filters( 'wpemerge_loaded', false );
	}
}

if ( ! function_exists( 'depicter_should_load_framework' ) ) {
	/**
	 * Get whether a compatible WP Emerge version is or should be loaded.
	 *
	 * @param string $name Project name.
	 * @param string $min Minimum version (inclusive).
	 * @param string $max Maximum version (exclusive).
	 * @return bool
	 */
	function depicter_should_load_framework( $name, $min, $max ) {
		$loaded = depicter_get_loaded_framework();

		if ( false === $loaded ) {
			// No version is loaded, yet.
			return true;
		}

		if ( version_compare( $loaded['version'], $min, '>=' ) && version_compare( $loaded['version'], $max, '<' ) ) {
			// A compatible version is already loaded.
			return true;
		}

		add_action(
			'admin_notices',
			function () use ( $name, $min, $max, $loaded ) {
				// Translators: %1$s = plugin or theme name; %2$s = minimum version number; %3$s = maximum version number; %4$s plugin or theme name; %5$s loaded version number.
				$message = __( '%1$s requires WP Emerge version >= %2$s and < %3$s but %4$s has already loaded version %5$s.', 'depicter' );
				?>
				<div class="notice notice-error">
					<p><strong><?php echo esc_html( $name ); ?></strong></p>
					<p><?php echo esc_html( sprintf( $message, $name, $min, $max, $loaded['name'], $loaded['version'] ) ); ?></p>
				</div>
				<?php
			}
		);

		// An incompatible version is already loaded.
		return false;
	}
}

if ( ! function_exists( 'depicter_declare_loaded_framework' ) ) {
	/**
	 * Declare the loaded WP Emerge version.
	 *
	 * @param  string $name Project name.
	 * @param  string $type Project type - 'plugin' or 'theme'.
	 * @param  string $file Main project file.
	 * @return void
	 */
	function depicter_declare_loaded_framework( $name, $type, $file ) {
		$loaded = depicter_get_loaded_framework();

		if ( $loaded ) {
			// A version is already loaded - bail.
			return;
		}

		// Declare loaded WP Emerge version.
		add_filter(
			'wpemerge_loaded',
			function () use ( $name, $type, $file ) {
				return [
					'version' => WPEMERGE_VERSION,
					'name'    => $name,
					'type'    => $type,
					'file'    => $file,
				];
			}
		);
	}
}
