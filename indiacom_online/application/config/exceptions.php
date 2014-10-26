<?php
/**
 * Created by PhpStorm.
 * User: Saurav
 * Date: 10/1/14
 * Time: 8:55 AM
 */

class MySqlException extends Exception
{
    protected $sqlError;
    public function __construct($errorMessage, $sqlError = null, $code = 0, Exception $previous = null)
    {
        $this->sqlError = $sqlError;
        parent::__construct($errorMessage, $code, $previous);
    }

    public function sqlError()
    {
        return $this->sqlError;
    }

    public function __toString()
    {
        return __CLASS__ . ": [{$this->code}]: {$this->message}\n";
    }
}

class InsertException extends MySqlException
{

}

class DeleteException extends MySqlException
{

}

class UpdateException extends MySqlException
{

}

class SelectException extends MySqlException
{

}