<?php
// check code melli
function check_national_code($code)
{
    if (!preg_match('/^[0-9]{10}$/', $code))
        return false;
    for ($i = 0; $i < 10; $i++)
        if (preg_match('/^' . $i . '{10}$/', $code))
            return false;
    for ($i = 0, $sum = 0; $i < 9; $i++)
        $sum += ((10 - $i) * intval(substr($code, $i, 1)));
    $ret = $sum % 11;
    $parity = intval(substr($code, 9, 1));
    if (($ret < 2 && $ret == $parity) || ($ret >= 2 && $ret == 11 - $parity))
        return true;
    return false;
}

//check mobile
function check_mobile($mobile)
{
    if (preg_match("/^09[0-9]{9}$/", $mobile)) {
        return true;
    } else {
        return false;
    }

}

//check sheba
function check_sheba($number)
{
    if (preg_match("/^(?:IR)(?=.{24}$)[0-9]*$/", $number)) {
        return true;
    } else {
        return false;
    }

}

//check farsi char
function check_farsi($string)
{
    if (preg_match('/^[پچجحخهعغفقثصضشسیبلاتنمکگوئدذرزطظژؤإأءًٌٍَُِّ\s]+$/u', $string)) {
        return true;
    } else {
        return false;
    }

}

//check number cart

function bankCardCheck($card = '', $irCard = true)
{
    $card = (string)preg_replace('/\D/', '', $card);
    $strlen = strlen($card);
    if ($irCard == true and $strlen != 16)
        return false;
    if ($irCard != true and ($strlen < 13 or $strlen > 19))
        return false;
    if (!in_array($card[0], [2, 4, 5, 6, 9]))
        return false;

    for ($i = 0; $i < $strlen; $i++) {
        $res[$i] = $card[$i];
        if (($strlen % 2) == ($i % 2)) {
            $res[$i] *= 2;
            if ($res[$i] > 9)
                $res[$i] -= 9;
        }
    }
    return array_sum($res) % 10 == 0 ? true : false;
}
