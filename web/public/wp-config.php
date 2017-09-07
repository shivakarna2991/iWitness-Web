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

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . DIRECTORY_SEPARATOR);
}

/**
 * Local environment configuration
 */
if (file_exists(ABSPATH . 'wp-local.php')) {
    require_once ABSPATH . 'wp-local.php';
}

/**
 * !!!!!!! DO NOT MAKE ENVIRONMENT SPECIFIC CONFIGURATIONS BELOW !!!!!!!
 *
 * Create or edit file wp-local.php to override default constants
 *
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'iwitness');

/** MySQL database username */
define('DB_USER', 'iwitness');

/** MySQL database password */
define('DB_PASSWORD', 'hAsw6d');

/** MySQL hostname */
define('DB_HOST', 'iw-db-01.ce1mskef1ivg.us-east-1.rds.amazonaws.com');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

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
define('AUTH_KEY', 'na8X08L>z*e~{_$+{>>WZfQ{x`uq2X7{x-@<?+9{XNXiSOKE/Vr{16Iq1:?^XIIy');
define('SECURE_AUTH_KEY', '-{C94#vT-jIgAr+_{R_eL1t4268|5UmM{O9Tf_wp/F+<9xNeHBA)_K]>k8-|@@WP');
define('LOGGED_IN_KEY', '^V,ujzD F%I,%Z%N@JVMK#q[X.YO02w:s6ge0A-`@&g:3+1oI1qJcq-r(-Aonj&M');
define('NONCE_KEY', 'Gnx|4@`_aj>(kI3b;Il5mOz(!m)HAm=EvIW=Ia|!yc|{7m.t$$gSMLmyjMx&?vW(');
define('AUTH_SALT', 'c]-gm>08oyh!#S&VSAQtDTR2|s+)=+ew>X35VEs`yo+$_q#eZWV(6xA!3 uC*[O:');
define('SECURE_AUTH_SALT', '@K=+]3:/{H,usfpcj1KB[xv5`sg`b(Ka(3W#?#2n*M,Yl__Bmz%rvTS@Nsv9u7;W');
define('LOGGED_IN_SALT', '^wEF4cUw$L,gLg-0by$cI9`-lULJt= bFLZvq;pfZmAN%Zkj|3_G[&=GbM}Np~Cm');
define('NONCE_SALT', '1Yaf[Q7v+c%0?Ize mQ^vZq4/8-2MSh_+{`,8;a5A:](3~VEau2ad5O]`57bY_Rx');


@ini_set('log_errors', 1);
@ini_set('display_errors', 0); /* enable or disable public display of errors (use 'On' or 'Off') */
@ini_set('error_reporting', E_ALL ^ E_NOTICE);

define('ENABLE_CACHE', false) ;

define('IWITNESS_LOG_LEVEL_ERROR', 1); //1: error, 2:debug, 3: info
define('IWITNESS_LOG_LEVEL_DEBUG', 2); //1: error, 2:debug, 3: info
define('IWITNESS_LOG_LEVEL_INFO', 3); //1: error, 2:debug, 3: info
define('IWITNESS_LOG', true);
define('IWITNESS_LOG_LEVEL', IWITNESS_LOG_LEVEL_ERROR); //1: error, 2:debug, 3: info


/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

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
define('WP_DEBUG', true);

/* That's all, stop editing! Happy blogging. */

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';


