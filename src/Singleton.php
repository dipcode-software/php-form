<?php
namespace PHPForm;

abstract class Singleton
{
    /**
     * Returns a unique instance of a class.
     * @return Singleton The unique instance.
     */
    public static function getInstance()
    {
        static $instance = null;
        if (null === $instance) {
            $instance = new static();
        }
        return $instance;
    }
    /**
     * Constructor of the protected type prevents a new instance of the Class
     * from being created through the `new` operator outside that class.
     */
    protected function __construct()
    {
    }
    /**
     * Clone method of the private type prevents the cloning of this instance
     */
    private function __clone()
    {
    }
    /**
     * Unserialize method of the private type to prevent the deserialization of
     * the instance
     */
    private function __wakeup()
    {
    }
}
