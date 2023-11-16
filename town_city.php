<?php
include_once("db.php"); // Include the Database class file

class TownCity
{
    private $db;

    public function __construct($db)
    {
        $this->db = $db;
    }

    public function getAll()
    {
        try {
            $sql = "SELECT * FROM town_city";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Handle errors (log or display)
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
    public function read($id)
    {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM town_city WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $studentData = $stmt->fetch(PDO::FETCH_ASSOC);

            return $studentData;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
    public function update($id, $data) {
        try {
            $sql = "UPDATE town_city SET
                    name = :name,
                    first_name = :first_name,
                    middle_name = :middle_name,
                    last_name = :last_name,
                    gender = :gender,
                    birthday = :birthday
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindValue(':id', $data['id']);
            $stmt->bindValue(':name', $data['name']);

            // Execute the query
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
    // Add this method 
    public function delete($id)
    {
        try {

            // SQL to delete record by ID
            $sql = "DELETE FROM town_city WHERE id = :id";

            // Prepare statement
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind ID value
            $stmt->bindParam(':id', $id);

            // Execute statement
            $stmt->execute();

            // Return rows deleted
            return $stmt->rowCount();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO town_city(name) VALUES(:name);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':name', $data['namer']);


            // Execute the INSERT query
            $stmt->execute();

            // Check if the insert was successful
             
            if($stmt->rowCount() > 0)
            {
                return $this->db->getConnection()->lastInsertId();
            }

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
}
