<?php

include('DB.php');

class Oci implements DB
{

    /**
     * @var false|resource
     */
    private $conn;
    /**
     * @var false|resource
     */
    private $stid;

    /**
     * Oci constructor.
     *
     * @param $username
     * @param $password
     * @param $connectionString
     */
    public function __construct($username, $password, $connectionString)
    {

        $this->conn = oci_pconnect($username, $password, $connectionString);
        if (!$this->conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
            die();
        }
    }

    /**
     * @param $sql
     */
    public function query($sql)
    {

        $this->stid = oci_parse($this->conn, $sql);
        oci_execute($this->stid);
    }

    /**
     * @return array
     */
    public function getData()
    {

        $data = [];
        while (($row = oci_fetch_array($this->stid, OCI_ASSOC)) != false) {
            $data[] = $row;
        }
        return $data;
    }

}
