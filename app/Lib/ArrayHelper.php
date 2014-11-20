<?php

class ArrayHelper
{
    public static function in_array($find, $array)
    {
        foreach ($array as $item) {
            if ($find === $item) {
                return true;
            }
        }
        return false;
    }

    public static function hasEmpty($array, $until = array())
    {
        foreach ($array as $item) {
            if (empty($item) && !self::in_array($item, $until)) {
                return true;
            }
        }
        return false;
    }


    public static function in_arrayi($value, $array)
    {
        foreach ($array as $item) {
            if ($value === $item || (is_numeric($item) || is_string($item)) && mb_strtolower($item) === mb_strtolower($value)) {
                return true;
            }
        }
        return false;
    }


    /**
     * Hàm trả về vị trí của 1 giá trị trong 1 mảng
     *
     * @param mixed $item  Giá trị cần tìm
     * @param array $array Mảng chứa giá trị
     *
     * @return bool|int
     */
    public static function arrayItemIndex($item, $array)
    {
        foreach ($array as $k => $v) {
            if ($v === $item) {
                return $k;
            }
        }
        return false;
    }


    public static function arrayShiftWithKey(&$array, $count = 1, $preserve_keys = null)
    {
        if (empty($array)) {
            return false;
        }
        $tmp = array_slice($array, 0, $count, $preserve_keys);
        $key = array_keys($tmp);

        $array = array_slice($array, $count, null, $preserve_keys);
        return array($key[0], $tmp[$key[0]]);
    }

    public static function arrayPopWithKey(&$array, $count = 1, $preserve_keys = null)
    {
        if (empty($array)) {
            return false;
        }
        $tmp = array_slice($array, count($array) - $count, null, $preserve_keys);
        $array = array_slice($array, 0, count($array) - $count, $preserve_keys);
        return $tmp;
    }




    /**
     * Chuyển các đối số của hàm thành 1 mảng
     *
     * @return array|mixed
     */
    public static function toArray()
    {
        $result = array();
        if (func_num_args() > 1) {
            $result = func_get_args();
        } else if (func_num_args() == 1) {
            $val = func_get_arg(0);
            if (is_array($val)) {
                return $val;
            } else if ($val !== null && !empty($val)) {
                $result[] = $val;
            }
        }
        return $result;
    }



    /**
     * Sắp thứ tự các phần tử của mảng bằng key. Thứ tự phụ thuộc vào kích thước mảng và giá trị của key.
     *
     * @param array  $array Mảng cần lấy thứ tự
     * @param string $key
     *
     * @return array
     */
    public static function getOrderByPassword($array, $key)
    {
        $array_len = count($array);
        if ($array_len < 2) {
            return $array;
        }

        $repeat_times = ceil($array_len / 128); //128 là số ký tự của thuật toán mã hóa sha512
        $key = hash('sha512', $array_len . $key);
        for ($i = 1; $i < $repeat_times; $i++) {
            $key .= hash('sha512', $key);
        }
        $key = substr($key, 0, $array_len);
        $key = str_split($key, 1);
        $array_keys = array_keys($array);
        array_multisort($key, SORT_DESC, $array_keys);
        $result = array();
        foreach ($array_keys as $key) {
            $result[$key] = $array[$key];
        }
        return $result;
    }


    /**
     * Láy các Item của 1 Array bởi các key phần tử mảng.
     * Nếu dữ liệu trả về được phép trùng lặp sẽ trả về associative array, ngược lại numeric array.
     *
     * @param array $keys
     * @param array $data
     * @param bool  $duplicable Cho phép trùng lặp dữ liệu hay không
     *
     * @return array
     */
    public static function getArrayItemByKeys($keys, $data, $duplicable = false)
    {
        $result = array();
        $keys = self::onlyInArray(self::toArray($keys), array_keys($data));
        if ($duplicable) {
            foreach ($keys as $key) {
                $result[] = $data[$key];
            }
        } else {
            foreach ($keys as $key) {
                $result[$key] = $data[$key];
            }
        }

        return $result;
    }

    /**
     * Kiểm tra giá trị và 1 mảng, nếu giá trị là thành viên của mảng thì trả về giá trị,
     * nếu không trả về giá trị đầu tiên của mảng
     *
     * @param mixed $data         Giá trị (mảng nhiều giá trị) cần kiểm tra
     * @param array $source_data  Mảng dữ liệu nguồn
     * @param bool  $compareByKey Kiểm tra dựa trên chỉ số mảng
     *
     * @return mixed
     */
    public static function onlyInArray($data, $source_data, $compareByKey = false)
    {
        $source_data = self::toArray($source_data);
        if ((is_string($data) || is_numeric($data)) && in_array($data, $source_data)) {
            return $data;
        }
        if (is_array($data)) {
            return $compareByKey ? array_intersect_key($data, $source_data) : array_intersect($data, $source_data);
        }
        $result = array_values($source_data);
        return $result[0];
    }

    /**
     * Lấy thông tin về Key và Value của 1 array item
     *
     * @param array $item
     *
     * @return array
     */
    public static function arrayItemDetail($item)
    {
        $result = array(
            'key' => '',
            'value' => '',
        );
        if (is_array($item)) {
            $arr_keys = array_keys($item);
            $result['key'] = $arr_keys[0];
            $result['value'] = $item[$result['key']];

        }
        return $result;
    }

    /**
     * Xóa các phần tử nào đó của mảng dựa vào key của nó
     *
     * @param $keys
     * @param $data
     *
     * @return array
     */
    public static function removeArrayItemByKeys($keys, $data)
    {
        return self::getArrayItemUntilKeys($keys, $data);
    }

    /**
     * Lấy các phần tử của mảng ngoại trừ các phần tử nào đó.
     *
     * @param string|number|array $keys
     * @param array               $data
     *
     * @return array
     */
    public static function getArrayItemUntilKeys($keys, $data)
    {
        $keys = self::onlyInArray(self::toArray($keys), array_keys($data));
        foreach ($keys as $key) {
            unset($data[$key]);
        }
        return $data;
    }

    /**
     * Xóa các phần tử của mảng dựa trên giá trị của chúng
     *
     * @param $values
     * @param $data
     *
     * @return mixed
     */
    public static function removeArrayItemByValues($values, &$data)
    {
        $values = self::toArray($values);
        foreach ($data as $k => $v) {
            if (in_array($v, $values)) {
                unset($data[$k]);
            }
        }
    }

    /**
     * Tách chuỗi phân tầng với mỗi tầng 1 ký tự phân tách khác nhau.
     * Tương tự hàm explode nhưng nếu chuỗi rỗng sẽ trả về mảng rỗng (explode trả về mảng chứa 1 phần tử rỗng)
     *
     * @param string|array $spliter Ký tự | mảng các ký tự phân tách
     * @param string|array $data    Dữ liệu cần phân tách
     * @param bool         $flatten Có làm phẳng mảng
     *
     * @return array
     */
    public static function splitToLayer($spliter, $data, $flatten = true)
    {
        $result = array();
        $spliters = self::toArray($spliter);
        if (is_array($data)) {
            $result = $data;
        }
        $spliter = array_shift($spliters);

        if (is_string($data) && !empty($data)) {
            $result = explode($spliter, $data);
        }
        if (!empty($spliters)) {
            foreach ($result as $k => $v) {
                if (strpos($v, $spliters[0])) {
                    $result[$k] = self::splitToLayer($spliters, $v);
                }

            }
        }
        return $flatten ? self::flattenArray($result, false) : $result;
    }

    /**
     * Làm xẹp mảng nhiều chiều, nếu mảng kết quả chỉ có 1 phần tử sẽ chỉ trả về riêng phần tử đó.
     *
     * @param array $array
     * @param bool  $unique Có unique mảng kết quả không
     *
     * @return bool|\RecursiveIteratorIterator
     */
    public static function flattenArray($array, $unique = true)
    {
        $array = self::toArray($array);
        $result = array();
        $it = new \RecursiveIteratorIterator(new \RecursiveArrayIterator($array));
        foreach ($it as $v) {
            $result[] = $v;
        }
        $result = $unique ? array_unique($result) : $result;
        if (count($result) == 1) {
            $result = array_shift($result);
        }
        return $result;
    }

    /**
     * Tách chuỗi với các phần tử phân tách. Tương tự explode nhưng hỗ trợ nhiều phần tử phân tách
     *
     * @param string|array $spliter Các ký tự phân tách
     * @param string       $data    Chuỗi cần tách
     *
     * @return array
     */
    public static function split($spliter, $data)
    {
        $spliter = self::toArray($spliter);
        if (empty($spliter)) {
            return self::toArray($data);
        }
        foreach (array_slice($spliter, 1) as $sp) {
            $data = str_replace($sp, $spliter[0], $data);
        }
        return explode($spliter[0], $data);
    }

    /**
     * Lấy các giá trị của 1 mảng ($data) mà không có trong mảng khác ($compare_data)
     *
     * @param array $data         Mảng cần lọc
     * @param array $compare_data Mảng đối chiếu
     * @param bool  $by_key       Lọc bởi key của phần tử mảng
     *
     * @return array
     */
    public static function getDiffValue($data, $compare_data = array(), $by_key = false)
    {
        $result = array();
        if ($by_key) {
            foreach ($data as $k => $v) {
                if (!isset($compare_data[$k])) {
                    $result[$k] = $v;
                }
            }
        } else {
            foreach ($data as $k => $v) {
                if (!in_array($v, $compare_data)) {
                    $result[$k] = $v;
                }
            }
        }

        return $result;
    }

    /**
     * Trả về đối số đã được gộp bởi dữ liệu mặc định và dữ liệu tùy chọn
     *
     * @param array $args    Mảng dữ liệu tùy chọn
     * @param array $default Mảng dữ liệu mặc định
     * @param bool  $addNew  Có cho phép thêm dữ liệu không có trong dữ liệu mặc định không
     *
     * @return array
     */
    public static function getArgs($args, $default = array(), $addNew = true)
    {
        $args = self::toArray($args);
        if (!$addNew) {
            $args = array_intersect_key($args, $default);
        }
        return array_merge($default, $args);
    }

    /**
     * Đặt tên cho các phần tử của mảng.
     * Các phần tử chưa có tên sẽ được đặt theo thứ tự tên cần đặt.
     * Các phần tử không có trong danh sách tên sẽ được đặt tên theo thứ tự cùng với tiền tố.
     * vd: $array = range(1,9);
     * $array['google'] = 'ABC';
     *  $names = array('yahoo', 'google', 'micr');
     *  $named = named($array, $names, null, 'excess_');
     *
     * Mảng $named sẽ có giá trị là
     * array('google'=>'ABC', 'yahoo'=>1, 'micr'=>2, 'excess_1'=>3, 'excess_2'=>4,....)
     *
     *
     *
     * @param array        $data
     * @param string|array $names         Các tên cần đặt
     * @param mixed        $default_value Giá trị mặc định cho các tên cần đặt nhưng $data không đủ giá trị
     * @param string       $excess_prefix Tiền tố cho các phần tử còn thừa của $data.
     *                                    False sẽ không đặt tên cho các phần tử này
     *
     * @param bool|string  $grouped       Gom nhóm các phần tử thừa. Nếu false sẽ đặt trực tiếp vào mảng kết quả.
     *                                    Nếu là chuỗi sẽ gom thành mảng với tên nhóm
     *
     * @return array
     */
    public static function named($data, $names, $default_value = null, $excess_prefix = '', $grouped = false)
    {
        $data = self::toArray($data);
        $names = self::toArray($names);
        $result = array();
        foreach ($names as $k => $name) {
            if (isset($data[$name])) {
                $result[$name] = $data[$name];
                unset($names[$k]);
                unset($data[$name]);

            }
        }

        while (!empty($data) && !empty($names)) {
            $result[array_shift($names)] = array_shift($data);
        }

        if (!empty($names)) {
            foreach ($names as $name) {
                $result[$name] = $default_value;
            }
        }
        if (!empty($data) && $excess_prefix !== false) {
            $i = 1;
            if ($grouped == false) {
                while ($item = array_shift($data)) {
                    $result[$excess_prefix . ($i++)] = $item;
                }
            } else {
                $result[$grouped] = array();
                while ($item = array_shift($data)) {
                    $result[$grouped][$excess_prefix . ($i++)] = $item;
                }
            }

        }
        return $result;
    }

    /**
     * Làm xẹp mảng nhiều chiều với các chỉ số phần tử.
     *
     * @param array  $array Mảng cần làm xẹp
     * @param string $glue  Chuỗi phân tách giữa các chỉ số
     *
     * @return array
     */
    public static function flattenAssoc($array, $glue = ':')
    {

        $result = array();
        foreach ($array as $key => $item) {
            if (!is_array($item)) {
                $result[$key] = $item;
            } else {
                $item = self::flattenAssoc($item, $glue);
                foreach ($item as $k => $i) {
                    $result[$key . $glue . $k] = $i;
                }
            }
        }
        return $result;
    }


    /**
     * Lấy về các giá trị không trùng của 1 cột trong số các record
     *
     * @param string $columnName Tên field chứa các giá trị cần lấy unique
     * @param array  $data       Dữ liệu
     *
     * @return array    Mảng kết quả có dạng <giá trị phần tử> => <số lần xuất hiện>
     */
    public static function getFieldUnique($data, $columnName)
    {
        $result = array();
        foreach ($data as $row) {
            if (isset($row[$columnName])) {
                if (isset($result[$row[$columnName]])) {
                    $result[$row[$columnName]] += 1;
                } else {
                    $result[$row[$columnName]] = 1;
                }
            }

        }
        //        return array_keys($result);
        return $result;
    }

    /**
     * Duyệt qua mảng 2 chiều và trả về các field cần lấy của từng phần tử mảng
     *
     * @param array $columnNames Mảng chứa tên các field cần lấy
     * @param array $data        Mảng 2 chiều cần lọc
     * @param bool  $flatten     Làm phẳng kết quả. Nếu kết quả lọc các mảng chỉ có 1 phần tử thì trả về phần tử đầu
     *                           tiên kết quả đó
     *
     * @return array
     */
    public static function getColumns($data, $columnNames, $flatten = false)
    {
        $result = array();
        $columnNames = self::toArray($columnNames);
        foreach ($data as $k => $row) {
            $result[$k] = self::getFileds($row, $columnNames);
            if ($flatten && count($result[$k]) == 1) {
                $result[$k] = self::getFirst($result[$k]);
            }
        }
        return $result;
    }

    /**
     * Lọc qua mảng 1 chiều và trả về các field cần lấy
     *
     * @param array $fields Mảng chứa tên các field cần lấy
     * @param array $data   Mảng dữ liệu
     *
     * @return array
     */
    public static function getFileds($data, $fields)
    {
        $result = array();
        $keys = array_keys($data);
        foreach ($fields as $filed) {
            if (in_array($filed, $keys)) {
                $result[$filed] = $data[$filed];
            }
        }
        return $result;
    }

    /**
     * lấy giá trị đầu tiên của mảng
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function getFirst($array)
    {
        $array = self::toArray($array);
        return array_shift($array);
    }

    /**
     * lấy giá trị cuối cùng của mảng
     *
     * @param array $array
     *
     * @return mixed
     */
    public static function getLast($array)
    {
        $array = self::toArray($array);
        return array_pop($array);
    }


    /**
     * Chuyển mảng 2 chiều data về dạng mảng kết hợp
     * => Thay chỉ số phần tử của mảng = giá trị của 1 cột nào đó
     *
     * @param array  $data          Dữ liệu
     * @param string $columnAsKey   Tên của column chứa các giá trị dùng để làm key
     * @param mixed  $columAsValues Chứa tên các field dùng làm giá trị.
     *                              Có thể là mảng các tên hay 1 tên, nếu rỗng sẽ lấy toàn bộ
     *
     *
     * @return array
     */
    public static function convertToAssocArray($data, $columnAsKey, $columAsValues = array())
    {
        $result = array();
        foreach ($data as $row) {
            if (isset($row[$columnAsKey])) {
                if (!empty($columAsValues)) {
                    if (is_array($columAsValues)) {
                        $result[$row[$columnAsKey]] = self::getFileds($row, $columAsValues);
                    } else if (is_string($columAsValues)) {
                        $result[$row[$columnAsKey]] = $row[$columAsValues];
                    }

                } else {
                    $result[$row[$columnAsKey]] = $row;
                }
            }
        }

        return $result;
    }


    /**
     * Tạo key cho các phần tử của mảng,
     * mỗi key gồm giá trị của nhiều field của mảng phần tử.
     * Chỉ trả về các phần tử có đầy đủ các phần tử dùng tạo key
     *
     * @param array  $keys     Mảng tên các field dùng tạo key
     * @param array  $data     Mảng dữ liệu
     * @param string $sperator Phân cách giữa các giá trị tạo thành key
     *
     * @return array
     */
    public static function createKey($data, $keys, $sperator = '_**_')
    {
        $result = array();
        $keys = self::toArray($keys);
        foreach ($data as $row) {
            $tmpKey = array();
            $continue = true;
            foreach ($keys as $key) {
                if (!isset($row[$key])) {
                    $continue = false;
                    break;
                }
                $tmpKey[] = $row[$key];
            }
            if ($continue) {
                $result[implode($sperator, $tmpKey)] = $row;
            }
        }
        return $result;
    }


    /**
     * Lọc mảng 2 chiều dựa trên giá trị của các cột.
     *
     * @param array $data
     * @param array $comlumns Mảng chứa tên các cột và giá trị của các cột đó, nếu cột có nhiều giá trị có thể ở dạng
     *                        mạng vd: array('group'=>0, 'parentId'=>5) hay array('group'=>0,
     *                        'parentId'=>array('A','B'))
     *
     * @return array
     */
    public static function filterByColumnValues($data, $comlumns)
    {
        $result = array();
        foreach ($data as $row) {
            $continue = true;
            foreach ($comlumns as $cl_key => $cl_val) {
                if (!isset($row[$cl_key]) || is_array($cl_val) ? !in_array($row[$cl_key], $cl_val) : $row[$cl_key] !== $cl_val) {
                    $continue = false;
                    break;
                }
            }
            if ($continue) {
                $result[] = $row;
            }
        }
        return $result;
    }


    /**
     * Phân bậc mảng 2 chiều.
     *
     * vd:
     * $keys=array('site','module', 'group');
     *   $array=array(
     *       array('site'=>'AA', 'group'=>'a', 'module'=>'A', 'name'=>'1'),
     *       array('site'=>'CC','group'=>'b', 'module'=>'C', 'name'=>'2'),
     *       array('site'=>'BB','group'=>'c', 'module'=>'B', 'name'=>'3'),
     *       array('site'=>'AA','group'=>'c', 'module'=>'A', 'name'=>'4'),
     *       array('site'=>'CC','group'=>'a', 'module'=>'C', 'name'=>'5'),
     *       array('site'=>'CC','group'=>'a', 'module'=>'B', 'name'=>'6')
     *   );
     * info(getArrayArchive($array,$keys));
     *
     * @param string|array $keys Mảng (hay chuỗi) các khóa (array key) dùng để phân bậc
     * @param array        $data Dữ liệu vào
     *
     * @return array
     */
    public static function getArrayStructure($data, $keys)
    {
        $result = array();
        if (is_string($keys) || (is_array($keys) && count($keys) == 1)) {
            $keys = is_array($keys) ? array_shift($keys) : $keys;
            foreach ($data as $item) {
                if (!empty($item[$keys])) {
                    $result[$item[$keys]][] = $item;
                }
            }
        } else if (is_array($keys) && count($keys) > 1) {
            $result = self::getArrayStructure($data, array_shift($keys));
            foreach ($result as $tmpKey => $tmpResult) {
                $result[$tmpKey] = self::getArrayStructure($tmpResult, $keys);
            }
        }

        ksort($result);
        return $result;
    }

    /**
     * Lấy giá trị đầu tiên không phải là null trong số các đối số của hàm
     *
     * @return null|mixed   Trả về phần tử đầu tiên không phải là null hoặc null nếu tất cả các đối số đều null
     */
    public static function getFirstNotNull()
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!is_null($arg)) {
                return $arg;
            }
        }
        return null;
    }

    /**
     * Lấy giá trị đầu tiên không rỗng trong số các đối số.
     *
     * @return string   Phần tử không rỗng đầu tiên, hoặc chuỗi rỗng nếu không tìm thấy
     */
    public static function getFirstNotEmpty()
    {
        $args = func_get_args();
        foreach ($args as $arg) {
            if (!empty($arg)) {
                return $arg;
            }
        }
        return '';
    }

    /**
     * Chuyển nội dung XML thành dữ liệu dạng mảng sử dụng json để chuyển đổi.
     *
     * @param $xml_string
     *
     * @return mixed|string
     */
    public static function xmlToArray($xml_string)
    {
        $xml = simplexml_load_string($xml_string);
        $result = json_encode($xml);
        $result = json_decode($result, true);
        return $result;
    }

    public static function utf8EncodeRecursive($dat)
    {
        if (is_string($dat)) {
            return !mb_check_encoding($dat, 'UTF-8') ? utf8_encode($dat) : $dat;
        }
        $func = __FUNCTION__;
        if (is_object($dat)) {
            $ovs = get_object_vars($dat);
            $new = $dat;
            foreach ($ovs as $k => $v) {
                $new->$k = $func($new->$k);
            }
            return $new;
        }

        if (!is_array($dat)) {
            return $dat;
        }
        $ret = array();
        foreach ($dat as $i => $d) {
            $ret[$i] = $func($d);
        }
        return $ret;
    }

    public static function utf8DecodeRecursive($dat)
    {
        if (is_string($dat)) {
            return !mb_check_encoding($dat, 'UTF-8') ? utf8_decode($dat) : $dat;
        }
        $func = __FUNCTION__;
        if (is_object($dat)) {
            $ovs = get_object_vars($dat);
            $new = $dat;
            foreach ($ovs as $k => $v) {
                $new->$k = $func($new->$k);
            }
            return $new;
        }

        if (!is_array($dat)) {
            return $dat;
        }
        $ret = array();
        foreach ($dat as $i => $d) {
            $ret[$i] = $func($d);
        }
        return $ret;
    }


    /**
     * Đếm số chiều của mảng
     *
     * @param array $array Mảng cần đếm
     * @param bool  $all   True - Tính số chiều với tất cả các phần tử của mảng.
     *                     False - lấy phần tử có số chiều lớn nhất
     *
     * @return int|mixed
     */
    public static function countDimention(&$array, $all = false)
    {
        if (!is_array($array)) {
            return 0;
        }
        $count = array();
        foreach ($array as $v) {
            $count[] = 1 + self::countDimention($v, $all);
        }
        return !empty($count) ? ($all ? min($count) : max($count)) : 1;
    }

    /**
     * Đảm bảo cấu trúc của mảng
     *
     * @param mixed $data   Dữ liệu cần tạo cấu trúc
     * @param array $struct Mảng cấu trúc
     */
    public static function setStruct(&$data, array $struct)
    {
        if (!is_array($data)) {
            $data = array();
        }
        foreach ($struct as $k => $v) {
            if (is_array($v)) {
                if (array_key_exists($k, $data)) {
                    self::setStruct($data[$k], $v);
                } else {
                    $tmp = array();
                    self::setStruct($tmp, $v);
                    if (is_numeric($k)) {
                        $data[] = $tmp;
                    } else {
                        $data[$k] = $tmp;
                    }
                }
            } else {
                if (is_numeric($k)) {
                    if (!in_array($v, $data)) {
                        $data[] = $v;
                    }
                } else {
                    if (!array_key_exists($k, $data)) {
                        $data[$k] = $v;
                    }
                }
            }
        }
    }

    /**
     * Trả về ngẫu nhiên phần tử của mảng
     *
     * @param array $array Mảng chứa
     * @param int   $count Số phần tử
     *
     * @return array
     */
    public static function randomItems(array $array, $count)
    {
        self::shuffle($array);
        return array_slice($array, 0, $count);
    }


    /**
     * Xáo trộn mảng giữ nguyên key.
     *
     * @param array $array
     */
    public static function shuffle(&$array)
    {
        $keys = array_keys($array);
        shuffle($keys);
        $new_array = array();
        foreach ($keys as $key) {
            $new_array[$key] = $array[$key];
        }
        $array = $new_array;
    }

    /**
     * Kiểm tra có phải là mảng associative
     *
     * @param array $array Mảng cần kiểm tra
     *
     * @return bool
     */
    public static function isAssoc($array)
    {
        if (is_array($array)) {
            foreach ($array as $k => $v) {
                if (!is_numeric($k)) {
                    return true;
                }
            }
        }
        return false;
    }

    /**
     * @param      $array
     * @param bool $all_key
     *
     * @return bool
     */
    public static function isMultiDimention($array, $all_key = false)
    {
        if ($all_key) {
            foreach ($array as $item) {
                if (!is_array($item)) {
                    return false;
                }
            }
            return true;
        } else {
            foreach ($array as $item) {
                if (is_array($item)) {
                    return true;
                }
            }
            return false;
        }
    }

    /**
     * Tính trung bình cộng mảng
     *
     * @param array $arr
     *
     * @return float
     */
    public static function average($arr)
    {
        if (empty($arr)) {
            return 0;
        }
        return array_sum($arr) / count($arr);
    }

    public static function getPaths($array)
    {
        $result = array();
        foreach($array as $key => $value){
            if(!is_array($value)){
                if(is_numeric($key)){
                    $result[]=$value;
                }else{
                    $result[$key] = $value;
                }
            }else{

            }
        }
    }

} 