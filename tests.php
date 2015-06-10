<?php
require __DIR__."/validate.php";

# create a stack of rules to apply
$rules = array(
  array('a', 'required', 'required'),
  array('b', 'regex', '@^[0-9]{2}$@i', '2 digits'),
  array('c', 'email', 'email address'),
  array('d', 'confirmed', 'matches confirmation'),
  array('e', 'callback', function ($v) { return $v === 'e'; }, 'passes callback')
);

# apply the rules, and get the errors
$data = validate($rules, array());

assert($data['a'][0] === 'required');
assert($data['b'][0] === '2 digits');
assert($data['c'][0] === 'email address');
assert($data['d'][0] === 'matches confirmation');
assert($data['e'][0] === 'passes callback');

$data = validate($rules, array(
  'a' => 'not empty',
  'b' => '12',
  'c' => 'kontakt@mustachelab.pl',
  'd' => '123abc',
  'd_confirmation' => '123abc',
  'e' => 'e'
));

assert(empty($data));

echo "Done running tests. If you don't see errors, it means all's ok. Visit <a href=\"http://mustachelab.pl\">Authors page</a>.\n";
