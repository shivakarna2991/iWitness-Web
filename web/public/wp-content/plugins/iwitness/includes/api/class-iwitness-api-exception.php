<?php

class iWitness_Api_Exception extends Exception
{

    private $data;


    public function __construct($message = "", $code = 0, $data = null, Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->data = $data;
        iwitness_log_error(print_r($data, true));
    }

    /**
     * @param WP_Error|array $error
     * @return iWitness_Api_Exception
     */
    public static function  parse_from(WP_Error $error)
    {
        $messages = $error->get_error_messages();
        $messages = implode('<br/>', $messages);
        $exception = new self($messages, 400, $error); //client side error
        return $exception;
    }

    /**
     * @return array
     */
    public function get_validation_errors()
    {
        $data = $this->get_data();

        //nothing
        if (!$data || !isset($data['validation_messages'])) {
            return array("Error" => $this->getMessage());
        }

        //single message
        if (!is_array($data['validation_messages'])) {
            return array("Error" => array((string)$data['validation_messages']));
        }

        //array
        $errors = array();
        foreach ($data['validation_messages'] as $field => $messages) {
            $errors[$field] = is_array($messages) ? array_values($messages) : array((string)$messages);
        }
        return $errors;
    }

    /**
     * @return mixed
     */
    public function get_data()
    {
        return $this->data;
    }


    /**
     * @return bool
     */
    public function is_validation_error()
    {
        return $this->getCode() == 422;
    }

    /**
     * @return bool
     */
    public function is_expired_exception()
    {
        return ($this->getCode() == 401 && isset($this->data['title']) && $this->data['title'] == 'Expired');
    }


}
