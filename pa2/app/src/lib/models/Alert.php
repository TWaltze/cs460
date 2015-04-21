<?php

class Alert {
    public $class = null;
    public $message = null;

    public function __construct($class, $message) {
            $this->class = $class;
            $this->message = $message;
    }
}
?>
