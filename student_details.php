<?php
include_once("db.php"); // Include the file with the Database class

class StudentDetails {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Create a student detail entry and link it to a student
    public function create($data) {
        try {
            // Prepare the SQL INSERT statement
            $sql = "INSERT INTO school_db.student_details(student_id, contact_number, street, zip_code, town_city, province) VALUES(:student_id, :contact_number, :street, :zip_code, :town_city,:province);";
            $stmt = $this->db->getConnection()->prepare($sql);

            // Bind values to placeholders
            $stmt->bindParam(':student_id', $data['student_id']);
            $stmt->bindParam(':contact_number', $data['contact_number']);
            $stmt->bindParam(':street', $data['street']);
            $stmt->bindParam(':zip_code', $data['zip_code']);
            $stmt->bindParam(':town_city', $data['town_city']);
            $stmt->bindParam(':province', $data['province']);

            // Execute the INSERT query
            //$stmt->execute();

            // Check if the insert was successful
            return $stmt->rowCount() > 0;

        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
        
    }

    public function read($id) {
        try {
            $connection = $this->db->getConnection();

            $sql = "SELECT * FROM school_db.student_details WHERE id = :id";
            $stmt = $connection->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Fetch the student data as an associative array
            $studentDetails  = $stmt->fetch(PDO::FETCH_ASSOC);

            return $studentDetails ;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function update($id, $data) {
        try {
            $sql = "UPDATE student_details SET
                    id = :id,
                    student_id = :student_id,
                    contact_number = :contact_number,
                    street = :street,
                    zip_code = :zip_code,
                    town_city = :town_city,
                    province = :province
                    WHERE id = :id";

            $stmt = $this->db->getConnection()->prepare($sql);
            // Bind parameters
            $stmt->bindValue(':id', $id);
            $stmt->bindValue(':student_id', $data['student_id']);
            $stmt->bindValue(':contact_number', $data['contact_number']);
            $stmt->bindValue(':street', $data['street']);
            $stmt->bindValue(':zip_code', $data['zip_code']);
            $stmt->bindValue(':town_city', $data['town_city']);
            $stmt->bindValue(':province', $data['province']);

            // Execute the query
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function delete($id) {
        try {
            $sql = "DELETE FROM student_details WHERE id = :id";
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindValue(':id', $id);
            $stmt->execute();

            // Check if any rows were affected (record deleted)
            if ($stmt->rowCount() > 0) {
                return true; // Record deleted successfully
            } else {
                return false; // No records were deleted (student_id not found)
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }

    public function displayAll(){
        try {
            $sql = "SELECT student_number, first_name, last_name, middle_name, gender, birthday, student_id, contact_number, street, town_city, province, zip_code 
            FROM school_db.students JOIN school_db.student_details ON students.id = student_details.student_id LIMIT 10"; // Modify the table name to match your database
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            // Handle any potential errors here
            echo "Error: " . $e->getMessage();
            throw $e; // Re-throw the exception for higher-level handling
        }
    }
 
 
 /*
        sample simple tests
    */
    // public function testCreateStudent() {
    //     $data = [
    //         'student_number' => 'S12345',
    //         'first_name' => 'John',
    //         'middle_name' => 'Doe',
    //         'last_name' => 'Smith',
    //         'gender' => '1',
    //         'birthday' => '1990-01-15',
    //     ];

    //     $student_id = $this->create($data);

    //     if ($student_id !== null) {
    //         echo "Test passed. Student created with ID: " . $student_id . PHP_EOL;
    //         return $student_id;
    //     } else {
    //         echo "Test failed. Student creation unsuccessful." . PHP_EOL;
    //     }
    // }

    // public function testReadStudent($id) {
    //     $studentDetails = $this->read($id);

    //     if ($studentDetails !== false) {
    //         echo "Test passed. Student data read successfully: " . PHP_EOL;
    //         print_r($studentDetails);
    //     } else {
    //         echo "Test failed. Unable to read student data." . PHP_EOL;
    //     }
    // }

    // public function testUpdateStudent($id, $data) {
    //     $success = $this->update($id, $data);

    //     if ($success) {
    //         echo "Test passed. Student data updated successfully." . PHP_EOL;
    //     } else {
    //         echo "Test failed. Unable to update student data." . PHP_EOL;
    //     }
    // }

    // public function testDeleteStudent($id) {
    //     $deleted = $this->delete($id);

    //     if ($deleted) {
    //         echo "Test passed. Student data deleted successfully." . PHP_EOL;
    //     } else {
    //         echo "Test failed. Unable to delete student data." . PHP_EOL;
    //     }
    // }
}


// $studentdetails = new StudentDetails(new Database());

// // Test the create method
// $student_id = $studentdetails->testCreateStudent();

// // Test the read method with the created student ID
// $studentdetails->testReadStudent($student_id);

// // Test the update method with the created student ID and updated data
// $update_data = [
//     'id' => $student_id,
//     'student_number' => 'S67890',
//     'first_name' => 'Alice',
//     'middle_name' => 'Jane',
//     'last_name' => 'Doe',
//     'gender' => '0',
//     'birthday' => '1995-05-20',
// ];
// $studentdetails->testUpdateStudent($student_id, $update_data);

// // Test the delete method with the created student ID
// $studentdetails->testDeleteStudent($student_id);

?>
