<?php


require_once(__DIR__ . '/../vendor/autoload.php');
if ( file_exists(__DIR__.'/../.env') ){
	$dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../');
	$dotenv->load();
}

@ini_set( 'upload_max_filesize' , '250M' );
@ini_set( 'post_max_size', '250M');
@ini_set( 'memory_limit', '256M' );
@ini_set( 'max_execution_time', '300' );
@ini_set( 'max_input_time', '300' );

// $dotenv = Dotenv\Dotenv::create();

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

 /* SSL Settings */
 define('FORCE_SSL_ADMIN', true);

 /* Turn HTTPS 'on' if HTTP_X_FORWARDED_PROTO matches 'https' */
 if (isset($_SERVER['HTTP_X_FORWARDED_PROTO'])) {
	if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
		$_SERVER['HTTPS'] = 'on';
	}
 }


// ** Database settings - You can get this info from your web host ** //
define( 'DB_NAME', $_ENV['DB_NAME']);
define( 'DB_USER', $_ENV['DB_USER']);
define( 'DB_PASSWORD', $_ENV['DB_PASSWORD']);
define( 'DB_HOST', $_ENV['DB_HOST']);
define( 'DB_CHARSET', 'utf8mb4' );
define( 'DB_COLLATE', '' );


/* Off Load Media -> amazon-s3-and-cloudfront-pro plugin */
define( 'AS3CF_SETTINGS', serialize( array(
	'provider' => $_ENV['S3_PROVIDER'],
	'access-key-id' => $_ENV['S3_ACCESS_KEY_ID'],
	'secret-access-key' => $_ENV['S3_SECRET_ACCESS_KEY'],
) ) );

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
define( 'AUTH_KEY',         '3tirX4EITVrAV<x.<Yeva]my8CLw5JkTq^)`<Ntumt9kuvO#$b8c&=URw-ggq`Jw' );
define( 'SECURE_AUTH_KEY',  '4$q.(QUZKCm&n&}w{[*XYh::)g^Y6<KTD7$P~4eZYLuH0Y/mCB%3XzP=T.9_{Mnv' );
define( 'LOGGED_IN_KEY',    '>$NHHemQx^`t9;`stKg(E1S~E&ty$d[m+RHN]+<3RPa91u6rZ=_cgs{<GIkSFCe;' );
define( 'NONCE_KEY',        'tuv~zqizw|ZBv<#HppPEE* hOy@a.Fo]/]{xMC$K4`]?z]SBAsH*J=U_#%}PgkWx' );
define( 'AUTH_SALT',        '=i]Zbr_A4lA&K6dBaOlwz@`.Torh!NOwCg=bMdmusFFi:H(0?.*3Vl8*)QEGc,wY' );
define( 'SECURE_AUTH_SALT', 'E$2KFv3R{Q<<}/&U16]R /(s%JxWefAy4A3Wfbj:oewC)qCZ)H}@2jqj4*nBR_{_' );
define( 'LOGGED_IN_SALT',   '2)(ee3CC9|i,`L,96DRGG}wherNPH!NhR>&?u@RclLAf-n7z1tVx^:tIf+J1b7PN' );
define( 'NONCE_SALT',       '&N<u2D5&1@_<Dig.J}6-lqp*9TMggFKL&/U5RF~uy9P1o1?_Q;U~4*ONi;_tIH!X' );

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
// define('WP_DEBUG', true);
// define('WP_DEBUG_LOG', true);
// define('WP_DEBUG_DISPLAY', false);

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';