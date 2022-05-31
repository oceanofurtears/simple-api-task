<?php

class City
{

    private $conn;
    private $table_name = "City";

    public $id;
    public $name;

    public function __construct($db)
    {
        $this->conn = $db;
    }

    function get($page)
    {
        $limit = 3;
        $offset = $limit * ($page - 1);

        $query = "SELECT * FROM " .$this->table_name. " LIMIT :limit OFFSET :offset ";


        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(":limit", $limit , PDO::PARAM_INT);
        $stmt->bindParam(":offset", $offset,  PDO::PARAM_INT);

        $stmt->execute();

        return $stmt;
    }

    function create()
    {

        $query = "INSERT INTO " . $this->table_name . " SET Name=:name";

        $stmt = $this->conn->prepare($query);

        $this->name = htmlspecialchars(strip_tags($this->name));

        $stmt->bindParam(":name", $this->name);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function update(){

        $query = "UPDATE
                " . $this->table_name . "
            SET
                Name = :name,
                City_id = :city_id
            WHERE
                id = :id";

        $stmt = $this->conn->prepare($query);

        $this->name=htmlspecialchars(strip_tags($this->name));
        $this->id=htmlspecialchars(strip_tags($this->id));


        $stmt->bindParam(':name', $this->name);
        $stmt->bindParam(':id', $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

    function delete(){

        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $this->id=htmlspecialchars(strip_tags($this->id));

        $stmt->bindParam(1, $this->id);

        if ($stmt->execute()) {
            return true;
        }

        return false;
    }

}


