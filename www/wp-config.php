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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'projectdb');

/** MySQL database username */
define('DB_USER', 'admin');

/** MySQL database password */
define('DB_PASSWORD', 'PASSWORD');

/** MySQL hostname */
define('DB_HOST', 'mariadb');

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
define('AUTH_KEY',         ')|4I*X#i5KA0]#1lTk1FZ[^3-d(,%DR*]bmcpTK9.{I,_$:1*c8}`htQ5m9FBy];');
define('SECURE_AUTH_KEY',  '$vp$yt@6y f%Ppakgxgo>}>F(98`2Ii/6s>@~n%FN3`8S~!4ROL)Gk4{o-u# e^b');
define('LOGGED_IN_KEY',    'rWZ^svz7[ -hP),V|c_zuuGT)4g< W#b_f9ecS)H$dFngbf]mx}540m*R_p_#| /');
define('NONCE_KEY',        'b|BWM{-j!~EuJqQr(}fv^t/N$U;>H|_wM9e@Yy)57?xOir/uF +s^GLo#1Ax3tc0');
define('AUTH_SALT',        '+I[%Bb=PH`T4Sjy~elkT.1Rb8ICGHzaDW`7?YQ#95#*l-YS=yb_~%/z%+u+;1:V^');
define('SECURE_AUTH_SALT', 'lS~/jhq4$]=Tu=QPE/ey5^}KgI~d Ai/B|^pZZ;1{yD#e;$ :KXCI;7!o*L5&*D ');
define('LOGGED_IN_SALT',   'hguY61l0BY]J~tb1pk$(B81^=]MA.S? WR)c2W6ywmV~5U3+{Ak/rMx5&O`Uysf}');
define('NONCE_SALT',       'nD$c3p*cS-F;?sbf%m9B(i_)  ];nv2~oLaGL><c*0j{JIOZIPV(5gH%P@:5nGj~');

/**#@-*/

/**
 * WordPress Database Table prefix.
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
define('WP_DEBUG', false);

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if (!defined('ABSPATH')) {
	define('ABSPATH', __DIR__ . '/');
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
