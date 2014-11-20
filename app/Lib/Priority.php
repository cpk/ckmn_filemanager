<?php

class Priority
{
    /**
     * Mức ưu tiên cao nhất
     */
    const HIGHTEST_PRIORITY = 100;
    /**
     * Mức ưu tiên cao
     */
    const HIGHT_PRIORITY = 250;

    /**
     * Mức ưu tiên mặc định
     */
    const DEFAULT_PRIORITY = 500;
    /**
     * Mức ưu tiên thấp
     */
    const LOW_PRIORITY = 750;

    /**
     * Mức ưu tiên thấp nhất
     */
    const LOWEST_PRIORITY = 1000;

    const PRIORITY_LEVEL_1 = 100;
    const PRIORITY_LEVEL_2 = 200;
    const PRIORITY_LEVEL_3 = 300;
    const PRIORITY_LEVEL_4 = 400;
    const PRIORITY_LEVEL_5 = 500;
    const PRIORITY_LEVEL_6 = 600;
    const PRIORITY_LEVEL_7 = 700;
    const PRIORITY_LEVEL_8 = 800;
    const PRIORITY_LEVEL_9 = 900;
    const PRIORITY_LEVEL_10 = 1000;
    /**
     * Value must be unique?
     *      - true  : unique on priority
     *      - false : not unique on priority
     *      - all   : unique all priority
     *
     * @var bool
     */
    public $unique_value = false;
    /**
     * Mảng chứa bảng id các giá trị và các priority
     *
     * @var array
     */
    protected $values = array();
    /**
     * Các giá trị mặc định
     *
     * @var array
     */
    protected $raw_values = array();

    protected function get_unique_id($variable)
    {
        if (!(is_string($variable) || is_numeric($variable))) {
            if (is_array($variable)) {
                $variable = serialize($variable);
            } else if (is_object($variable)) {
                if (function_exists('spl_object_hash')) {
                    $variable = spl_object_hash($variable);
                } else {
                    return false;
                }
            }
        }
        return hash('crc32b', serialize($variable));
    }

    public function exportValues()
    {
        return $this->mixValue();
    }

    protected function mixValue()
    {
        $values = $this->values;

        foreach ($values as $priority => $valPrios) {
            foreach ($valPrios as $k => $val) {
                if (isset($this->raw_values[$val])) {
                    $valPrios[$k] = $this->raw_values[$val];
                } else {
                    unset($valPrios[$k]);
                }
            }
            $values[$priority] = $valPrios;
        }
        return $values;
    }

    public function importValues($values)
    {
        foreach ($values as $pri => $valArray) {
            foreach ($valArray as $value) {
                $this->addValue($value, $pri);
            }
        }
    }

    /**
     * Thêm giá trị
     *
     * @param mixed $value    Giá trị cần thêm
     * @param int   $priority Độ ưu tiên
     */
    public function addValue($value, $priority = self::DEFAULT_PRIORITY)
    {
        if (!$this->hasPriority($priority)) {
            $this->values[$priority] = array();
        }
        $value_id = $this->get_unique_id($value);
        if ($value_id === false) {
            return false;
        }

        if ($this->unique_value === true) {
            if (!$this->hasValue($value) || !$this->hasValueOnPriority($value, $priority)) {
                $this->raw_values[$value_id] = $value;
                $this->values[$priority][] = $value_id;
            } else {
                return false;
            }
        } else if ($this->unique_value === false) {
            $this->raw_values[$value_id] = $value;
            $this->values[$priority][] = $value_id;

        } else if ($this->unique_value === 'all') {
            if (!$this->hasValue($value)) {
                $this->raw_values[$value_id] = $value;
                $this->values[$priority][] = $value_id;
            }
            return false;
        }
        return true;
    }

    public function hasPriority($priority)
    {
        return isset($this->values[$priority]);
    }

    /**
     * Kiểm tra tồn tại của 1 giá trị ở 1 priority
     *
     * @param     $value
     * @param int $priority
     *
     * @return bool
     */
    public function hasValueOnPriority($value, $priority = self::DEFAULT_PRIORITY)
    {
        if ($this->hasPriority($priority)) {
            return in_array($value, $this->values[$priority]);
        }
        return false;
    }

    /**
     * Kiểm tra tồn tại của 1 giá trị ở tất cả priority
     *
     * @param $value
     *
     * @return bool
     */
    public function hasValue($value)
    {
        $unique_id = $this->get_unique_id($value);
        return array_key_exists($unique_id, $this->raw_values);
    }

    public function removeValue($value, $priority = self::DEFAULT_PRIORITY)
    {
        $value_id = $this->get_unique_id($value);
        if ($value_id === false) {
            return false;
        }
        if (array_key_exists($value_id, $this->raw_values)) {
            if ($priority === true) {
                foreach ($this->values as $prio_key => $values) {
                    foreach ($values as $key => $val) {
                        if ($val === $value) {
                            unset($values[$key]);
                        }
                    }
                    $this->values[$prio_key] = $values;
                }
            } else {
                foreach ($this->values[$priority] as $key => $val) {
                    if ($val === $value) {
                        unset($this->values[$priority][$key]);
                    }
                }
            }
            unset($this->raw_values[$value_id]);
            return true;
        }

        return false;
    }

    /**
     * Trả về dữ liệu đã phân mức độ ưu tiên
     *
     * @return array
     */
    public function render()
    {
        $values = $this->mixValue();
        $result = array();
        ksort($values);
        foreach ($values as $valueArr) {
            $result = array_merge($result, $valueArr);
        }
        return $result;
    }

}