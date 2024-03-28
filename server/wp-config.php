<?php
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
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
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
define( 'DB_HOST', 'wordpress-mysql' );

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
define( 'AUTH_KEY',         'u(-79zE#d5j{w]VI)?$n:J$Z?T]b}>X<=,nZJa?v!M/<0G?N5k|+O(RKXez}m`SH' );
define( 'SECURE_AUTH_KEY',  '{e$m$3@DaZ1)TXZ/nSg4#%ji/#(8wKADSh`HGa()Z1[4K4?E$?4&p-wp+;%A%DTQ' );
define( 'LOGGED_IN_KEY',    'G=}*1{K4coR>)8Kt0B;E1)8qe>@Rf;$:AL4X&o8oU0/oN4~s,3Oz,SNWlo)r2`%g' );
define( 'NONCE_KEY',        'LN/A#?VgZNDEZg>_;Ig%VHEq76JyH5U:8bzACfeS5o0Y!b@ Q5|E3=m+Bjz-j.pI' );
define( 'AUTH_SALT',        '[4IqhN5`4!whQX(F#D9iOO0l:i*MA=4SL]?m4]/x`K)[7|oF5e9*6V0a_c]7aCXV' );
define( 'SECURE_AUTH_SALT', 'GZC*HZ*0_E9IFcteqE5nA=?ug4?GYp5W}*+s3OJ(&;9}!aZ4.YF;qG $>9~8(?uP' );
define( 'LOGGED_IN_SALT',   'sVm!tKh|Bj02ikFlClt3pdk 4Y}iQ04?qT3M#/sq6C=G,Uv%{zERD_)Ojj>u7?B%' );
define( 'NONCE_SALT',       'lK}x&Yl.q7q||a|>y^$u<Xd08rG_i-a2e-f;Mz~C;*)QsCD@/tG0pyw-B>|7dr3^' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
