<?php
App::uses( 'ArrayHelper', 'Lib' );

class Filesystem {
	const FOPEN_READ = 'rb';
	const FOPEN_READ_WRITE = 'r+b';
	const FOPEN_WRITE_CREATE_DESTRUCTIVE = 'wb'; // truncates existing file data, use with care
	const FOPEN_READ_WRITE_CREATE_DESTRUCTIVE = 'w+b'; // truncates existing file data, use with care
	const FOPEN_WRITE_CREATE = 'ab';
	const FOPEN_READ_WRITE_CREATE = 'a+b';
	const FOPEN_WRITE_CREATE_STRICT = 'xb';
	const FOPEN_READ_WRITE_CREATE_STRICT = 'x+b';

	const FILE_READ_MODE = 0644;
	const FILE_WRITE_MODE = 0666;
	const DIR_READ_MODE = 0755;
	const DIR_WRITE_MODE = 0777;


	public static function write_file( $path, $data, $mode = self::FOPEN_WRITE_CREATE_DESTRUCTIVE ) {
		if ( ! $fp = @fopen( $path, $mode ) ) {
			return false;
		}

		flock( $fp, LOCK_EX );
		fwrite( $fp, $data );
		flock( $fp, LOCK_UN );
		fclose( $fp );

		return true;
	}

	public static function read_file( $file ) {
		if ( ! file_exists( $file ) ) {
			return false;
		}

		if ( function_exists( 'file_get_contents' ) ) {
			return file_get_contents( $file );
		}

		if ( ! $fp = @fopen( $file, self::FOPEN_READ ) ) {
			return false;
		}

		flock( $fp, LOCK_SH );

		$data = '';
		if ( filesize( $file ) > 0 ) {
			$data =& fread( $fp, filesize( $file ) );
		}

		flock( $fp, LOCK_UN );
		fclose( $fp );

		return $data;
	}

	/**
	 * Lấy phần mở rộng của tập tin. Trả về phần mở rộng hoặc False nếu thất bại
	 *
	 * @param string $fileFullName
	 *
	 * @return bool|string|array
	 */
	public static function getFileExtention( $fileFullName ) {
		if ( is_array( $fileFullName ) ) {
			foreach ( $fileFullName as $k => $v ) {
				$fileFullName[ $v ] = @pathinfo( $v, PATHINFO_EXTENSION );
				unset( $fileFullName[ $k ] );
			}

			return $fileFullName;
		} else if ( is_string( $fileFullName ) ) {
			return @pathinfo( $fileFullName, PATHINFO_EXTENSION );
		}

		return false;
	}

	/**
	 * Lấy tên của file, bỏ phần mở rộng. Trả về False nếu thất bại
	 *
	 * @param string $fileFullName
	 *
	 * @return bool|string|array
	 */
	public static function getFileName( $fileFullName ) {
		if ( is_array( $fileFullName ) ) {
			foreach ( $fileFullName as $k => $v ) {
				if ( false !== ( $ext = @pathinfo( $v, PATHINFO_FILENAME ) ) ) {
					$fileFullName[ $v ] = $ext;
				}
				unset( $fileFullName[ $k ] );
			}

			return $fileFullName;
		} else if ( is_string( $fileFullName ) ) {
			return @pathinfo( $fileFullName, PATHINFO_FILENAME );
		}

		return false;
	}

	public static function pathSplit( $path = __FILE__, $reverse = true ) {
		$path = explode( DIRECTORY_SEPARATOR, trim( $path, '\\' ) );

		return $reverse ? array_reverse( $path ) : $path;
	}

	public static function parentDirName( $path = '' ) {
		if ( is_file( $path ) || is_dir( $path ) ) {
			$info = @self::pathSplit( $path );

			return $info[1];
		}

		return '';
	}

	/**
	 * Xóa thư mục và các phần tử bên trong
	 *
	 * @param string $dir Đường dẫn tới thư mục cần xóa
	 *
	 * @return bool
	 */
	public static function removeDir( $dir ) {
		if ( ! file_exists( $dir ) || ! is_dir( $dir ) ) {
			return false;
		}
		$files = array_diff( scandir( $dir ), array( '.', '..' ) );
		foreach ( $files as $file ) {
			( is_dir( $dir . DIRECTORY_SEPARATOR . $file ) ) ? self::removeDir( $dir . DIRECTORY_SEPARATOR . $file ) : unlink( $dir . DIRECTORY_SEPARATOR . $file );
		}

		return rmdir( $dir );
	}

	/**
	 * Lấy tên các tập tin trong 1 thư mục
	 *
	 * @param string $dir Đường dẫn tới thư mục cần lấy
	 *
	 * @return string[]
	 */
	public static function subFileInFolder( $dir ) {
		$sub_files = array();
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			foreach ( $objects as $object ) {
				if ( $object != "." && $object != ".." ) {
					if ( filetype( $dir . "/" . $object ) == "file" ) {
						$sub_files[] = $object;
					}
				}
			}
			reset( $objects );
		}

		return $sub_files;
	}

	/**
	 * Lấy tên các thư mục con của 1 thư mục
	 *
	 * @param string $dir Đường dẫn tới thư mục cần lấy
	 *
	 * @return array
	 */
	public static function subFolderInFolder( $dir ) {
		$sub_folders = array();
		if ( is_dir( $dir ) ) {
			$objects = scandir( $dir );
			foreach ( $objects as $object ) {
				if ( $object != "." && $object != ".." ) {
					if ( filetype( $dir . "/" . $object ) == "dir" ) {
						$sub_folders[] = $object;
					}
				}
			}
			reset( $objects );
		}

		return $sub_folders;
	}

	/**
	 * Quét folder và trả về các file và folder trong folder đó
	 *
	 * @param string $dir
	 *
	 * @return array
	 */
	public static function scanFolder( $dir ) {
		return array(
			'folders' => self::subFolderInFolder( $dir ),
			'files'   => self::subFileInFolder( $dir ),
		);
	}

	public static function filterSubFile( array $files, $file_name = null, $file_ext = null ) {
		$names = self::getFileName( $files );
		$exts  = self::getFileExtention( $files );

		if ( $file_name !== null ) {
			$file_name = ArrayHelper::toArray( $file_name );
			foreach ( $names as $k => $name ) {
				if ( ! in_array( $name, $file_name ) ) {
					unset( $names[ $k ] );
					unset( $exts[ $k ] );
				}
			}
		}

		if ( $file_ext !== null ) {
			$file_ext = ArrayHelper::toArray( $file_ext );
			foreach ( $exts as $k => $ext ) {
				if ( ! in_array( $ext, $file_ext ) ) {
					unset( $exts[ $k ] );
				}
			}
		}

		return array_intersect( array_keys( $names ), array_keys( $exts ) );

	}

	/**
	 * Given a file and path, returns the name, path, size, date modified
	 * Second parameter allows you to explicitly declare what information you want returned
	 * Options are: name, server_path, size, date, readable, writable, executable, fileperms
	 * Returns FALSE if the file cannot be found.
	 *
	 * @param string $file            path to file
	 * @param array  $returned_values array or comma separated string of information returned
	 *
	 * @return array|bool
	 */
	public static function fileInfo( $file, $returned_values = array( 'name', 'server_path', 'size', 'date' ) ) {

		if ( ! file_exists( $file ) ) {
			return false;
		}

		if ( is_string( $returned_values ) ) {
			$returned_values = explode( ',', $returned_values );
		}
		$fileinfo = array();
		foreach ( $returned_values as $key ) {
			switch ( $key ) {
				case 'name':
					$fileinfo['name'] = substr( strrchr( $file, DIRECTORY_SEPARATOR ), 1 );
					break;
				case 'server_path':
					$fileinfo['server_path'] = $file;
					break;
				case 'size':
					$fileinfo['size'] = filesize( $file );
					break;
				case 'date':
					$fileinfo['date'] = filemtime( $file );
					break;
				case 'readable':
					$fileinfo['readable'] = is_readable( $file );
					break;
				case 'writable':
					// There are known problems using is_weritable on IIS.  It may not be reliable - consider fileperms()
					$fileinfo['writable'] = is_writable( $file );
					break;
				case 'executable':
					$fileinfo['executable'] = is_executable( $file );
					break;
				case 'fileperms':
					$fileinfo['fileperms'] = fileperms( $file );
					break;
			}
		}

		return $fileinfo;
	}


	/**
	 * Tách dữ liệu từ file php
	 *
	 * @param string $path     Đường dẫn tới file php
	 * @param string $var_name Tên biến cần tách
	 * @param mixed  $default  Giá trị mặc định của biến
	 *
	 * @return mixed
	 */
	public static function getIncludeVars( $path, $var_name, $default = null ) {
		$$var_name = $default;
		if ( is_readable( $path ) ) {
			include_once $path;
		}

		return $$var_name;
	}

	/**
	 * @param string $path
	 * @param mixed  $default
	 *
	 * @return mixed
	 */
	public static function getIncludeReturn( $path, $default = false ) {
		if ( is_readable( $path ) ) {
			return include( $path );
		}

		return $default;
	}

	/**
	 * Trả về nội dung xuất ra khi include 1 file
	 *
	 * @param string $path
	 *
	 * @return bool
	 */
	public static function getOutput( $path ) {
		ob_start();
		include( $path );
		$result = ob_end_flush();

		return $result;
	}
}