<?php
namespace CSY2028;
class DatabaseTable {
    private $table;
    private $pk;
    private $entityClass;
    private $entityConstructor;

    public function __construct($table, $pk = 'id', $entityClass = 'stdclass', $entityConstructor = []) {
        $this->table = $table;
        $this->pk = $pk;
        $this->entityClass = $entityClass;
        $this->entityConstructor = $entityConstructor;
    }

    private function startDB() { //TODO: Maybe move
        $server = 'mysql';
        $username = 'student';
        $password = 'student';
        $schema = 'job';
        return new \PDO('mysql:dbname='.$schema.';host='.$server, $username, $password);
    }

    private function insert($record) {
        $keys = \array_keys($record);
        $columns = \implode(', ', $keys);
        $values = \implode(', :', $keys);
        $this->startDB()->prepare('INSERT INTO '. $this->table . ' (' . $columns . ') VALUES (:' . $values . ')')->execute($record);
    }
    
    private function update($record) {
        $params = [];
        foreach ($record as $key => $value) {
            $params[] = $key . ' = :' .$key;
        }
        $record['primaryKey'] = $record[$this->pk];
        $this->startDB()->prepare('UPDATE '. $this->table .' SET '. \implode(', ', $params) .' WHERE '. $this->pk .' = :primaryKey')->execute($record);
    }

    public function find($column, $value, $column2 = "", $value2 = "") {
        if ($column2 == "" && $value2 == "") {
            $values = [
                'value' => $value
            ];
            $stmt = $this->startDB()->prepare('SELECT * FROM '. $this->table . ' WHERE '. $column . ' = :value');
            $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
            $stmt->execute($values);
            return $stmt->fetchAll();
        }
        else {
            $values = [
                'value' => $value,
                'value2' => $value2
            ];
            $stmt = $this->startDB()->prepare('SELECT * FROM '. $this->table . ' WHERE '. $column . ' = :value AND '. $column2 .' = :value2');
            $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
            $stmt->execute($values);
            return $stmt->fetchAll();
        }
    }
    
    public function findAll() {
        $stmt = $this->startDB()->prepare('SELECT * FROM ' . $this->table);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function delete($column, $value) {
        $values = [
            'value' => $value
        ];
        $this->startDB()->prepare('DELETE FROM '. $this->table .' WHERE '. $column .' = :value')->execute($values);
    }
    
    public function save($record) {
        if (empty($record[$this->pk])) {
            unset($record[$this->pk]);
        }
        try {
            $this->insert($record);
        }
        catch (\Exception $e) {
            $this->update($record);
        }
    }
}
?>