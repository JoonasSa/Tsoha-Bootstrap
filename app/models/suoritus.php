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
        self::makeSmallArray($rows);
    }

    public static function findByToteutus($id) {
        $query = DB::connection()->prepare("SELECT * FROM Suoritus WHERE tote_id = :id");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();
        if ($rows) {
            return self::makeSmallArray($rows);
        }
        return null;
    }

    private static function makeSmallArray($rows) {
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

    //TÄN VOIS PIENENTÄÄ
    public static function findByOppilas($id) {
        $query = DB::connection()->prepare("SELECT Suoritus.tote_id, Suoritus.arvosana, "
                . "Suoritus.pvm, Oppilas.opiskelijanumero, Oppilas.etunimi, Oppilas.sukunimi, "
                . "Kurssi.nimi, Kurssi.kurssi_id, Kurssi.opintopisteet FROM Oppilas "
                . "LEFT JOIN Suoritus ON (Oppilas.opiskelijanumero = Suoritus.suorittaja) "
                . "LEFT JOIN Toteutus ON (Suoritus.tote_id = Toteutus.tote_id) "
                . "LEFT JOIN Kurssi ON (Toteutus.kurssi_id = Kurssi.kurssi_id) "
                . "WHERE Oppilas.opiskelijanumero = :id "
                . "ORDER BY Kurssi.nimi ASC, Suoritus.pvm ASC");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();
        if ($rows) {
            $suoritukset = array();

            foreach ($rows as $row) {
                $suoritukset[] = array(
                    "tote_id" => $row["tote_id"],
                    "arvosana" => $row["arvosana"],
                    "pvm" => $row["pvm"],
                    "kurssi" => $row["nimi"],
                    "kurssi_id" => $row["kurssi_id"],
                    "etunimi" => $row["etunimi"],
                    "sukunimi" => $row["sukunimi"],
                    "opiskelijanumero" => $row["opiskelijanumero"],
                    "opintopisteet" => $row["opintopisteet"]
                );
            }

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
        return self::makeBigArray($rows);
    }

    private static function makeBigArray($rows) {
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
        }

        return $suoritukset;
    }

    public static function getIsGraded($tote_id, $suorittaja) {
        $query = DB::connection()->prepare('SELECT * FROM Suoritus WHERE tote_id = :tote_id AND suorittaja = :suorittaja LIMIT 1');
        $query->execute(array('tote_id' => $tote_id, 'suorittaja' => $suorittaja));
        return $query->fetch();
    }

    public function save() {
        $query = DB::connection()->prepare('INSERT INTO Suoritus (tote_id, pvm, arvosana, suorittaja)'
                . 'VALUES (:tote_id, :pvm, :arvosana, :suorittaja)');
        $query->execute(array('tote_id' => $this->tote_id, 'pvm' => $this->pvm,
            'arvosana' => $this->arvosana, 'suorittaja' => $this->suorittaja));
    }

    public function destroy() {
        $query = DB::connection()->prepare('DELETE FROM Suoritus WHERE tote_id = :tote_id AND suorittaja = :suorittaja');
        $query->execute(array('tote_id' => $this->tote_id, 'suorittaja' => $this->suorittaja));
    }

}
