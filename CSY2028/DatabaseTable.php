<?php
namespace CSY2028;
class DatabaseTable {
    protected $server;
    protected $username;
    protected $password;
    protected $schema;
    private $pdo;

    private $table;
    private $pk;
    private $entityClass;
    private $entityConstructor;

    public function __construct($table, $pk = 'id', $entityClass = 'stdclass', $entityConstructor = []) {
        $this->table = $table;
        $this->pk = $pk;
        $this->entityClass = $entityClass;
        $this->entityConstructor = $entityConstructor;
        $this->pdo = new \PDO('mysql:dbname='.$this->schema.';host='.$this->server, $this->username, $this->password);
    }

    private function insert($record) {
        $keys = \array_keys($record);
        $columns = \implode(', ', $keys);
        $values = \implode(', :', $keys);
        $this->pdo->prepare('INSERT INTO '. $this->table . ' (' . $columns . ') VALUES (:' . $values . ')')->execute($record);
    }
    
    private function update($record) {
        $params = [];
        foreach ($record as $key => $value) {
            $params[] = $key . ' = :' .$key;
        }
        $record['primaryKey'] = $record[$this->pk];
        $this->pdo->prepare('UPDATE '. $this->table .' SET '. \implode(', ', $params) .' WHERE '. $this->pk .' = :primaryKey')->execute($record);
    }

    public function find($columns, $values, $comparators = ['=', '='], $order = "ASC", $orderColumn = "id") {
            $string = 'SELECT * FROM '.$this->table.' WHERE ';
            for ($i = 0; $i < count($values); $i++) {
                $string .= $columns[$i].' '.$comparators[$i].' :value'.$i.' ';
            }
            $string .= 'ORDER BY '.$orderColumn.' '.$order;
            $stmt = $this->pdo->prepare($string);
            $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
            $stmt->execute($values);
            return $stmt->fetchAll();
    }
    
    public function findAll() {
        $stmt = $this->pdo->prepare('SELECT * FROM ' . $this->table);
        $stmt->setFetchMode(\PDO::FETCH_CLASS, $this->entityClass, $this->entityConstructor);
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    public function delete($column, $value) {
        $values = [
            'value' => $value
        ];
        $this->pdo->prepare('DELETE FROM '. $this->table .' WHERE '. $column .' = :value')->execute($values);
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