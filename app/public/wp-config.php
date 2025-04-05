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
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',          'c![60TW/gwpqP,~a_h`=<PpElbLCapz!`zKnJ`Y;3E&uOdA~s_[j?=744t~7`k-<' );
define( 'SECURE_AUTH_KEY',   'u9Ec,7fRZp?fsdfp7xK0CC}F-t&D}L+$bp**vx&|j3j1nJf}tzowu#FF_+|e*J3T' );
define( 'LOGGED_IN_KEY',     '<F_ueTy^c5,iR5N0zmCTd!sm4uIYUYT/vm9/Nc>Rzv-4nED+Rf6mi] sPrC$1nrV' );
define( 'NONCE_KEY',         '<4[>7li*?5TU/l^+RHW`WYz<o-HVj}ARtr!ly1SwusqCb:*6>j?,=Ci|iLG&9kC/' );
define( 'AUTH_SALT',         'F;{iB6k-uuSr^bh-8s[[J9!4xEPcq7)z73A}gQ,[O;W!&lMLXUee/FYGtK%JJn^J' );
define( 'SECURE_AUTH_SALT',  '@CMKZE{JKJ@<{97oS5PLRs,-}q^/o!hEiHRvn4wpDJ tYBXiyV(_1ddWwRilMX~i' );
define( 'LOGGED_IN_SALT',    'Hp_11Yk)%@0ZWiJ!R>lXhW)4&J/IItjL7)J1O6_x ~pQ`zSSArTTRQzW%zpj?[}b' );
define( 'NONCE_SALT',        'F{j+[pB9((^Ed#*n>ygpv(Ka( aS%9d>o!u3`7t2YddLzKr{pZD=5@4[O9f*k9>,' );
define( 'WP_CACHE_KEY_SALT', 'nH1EMa2`B$GBJ0EMC~p1Ln^`0Y%RL:[Dm|od!*=Wzu2soEf7eBYpgMzuD#(uJ7c|' );


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

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
