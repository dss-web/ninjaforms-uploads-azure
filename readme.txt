=== Ninja Forms - File Uploads to Azure ===
Contributors: dekode, dss-web
Tags: ninja forms, azure, file upload, blob storage, microsoft azure
Requires at least: 6.0
Tested up to: 6.7
Requires PHP: 8.1
Stable tag: 1.2.0
License: GPL-3.0-or-later
License URI: https://www.gnu.org/licenses/gpl-3.0.html

Add support for offloading Ninja Forms Uploads to the Microsoft Azure cloud.

== Description ==

This plugin extends Ninja Forms File Uploads to support Microsoft Azure Blob Storage as an external storage service.

= Features =

* Upload files directly to Azure Blob Storage
* Automatic container creation
* Support for Azure Storage emulator (Azurite) for local development
* Constants for configuration in controlled environments

= Requirements =

* WordPress 6.0+
* PHP 8.1+
* Ninja Forms
* Ninja Forms File Uploads extension

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/ninjaforms-uploads-azure`
2. Run `composer install` to install dependencies
3. Activate the plugin through the 'Plugins' screen in WordPress
4. Configure Azure connection settings at Ninja Forms > File Uploads > External

= Configuration =

You can define constants in wp-config.php:

    define( 'MICROSOFT_AZURE_ACCOUNT_NAME', '' );
    define( 'MICROSOFT_AZURE_ACCOUNT_KEY', '' );
    define( 'MICROSOFT_AZURE_CNAME', '' );

To force external Azure upload for all forms:

    define( 'MICROSOFT_AZURE_FORCE_EXTERNAL_UPLOAD', true );

== Frequently Asked Questions ==

= How do I set up local development? =

Install Node.js, run `npm install` and `npm run azurite` to launch the Azure Storage emulator.

Use these local settings:
* Account Name: `devstoreaccount1`
* Account Key: `Eby8vdM02xNOcqFlqUwJPLlmEtlCDXJ1OUzFT50uSRZ6IFsuFq2UVErCz4I6tq/K1SZFPTOtr/KBHBeksoGMGw==`
* Blob Service Endpoint: `http://127.0.0.1:10000/devstoreaccount1`

== Changelog ==

= 1.2.0 =
* Updated: PHP requirement raised to 8.1+
* Updated: Node.js requirement raised to 22+
* Updated: guzzlehttp/psr7 to ^2.0
* Updated: microsoft/azure-storage-blob to ^1.5
* Updated: microsoft/azure-storage-file to ^1.2
* Added: PHPUnit 10.5 test suite with Brain Monkey for WordPress mocking
* Added: Mockery for test doubles
* Removed: axios dependency (Node 18+ has native fetch)

= 1.1.1 =
* Maintenance release

= 1.1.0 =
* Initial public release

== Upgrade Notice ==

= 1.2.0 =
Requires PHP 8.1+ and Node.js 22+. Run `composer update` after upgrading.
