<?php
/**
 * A wrapper around the native "mysqli" interface, designed to provide a more palatable query interface.
 */
class Database {
    private $config;
    public $conn;

    /**
     * Accepts an associative array formatted like so:
     * [
     *    host => string,
     *    user => string,
     *    password => string,
     *    dbname => string,
     *    port => string
     * ]
     */
    public function __construct($config) {
        $this->config = $config;
    }

    public function connect() {
        $this->conn = new mysqli($this->config->host, $this->config->user, $this->config->password, $this->config->dbname, $this->config->port);
    }

    public function close() {
        if ($this->conn) {
            $this->conn->close();
            $this->conn = false;
        }
    }

    /**
     * Parameters are formatted as ":param_name" in the SQL string.
     * Parameter values are escaped before insertion into the SQL string.
     */
    public function query($sql, $params = array()) {
        foreach ($params as $k => $v) {
            $sql = str_replace(":" . $k, "'" . $this->conn->escape_string((string)$v) . "'", $sql);
        }
        $result = $this->conn->query($sql);
        if (!$result) die("MySQL query error: " . $this->conn->error);
        if (!($result instanceof mysqli_result)) return array();
        $rows = array();
        while (($row = $result->fetch_assoc())) {
            $rows[] = $row;
        }
        $result->close();
        return $rows;
    }

    /**
     * Calls query(), but abstracts the PHP 5.2 necessity of assigning a separate variable for the results.
     */
    public function query_single($sql, $params = array()) {
        $rows = $this->query($sql, $params);
        if (count($rows) == 0) return null;
        return $rows[0];
    }
}
?>
