<?php
/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */


/**
 * Smarty {html_options} function plugin
 *
 * Type:     function<br>
 * Name:     html_options<br>
 * Input:<br>
 *           - name       (optional) - string default "select"
 *           - values     (required if no options supplied) - array
 *           - options    (required if no values supplied) - associative array
 *           - selected   (optional) - string default not set
 *           - output     (required if not options supplied) - array
 * Purpose:  Prints the list of <option> tags generated from
 *           the passed parameters
 * @link http://smarty.php.net/manual/en/language.function.html.options.php {html_image}
 *      (Smarty online manual)
 * @param array
 * @param Smarty
 * @return string
 * @uses smarty_function_escape_special_chars()
 */
 class Default_Dropdown_CircuitFrame
 {

    function execute( & $controller )
    {
        $observer =& $controller->getObserver();
        $params = $observer->get('default.dropdown.options');
        if( empty( $params ) || ! is_array( $params ) || ! isset( $params['values'] ) ) return '';
        $options = $observer->get('default.dropdown.options');
        $observer->remove('default.dropdown.options');
        return $this->options( $options );
    }


    function options($params)
    {
        $name = null;
        $values = null;
        $options = null;
        $selected = array();
        $output = null;

        $extra = '';

        foreach($params as $_key => $_val) {
            switch($_key) {
                case 'name':
                    $$_key = (string)$_val;
                    break;

                case 'options':
                    $$_key = (array)$_val;
                    break;

                case 'values':
                case 'output':
                    $$_key = array_values((array)$_val);
                    break;

                case 'selected':
                    $$_key = array_map('strval', array_values((array)$_val));
                    break;

                default:
                    if(!is_array($_val)) {
                        $extra .= ' '.$_key.'="'. $this->escape($_val).'"';
                    } else {
                        trigger_error("html_options: extra attribute '$_key' cannot be an array", E_USER_NOTICE);
                    }
                    break;
            }
        }

        if (!isset($options) && !isset($values))
            return ''; /* raise error here? */

        $_html_result = '';

        if (is_array($options)) {

            foreach ($options as $_key=>$_val)
                $_html_result .= $this->optoutput($_key, $_val, $selected);

        } else {

            foreach ((array)$values as $_i=>$_key) {
                $_val = isset($output[$_i]) ? $output[$_i] : '';
                $_html_result .= $this->optoutput($_key, $_val, $selected);
            }

        }

        if(!empty($name)) {
            $_html_result = '<select name="' . $name . '"' . $extra . '>' . "\n" . $_html_result . '</select>' . "\n";
        }

        return $_html_result;

    }

    function optoutput($key, $value, $selected) {
        if(!is_array($value)) {
            $_html_result = '<option label="' . $this->escape($value) . '" value="' .
                $this->escape($key) . '"';
            if (in_array((string)$key, $selected))
                $_html_result .= ' selected="selected"';
            $_html_result .= '>' . $this->escape($value) . '</option>' . "\n";
        } else {
            $_html_result = $this->optgroup($key, $value, $selected);
        }
        return $_html_result;
    }

    function optgroup($key, $values, $selected) {
        $optgroup_html = '<optgroup label="' . $this->escape($key) . '">' . "\n";
        foreach ($values as $key => $value) {
            $optgroup_html .= $this->optoutput($key, $value, $selected);
        }
        $optgroup_html .= "</optgroup>\n";
        return $optgroup_html;
    }

    function escape($string)
    {
        if(!is_array($string)) {
            $string = preg_replace('!&(#?\w+);!', '%%%_START%%%\\1%%%_END%%%', $string);
            $string = htmlspecialchars($string);
            $string = str_replace(array('%%%_START%%%','%%%_END%%%'), array('&',';'), $string);
        }
        return $string;
    }

}

?>
