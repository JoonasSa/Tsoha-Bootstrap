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
            $array[] =  $string_name . " ei saa olla tyhjä.";
        } else if (strlen($string) < $min_length) {
            $array[] =  $string_name . " pitää olla ainakin " . $min_length . " merkkiä pitkä.";
        } else if (strlen($string) > $max_length) {
            $array[] =  $string_name . " ei saa olla yli " . $max_length . " merkkiä pitkä.";
        }
        return $array;
    }
    
    public function validate_number($number_name, $number, $min, $max, $array) {
        if ($number == null) {
            $array[] =  $number_name . " ei saa olla tyhjä.";
        } else if (!is_numeric($number)) {
            $array[] =  $number_name . " pitää olla numero.";
        } else if ($number < $min) {
            $array[] =  $number_name . " pitää olla ainakin " . $min . ".";
        } else if ($number > $max) {
            $array[] =  $number_name . " ei saa olla yli " . $max . ".";
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
    
    /*  
    public function errors() {
        // Lisätään $errors muuttujaan kaikki virheilmoitukset taulukkona
        $errors = array();
        foreach ($this->validators as $validator) {
            $errors[] = $validator();
        }
        return $errors;
    }
    
    public function validate_etunimi() {
        if ($this->{etunimi} != null) {
            return "Etunimi ei saa olla tyhjä!";
        } else if (strlen($this->{etunimi}) < 2) {
            return "Etunimi on liian lyhyt!";
        } else if (strlen($this->{etunimi}) > 30) {
            return "Etunimi on liian pitkä!";
        }
    }

    public function validate_sukunimi() {
        if ($this->{sukunimi} != null) {
            return "Sukunimi ei saa olla tyhjä!";
        } else if (strlen($this->{sukunimi}) < 2) {
            return "Sukunimi on liian lyhyt!";
        } else if (strlen($this->{sukunimi}) > 30) {
            return "Sukunimi on liian pitkä!";
        }
    }
    
    public function validate_nimi() {
        if ($this->{nimi} != null) {
            return "Nimi ei saa olla tyhjä!";
        } else if (strlen($this->{nimi}) < 2) {
            return "Nimi on liian lyhyt!";
        } else if (strlen($this->{nimi}) > 60) {
            return "Nimi on liian pitkä!";
        }
    }
    */
    
}
