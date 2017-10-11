<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'soundblog2');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'gpj<:K-t]x[y5#i2[Ja1E6`wphKCcI{cxSXlb;6<SZY2Bbja29m=/Rb1PzsKT&`9');
define('SECURE_AUTH_KEY',  '+p+b)@bB1U{vz,85/tpxb@<u:@=q`vnD/%dV%?jo#F}Zj^LDPVR}ThvOcTa=0<f(');
define('LOGGED_IN_KEY',    'f3%}y8[ D6z82A4PTh[T]uY&p&qLS*SP_Wp)Y~=5QrWYk(J1tauS~dh:Dt><TcPf');
define('NONCE_KEY',        'p24]UcP{#d`DYgxcB;6Zbwj4S>M]S<Tw%SneI{]/Q6evY?znhd[JX^@<k57kB`Z5');
define('AUTH_SALT',        'OPBBYQZL<|anbL`:Yy=]1[!c02>CL8#53Ff$4:q1?8|RfrrcnZ+S%oelnx$X@_ER');
define('SECURE_AUTH_SALT', 'V4jl:r|.{W9r3jc)(7c{7UwW$.FXLSrNO^h<j1E^j.1^,tMvctW/-u/@Q]*0$iA/');
define('LOGGED_IN_SALT',   'Bf[y|KhuX)C`IO.YvN&d{$:@ 1Xn+nWp,HmV`~?/!cNT{@k`kOel]X&[7Sed,Vw^');
define('NONCE_SALT',       'YJ_y+G(Cbk_7QvPy,!|dB`%E*1XV!= wTn EyB&iPJ>bv30cj!q C+}<O+@Qe5JI');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
