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
        startDB()->prepare('INSERT INTO '. $this->table . ' (' . $columns . ') VALUES (:' . $values . ')')->execute($record);
    }
    
    private function update($record) {
         $params = [];
         foreach ($record as $key => $value) {
            $params[] = $key . ' = :' .$key;
         }
         $record['primaryKey'] = $record[$this->pk];
         startDB()->prepare('UPDATE '. $this->table .' SET '. \implode(', ', $params) .' WHERE '. $this->pk .' = :primaryKey')->execute($record);
    }

    public function find($column, $value) {
        $values = [
            'value' => $value
        ];
        return startDB()->prepare('SELECT * FROM '. $this->table . ' WHERE '. $field . ' = :value')->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor)->execute($values)->fetchAll();
    }
    
    public function findAll() {
        return startDB()->prepare('SELECT * FROM ' . $this->table)->execute()->fetchAll();
    }
    
    public function delete($column, $value) {
        $values = [
            'value' => $value
        ];
        startDB()->prepare('DELETE FROM '. $this->$table .' WHERE '. $column .' = :value')->execute($values);
    }
    
    public function save($record) {
        if (\empty($record[$pk])) {
            \unset($record[$pk]);
        }
        try {
            insert($record);
        }
        catch (\Exception $e) {
            update($record);
        }
    }
}
?>