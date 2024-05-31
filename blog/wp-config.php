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
define( 'DB_NAME', 'quikflo_quikflo' );

/** Database username */
define( 'DB_USER', 'quikflo_quikflo' );

/** Database password */
define( 'DB_PASSWORD', '%Fa)H0gsILm@' );

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
define( 'AUTH_KEY',         'qav>M.P.Yo!U~=WMtHR2_T%0M<(y#<z,BwETN%qRP[sw<O*{:mW/Yk#UV&)<[UNz' );
define( 'SECURE_AUTH_KEY',  '@KA;zg7Q63|&y^j{52YK`kBt[tA>&`F+GTo/k.=a:TfqSKz@Y/DT,a8*g%2ajFW3' );
define( 'LOGGED_IN_KEY',    'H6o:OP}Pl]OxPEdlEZ)L>Pf)L~z-W ?050uWkRAE?}W|j#>tD+.m/X~YCkN/mA0V' );
define( 'NONCE_KEY',        'e:[I?}atC02S/sssr#(r~.Ci4cQPu@%?r:KQ.3SCxfx `{64~k2{K{@M*/j4vHI{' );
define( 'AUTH_SALT',        'v5ueE2w[_Iu>%FK4-]s]VjugP0CEYkG@=@P1(qqKcRMb$,OL1d?>jszro+b3.ik3' );
define( 'SECURE_AUTH_SALT', '] J@mT39/M36V^DiM0GSMdIHKfvt8G.HwT`m!x.`?Gh9/zG.wYb%9}D/7klpeJqH' );
define( 'LOGGED_IN_SALT',   'n/88Hdmk~4m91&@coQDl||8~yP=vi/.g:Qa`:K=d<f;,q_%9 6WJq(&JC(BS_8.B' );
define( 'NONCE_SALT',       ']c~VC5.3}ry+a_+I.:[ur_9t<YCH:NxjBAyql|&];M:9s6[{ X1&(r/$.54S4$PN' );

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
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
