<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $fullname = trim($_POST['name']);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $gender = trim($_POST["gender"]);
    $dateofbirth = trim($_POST["DateOfBirth"]);
    $course = trim($_POST["course"]);
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);
    $confirm_password = trim($_POST["confirm-password"]);

    if ($password != $confirm_password) {
        die("Passwords do not match!");
    }

    if ($fullname == "" || $email == "" || $username == "") {
        die("Please fill all required fields!");
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = mysqli_prepare(
        $conn,
        "INSERT INTO user (fullname, email, phone, gender, dateofbirth, course, username, password)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?)"
    );

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssss",
        $fullname,
        $email,
        $phone,
        $gender,
        $dateofbirth,
        $course,
        $username,
        $hashed_password
    );

    if (mysqli_stmt_execute($stmt)) {
        header("Location: login.html");
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);
?>