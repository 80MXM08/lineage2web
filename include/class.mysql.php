<?php

if (!defined('CORE')) {
    header("Location: index.php");
    die();
}

class SQL {

    private $id = 0;
    private $persistant = false;
    private $link;
    private static $query = array();
    private static $queryCount = 0;
    private static $totalSqlTime = 0;
    private $lastId = 0;

    function __construct($data, $nid = 0, $persistant = false) {
        $this->id = $nid;
        $this->persistant = $persistant;
        $this->connectAndSelectDB($data);
        mysql_set_charset('utf8', $this->link);
    }

    function connectAndSelectDB($data) {
        global $Lang;
        if ($this->persistant) {
            $this->link = mysql_pconnect($data['host'], $data['user'], $data['password']);
        } else {
            $this->link = mysql_connect($data['host'], $data['user'], $data['password'], true);
        }
        if (!$this->link) {
            $this->err(sprintf($Lang['could_not_connect'], $this->DBinfo['host']));
            exit();
        }
        if (!mysql_select_db($data['database'], $this->link)) {
            $this->err(sprintf($Lang['could_not_open'], $data['database']));
            exit();
        }
    }

    function __destruct() {
        if (!$this->persistant && $this->link) {
            mysql_close($this->link);
        }
    }

    function query($qry, $array = array()) {
        global $q, $Lang;
        $querytime = explode(" ", microtime());
        $querystart = $querytime[1] . substr($querytime[0], 1);
        if (isset($q[$this->id][$qry])) {
            $qry2 = $q[$this->id][$qry];
        } else if (is_numeric($qry) && !isset($q[$this->id][$qry])) {
            die('SQL-' . $this->id . ' Q-' . $qry);
        }
        else {
            $qry2=$qry;
        }
        $arr=array_map(array($this, 'escape'),$array);
        $qry2 = preg_replace('#\{([a-z0-9\-_]*?)\}#Ssie', '( ( isset($arr[\'\1\']) ) ? $arr[\'\1\'] : \'\' );', $qry2);

        $result = mysql_query($qry2, $this->link) or $this->err(sprintf($Lang['mysql_error'], $qry2));

        $querytime = explode(" ", microtime());
        $queryend = $querytime[1] . substr($querytime[0], 1);
        $time = bcsub($queryend, $querystart, 6);
        SQL::addTime($time);
        $rc = (substr($qry2, 0, 6) == 'SELECT') ? @mysql_num_rows($result) : @mysql_affected_rows($this->link);
        SQL::addQuery(array(
            'name' => $qry,
            'query' => $qry2,
            'result' => $result,
            'time' => $time,
            'rows' => $rc));

        if (substr($qry2, 0, 6) == 'INSERT') {
            SQL::setLastId($this->getLastId());
        } else {
            SQL::setLastId(0);
        }
        SQL::incQueryCount();
        end(SQL::$query);
        return key(SQL::$query);
    }

    function escape($string) {
        return mysql_real_escape_string($string, $this->link);
    }
    private function err($msg = '') {
        global $Lang;
        if ($this->link) {
            $error = mysql_error($this->link);
            $errno = mysql_errno($this->link);
        } else {
            $error = mysql_error();
            $errno = mysql_errno();
        }
        $parse['db_error'] = $Lang['db_error'];
        $parse['lMessage'] = $Lang['message'];
        $parse['mysql_error'] = $Lang['mysql_error2'];
        $parse['lDate'] = $Lang['date'];
        $parse['script'] = $Lang['script'];
        $parse['date'] = date("l, F j, Y \a\\t g:i:s A");
        $parse['message'] = $msg;
        $parse['request_uri'] = @$_SERVER['REQUEST_URI'];
        $parse['error'] = $error;
        $parse['lReferer'] = $Lang['referer'];
        $parse['referer'] = @$_SERVER['HTTP_REFERER'];
        TplParser::parse('mysql_error', $parse);
    }

    private function setLastId($id) {
        $this->lastId = $id;
    }

    function getLastId() {
        if ($this->lastId == 0) {
            return mysql_insert_id($this->link);
        }
        return $this->lastId;
    }

    static function return_result($res) {
        return SQL::$query[$res]['result'];
    }

    static function result($res = null, $row = 0, $field = 0) {
        if ($res === null) {
            end(SQL::$query);
            $res = key(SQL::$query);
        }
        return mysql_result(SQL::$query[$res]['result'], $row, $field);
    }

    static function addTime($time) {
        SQL::$totalSqlTime +=$time;
    }

    static function getTime() {
        return SQL::$totalSqlTime;
    }

    static function addQuery($q) {
        array_push(SQL::$query, $q);
    }

    static function incQueryCount() {
        SQL::$queryCount++;
    }

    static function getQueryCount() {
        return SQL::$queryCount;
    }

    static function numRows($res = null) {
        if ($res === null) {
            end(SQL::$query);
            $res = key(SQL::$query);
        }
        return SQL::$query[$res]['rows'];
    }

    static function fetchArray($res = null) {
        if ($res === null) {
            end(SQL::$query);
            $res = key(SQL::$query);
        }
        return mysql_fetch_assoc(SQL::$query[$res]['result']);
    }

    static function fetchRow($res = null) {
        if ($res === null) {
            end(SQL::$query);
            $res = key(SQL::$query);
        }
        return mysql_fetch_row(SQL::$query[$res]['result']);
    }

    static function free($res = null) {
        if ($res === null) {
            end(SQL::$query);
            $res = key(SQL::$query);
        }
        return mysql_free_result(SQL::$query[$res]['result']);
    }

    static function reset_query($res = null, $pos = 0) {
        if ($res === null) {
            end(SQL::$query);
            $res = key(SQL::$query);
        }
        return mysql_data_seek(SQL::$query[$res]['result'], $pos);
    }

    static function debug($parse) {
        global $Lang;
        $parse['lLink'] = $Lang['link'];
        $parse['link'] = '$this->link';
        $parse['query_rows'] = '';
        foreach (SQL::$query as $key => $value) {
            $rParse = $value;
            $rParse['query'] = htmlspecialchars(html_entity_decode(stripslashes($value['query'])));
            if ($value['time'] <= 0.01) {
                $rParse['color'] = 'green';
            } elseif ($value["time"] > 0.01 && $value["time"] < 0.1) {
                $rParse['color'] = 'orange';
            } else {
                $rParse['color'] = 'red';
            }
            $rParse['title'] = $Lang['query_' . $rParse['color']];
            $rParse['key'] = $key + 1;
            $parse['query_rows'].=TplParser::parse('mysql_debug_row', $rParse, true);
        }
        return TplParser::parse('mysql_debug', $parse, true);
    }

}

?>