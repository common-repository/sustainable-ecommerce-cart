<?php
namespace Rgbcode\Plugins\Netzero_SM;

/**
 *
 * After registering this autoload function with SPL, the following line
 * would cause the function to attempt to load the \Foo\Bar\Baz\Qux class
 * from /path/to/project/src/Baz/Qux.php:
 *
 *      new \Foo\Bar\Baz\Qux;
 *
 * @param string $class The fully-qualified class name.
 *
 * @return void
 */
spl_autoload_register(
	function ( $class ) {

		// project-specific namespace prefix
		$prefix = 'Rgbcode\\Plugins\\Netzero_SM';

		// base directory for the namespace prefix
		$base_dir = __DIR__ . '/src/';

		// does the class use the namespace prefix?
		$len = strlen( $prefix );
		if ( strncmp( $prefix, $class, $len ) !== 0 ) {
			// no, move to the next registered autoloader
			return;
		}

		// get the relative class name
		$relative_class = substr( $class, $len );

		$path               = $base_dir . strtolower( str_replace( '\\', '/', $relative_class ) );
		$path_array         = explode( '/', $path );
		$last_element_index = count( $path_array ) - 1;
		$class_name         = $path_array[ $last_element_index ];

		$class_name                        = 'class-' . str_replace( '_', '-', $class_name );
		$path_array[ $last_element_index ] = "$class_name.php";
		$file                              = implode( '/', $path_array );

		// if the file exists, require it
		if ( file_exists( $file ) ) {
			require $file;
		}
	}
);
