<?php

include('DB.php');

class Mysqli_DB implements DB
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
     * Mysqli constructor.
     *
     * @param     $host
     * @param     $username
     * @param     $password
     * @param     $database
     * @param int $port
     */
    public function __construct($host, $username, $password, $database)
    {

        $this->conn = mysqli_connect($host, $username, $password, $database);
        if (!$this->conn) {
            print_r(mysqli_error($this->conn));
            die();
        }
    }

    /**
     * @param $sql
     */
    public function query($sql)
    {

        $this->stid = $this->conn->query($sql);

    }

    /**
     * @return array
     */
    public function getData()
    {

        $data = [];

        try {

            if (!empty($this->stid)) {

                while ($row = $this->stid->fetch_array(MYSQLI_ASSOC)) {
                    $data[] = $row;
                }

                $this->stid->free_result();
                $this->conn->close();

            }

        } catch (Exception $e) {
            print_r($e->getMessage());
        }

        return $data;

    }

}
