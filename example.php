<?php

// include the class
require 'SimpleTester.php';

// create object of it
$tester = new SimpleTester;
// then use it just like:
$tester->subtest('Test SimpleTester class', function($subtest) use($tester){
	// test($testName@string, $assertion@boolean)
	$subtest->test('must have a name', property_exists($tester, 'name'));
    	$subtest->test('must have a templateReport', property_exists($tester, 'templateReport'));
});
$tester->subtest('Test SimpleSubtester class', function($subtest){
    	$subtest->test('must have a name', empty($subtest->name) === false);
	$subtest->test('must have a tester', empty($subtest->tester) === false);
});

// how about catch the result?
// dont worry, it so simple, use var_dump or var_export to see the result
// then manipulate it, done.
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
