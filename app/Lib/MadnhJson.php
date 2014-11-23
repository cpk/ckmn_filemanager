<?php

App::uses( 'Priority', 'Lib' );
App::uses( 'ProcessResult', 'Lib' );
App::uses( 'ArrayHelper', 'Lib' );

class MadnhJson {
	const JSON_OUTPUT_VER = 1.0;

	/**
	 * Output. Tùy chọn header mặc định có: Content-type: application/json
	 *
	 * @param ProcessResult $result Các tùy chọn
	 *
	 * @return mixed
	 * @throws \Exception Lỗi khi chưa gán kết quả xử lý (ProcessResult)
	 */
	public static function output( ProcessResult $result) {
		if ( ! is_a( $result, 'ProcessResult' ) ) {
			throw new \Exception( 'Chưa gán kết quả xử lý' );
		}


		$json = array(
			'info'           => array(
				'json_provider'         => 'json_output',
				'json_provider_version' => self::JSON_OUTPUT_VER,
				'system'                => 'FileManager',
				'system_version'        => 1,
				'send_time'             => time(),
			),
			'process_info'   => $result->getInfos(),
			'process_data'   => $result->getDatas(),
			'process_action' => $result->getActions(),
		);


		return json_encode( $json );
	}
} 