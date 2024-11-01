<?php
namespace Rgbcode\Plugins\Netzero_SM\Classes;

class Flash extends Singleton {

	const FLASH_KEY = 'rgbc_netzero_sm_flash';

	protected function __construct() {
		parent::__construct();
		if ( ! session_id() ) {
			session_start();
		}
	}

	/**
	 * @param string $key
	 * @param array $data
	 *
	 * @return void
	 */
	public function set( $key, array $data ) {
		$_SESSION[ self::FLASH_KEY ][ $key ] = $data;
	}

	/**
	 * @param string $key
	 * @param $data
	 *
	 * @return void
	 */
	public function add( $key, $data ) {
		$_SESSION[ self::FLASH_KEY ][ $key ][] = $data;
	}


	/**
	 * @return mixed|null
	 */
	public function get() {
		$value = $_SESSION[ self::FLASH_KEY ] ?? null;

		if ( $value !== null ) {
			unset( $_SESSION[ self::FLASH_KEY ] );
		}

		return $value;
	}
}
