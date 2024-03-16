<?php  

# Get all Users function
function get_all_users($con, $name){

    $sql = "SELECT * FROM user WHERE name LIKE :name";
    $stmt = $con->prepare($sql);
    $stmt->bindValue(':name', '%' . $name . '%', PDO::PARAM_STR); // Use parameterized query to prevent SQL injection
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
    } else {
        $users = [];
    }

    return $users;
}