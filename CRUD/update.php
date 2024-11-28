<?php
include_once('../PHP/dbconnect.php'); // Include your database connection file

if (isset($_GET['id'])) {
    $id = $_GET['id']; // Get the ID from the URL

    // Create a new database connection
    $dbConnect = new DBConnect();

    // Fetch the record from the database based on the ID
    $stmt = $dbConnect->conn->prepare("SELECT * FROM crud WHERE id = :id");
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $record = $stmt->fetch(PDO::FETCH_ASSOC);

    // If record is found, display the form
    if ($record) {
        $name = $record['name'];
        $age = $record['age'];
        $email = $record['email'];
        // No need to fetch password (hashed), will leave it unchanged unless it's modified
    } else {
        echo "Record not found!";
        exit;
    }
} else {
    echo "No ID provided!";
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the form data
    $name = $_POST["name"];
    $age = $_POST["age"];
    $email = $_POST["email"];
    $password = $_POST["password"]; // Optional, if you want to update the password

    // If password is provided, hash it; otherwise, leave it unchanged
    $hashed_password = !empty($password) ? password_hash($password, PASSWORD_BCRYPT) : $record['password'];

    // Create a new database connection
    $dbConnect = new DBConnect();

    // Update the record in the database
    $stmt = $dbConnect->conn->prepare("UPDATE crud SET name = :name, age = :age, email = :email, password = :password WHERE id = :id");
    $stmt->bindParam(":name", $name);
    $stmt->bindParam(":age", $age);
    $stmt->bindParam(":email", $email);
    $stmt->bindParam(":password", $hashed_password);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    // Success message and redirect
    echo "<h2>Update Successful</h2>";
    echo "Your information has been updated!";
    header("refresh:3;url=../PHP/user.php"); // Redirect to another page (e.g., profile or listing page)
    exit();
}
?>

<!-- Display the update form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css"/>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>UPDATE USER</title>
    <style>
        /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f4f4f9;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Form Container */
form {
    background-color: #fff;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 400px;
    transition: transform 0.3s ease;
}

form:hover {
    transform: translateY(-5px);
}

/* Form Header */
form h2 {
    text-align: center;
    font-size: 24px;
    margin-bottom: 20px;
    color: #4CAF50; /* Elegant Green */
}

/* Label */
label {
    font-size: 14px;
    font-weight: bold;
    color: #555;
    margin-bottom: 5px;
    display: block;
}

/* Input Fields */
input[type="text"],
input[type="email"],
input[type="password"] {
    width: 100%;
    padding: 10px;
    margin: 10px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 16px;
    box-sizing: border-box;
    transition: border-color 0.3s ease;
}

/* Input Fields Focus */
input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
    border-color: black; /* Green border on focus */
    outline: none;
}

/* Submit Button */
input[type="submit"] {
    background-color: black;
    color: white;
    border: none;
    padding: 12px 20px;
    border-radius: 4px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    transition: background-color 0.3s ease;
}

/* Submit Button Hover */
input[type="submit"]:hover {
    background-color: #45a049;
}

/* Responsive Design */
@media (max-width: 480px) {
    form {
        width: 90%;
        padding: 15px;
    }

    form h2 {
        font-size: 20px;
    }
}

    </style>

    
    <body>



   
  
<form method="POST">
    <label>Name: </label>
    <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required><br>

    <label>Age: </label>
    <input type="text" name="age" value="<?php echo htmlspecialchars($age); ?>" required><br>

    <label>Email: </label>
    <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br>

    <label>Password (leave blank to keep existing): </label>
    <input type="password" name="password"><br>

    <input type="submit" value="Update">
</form>

 
</body>
</html>
