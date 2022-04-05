<?php
function isEmpty($var)
{
    return empty(trim($var));
}
function isText($var)
{
    return preg_match('/^[a-zA-ZÀ-ÿ\u00f1\u00d1]+(\s*[a-zA-ZÀ-ÿ\u00f1\u00d1]*)*[a-zA-ZÀ-ÿ\u00f1\u00d1]+$/', $var);
}
function isEmail($var)
{
    return filter_var($var, FILTER_VALIDATE_EMAIL);
}
function isImage($field)
{
    $patron = "/\.(jpe?g|png)$/i";
    $verificado = preg_match($patron, $field);
    return $verificado;
}
function isCode($field)
{
    return preg_match('/^PROD[0-9]{5}+$/', $field);
}
function isMoney($field)
{
    return preg_match('/^[0-9]+(\.[0-9]{2})?+$/', $field);
}
function isEntero($field)
{
    return is_numeric($field) && (int)$field > 0;
}
