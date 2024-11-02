<?php
class Student {
    private $name;
    private $gpa;
    private $id;

    private $connection;
    public function __construct($connection)
{
    $this->connection=$connection;
}
    public function setName($name) {
        $this->name = $name;
    }

    public function getName() {
        return $this->name;
    }

    public function setGPA($gpa) {
        $this->gpa = $gpa;
    }

    public function getGPA() {
        return $this->gpa;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getId() {
        return $this->id;
    }


    // GET ELEMENTS FROM STUDENT TABLE
    public function getAllStudent()
{
    $query = "SELECT * FROM student";
    $result = mysqli_query($this->connection, $query);

    if (!$result) {
        die("Query failed: " . mysqli_error($this->connection));
    }

    $students = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $students[] = $row;
    }

    return $students;
}

 // CREATE DATA OR ROW IN STUDENT TABLE
 public function create() 
    { 
        if (empty($this->name) || empty($this->gpa)) { 
            return header('location:index.php?error=All fields are 
required'); 
        } 
 
        $query = "insert into Student (name,gpa) values 
('$this->name', '$this->gpa')"; 

        $result = mysqli_query($this->connection, $query); 
 
        if (!$result) { 
            return header('location:index.php?error=Failed to add student');  
        } 
 
        return header('location:index.php?success=Successfully added student'); 
} 
// DELETE THE  DATA

public function delete() 
    { 
        $query = "delete from Student where ID = '$this->id'"; 
        $result = mysqli_query($this->connection, $query); 
 
        if (!$result) { 
            return header('location:index.php?error=Failed to delete student'); 
        } 
 
        return header('location:index.php?success=Successfully deleted student');  
} 

public function getStudentByID($id) {
    $sql = "SELECT * FROM Student WHERE ID = ?";
    $stmt = $this->connection->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}
public function update() 
    { 
        if (empty($this->id) || empty($this->name) || empty($this->gpa)) { 
            return header('location:index.php?error=All Fields are required'); 
        } 
 
        $query = "update Student set Name = '$this->name', gpa = '$this->gpa' where ID = '$this->id'"; 
        $result = mysqli_query($this->connection, $query); 
 
        if (!$result) { 
            return header('location:index.php?error=Failed updated student data'); 
        } 
 
        return header('location:index.php?success=Successfully updated student data');  
} 

}
?>