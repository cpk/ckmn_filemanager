<?php
/**
 * Created by Đỗ Danh Mạnh.
 * @ver 2.0
 * Date: 1/23/14
 * Time: 8:22 PM
 */

App::uses('Priority', 'Lib');

class ProcessResult
{
    const PROCESS_ERROR = 'error';
    const PROCESS_DANGER = 'danger';
    const PROCESS_WARNING = 'warning';
    const PROCESS_INFO = 'info';
    const PROCESS_SUCCESS = 'success';
    const PROCESS_NO_INFO = 'clean';
    const DEFAULT_PRIORITY = 100;

    protected static $_prog_info_value = array(
        self::PROCESS_NO_INFO => 0,
        self::PROCESS_INFO => 1,
        self::PROCESS_SUCCESS => 2,
        self::PROCESS_WARNING => 4,
        self::PROCESS_DANGER => 8,
        self::PROCESS_ERROR => 16,
    );
    /**
     * Các thông tin xử lý
     * @var array
     */
    protected $_info = array();

    /**
     * Các hành động cần thực hiện
     * @var Priority
     */
    protected $_action;

    /**
     * Các dữ liệu xử lý
     * @var array
     */
    protected $_data = array();

    /**
     * Biến kiểm tra lỗi
     * @var bool
     */
    protected $_isError = false;

    protected $_status = 0;

    public function __construct()
    {
        $this->_action = new Priority();
    }

    /**
     * Thêm thông tin xử lý
     *
     * @param string $info Thông điệp
     * @param string $infoType Loại thông điệp
     * @param integer $info_code Mã thông điệp
     */
    public function addInfo($info, $infoType = self::PROCESS_INFO, $info_code = 0)
    {
        $this->_info[] = array('content' => $info, 'type' => $infoType, 'code' => $info_code);

        if (self::$_prog_info_value[$infoType] > $this->_status) {
            $this->_status = self::$_prog_info_value[$infoType];
        }
    }

    /**
     * Thêm dữ liệu
     *
     * @param string $dataName Tên dữ liệu
     * @param mixed $dataValue Giá trị của dữ liệu
     */
    public function addData($dataName, $dataValue)
    {
        $this->_data[$dataName] = $dataValue;
    }

    /**
     * Thêm hành động
     *
     * @param string $action Tên hành động
     * @param integer $priority Mức độ quan trọng của action, giá trị càng nhỏ hành động càng quan trọng
     */
    public function addAction($action, $priority = self::DEFAULT_PRIORITY)
    {
        $this->_action->addValue($action, $priority);
    }

    public function getAction($merge = true)
    {
        if ($merge) {
            return $this->_action->render();
        }
        return $this->_action->exportValues();
    }

    /**
     * Nhập thông tin từ đối tuợng khác
     *
     * @param self $resultObj
     */
    public function import($resultObj)
    {

        if (is_object($resultObj) && (is_a($resultObj, __CLASS__) || is_subclass_of($resultObj, __CLASS__))) {
            $infos = $resultObj->getInfos();
            foreach ($infos as $info) {
                $this->addInfo($info['content'], $info['type'], $info['code']);
            }
            $this->_data = array_merge($this->_data, $resultObj->getDatas());
            $action = $resultObj->getAction(false);
            foreach ($action as $priority => $act_arr) {
                if (empty($this->_action[$priority])) {
                    $this->_action[$priority] = array();
                    $this->_action[$priority] = $act_arr;
                } else {
                    $this->_action[$priority] = array_merge($this->_action[$priority], $act_arr);
                }
            }
        }
    }

    /**
     * Kiểm tra quá trình xử lý có lỗi không
     * @return bool
     */
    public function isError()
    {
        return $this->_status == self::$_prog_info_value[self::PROCESS_ERROR];
    }

    /**
     * Kiểm tra quá trình xử lý có cảnh báo WARNING nào không
     * @return bool
     */
    public function hasWarning()
    {
        return $this->_status >= self::$_prog_info_value[self::PROCESS_WARNING];
    }

    /**
     * Kiểm tra quá trình xử lý có cảnh báo DANGER nào không
     * @return bool
     */
    public function hasDanger()
    {
        return $this->_status >= self::$_prog_info_value[self::PROCESS_DANGER];
    }

    /**
     * Kiểm tra quá trình xử lý có thành công (không có các cảnh báo WARNING, DANGER, ERROR) không
     * @return bool
     */
    public function isSuccess()
    {
        return $this->_status <= self::$_prog_info_value[self::PROCESS_SUCCESS];
    }

    /**
     * Đặt tình trạng xử lý
     *
     * @param string $status
     */
    public function setStatus($status = self::PROCESS_NO_INFO)
    {
        $this->_status = self::$_prog_info_value[$status];
    }

    /**
     * Lấy tình trạng xử lý
     * @return int
     */
    public function getStatus()
    {
        return $this->_status;
    }

    /**
     * Trả về thông tin xử lý
     * @return array
     */
    public function getInfos()
    {
        return $this->_info;
    }

    /**
     * Kiểm tra có tồn tại 1 dữ liệu nào đó hay ko
     *
     * @param $dataName
     *
     * @return bool
     */
    public function hasData($dataName)
    {
        return isset($this->_data[$dataName]);
    }

    /**
     * Gỡ bỏ 1 data
     *
     * @param $dataName
     */
    public function removeData($dataName)
    {
        unset($this->_data[$dataName]);
    }

    public function emptyInfo()
    {
        $this->_info = array();
        $this->_status = 0;
        $this->_isError = false;
    }

    /**
     * Trả về dữ liệu xử lý
     * @return array
     */
    public function getDatas()
    {
        return $this->_data;
    }

    /**
     * Trả về 1 data
     *
     * @param $dataName
     *
     * @return null
     */
    public function getData($dataName)
    {
        if (isset($this->_data[$dataName])) {
            return $this->_data[$dataName];
        }
        return null;
    }

    /**
     * Trả về mảng chứa các hoạt động cần thực hiện
     * @return array
     */
    public function getActions()
    {
        return $this->_action->render();
    }
}