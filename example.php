<?php

require 'SimpleTester.php';

$tester = new SimpleTester;
$tester->subtest('Test SimpleTester class', function($subtest) use($tester){
    $subtest->test('must have a name', property_exists($tester, 'name'));
    $subtest->test('must have a templateReport', property_exists($tester, 'templateReport'));
});
$tester->subtest('Test SimpleSubtester class', function($subtest){
    $subtest->test('must have a name', empty($subtest->name) === false);
    $subtest->test('must have a tester', empty($subtest->tester) === false);
});

// echo "<pre>";
// var_export($tester->result());

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
	echo "$no. <b>$subtest:</b> $tested tests ($passed passed, $failed failed).<br/>";
}