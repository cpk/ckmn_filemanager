<?php

class CommonComponent extends Component {

    function subval_sort($a, $subkey) {
        $b = array();
        $c = array();
        if (is_array($a))
            foreach ($a as $k => $v) {
                $b[$k] = strtolower($v[$subkey]);
            }
        if (is_array($b)) {
            asort($b);
            foreach ($b as $key => $val) {
                $c[] = $a[$key];
            }
        }
        return $c;
    }

}
