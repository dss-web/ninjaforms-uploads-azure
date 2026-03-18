<?php
/**
 * Unit tests for Controller class.
 *
 * @package Dekode\NinjaForms\Azure\Tests\Unit
 */

declare(strict_types=1);

namespace Dekode\NinjaForms\Azure\Tests\Unit;

use Brain\Monkey\Functions;
use Dekode\NinjaForms\Azure\Controller;
use Dekode\NinjaForms\Azure\Tests\TestCase;
use Mockery;

/**
 * Test cases for Controller class.
 */
class ControllerTest extends TestCase {

	/**
	 * Test build_connection_string returns properly formatted string with HTTPS.
	 */
	public function test_build_connection_string_returns_https_protocol(): void {
		$service           = Mockery::mock( 'NF_FU_External_Services_Azure_Service' );
		$service->settings = [
			'MICROSOFT_AZURE_ACCOUNT_NAME' => 'testaccount',
			'MICROSOFT_AZURE_ACCOUNT_KEY'  => 'testkey123',
			'MICROSOFT_AZURE_CNAME'        => 'https://testaccount.blob.core.windows.net',
		];
		$service->shouldReceive( 'load_settings' )->once()->andReturn( $service->settings );

		$controller = new Controller( $service );

		$connection_string = $controller->build_connection_string();

		$this->assertStringContainsString( 'AccountName=testaccount', $connection_string );
		$this->assertStringContainsString( 'AccountKey=testkey123', $connection_string );
		$this->assertStringContainsString( 'DefaultEndpointsProtocol=https', $connection_string );
		$this->assertStringContainsString( 'BlobEndpoint=https://testaccount.blob.core.windows.net', $connection_string );
	}

	/**
	 * Test build_connection_string returns HTTP when endpoint is HTTP.
	 */
	public function test_build_connection_string_returns_http_protocol(): void {
		$service           = Mockery::mock( 'NF_FU_External_Services_Azure_Service' );
		$service->settings = [
			'MICROSOFT_AZURE_ACCOUNT_NAME' => 'testaccount',
			'MICROSOFT_AZURE_ACCOUNT_KEY'  => 'testkey123',
			'MICROSOFT_AZURE_CNAME'        => 'http://127.0.0.1:10000/devstoreaccount1',
		];
		$service->shouldReceive( 'load_settings' )->once()->andReturn( $service->settings );

		$controller = new Controller( $service );

		$connection_string = $controller->build_connection_string();

		$this->assertStringContainsString( 'DefaultEndpointsProtocol=http', $connection_string );
	}

	/**
	 * Test error_log does not throw when called.
	 */
	public function test_error_log_does_not_throw(): void {
		$service           = Mockery::mock( 'NF_FU_External_Services_Azure_Service' );
		$service->settings = [];
		$service->shouldReceive( 'load_settings' )->once()->andReturn( [] );

		$controller = new Controller( $service );

		// WP_DEBUG is defined as true in bootstrap.php.
		// Verify the method executes without exception.
		$controller->error_log( 'Test error message' );

		$this->assertTrue( true );
	}

	/**
	 * Data provider for container name tests.
	 *
	 * @return array<string, array{string, string}>
	 */
	public static function container_name_provider(): array {
		return [
			'simple domain'      => [ 'https://example.com', 'example-com' ],
			'subdomain'          => [ 'https://blog.example.com', 'blog-example-com' ],
			'with port'          => [ 'https://localhost:8080', 'localhost' ],
			'uppercase'          => [ 'https://EXAMPLE.COM', 'example-com' ],
			'special characters' => [ 'https://my_site.example.com', 'my-site-example-com' ],
		];
	}

	/**
	 * Test get_container_name generates valid Azure container names.
	 *
	 * @dataProvider container_name_provider
	 *
	 * @param string $site_url     The site URL to test.
	 * @param string $expected     Expected container name.
	 */
	public function test_get_container_name_generates_valid_names( string $site_url, string $expected ): void {
		$service           = Mockery::mock( 'NF_FU_External_Services_Azure_Service' );
		$service->settings = [
			'MICROSOFT_AZURE_ACCOUNT_NAME' => 'test',
			'MICROSOFT_AZURE_ACCOUNT_KEY'  => 'test',
			'MICROSOFT_AZURE_CNAME'        => 'https://test.blob.core.windows.net',
		];
		$service->shouldReceive( 'load_settings' )->once()->andReturn( $service->settings );

		Functions\when( 'wp_parse_url' )->alias( 'parse_url' );
		Functions\when( 'get_site_url' )->justReturn( $site_url );

		$controller = new Controller( $service );

		// Use reflection to test protected method.
		$reflection = new \ReflectionClass( $controller );
		$method     = $reflection->getMethod( 'get_container_name' );
		$method->setAccessible( true );

		$result = $method->invoke( $controller );

		$this->assertSame( $expected, $result );
	}
}
