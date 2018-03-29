<?php
namespace evolve\Exceptions;
use \Exception;

class BaseException extends Exception
{
    public function __construct($msg, $code = 0, $previous = null)
    {
        parent::__construct($this->stringify($msg), $this->codify($code), $this->exceptionify($previous));
    }
    protected function stringify($mixed){
        if(is_string($mixed)) {
            return $mixed;
        }
        if(is_object($mixed)){
            return "Object::Type::".get_class($mixed);
        }
        if(is_array($mixed)) {
            return "Array::Size::".count($mixed);
        }
        if(is_float($mixed)) {
            return "Float::Value::".strval($mixed);
        }
        if(is_int($mixed)) {
            return "Int::Value::".strval($mixed);
        }
        if(is_bool($mixed)) {
            return "Bool::Value::".($mixed?'True':'False');
        }
        // no other data types, so must be NULL
        return "NULL::Value::NULL";
    }

    protected function codify($mixed) {
        if (! is_numeric($mixed)) {
            return 404;
        }
        return $mixed*1;
    }

    protected function exceptionify($mixed) {
        if (is_null($mixed)) {
            return null;
        }

        if ($mixed instanceof \Exception) {
            return $mixed;
        }

        $exception = new Exception("Expected object of type Exception, got: ".$this->stringify($mixed));
        return $exception;
    }
}