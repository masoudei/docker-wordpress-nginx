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
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'projectdb' );

/** MySQL database username */
define( 'DB_USER', 'admin' );

/** MySQL database password */
define( 'DB_PASSWORD', 'PASSWORD' );

/** MySQL hostname */
define( 'DB_HOST', 'mariadb' );

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
define( 'AUTH_KEY',         'i%P^s=K_Dj(a|.3uF*B(,e+l`^8g[T))9iAV}4pR@/]$0$CYd:QPrFPWu61-7sb`' );
define( 'SECURE_AUTH_KEY',  '!`GIb{x>LiD/e9I,NHxg$F}fl2|4yNR][p%h:-z9MUtVM#j{W:po9CIh8;lC*sNh' );
define( 'LOGGED_IN_KEY',    'N`fW_4E+-?kikv# wd+noN-W7M:A0P@^SV 3S*tx.1BfwG=]h`:NK1O51dTBa:B@' );
define( 'NONCE_KEY',        'u!!2Y-Lmv~9~jgFy.|N%u?^eo<E4/tPXU$HO}8QLhm-yP]4#&I-|;3S.I.36_f-c' );
define( 'AUTH_SALT',        'XeU03*e:C]%ok/=XTIXskPI^P.Jo4)=%t]=.DShc`T53dYQ(#L_,;t:4/#@r1Wey' );
define( 'SECURE_AUTH_SALT', 'r* GT@eaL@S.WP6ur:[_|`0WGU[AzNC+aC/Q`N%}9bFf0?)*BDOcOqddMlZU]RTv' );
define( 'LOGGED_IN_SALT',   '%rC-<>#^cU-` 4q;)#IlZW7|KED%RSMP<RU6X;Y%0H`_yq<^Xars7I.Gx)E^ x/8' );
define( 'NONCE_SALT',       '^{WJbNiA`SE{nt2U89)>n6tjz7zaY*KuCb9-XDUi!qGKPLg!GyDQ48$k$MYxRUi]' );

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
