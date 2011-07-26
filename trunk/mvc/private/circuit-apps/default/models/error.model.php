<?php
/**
 * Generic errors container
 * Use this model to store errors. Errors have the following properties:
 * - code: unique string to identify the error
 * - severity: use the PHP constants E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE
 * - message: public-facing message that will be displayed to the user
 * - debug: debug trace in any format
 * The stack of errors has the following
 **/
class Default_Error_CircuitModel extends CircuitModel {

    protected $severities = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);

    /**
     * Adds an error to the stack
     *
     **/
    public function addError($params) {
        $error = array();

        // Code can be null
        if (isset($params['code'])) {
            $error['code'] = strval($params['code']);
        }

        // Error severity defaults to E_USER_ERROR if not set or not a valid severity
        if (isset($params['severity']) && in_array($params['severity'], $this->severities)) {
            $error['code'] = strval($params['severity']);
        }
        else {
            $error['severity'] = E_USER_ERROR;
        }

        // Message is set to default if not passed in
        $error['message'] = isset($params['message'])
            ? $params['message']
            : 'Oops, there was an error but the developer forgot to say what it is!';

        // Debug can be null and any format
        if (isset($params['debug'])) {
            $error['debug'] = $params['debug'];
        }

        if (isset($params['title'])) {
            $error['title'] = $params['title'];
        }

        $errors = $this->get('errors');
        $errors[] = $error;

        $this->set('errors', $errors);

        // Don't need these anymore
        unset($error, $errors);
    }
    
    public function hasErrors() {
        return count($this->get('errors')) > 0;
    }
    
    public function clearError() {
        
    }

    public function clearErrorStack() {
        $this->set('errors', array());
    }

    public function getErrorStack() {
        return $this->get('errors');
    }

    public function getErrorCount() {
        return sizeof($this->get('errors'));
    }

    public function storeInSession() {
        $nonce = md5(mt_rand());
        session_set($nonce.'_error_model_data', $this->_data, SC::get('userdata.user_id'));
        $this->set('error_nonce', $nonce);
    }

    public function loadFromSession($nonce) {
        $key = $nonce.'_error_model_data';
        $this->_data = session_get($key, SC::get('userdata.user_id'));
        session_remove($key, SC::get('userdata.user_id'));
    }
}
?>
