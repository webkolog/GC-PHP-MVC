<?php

class Database extends PDO {

    public function __construct($dns, $user, $pass) {
        parent::__construct($dns, $user, $pass);
    }

    public function select($sql, $array = array(), $fetchMode = NULL) {
        $sth = $this->prepare($sql);
        foreach ($array as $key => $value) {
            $sth->bindValue($key, $value);
        }
        $sth->execute();
        return $sth->fetchAll($fetchMode);
    }

    public function insert($tableName, $data) {
        $fieldKeys = implode(", ", array_keys($data));
        $fieldValues = ":" . implode(", :", array_keys($data));
        $sql = "INSERT INTO $tableName ($fieldKeys) VALUES($fieldValues)";
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindValue(":" . $key, $value);
        }
        return $sth->execute();
    }

    public function update($tableName, $data, $filter) {
        $fieldKeys = array_keys($data);
        $fieldVals = array_values($data);
        $dataSay = count($data);
        $fields = "";
        for ($i = 0; $i < $dataSay; $i++) {
            $fields .= $fieldKeys[$i] . "=:" . $fieldKeys[$i] . ",";
        }
        $fields = trim($fields, ",");
        $filterCount = count($filter);
        if (is_array($filter[0])) {
            $where = $filter[0][1] . $filter[0][2] . ":vi_" . $filter[0][1];
            if ($filterCount > 1) {
                for ($i = 1; $i < $filterCount; $i++) {
                    $where .= " " . $filter[$i][0] . " " . $filter[$i][1] . $filter[$i][2] . ":vi_" . $filter[$i][1];
                }
            }
            $multiFilter = true;
        } else {
            $keyIndex = 1;
            $oprIndex = 2;
            $valIndex = 3;
            $autoEq = false;
            switch ($filterCount) {
                case 3:
                    $keyIndex = 0;
                    $oprIndex = 1;
                    $valIndex = 2;
                    break;
                case 2:
                    $keyIndex = 0;
                    $valIndex = 1;
                    $autoEq = true;
                    break;
            }
            if ($autoEq) {
                $where = $filter[$keyIndex] . "=:vi_" . $filter[$keyIndex];
            } else {
                $where = $filter[$keyIndex] . $filter[$oprIndex] . ":vi_" . $filter[$keyIndex];
            }
            $multiFilter = false;
        }
        $sql = "UPDATE $tableName SET $fields WHERE $where";
        $sth = $this->prepare($sql);
        foreach ($data as $key => $value) {
            $sth->bindValue(":" . $key, $value);
        }
        if ($multiFilter) {
            for ($i = 0; $i < $filterCount; $i++) {
                $sth->bindValue(":vi_" . $filter[$i][1], $filter[$i][3]);
            }
        } else {
            $sth->bindValue(":vi_" . $filter[$keyIndex], $filter[$valIndex]);
        }
        return $sth->execute();
    }

    public function delete($tableName, $filter) {
        $filterCount = count($filter);
        if (is_array($filter[0])) {
            $where = $filter[0][1] . $filter[0][2] . ":vi_" . $filter[0][1];
            if ($filterCount > 1) {
                for ($i = 1; $i < $filterCount; $i++) {
                    $where .= " " . $filter[$i][0] . " " . $filter[$i][1] . $filter[$i][2] . ":vi_" . $filter[$i][1];
                }
            }
            $multiFilter = true;
        } else {
            $keyIndex = 1;
            $oprIndex = 2;
            $valIndex = 3;
            $autoEq = false;
            switch ($filterCount) {
                case 3:
                    $keyIndex = 0;
                    $oprIndex = 1;
                    $valIndex = 2;
                    break;
                case 2:
                    $keyIndex = 0;
                    $valIndex = 1;
                    $autoEq = true;
                    break;
            }
            if ($autoEq) {
                $where = $filter[$keyIndex] . "=:vi_" . $filter[$keyIndex];
            } else {
                $where = $filter[$keyIndex] . $filter[$oprIndex] . ":vi_" . $filter[$keyIndex];
            }
            $multiFilter = false;
        }
        $sql = "DELETE FROM $tableName WHERE $where";
        $sth = $this->prepare($sql);
        if ($multiFilter) {
            for ($i = 0; $i < $filterCount; $i++) {
                $sth->bindValue(":vi_" . $filter[$i][1], $filter[$i][3]);
            }
        } else {
            $sth->bindValue(":vi_" . $filter[$keyIndex], $filter[$valIndex]);
        }
        return $sth->execute();
    }

    public function rowCount($tableName, $filter) {
        $filterCount = count($filter);
        if (is_array($filter[0])) {
            $where = $filter[0][1] . $filter[0][2] . ":vi_" . $filter[0][1];
            if ($filterCount > 1) {
                for ($i = 1; $i < $filterCount; $i++) {
                    $where .= " " . $filter[$i][0] . " " . $filter[$i][1] . $filter[$i][2] . ":vi_" . $filter[$i][1];
                }
            }
            $multiFilter = true;
        } else {
            $keyIndex = 1;
            $oprIndex = 2;
            $valIndex = 3;
            $autoEq = false;
            switch ($filterCount) {
                case 3:
                    $keyIndex = 0;
                    $oprIndex = 1;
                    $valIndex = 2;
                    break;
                case 2:
                    $keyIndex = 0;
                    $valIndex = 1;
                    $autoEq = true;
                    break;
            }
            if ($autoEq) {
                $where = $filter[$keyIndex] . "=:vi_" . $filter[$keyIndex];
            } else {
                $where = $filter[$keyIndex] . $filter[$oprIndex] . ":vi_" . $filter[$keyIndex];
            }
            $multiFilter = false;
        }
        $where = (strlen($where)>0?'WHERE ':'').$where;
        $sql = "SELECT COUNT(*) FROM $tableName $where";
        $sth = $this->prepare($sql);
        if ($multiFilter) {
            for ($i = 0; $i < $filterCount; $i++) {
                $sth->bindValue(":vi_" . $filter[$i][1], $filter[$i][3]);
            }
        } else {
            $sth->bindValue(":vi_" . $filter[$keyIndex], $filter[$valIndex]);
        }
            $sth->execute();
            $rs = $sth->fetch(PDO::FETCH_NUM);
            return $rs[0];
    }
    
}
