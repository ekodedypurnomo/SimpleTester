<?php

require __DIR__ . DIRECTORY_SEPARATOR.'SimpleSubtester.php';

class SimpleTester{

    public $templateReport = array();

    public $name = null;

    protected $subtests = array();

    function __construct($name = null){
        $this->name = $name;
    }

    function getSubtest($subtestName = null){
        if(!is_array($this->subtests)) $this->subtests = array();
        
        if(is_object($subtestName)){
            foreach ($this->subtests as $i => $s) {
                if($s === $subtestName) return $s;
            }
        }else{
            foreach ($this->subtests as $i => $s) {
                if($s->name === $subtestName) return $s;
            }
        }
    }

    function addSubtest(SimpleSubtester $subtest = null){
        if(!is_array($this->subtests)) $this->subtests = array();
        $this->subtests[] = $subtest;
    }

    /**
     * [subtest description]
     *
     *
     *      $tester = new Tester;
     *      $tester->subtest('testing module x', function($subtest){
     *          $subtest->test('testing argument1', true);
     *          $subtest->test('testing argument2', true);
     *          return false; // false make ignore the testing to assert in report
     *      });
     * 
     * @param  integer $subtestName [description]
     * @param  [type]  $callback    [description]
     * @return [type]               [description]
     */
    function subtest($subtestName = null, $callback = null){
        $subtest = $this->getSubtest($subtestName);
        if(!$subtest){
            $subtest = new SimpleSubtester(array(
                'name'=>$subtestName,
                'tester'=>$this
            ));
            $this->addSubtest($subtest);
        }

        call_user_func_array($callback, array($subtest, $this));
        return $subtest;
    }

    /**
     * [test description]
     *
     *      $test = $tester->test('argue 1');
     *      $test->id; // id test
     *      $test->type; // 'test','sub','module'
     *      $test->result(); // array('type'=>'test','result'=>boolean)
     *      // if type is module
     *      $test->subs; array();
     *      // if type is sub
     *      $test->tests; array();
     *      
     * @param  [type]  $testName    [description]
     * @param  boolean $assertation [description]
     * @return [type]               [description]
     */
    function test($testName, $assertation = false, $subtest){
        if(!$this->getSubtest($subtest)){
            $this->addSubtest($subtest);
        }

        $subtest->addTest($testName, $assertation);
    }

    function result(){
        if(!is_array($this->subtests)) $this->subtests = array();
        $result = array();
        foreach ($this->subtests as $i => $s) {
            $result[$s->name] = $s->getTests();
        }
        return $result;
    }

    function report(){}
}
