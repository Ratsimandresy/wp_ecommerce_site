<?php

// BEGIN iThemes Security - Do not modify or remove this line
// iThemes Security Config Details: 2
define( 'DISALLOW_FILE_EDIT', true ); // Disable File Editor - Security > Settings > WordPress Tweaks > File Editor
// END iThemes Security - Do not modify or remove this line

/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'D#|owHL GCgRql7*Aj[4Ns=6]?kii%DRnispMu]#%fUSedoVJP=%q(:[gy99&F3f' );
define( 'SECURE_AUTH_KEY',  '2e73M]6Bi)r+}MX:~kz#e4tl>z=:-.4gan.|9Zs&3t!;m*pIa(<P=<;o@S28=H?m' );
define( 'LOGGED_IN_KEY',    'dGxd?EHMgOVXrdm*{m[RlH=QG![Fw$L;$Ho|b8Z>kb=x{raj<?-a,FTx0*1ri[~[' );
define( 'NONCE_KEY',        's$Y>FTl0{Z}noC/D+5LYF1~GGlipB/UJ?%Q7GGEWZ(9b&shk(}18~oP,uHb8M1H~' );
define( 'AUTH_SALT',        'QpJriKVD[b5:`*fBzV>}f6kTJ<M$=@)2V#(Lx5[)7+*jmxb7~s3}[2qH15#my8~z' );
define( 'SECURE_AUTH_SALT', 'XBYfpP%B@PIPIQCu<c3;r2XAfKW5$}{R;`.up1}$;12@K{=P1$yz:,tw`vq@BBqX' );
define( 'LOGGED_IN_SALT',   'O /5!(4}~NLeND30HnCV8{B{K>Tg)|BXCWp+^MsZoy{aVsIC=Unm-mQ6+JV.{6G,' );
define( 'NONCE_SALT',       'VaqkgH<k #c*21!RM)3i%{9gGeNhKO &UTN;78-Fpl|j4t8X),:=)Dg.D_3r%$a2' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
