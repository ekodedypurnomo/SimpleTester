<?php

class SimpleSubtester{
    public $tester = null;
    public $name = null;
    protected $tests = array();

    function __construct($config){
        if(is_string($config)) $config = array('name'=> $config);

        if(is_array($config)){
            if(array_key_exists('tester', $config)) $this->tester = $config['tester'];
            if(array_key_exists('name', $config)) $this->name = $config['name'];
        }
    }

    function test($testName = null, $assertation = false){
        $this->addTest($testName, $assertation);
    }

    function addTest($testName = null, $assertation = false){
        if(!is_array($this->tests)) $this->tests = array();
        $this->tests[$testName] = (boolean)$assertation;
    }
    
    function getTest($testName = null){
        $tests = $this->getTests();
        foreach ($tests as $key => $test) {
            if($key === $testName) return $test;
        }
    }

    function getTests(){
        if(!is_array($this->tests)) $this->tests = array();
        return $this->tests;
    }
}