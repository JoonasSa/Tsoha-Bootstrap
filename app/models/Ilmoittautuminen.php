<?php

class Ilmoittautuminen extends BaseModel {

    public $ilmoittautuja, $tote_id, $ilmoaika;

    public static function findByOppilas($id) {
        $query = DB::connection()->prepare("SELECT * FROM Ilmoittautuminen WHERE ilmoittautuja = :id");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();
        $ilmot = array();
        foreach ($rows as $row) {
            $ilmot[] = array(
                'tote_id' => $row['tote_id'],
                'ilmoaika' => $row['ilmoaika']
            );
        }
        return $ilmot;
    }

    public static function findByToteutus($id) {
        $query = DB::connection()->prepare("SELECT * FROM Ilmoittautuminen WHERE tote_id = :id");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();
        $ilmot = array();
        foreach ($rows as $row) {
            $ilmot[] = array(
                'ilmoittautuja' => $row['ilmoittautuja'],
                'tote_id' => $id,
                'ilmoaika' => $row['ilmoaika']
            );
        }
        return $ilmot;
    }

    public static function all() {
        $query = DB::connection()->prepare("SELECT * FROM Ilmoittatuminen");
        $query->execute();
        $rows = $query->fetchAll();
        $ilmot = array();

        foreach ($rows as $row) {
            $ilmot[] = new Imoittautuminen(array(
                'ilmoittautuja' => $row['ilmoittautuja'],
                'tote_id' => $row['tote_id'],
                'ilmoaika' => $row['ilmoaika']
            ));
        }
        return $ilmot;
    }

    public static function allLeftJoinOppilasToteutusKurssi() {
        $query = DB::connection()->prepare("SELECT * FROM Ilmoittautuminen "
                . "LEFT JOIN Oppilas ON (Ilmoittautuminen.ilmoittautuja = Oppilas.opsikelijanumero) "
                . "LEFT JOIN Toteutus ON (Ilmoittautuminen.tote_id = Toteutus.tote_id) "
                . "LEFT JOIN Kurssi ON (Toteutus.kurssi_id = Kurssi.kurssi_id)");
        $query->execute();
        $rows = $query->fetchAll();
        $ilmot = array();
        foreach ($rows as $row) {
            $ilmot[] = array(
                'ilmoittautuja' => $row['ilmoittautuja'],
                'tote_id' => $row['ilmoittautuja'],
                'ilmoaika' => $row['ilmoaika']
            );
        }
        return $ilmot;
    }

    public static function leftJoinToteutusKurssiOpettajaByOppilas($id) {
        $query = DB::connection()->prepare("SELECT Ilmoittautuminen.tote_id, Ilmoittautuminen.ilmoaika, "
                . "Toteutus.alkupvm, Toteutus.koepvm, Toteutus.kurssi_id, Toteutus.periodi, "
                . "Kurssi.nimi, Kurssi.opintopisteet, Opettaja.etunimi, "
                . "Opettaja.sukunimi FROM Ilmoittautuminen "
                . "LEFT JOIN Toteutus ON (Ilmoittautuminen.tote_id = Toteutus.tote_id) "
                . "LEFT JOIN Kurssi ON (Toteutus.kurssi_id = Kurssi.kurssi_id) "
                . "LEFT JOIN Opettaja ON (Toteutus.vastuu_id = Opettaja.opettajatunnus) "
                . "WHERE Ilmoittautuminen.ilmoittautuja = :id");
        $query->execute(array("id" => $id));
        $rows = $query->fetchAll();
        $ilmot = array();
        foreach ($rows as $row) {
            $ilmot[] = array(
                'tote_id' => $row['tote_id'],
                'ilmoaika' => $row['ilmoaika'],
                'alkupvm' => $row['alkupvm'],
                'koepvm' => $row['koepvm'],
                'periodi' => $row['periodi'],
                'kurssi_id' => $row['kurssi_id'],
                'nimi' => $row['nimi'],
                'opintopisteet' => $row['opintopisteet'],
                'opettaja' => $row['etunimi'] . ' ' . $row['sukunimi']
            );
        }
        return $ilmot;
    }

}
