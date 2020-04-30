<?php


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
     * Oci constructor.
     *
     * @param $username
     * @param $password
     * @param $connectionString
     */
    public function __construct($username, $password, $connectionString)
    {

        $this->conn = mysqli_connect($username, $password, $connectionString);
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
        $this->stid  = $this->conn->query($sql);

    }

    /**
     * @return array
     */
    public function getData()
    {

        $data = [];
        while ($row = $this->stid->fetch_row()) {
            $data[] = $row;
        }
        $this->stid->free_result();
        return $data;

    }

}
