

<?php
session_start();
include "db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    // Secure query
    $stmt = mysqli_prepare($conn, "SELECT id, username, password FROM user WHERE username = ?");
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {

        // Check password
        if (password_verify($password, $row["password"])) {

            // Save session
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];

            // SUCCESS MESSAGE
            echo "Login successful. Redirecting...";

            // Redirect after 2 seconds
            header("refresh:2;url=home.php");
            exit();

        } else {
            echo "Login successful.";
        }

    } else {
        echo "Username not found.";
    }

    mysqli_stmt_close($stmt);
}

mysqli_close($conn);