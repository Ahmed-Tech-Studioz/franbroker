<?php
/**
 * The base configurations of the WordPress.
 *
 * This file has the following configurations: MySQL settings, Table Prefix,
 * Secret Keys, WordPress Language, and ABSPATH. You can find more information
 * by visiting {@link http://codex.wordpress.org/Editing_wp-config.php Editing
 * wp-config.php} Codex page. You can get the MySQL settings from your web host.
 *
 * This file is used by the wp-config.php creation script during the
 * installation. You don't have to use the web site, you can just copy this file
 * to "wp-config.php" and fill in the values.
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'franbrok_site');

/** MySQL database username */
define('DB_USER', 'franbrok_site');

/** MySQL database password */
define('DB_PASSWORD', 'oo1JSxae@Vb#');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');
#define('WP_MEMORY_LIMIT', '20000MB');
define('DISABLE_WP_CRON', 'true');

define('SCRIPT_DEBUG', true);
/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'yg(e~7yIN/K@20zM_;)%GiVEE^PLvkJ5^8E5kGw&0deNOHQ=1HRD%Cz1sydY)Wnm');
define('SECURE_AUTH_KEY',  'H8Qdf|.v%|Rt>HR[_X$T!pWL>F63Qw=&A%pLD)Zn#EHevexEY&1>3~#rMid+*3(S');
define('LOGGED_IN_KEY',    'wavV]|3,3+|B<|rZ9O<r9l;PscNrh62-d[S00-q/0AOLuGI1NBzk*088%Ain-Q=x');
define('NONCE_KEY',        '_^+^Ia}QIg.;.~B]zG,-=~_z|C.ap[j67FbSh=niG7[~%+6h|cxVa^?8*9E2+>BP');
define('AUTH_SALT',        '*9/x9XP(O=ZPv@g*Khs;,EN>,ykPnNQXEaRH.;*,NfM&@n55N37xAgb<6Pa|fR%X');
define('SECURE_AUTH_SALT', 'mg`ja9OFrP`G9vfGt{w,V|/gUtLWr`a{CWVU!{(5$y@3CsLwK.eyz@PWBx k|Vx0');
define('LOGGED_IN_SALT',   'i)0dlS+7Hmho:pYS_@aZW{D6IK L`|48d|t{|Fs-0SV+?g;cQ*di<4~X$|Ye+frc');
define('NONCE_SALT',       'U7g.F_O3n*(wiv->lF1VTP{22;%t`U%.NLwcs5?tXN0lq)-ea&(x|X+-#hWfdDgJ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 */
define('WP_DEBUG', false);
define( 'AUTOMATIC_UPDATER_DISABLED', true );
/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');