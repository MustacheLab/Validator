<?php
require __DIR__."/validate.php";

# create a stack of rules to apply
$rules = array(
  array('username', 'required', 'Username is empty'),
  array('username', 'regex', '/^[a-z0-9_]{4,}$/i', 'Username is invalid'),
  array('email', 'required', 'Email is empty'),
  array('email', 'email', 'Email is invalid'),
  array('password', 'confirmed', 'Password is invalid or not confirmed'),
  array(
    'age',
    'regex',
    '/^[0-9]+$/',
    'Age is invalid'
  ),
  array(
    'role',
    'callback',
    function ($role) { return $role == 'sith'; },
    'Come to the dark side!'
  )
);

echo '<pre style="color:red;">';
# apply the rules, and get the errors
print_r(validate($rules, array(
  'username' => '',
  'email' => '',
  'role' => 'developer',
  'password' => 'abc',
  'password_confirmation' => '123'
)));
echo '</pre>';
echo '<pre style="color:green">';
# apply the rules to passing data
var_dump(validate($rules, array(
  'username' => 'noodlehaus',
  'email' => 'jesus.domingo@gmail.com',
  'age' => 35,
  'role' => 'sith',
  'password' => 'awesome123',
  'password_confirmation' => 'awesome123'
)));

echo '</pre>';


