<?php

if (!defined('CORE')) {
    header("Location: index.php");
    die();
}

class DB {

    private $id, $name, $db, $debug, $server_ip, $server_port;
    private $queries = [];
    private $totalSqlTime = 0;
    private $drivers = ['mysql'];
    private $show_on_stats = false;

    function __construct($data, $id) {
        global $Lang;
        $this->id = $id;
        $this->name = $Lang['__db-' . $id . '_'];
        $this->debug = $data['debug'];
        if ($data['show_on_stats']) {
            $this->show_on_stats = true;
            $this->server_ip = $data['server_ip'];
            $this->server_port = $data['server_port'];
        }
        if (!in_array($data['driver'], $this->drivers)) {
            $this->err(sprintf($Lang['__could-not-connect_'], $data['driver']));
            exit();
        }
        try {
            $this->db = new PDO($data['driver'] . ':host=' . $data['host'] . ';dbname=' . $data['database'] . ';charset=utf8', $data['user'], $data['password']);
            require_once('queries_' . $data['driver'] . '.php');
        } catch (PDOException $ex) {
            $this->err(sprintf($Lang['__could-not-connect_'], $data['host']), $ex->getMessage());
            exit(sprintf($Lang['__could-not-connect_'], $data['host']));
        }
    }

    function query($qry, $data = null, $name = '') {
        global $Lang;
        if ($this->debug) {
            $querytime = explode(" ", microtime());
            $querystart = $querytime[1] . substr($querytime[0], 1);
        }
        try {
            $r = $this->getPDO()->prepare($qry);

            //$r->execute($array);
            if (is_array($data)) {
                if (isMultiArray($data)) {
                    foreach ($data as $a) {
                        $r->bindParam($a[0], $a[1], $a[2]);
                    }
                    $r->execute();
                } else {
                    $r->execute($data);
                }
                //$r = (isMultiArray($data)) ? $this->advancedQuery($qry, $data) : $this->simpleQuery($qry, $data);
            } else {
                $r->execute();
            }
        } catch (PDOException $ex) {
            $this->err(sprintf($Lang['__mysql-error_'], $qry), $ex->getMessage());
        }

        if ($this->debug) {
            $querytime1 = explode(" ", microtime());
            $queryend = $querytime1[1] . substr($querytime1[0], 1);
            $time = bcsub($queryend, $querystart, 6);
            $this->addTime($time);
            $this->addQuery(['name' => $name,
                //'query' => $qry,
                'time' => $time,
                'rows' => $r->rowCount()]);
        }
        return $r;
    }

    /*public function singleQuery($qry) {
        global $Lang;
        try {
            $r = $this->getPDO()->prepare($qry);
            $r->execute();
        } catch (PDOException $ex) {
            $this->err(sprintf($Lang['__mysql-error_'], $qry), $ex->getMessage());
        }
        return $r;
    }

    private function simpleQuery($qry, $array) {
        global $Lang;
        try {
            $r = $this->getPDO()->prepare($qry);

            $r->execute($array);
        } catch (PDOException $ex) {
            $this->err(sprintf($Lang['__mysql-error_'], $qry), $ex->getMessage());
        }
        return $r;
    }

    private function advancedQuery($qry, $array) {
        global $Lang;
        try {
            $r = $this->getPDO()->prepare($qry);

            foreach ($array as $a) {
                $r->bindParam($a[0], $a[1], $a[2]);
            }
            $r->execute();
        } catch (PDOException $ex) {
            $this->err(sprintf($Lang['__mysql-error_'], $qry), $ex->getMessage());
        }
        return $r;
    }*/

    function getPDO() {
        return $this->db;
    }

    private function err($msg = '', $err = '') {
        $parse['date'] = date("l, F j, Y \a\\t g:i:s A");
        $parse['message'] = $msg;
        $parse['request_uri'] = filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $parse['error'] = $err;
        $parse['referer'] = filter_var($_SERVER['HTTP_REFERER'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        echo tpl::parse('mysql_error', $parse);
    }

    function getLastId() {
        $this->db->lastInsertId();
    }

    private function addTime($time) {
        $this->totalSqlTime += $time;
    }

    function getTime() {
        return $this->totalSqlTime;
    }

    private function addQuery($q) {
        array_push($this->queries, $q);
    }

    function getQueryCount() {
        return count($this->queries);
    }

    function isDebug() {
        return $this->debug;
    }

    function debug($parse) {
        global $Lang;
        if (!$this->debug) {
            return;
        }

        $parse['id'] = $this->name;
        $parse['query_count'] = count($this->queries);
        $parse['query_rows'] = '';
        foreach ($this->queries as $key => $value) {
            $rParse = $value;
            //$rParse['query'] = htmlspecialchars(html_entity_decode(stripslashes($value['query'])));
            if ($value['time'] <= 0.01) {
                $rParse['color'] = 'green';
            } elseif ($value["time"] > 0.01 && $value["time"] < 0.1) {
                $rParse['color'] = 'orange';
            } else {
                $rParse['color'] = 'red';
            }
            $rParse['title'] = $Lang['__query-' . $rParse['color'] . '_'];
            $rParse['key'] = $key + 1;
            $parse['query_rows'] .= tpl::parse('mysql_debug_row', $rParse, true);
            unset($rParse);
        }
        return tpl::parse('mysql_debug', $parse, true);
    }

    function getServerIp() {
        return $this->server_ip;
    }

    function getServerPort() {
        return $this->server_port;
    }

    function showOnStats() {
        return $this->show_on_stats;
    }

}
