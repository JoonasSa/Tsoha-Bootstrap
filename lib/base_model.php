<?php

class BaseModel {

    protected $validators;

    public function __construct($attributes = null) {
        // Käydään assosiaatiolistan avaimet läpi
        foreach ($attributes as $attribute => $value) {
            // Jos avaimen niminen attribuutti on olemassa...
            if (property_exists($this, $attribute)) {
                // ... lisätään avaimen nimiseen attribuuttin siihen liittyvä arvo
                $this->{$attribute} = $value;
            }
        }
    }

    public function validate_string($string_name, $string, $min_length, $max_length, $array) {
        if ($string == null) {
            $array[] = $string_name . " ei saa olla tyhjä.";
        } else if (strlen($string) < $min_length) {
            $array[] = $string_name . " pitää olla ainakin " . $min_length . " merkkiä pitkä.";
        } else if (strlen($string) > $max_length) {
            $array[] = $string_name . " ei saa olla yli " . $max_length . " merkkiä pitkä.";
        }
        return $array;
    }

    public function validate_number($number_name, $number, $min, $max, $array) {
        if ($number == null) {
            $array[] = $number_name . " ei saa olla tyhjä.";
        } else if (!is_numeric($number)) {
            $array[] = $number_name . " pitää olla numero.";
        } else if ($number < $min) {
            $array[] = $number_name . " pitää olla ainakin " . $min . ".";
        } else if ($number > $max) {
            $array[] = $number_name . " ei saa olla yli " . $max . ".";
        }
        return $array;
    }

    public function validateDate($alkupvm, $nimi, $array) {
        $d = DateTime::createFromFormat('Y-m-d', $alkupvm);
        if (!($d && $d->format('Y-m-d') === $alkupvm)) {
            $array[] = $nimi . " ei ole muotoa YYYY-MM-DD.";
        }
        return $array;
    }

}
