<?php
/**
 * PHPUnit bootstrap file.
 *
 * @package Dekode\NinjaForms\Azure\Tests
 */

declare(strict_types=1);

// Composer autoloader.
require_once dirname( __DIR__ ) . '/vendor/autoload.php';

// Brain Monkey setup.
require_once dirname( __DIR__ ) . '/vendor/antecedent/patchwork/Patchwork.php';

// Define WordPress constants used in the plugin.
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', '/tmp/wordpress/' );
}

if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', true );
}

// Define plugin constants.
if ( ! defined( 'DEKODE_NINJAFORMS_AZURE_VERSION' ) ) {
	define( 'DEKODE_NINJAFORMS_AZURE_VERSION', '1.2.0' );
}

if ( ! defined( 'DEKODE_NINJAFORMS_AZURE_DIR_PATH' ) ) {
	define( 'DEKODE_NINJAFORMS_AZURE_DIR_PATH', dirname( __DIR__ ) . '/' );
}

// Load plugin classes (WordPress naming convention, not PSR-4).
require_once dirname( __DIR__ ) . '/includes/class-controller.php';
