<?php
    /**
    * Menu Helper class file.
    *
    * Use regular ereg expressions in the pattern matching to be highlight a list item based on path.
    */
    App::uses('Helper', 'View');

    class FlashMessageHelper extends Helper {
        var $helpers = array('Session');

        function flash($key = '', $attr = array()) {
            if($key == '') {
                $key = $this->request->params['controller'] . '.' . $this->request->params['action'];
            }
            return $this->Session->flash($key, $attr);
        }
    }
?>