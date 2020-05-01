<?php

require __DIR__ . '/../vendor/autoload.php';

class Pais_Ciudad
{

    /**
     * Pais_Ciudad constructor.
     *
     * @param array  $connectionData
     * @param string $connector
     * @param string $prefix
     */

    public function __construct($connectionData = [], $connector = 'oci', $prefix = '')
    {

        $this->connector = $connector;
        $this->prefix = $prefix;

        if ($connector == 'oci') {

            // connection to ORACLE
            require __DIR__ . '/db_connectors/oci.php';
            $this->db = new Oci($connectionData['username'], $connectionData['password'], $connectionData['connectionString']);

        } else {

            // connection to Mysql
            require __DIR__ . '/db_connectors/Mysqli_DB.php';
            $this->db = new Mysqli_DB ($connectionData['host'], $connectionData['username'], $connectionData['password'], $connectionData['database']);

        }

    }

    /**
     * @var DB
     */
    private $db;

    /**
     * @var db prefix
     */
    private $prefix;

    /**
     * @var DB
     */
    public $connector;

    /**
     * Get all hemisferios
     *
     * @return array
     */
    public function getHemisferios()
    {

        $this->db->query("SELECT HEMISFERIO_ID, DESCRIPCION FROM " . $this->prefix . "HEMISFERIO");

        return $this->db->getData();

    }

    /**
     * Get all continentes
     *
     * @param $hemisferio
     *
     * @return array
     */
    public function getContinentes($hemisferio = null)
    {

        $sql = "SELECT CONTINENTE_ID, DESCRIPCION, HEMISFERIO_ID  FROM  " . $this->prefix . "CONTINENTE ";
        if (!empty($hemisferio)) {
            $sql .= " WHERE  where HEMISFERIO_ID = " . $hemisferio;
        }

        $this->db->query($sql);

        return $this->db->getData();

    }

    /**
     * Get all Paises
     *
     * @param $hemisferio
     *
     * @return array
     */
    public function getPaises($continente = null)
    {

        $sql = "SELECT  PAIS_ID, DESCRIPCION, CONTINENTE_ID FROM " . $this->prefix . "PAIS ";
        if (!empty($hemisferio)) {
            $sql .= " WHERE CONTINENTE_ID= " . $continente;
        }
        echo $sql;
        $this->db->query($sql);

        return $this->db->getData();

    }

    /**
     * Get all Cuidades
     *
     * @param null $pais
     *
     * @return array
     */
    public function getCuidades($pais = null)
    {

        $sql = "SELECT CIUDAD_ID, DESCRIPCION, PAIS_ID FROM " . $this->prefix . "CIUDAD ";
        if (!empty($hemisferio)) {
            $sql .= " WHERE PAIS_ID =  " . $pais;
        }

        $this->db->query($sql);

        return $this->db->getData();

    }

}



