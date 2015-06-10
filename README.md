# PHP VALIDATE

this validate only supports the following
rules:

* `required`
* `email`
* `confirmed`
* `regex`
* `callback`

## Example

```php
<?php
require __DIR__."/validate.php";

# create a stack of rules to apply
$rules = array(
  'username' => array('required', 'Username is empty'),
  'username' => array('regex', '/^[a-z0-9_]{4,}$/i', 'Username is invalid'),
  'email' => array('required', 'Email is empty'),
  'email' => array('email', 'Email is invalid'),
  'password' => array('confirmed', 'Password is invalid or not confirmed'),
  'age' => array(
    'regex',
    '/^[0-9]+$/',
    'Age is invalid'
  ),
  'role' => array(
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
  'username' => 'masiar',
  'email' => 'kontakt@mustachelab.pl',
  'age' => (date(Y)-'1992'),
  'role' => 'sith',
  'password' => 'awesome123',
  'password_confirmation' => 'awesome123'
)));
echo '</pre>';
```

Output will be:

```
# first call has errors
Array
(
    [username] => Array
        (
            [0] => Username is empty
            [1] => Username is invalid
        )

    [email] => Array
        (
            [0] => Email is empty
            [1] => Email is invalid
        )

    [password] => Array
        (
            [0] => Password is invalid or not confirmed
        )

    [age] => Array
        (
            [0] => Age is invalid
        )

    [role] => Array
        (
            [0] => Come to the dark side!
        )

)
# second call has no errors
array(0) {
}
```