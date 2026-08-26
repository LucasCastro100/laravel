<?php
define( 'WP_CACHE', true );

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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'u988649444_ZsHUQ' );

/** Database username */
define( 'DB_USER', 'u988649444_KQVUH' );

/** Database password */
define( 'DB_PASSWORD', 'wvfiHBZbBv' );

/** Database hostname */
define( 'DB_HOST', '127.0.0.1' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          '>?hdS`P;z7`rR2]I[nmg@6)|#l/Z`{[d&?1~ e1VRZnjx!B,L-$hAwbE*_3Q7#HV' );
define( 'SECURE_AUTH_KEY',   '!..~6ie*8[HnsD(h/32gsd]>}l>.9=$Dyl|H?ymJQ8IXVa8(x&3cRV2P7d_GR0,Y' );
define( 'LOGGED_IN_KEY',     '.E5Z-JB*}JfEBMj-^hmw[$Sb,<J;5AQ%G]:wV.RRIY6Bi2HSJQ_9#z:|O!j|K*X[' );
define( 'NONCE_KEY',         '5ND6$X/{zWi$ic(xEL#e~&IF/^c~6@6X<ROm,2B$4=r3^K-{t5q-)9KEB_./=x7U' );
define( 'AUTH_SALT',         'T_)}Pnra a2k6JUAboU-lu.9]&YS2q|!X&^ZU/=?6yZW-xJLv#r7cV;~:/D#_3Uz' );
define( 'SECURE_AUTH_SALT',  'J$kc*Z9MsFlAy_Hh6zU!3&>On ,k#E_v!FNR1Us0i6A.AUY,HPLG0Je#Ac_(^vC?' );
define( 'LOGGED_IN_SALT',    'V4xTpFV`FsYvIiq0awz#/K 4! &qC+sZRK*$3=V@ZuL8f,9WC(z{p[Owh_:-`7IM' );
define( 'NONCE_SALT',        '<SkKS|+V!=l;O^a(X.kJ*V=[hTe<{dLrE8+kN.s$l])(1*7]*Z-S6I)~Co4@Rg3Q' );
define( 'WP_CACHE_KEY_SALT', 'Q(_/,:4/+MLki/BTZbyH2TCTc9@WP)m,kR|ZuB(M:o.~4[OI}WVs,6YBdh#F7& v' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'FS_METHOD', 'direct' );
define( 'COOKIEHASH', 'c04d6196a58da8b852a4891004a760d5' );
define( 'WP_AUTO_UPDATE_CORE', false );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';