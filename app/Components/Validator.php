<?php

namespace app\Components;
class Validator
{
    // private $TicketsGateway;
    // public function __construct(){
    // 	$this->ticketsGateway = new TicketsGateway;

    // }
    public static function checkName($field)
    {
        $error = [];


        if (mb_strlen($field) == 0) {
            $error[1] = '<label class="control-label" for="inputError1">Введено пустое поле</label>';
            $error[0] = 'has-error';
        } elseif (mb_strlen($field) > 40) {
            $error[1] = '<label class="control-label" for="inputError1">Введено слишком много символов</label>';
            $error[0] = 'has-error';
        } elseif (!preg_match('/^[0-9a-zA-Zа-яёА-ЯЁ]+$/u', $field)) {
            $error[1] = '<label class="control-label" for="inputError1">Введено недопустимое поле</label>';
            $error[0] = 'has-error';
        } else {
            $error[0] = 'has-success';
        }
        return $error;


    }

    public static function checkNumber($field)
    {
        $error = [];


        if (mb_strlen($field) == 0) {
            $error[1] = '<label class="control-label" for="inputError1">Введено пустое поле</label>';
            $error[0] = 'has-error';
        } elseif (mb_strlen($field) > 12) {
            $error[1] = '<label class="control-label" for="inputError1">Введено слишком много символов</label>';
            $error[0] = 'has-error';
        } elseif (!is_numeric($field)) {
            $error[1] = '<label class="control-label" for="inputError1">Введено недопустимое число</label>';
            $error[0] = 'has-error';
        } else {
            $error[0] = 'has-success';
        }
        return $error;


    }


    public static function checkTextArea($field)
    {
        $error = [];

        if (mb_strlen($field) > 400) {
            $error[1] = '<label class="control-label" for="inputError1">Введено слишком много символов. Допустимо не больше 400.</label>';
            $error[0] = 'has-error';
        } else {
            $error[0] = 'has-success';
        }
        return $error;


    }


    public static function checkEmail($field)
    {
        $error = [];

        if (mb_strlen($field) == 0) {
            $error[1] = '<label class="control-label" for="inputError1">Введено пустое поле</label>';
            $error[0] = 'has-error';
        } elseif (mb_strlen($field) > 50) {
            $error[1] = '<label class="control-label" for="inputError1">Введено слишком много символов</label>';
            $error[0] = 'has-error';
        } elseif (!preg_match('/^[.a-z0-9_-]+@[а-яА-Яa-z0-9-]+\.[а-яА-Яa-zA-Z]{2,6}$/i', $field)) {
            $error[1] = '<label class="control-label" for="inputError1">Введено недопустимое имя</label>';
            $error[0] = 'has-error';
        } else {
            $error[0] = 'has-success';
        }
        return $error;


    }

    public static function nCheckTitle($field)
    {

        $error = '';

        if (mb_strlen($field) == 0)
            $error = 1;
        if (mb_strlen($field) > 40)
            $error = 2;
        if (!preg_match('/^[0-9\sa-zA-Zа-яёА-ЯЁ]+$/u', $field))
            $error = 3;

        if (empty($error)) {
            return false;
        } else {
            return $error;
        }

    }

    public static function nCheckTextArea($field, $empty = false)
    {

        $error = '';

        if (mb_strlen($field) > 400)
            $error = 1;
        if ($empty) {
            if (mb_strlen($field) == 0)
                $error = 2;
        }

        if (empty($error)) {
            return false;
        } else {
            return $error;
        }

    }

    public static function nCheckNumber($field)
    {

        $error = '';

        if (mb_strlen($field) == 0)
            $error = 1;

        if (mb_strlen($field) > 20)
            $error = 2;
        if (!is_numeric($field))
            $error = 3;

        if (empty($error)) {
            return false;
        } else {
            return $error;
        }

    }

    public static function nCheckDaysAmount($field)
    {

        $error = '';

        if (mb_strlen($field) == 0)
            $error = 1;

        if ($field > 30)
            $error = 2;
        if (!is_numeric($field))
            $error = 3;

        if (empty($error)) {
            return false;
        } else {
            return $error;
        }

    }

    public static function nCheckTicketsAmount($field)
    {

        $error = '';

        if (mb_strlen($field) == 0)
            $error = 1;

        if ($field > 40)
            $error = 2;
        if (!is_numeric($field))
            $error = 3;

        if (empty($error)) {
            return false;
        } else {
            return $error;
        }

    }

    public static function nCheckTicketsPrice($field)
    {

        $error = '';

        if (mb_strlen($field) == 0)
            $error = 1;

        if ($field > 1000000)
            $error = 2;
        if (!is_numeric($field))
            $error = 3;

        if (empty($error)) {
            return false;
        } else {
            return $error;
        }

    }
}

?>