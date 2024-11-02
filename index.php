<?php
include ('Databaseconnection.php');
require_once("Student.php");


$db = new Databaseconnection("localhost", "root", "", "faculty");
$connection = $db->getConnection();




$Student = new Student($connection); 
$Studnet = $Student->getAllStudent();

$edit_mode = false;
$student_to_edit = null;

if(isset($_GET['ID'])&& isset($_GET['to_delete']))
{
    $std_id=$_GET['ID'];
    $Student->setID($std_id);
    $Student->delete();
}

if (isset($_GET['ID']) && isset($_GET['to_edit'])) {
    $edit_mode = true;
    $std_id = $_GET['ID'];
    $student_to_edit = $Student->getStudentByID($std_id);
}
if (isset($_POST['update_student'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $gpa = $_POST['gpa'];

    $Student->setId($id);
    $Student->setName($name);
    $Student->setGPA($gpa);
    $Student->update();
    header("Location: index.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student GPA List</title>
</head>
<body>
<form action="index.php" method="POST">
        <?php if ($edit_mode): ?>
            <input type="hidden" name="id" value="<?php echo $student_to_edit['ID']; ?>">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" value="<?php echo $student_to_edit['Name']; ?>" placeholder="Enter your name">
            <label for="gpa">GPA</label>
            <input type="text" id="gpa" name="gpa" value="<?php echo $student_to_edit['GPA']; ?>" placeholder="Enter your GPA">
            <input type="submit" value="Update" name="update_student">
        <?php else: ?>
            <label for="name">Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your name">
            <label for="gpa">GPA</label>
            <input type="text" id="gpa" name="gpa" placeholder="Enter your GPA">
            <input type="submit" value="Add" name="add_student">
        <?php endif; ?>
    </form>
    <?php
        if(isset($_POST['add_student']))
        {
            $name=$_POST['name'];
            $gpa=$_POST['gpa'];

            $Student->setName($name);
            $Student->setGpa($gpa);

            $Student->create();
        }
    ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>GPA</th>
            <th>Action</th>
        </tr>
        <?php foreach ($Studnet as $std): ?> 
            <tr>
                <td><?php echo $std['ID']; ?></td>
                <td><?php echo $std['Name']; ?></td>
                <td><?php echo $std['GPA']; ?></td>
                <td><button><a href="index.php?ID=<?php echo $std['ID']?>&to_delete=1">Delete</a></button>
                <button><a href="index.php?ID=<?php echo $std['ID']?>&to_edit=1">Edit</a></button>
              </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>