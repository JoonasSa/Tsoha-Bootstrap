<?php

class Suoritus extends BaseModel {

    public $tote_id, $pvm, $arvosana, $suorittaja;

    public function __construct($attributes) {
        parent::__construct($attributes);
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Suoritus");
        $query->execute();
        $rows = $query->fetchAll();
        $suoritukset = array();

        foreach ($rows as $row) {
            $suoritukset[] = new Suoritus(array(
                "tote_id" => $row["tote_id"],
                "pvm" => $row["pvm"],
                "arvosana" => $row["arvosana"],
                "suorittaja" => $row["suorittaja"]
            ));
        }

        return $suoritukset;
    }

    public static function findByToteutus($id) {
        $query = DB::connection()->prepare("SELECT * FROM Suoritus WHERE tote_id = :id");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();

        if ($rows) {
            $suoritukset = array();
            foreach ($rows as $row) {
                $suoritukset[] = new Suoritus(array(
                    "tote_id" => $row["tote_id"],
                    "pvm" => $row["pvm"],
                    "arvosana" => $row["arvosana"],
                    "suorittaja" => $row["suorittaja"]
                ));
            }
            return $suoritukset;
        }

        return null;
    }

    public static function findByOppilas($id) {
        $query = DB::connection()->prepare("SELECT * FROM Suoritus WHERE suorittaja = :id");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();

        if ($rows) {
            $suoritukset = array();
            foreach ($rows as $row) {
                $suoritukset[] = new Suoritus(array(
                    "tote_id" => $row["tote_id"],
                    "pvm" => $row["pvm"],
                    "arvosana" => $row["arvosana"],
                    "suorittaja" => $row["suorittaja"]
                ));
            }
            return $suoritukset;
        }

        return null;
    }
    
    public static function findByOppilasAndToteutus($oppilas, $toteutus) {
        $query = DB::connection()->prepare("SELECT * FROM Suoritus WHERE suorittaja = :oppilas AND tote_id = :toteutus");
        $query->execute(array("oppilas" => $oppilas, "toteutus" => $toteutus));
        $rows = $query->fetchAll();

        if ($rows) {
            $suoritukset = array();
            foreach ($rows as $row) {
                $suoritukset[] = new Suoritus(array(
                    "tote_id" => $row["tote_id"],
                    "pvm" => $row["pvm"],
                    "arvosana" => $row["arvosana"],
                    "suorittaja" => $row["suorittaja"]
                ));
            }
            return $suoritukset;
        }

        return null;
    }
}
