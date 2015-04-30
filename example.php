<?php

require 'SimpleTester.php';

// begin the test
$tester = new SimpleTester;
// test grup 1
$tester->subtest('Test SimpleTester class', function($subtest) use($tester){
    $subtest->test('must have a name', property_exists($tester, 'name'));
    $subtest->test('must have a templateReport', property_exists($tester, 'templateReport'));
});
// test grup 2
$tester->subtest('Test SimpleSubtester class', function($subtest){
    $subtest->test('must have a name', empty($subtest->name) === false);
    $subtest->test('must have a tester', empty($subtest->tester) === false);
});

// create report for human readable
// this is the custom part for us to deploy the report
echo 'Testing class SimpleTester within result:<br/>';
$no = 0;
foreach ($tester->result() as $subtest => $tests) {
	$tested = count($tests);
	$passed = count(array_filter($tests, function($test){
		return $test === true;
	}));
	$failed = count(array_filter($tests, function($test){
		return $test === false;
	}));
	$no++;
	echo "$no. $subtest: $tested tests ($passed passed, $failed failed).<br/>";
}