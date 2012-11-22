<?php

require_once(dirname(__FILE__) . '/../controllers/UserController.php');

class ComputeExpiryTest extends PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        $this -> threshold = mktime(0, 0, 0, 5, 25, 2012);
        $this -> expiry = mktime(0, 0, 0, 10, 5, 2012) / (24 * 60 * 60);
        $this -> nextExpiry = mktime(0, 0, 0, 10, 4, 2013) / (24 * 60 * 60);
    }
    
    public function testBeforeThreshold()
    {
        $date = $this -> threshold - (7 * 24 * 60 * 60);
        $expiry = UserController::computeExpiry($date);
        
        $this -> assertEquals($this -> expiry, $expiry);
    }

    public function testAfterThreshold()
    {
        $date = $this -> threshold + (7 * 24 * 60 * 60);
        $expiry = UserController::computeExpiry($date);
        
        $this -> assertEquals($this -> nextExpiry, $expiry);
    }

    public function testOnThreshold()
    {
        $expiry = UserController::computeExpiry($this -> threshold);
        
        $this -> assertEquals($this -> nextExpiry, $expiry);
    }
    
    public function testAfterBoth()
    {
        $date = ($this -> expiry + 7) * (24 * 60 * 60);
        $expiry = UserController::computeExpiry($date);
        
        $this -> assertEquals($this -> nextExpiry, $expiry);
    }
}
