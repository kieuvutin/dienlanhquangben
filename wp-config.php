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
define('DB_NAME', 'dienlanhquangben');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', '');

/** MySQL hostname */
define('DB_HOST', 'localhost');

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
define('AUTH_KEY',         '(F1tFW$00|qdto/L7:TI(7y OVPMM$0*@%}rBw2bg+=ah[n5c~zso3-TnEH/|nSa');
define('SECURE_AUTH_KEY',  'x#+pkcV=idt9viBPxqGa.`/WUr]jWwBX^*yo-,mQi+r]TaH&>_}B$OU]e(A}<2 D');
define('LOGGED_IN_KEY',    'FoUiY;/=,Dao.DR!hH6Te`821p]v(tY;OxGV~Y__la{97UNtC:w(s _Pj^Msj#4g');
define('NONCE_KEY',        'vq9KpuVZEu~VbT|m.[NzgX)zEo07r)sYTQKG%al15Av~;5wqHk&Al!dPs;[9~$Z.');
define('AUTH_SALT',        'nBpd0BN[{0.Mnc$Zc>AdYPZ|4b&K1ES!Yz]E4RY(1JUUEBzBsl[ZH8bVQZ.Y#(v7');
define('SECURE_AUTH_SALT', ']Ob`5=P]t)6x/^zG]K8Q^l[w@Oo Im|;[yM[Oy.P~,<T.=KA^iI/SIR*v,Q=iFO@');
define('LOGGED_IN_SALT',   '=x3xU^{Z}/t2GEp_qJAZ:;;x;)$lzY^x:++#HZFJqyd16N?!xCF#p|$&h~kYGS3n');
define('NONCE_SALT',       'Pg15SY|{Igr-8F69I%nTqWrUML02_V[ZCmtAKrUxTJ1v2yv4`EN,%$,htd-}#44#');

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
