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
        $query = DB::connection()->prepare("SELECT Suoritus.tote_id, Suoritus.arvosana, "
                . "Suoritus.pvm, Kayttaja.id, Kayttaja.username, Kurssi.nimi, Kurssi.kurssi_id, "
                . "Kurssi.opintopisteet FROM Suoritus LEFT JOIN Toteutus ON "
                . "(Suoritus.tote_id = Toteutus.tote_id) LEFT JOIN Kurssi ON "
                . "(Toteutus.kurssi_id = Kurssi.kurssi_id) LEFT JOIN Oppilas ON "
                . "(Suoritus.suorittaja = Oppilas.opiskelijanumero) LEFT JOIN Kayttaja "
                . "ON (Oppilas.opiskelijanumero = Kayttaja.id) WHERE Kayttaja.id = :id ORDER BY "
                . "Kurssi.nimi ASC, Suoritus.pvm ASC");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();

        if ($rows) {
            $opintopisteet = 0;
            $suoritukset = array();
            foreach ($rows as $row) {
                $suoritukset[] = array(
                    "tote_id" => $row["tote_id"],
                    "arvosana" => $row["arvosana"],
                    "pvm" => $row["pvm"],
                    "kurssi" => $row["nimi"],
                    "kurssi_id" => $row["kurssi_id"],
                    "username" => $row["username"],
                    "id" => $row["id"],
                    "opintopisteet" => $row["opintopisteet"]
                );
                $opintopisteet += $row['opintopisteet'];
            }
            $suoritukset['op'] = $opintopisteet;
            return $suoritukset;
        }

        return null;
    }

    public static function leftJoinToteutusKurssiOppilas() {
        $query = DB::connection()->prepare("SELECT Suoritus.tote_id, Suoritus.arvosana, "
                . "Suoritus.pvm, Kayttaja.id, Kayttaja.username, Kurssi.nimi, Kurssi.kurssi_id, "
                . "Kurssi.opintopisteet FROM Suoritus LEFT JOIN Toteutus ON "
                . "(Suoritus.tote_id = Toteutus.tote_id) LEFT JOIN Kurssi ON "
                . "(Toteutus.kurssi_id = Kurssi.kurssi_id) LEFT JOIN Oppilas ON "
                . "(Suoritus.suorittaja = Oppilas.opiskelijanumero) LEFT JOIN Kayttaja "
                . "ON (Oppilas.opiskelijanumero = Kayttaja.id) ORDER BY "
                . "Kurssi.nimi ASC, Suoritus.pvm ASC");
        $query->execute();
        $rows = $query->fetchAll();
        $toteutusjoin = array();

        foreach ($rows as $row) {
            $toteutusjoin[] = array(
                "tote_id" => $row["tote_id"],
                "arvosana" => $row["arvosana"],
                "pvm" => $row["pvm"],
                "kurssi" => $row["nimi"],
                "kurssi_id" => $row["kurssi_id"],
                "username" => $row["username"],
                "id" => $row["id"],
                "opintopisteet" => $row["opintopisteet"]
            );
        }

        return $toteutusjoin;
    }
    
}
