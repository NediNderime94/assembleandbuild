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
define( 'DB_NAME', 'assemblewebsite' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '00Admin00!' );

/** MySQL hostname */
define( 'DB_HOST', '' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '=yIh=T$sp9Zf<>oFV/C.Fe8AD_C0GIDZ!V)}{wbY4E<aq|ox+{^N6S#yZQJ.Zd*!' );
define( 'SECURE_AUTH_KEY',  '3^5g-bOE:zwG>!N.o}1z%HjVC2-.7hiE7u9)3j;IW>JxD{3qvVRIve<5d<KBEyTm' );
define( 'LOGGED_IN_KEY',    '[o}?ZzkQh9F>R`o9SCQ9=b+b&/q!,aA_WBu2Bs^DfA.i#L}:#dbJCzl&Vr^H)9U7' );
define( 'NONCE_KEY',        '@YS[sY_,-yFm>7fJaBHCyUqjH1,IryVrk8HjX3:3jfcrixnAxx%@P]ta/{$/T?pa' );
define( 'AUTH_SALT',        'q6%y[lGuqp3O$n|xJ>R+zDH(|Ws z{SLt9h9viVP*6M&:Y_Ii)x}^>0hSGJwg>*p' );
define( 'SECURE_AUTH_SALT', 'm3w`t?lty )?WPODIFL1C^]%uCA4R5C.`o(<@=+wE_~:>b%PBfpv!Nuw570y{016' );
define( 'LOGGED_IN_SALT',   '7BZ0U|O|o$)z9-z3b_a%oq~LfravxvGfTklUd)3FY8=HM=lf.yI|ad*YH4Olhg]E' );
define( 'NONCE_SALT',       'VI?~=.8DDIppePoZUD>G K1|@?xNP#&mes`vc%w{|(9au)|R(}UWvolrD>2:Jni8' );

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_assemblewebsite';

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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
