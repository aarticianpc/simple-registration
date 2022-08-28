<?php

class SQLQuery {
    protected $_dbHandle;
    protected $_result;
    protected $_table;
    protected $_describe = array();
    /**
     * Connection to database
     */
    public function connect($host, $user, $password, $db_name): int
    {
        $this->_dbHandle = mysqli_connect($host, $user, $password);
        if($this->_dbHandle) {
            if(mysqli_select_db($this->_dbHandle, $db_name)) {
                return 1;
            } else {
                return 0;
            }
        } else {
            return 0;
        }
    }

    public function disconnect(): int
    {
        if(@mysqli_close($this->_dbHandle) != 0) {
            return 1;
        } else {
            return 0;
        }
    }


    public function query(string $query, int $singleRecord = 0) {
        $this->_result = mysqli_query($this->_dbHandle, $query);

        if(preg_match('/select/i', $query)) {
            $result = [];
            $table = [];
            $field = [];
            $tempResult = [];
            $numOfFields = mysqli_num_fields($this->_result);
            for($i = 0; $i < $numOfFields; $i++) {
                $tableInfo = mysqli_fetch_field_direct($this->_result, $i);
                $table[] = $tableInfo->table;
                $field[] = $tableInfo->name;
            }

            while($row = mysqli_fetch_row($this->_result)) {

                for($i = 0; $i < $numOfFields; $i++) {
                    $table[$i] = trim(ucfirst($table[$i]),'s');
                    $tempResult[$table[$i]][$field[$i]] = $row[$i];
                }
                if(!empty($singleRecord)) {
                    $this->freeResult();
                    return $tempResult;
                }
                $result[] = $tempResult;
            }
            return $result;
        }
    }


    /**
     * Free resources allocated by query
     * @return void
     */
    protected function freeResult() {
        mysqli_free_result($this->_result);
    }

    /**
     * Get error string
     * @return string
     */
    protected function getError(): string
    {
        return mysqli_error($this->_dbHandle);
    }

    protected function _describe() {

        $this->_describe = Cache::get('describe'.$this->_table);

        if (!$this->_describe) {
            $this->_describe = [];
            $query = 'DESCRIBE '.$this->_table;
            $this->_result = mysqli_query($this->_dbHandle, $query);
            while ($row = mysqli_fetch_row($this->_result)) {
                $this->_describe[] = $row[0];
            }
            $this->freeResult();
            Cache::set('describe'.$this->_table,$this->_describe);
        }
    }

    public function select($where = null) {
        $whereCondition = ' 1=1 ';
        if(!empty($where)) {
            foreach ($where as $key => $condition) {
                $whereCondition .= ' AND `'.$key.'` = "'.mysqli_real_escape_string($this->_dbHandle, $condition).'"';
            }
        }
        $query = 'Select * from `'.$this->_table.'` where '.$whereCondition;
        return $this->query($query);
    }

    /**
     * Saves an Object i.e. Updates/Inserts Query
     */
    public function save() {
        $query = '';
        if (isset($this->id)) {
            $updates = '';
            foreach ($this->_describe as $field) {
                if ($this->$field) {
                    $updates .= '`'.$field.'` = \''.mysqli_real_escape_string($this->_dbHandle, $this->$field).'\',';
                }
            }

            $updates = substr($updates,0,-1);

            $query = 'UPDATE '.$this->_table.' SET '.$updates.' WHERE `id`=\''.mysqli_real_escape_string($this->_dbHandle, $this->id).'\'';
        } else {
            $fields = '';
            $values = '';
            $this->_describe();

            foreach ($this->_describe as $field) {

                if ($this->$field) {
                    $fields .= '`'.$field.'`,';
                    $values .= '\''.mysqli_real_escape_string($this->_dbHandle, $this->$field).'\',';
                }
            }
            $values = substr($values,0,-1);
            $fields = substr($fields,0,-1);

            $query = 'INSERT INTO '.$this->_table.' ('.$fields.') VALUES ('.$values.')';
        }

        $this->_result = mysqli_query($this->_dbHandle, $query);
        $this->clear();
        if ($this->_result == 0) {
            /** Error Generation **/
            return -1;
        }
    }

    protected function clear() {
        foreach($this->_describe as $field) {
            $this->$field = null;
        }
    }
}