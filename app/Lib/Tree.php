<?php
App::uses('Priority', 'Lib');
App::uses('ArrayHelper', 'Lib');
class Tree {

	/**
	 * Dữ liệu chung
	 *
	 * @var array
	 */
	protected $data;
	/**
	 * Bản backup của dữ liệu chung
	 *
	 * @var array
	 */
	protected $data_bk;

	/**
	 * Mảng chứa các hàm sẽ dùng để lọc các phần tử
	 *
	 * @var array
	 */
	protected $filterFuncs = array();

	/**
	 * Tên field chứa ID của item
	 *
	 * @var string
	 */
	public $item_id_field = '';

	/**
	 * Tên field chứa parent id của item
	 *
	 * @var string
	 */
	public $parent_item_field = '';

	/**
	 * Tên field chứa children id của item
	 *
	 * @var string
	 */
	public $children_item_field = '';

	/**
	 * Tên phần tử sẽ thêm vào các item, phần tử này sẽ chứa các phần tử con của phần tử.
	 * Cần đặt tên khác nếu trùng với giá trị của phần tử
	 *
	 * @var string
	 */
	public $sub_items_string = 'childrens';

	/**
	 * Chứa các field dùng để lọc phần tử. Nếu rỗng sẽ lấy toàn bộ phần tử
	 *
	 * @var array
	 */
	public $item_info_fields = array();

	/**
	 * Field chứa giá trị ưu tiên. Null sẽ không sử dụng tính yếu tố ưu tiên
	 *
	 * @var null|number
	 */
	public $priority_field = null;


	/**
	 * Khôi phục lại dữ liệu chung từ dữ liệu đã backup
	 */
	function resetData() {
		$this->data = $this->data_bk;
	}

	/**
	 * Thêm hàm dùng filter phần tử mảng
	 *
	 * @param string|array $funcName Tên hàm
	 */
	function addFilterFunction( $funcName ) {
		if ( is_callable( $funcName ) ) {
			$this->filterFuncs[] = $funcName;
		}
	}

	/**
	 * Cài đặt dữ liệu sẽ lọc
	 *
	 * @param array $data
	 */

	function setData( $data ) {
		$this->data    = $data;
		$this->data_bk = $data;
	}


	/**
	 * Lọc item lấy các giá trị cần lấy
	 *
	 * @param array $item Item cần lọc
	 * @param bool  $trim Cho phép tự động chuyển dạng mảng về dạng bình thường khi mảng đã lọc chỉ có 1 phàn tử
	 *
	 * @return array
	 */
	protected function getItemData( $item, $trim = false ) {
		if ( empty( $this->item_info_fields ) ) {
			return $item;
		}
		if ( $trim && count( $this->item_info_fields ) == 1 ) {
			return $item[ $this->item_info_fields[0] ];
		}
		$value = ArrayHelper::getFileds( $item, $this->item_info_fields );

		return $value;
	}

	/**
	 * Lấy cấu trúc dạng cây của dữ liệu
	 *
	 * @param string|integer $parentId ID của item gốc
	 * @param integer|bool   $dept     Độ sâu tìm, <b>false</b> nếu không xét độ sâu
	 *
	 * @return array
	 */
	function getChildrensTree( $parentId, $dept = false ) {
		$result = array();

		if ( $dept !== false && $dept <= 0 ) {
			return $result;
		}
		foreach ( $this->data as $key => $value ) {
			if ( $value[ $this->parent_item_field ] === $parentId ) {
				$result[ $value[ $this->item_id_field ] ] = $value;
				unset( $this->data[ $key ] );
			}
		}

		if ( null !== $this->priority_field ) {
			$priority = new Priority();
			foreach ( $result as $k => $v ) {
				if ( isset( $v[ $this->priority_field ] ) ) {
					$priority->addValue( $k, $v[ $this->priority_field ] );
				}
			}
			$order  = $priority->render();
			$result = ArrayHelper::getArrayItemByKeys( $order, $result );
		}

		foreach ( $result as $key => $value ) {
			$subItems = $this->getChildrensTree( $value[ $this->item_id_field ], $dept !== false ? $dept - 1 : false );
			$value    = $this->getItemData( $value );
			if ( empty( $this->sub_items_string ) ) {
				$value[] = $subItems;
			} else {
				$value[ $this->sub_items_string ] = $subItems;
			}

			foreach ( $this->filterFuncs as $func ) {
				$value = call_user_func( $func, $value );
			}
			$result[ $key ] = $value;
		}

		return $result;
	}

	/**
	 * Lấy mảng các phần tử con cháu của 1 ID,
	 * Trả về dạng mảng flat
	 *
	 * @param string|integer $parentId ID của item gốc
	 * @param integer|bool   $dept     Độ sâu tìm, <b>false</b> nếu không xét độ sâu
	 *
	 * @return array
	 */
	function getChildrens( $parentId, $dept = false ) {
		$result = array();
		$stack  = array( $parentId );

		while ( ! ( empty( $stack ) || empty( $this->data ) ) ) {
			if ( $dept !== false && $dept < 0 ) {
				break;
			}
			$dept --;
			$parentId = $stack[0];
			$stack    = array_slice( $stack, 1 );

			foreach ( $this->data as $key => $value ) {
				if ( $value[ $this->parent_item_field ] === $parentId ) {
					$result[ $value[ $this->item_id_field ] ] = $value;
					$stack[]                                  = $value[ $this->item_id_field ];
					unset( $this->data[ $key ] );
				}
			}
		}
		foreach ( $result as $key => $value ) {
			$result[ $key ] = $this->getItemData( $value, true );
		}

		return $result;
	}


	/**
	 * Lấy mảng các phần tử cha của 1 item ID
	 *
	 * @param string|number $childrentId   ID của item cần tìm các phần tử cha
	 * @param bool          $untilParentId ID của phần tử sẽ dừng khi tìm tới đó, FALSE nếu không dùng tính năng này
	 * @param bool          $high          Độ cao tìm tối đa, FALSE nếu ko dùng tính năng này
	 *
	 * @return array
	 */
	function getParents( $childrentId, $untilParentId = false, $high = false ) {
		$result = array();

		while ( ! empty( $childrentId ) && $childrentId !== $untilParentId ) {
			if ( $high !== false && $high < 0 ) {
				break;
			}
			$found = false;
			foreach ( $this->data as $key => $value ) {

				if ( $value[ $this->item_id_field ] === $childrentId ) {
					$result[ $value[ $this->item_id_field ] ] = $value;
					$childrentId                              = $value[ $this->parent_item_field ];
					unset( $this->data[ $key ] );
					$found = true;
					if ( $high !== false ) {
						$high --;
					}
					break;
				}
			}
			if ( ! $found ) {
				break;
			}
		}
		foreach ( $result as $key => $value ) {
			$result[ $key ] = $this->getItemData( $value );
		}
		if ( count( $result ) > 0 ) {
			$result = array_slice( $result, 1 );
		}

		return $result;
	}


}

?>
