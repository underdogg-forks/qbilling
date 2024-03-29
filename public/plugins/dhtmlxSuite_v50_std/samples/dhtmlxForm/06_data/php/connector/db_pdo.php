<?php

require_once 'db_common.php';
/*! Implementation of DataWrapper for PDO

if you plan to use it for Oracle - use Oracle connection type instead
**/
class PDODBDataWrapper extends DBDataWrapper
{
    private $last_result; //!< store result or last operation

    public function query($sql)
    {
        if ($this->last_result) {
            $this->last_result->closeCursor();
        }

        LogMaster::log($sql);

        $this->last_result = $res = $this->connection->query($sql);
        if ($res === false) {
            throw new Exception("PDO - sql execution failed\n".$this->connection->errorInfo());
        }
        return $res;
    }

    protected function select_query($select, $from, $where, $sort, $start, $count)
    {
        $sql = 'SELECT '.$select.' FROM '.$from;
        if ($where) {
            $sql .= ' WHERE '.$where;
        }
        if ($sort) {
            $sql .= ' ORDER BY '.$sort;
        }
        if ($start || $count) {
            if ($this->connection->getAttribute(PDO::ATTR_DRIVER_NAME) == 'pgsql') {
                $sql .= ' OFFSET '.$start.' LIMIT '.$count;
            } else {
                $sql .= ' LIMIT '.$start.','.$count;
            }
        }

        return $sql;
    }

    public function get_next($res)
    {
        $data = $res->fetch(PDO::FETCH_ASSOC);

        return $data;
    }

    protected function get_new_id()
    {
        return $this->connection->lastInsertId();
    }

    public function escape($str)
    {
        $res = $this->connection->quote($str);
        if ($res === false) { //not supported by pdo driver
            return str_replace("'", "''", $str);
        }

        return substr($res, 1, -1);
    }
}
