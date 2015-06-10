<?php

function validate(array $rules, $data) {

  $errors = array();

  foreach ($rules as $rule) {

    $name = array_shift($rule);
    $stub = isset($data[$name]) ? trim($data[$name]) : '';
    $type = strtolower(trim(array_shift($rule)));
    $arg1 = array_shift($rule);
    $arg2 = array_shift($rule);

    switch ($type) {

    case 'required':
      if (!strlen($stub)) {
        $errors[$name][] = $arg1;
      }
      break;

    case 'confirmed':

      $k = "{$name}_confirmation";
      $v = isset($data[$k]) ? $data[$k] : null;

      if (!strlen($stub) || ($stub !== $v)) {
        $errors[$name][] = $arg1;
      }

      break;

    case 'email':
      $email = filter_var($stub, FILTER_VALIDATE_EMAIL);
      if ($email === false || $email !== $stub ||
          !preg_match('@\.\w+$@', $email)) {
        $errors[$name][] = $arg1;
      }
      break;

    case 'regex':
      if (!preg_match($arg1, $stub)) {
        $errors[$name][] = $arg2;
      }
      break;

    case 'callback':
      if (!$arg1($stub)) {
        $errors[$name][] = $arg2;
      }
      break;

    default:
      throw new UnexpectedValueException(
        "Rule type not supported [{$type}]",
        400
      );
    }
  }

  return $errors;
}
