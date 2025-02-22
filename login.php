<?php
//login.php

include('config/function.php');

if (isset($_SESSION['type'])) {
    if ($_SESSION['type'] == 'master') {
        header("location:admin/index.php");
    } elseif ($_SESSION['type'] == 'office') {
        header("location:office/index.php");
    } else {
        header("location:index.php");
    }
    exit();
}

$message = '';

if (isset($_POST["login"])) {
    $query = "SELECT * FROM user_details WHERE user_email = :user_email";
    $statement = $connect->prepare($query);
    $statement->execute(['user_email' => $_POST["user_email"]]);
    $count = $statement->rowCount();

    if ($count > 0) {
        $result = $statement->fetchAll();
        foreach ($result as $row) {
            if ($row['user_status'] == 'Active') {
                if (password_verify($_POST["user_password"], $row["user_password"])) {
                    
                    $_SESSION['type'] = $row['user_type'];
                    $_SESSION['user_id'] = $row['user_id'];
                    $_SESSION['user_name'] = $row['user_name'];

                    // Redirect based on user role
                    if ($row['user_type'] == 'master') {
                        header("location:admin/index.php");
                    } elseif ($row['user_type'] == 'office') {
                        header("location:office/index.php");
                    } elseif ($row['user_type'] == 'user') {
                        header("location:index.php");
                    }
                    exit();
                } else {
                    $message = "<label>Wrong Password</label>";
                }
            } else {
                $message = "<label>Your account is disabled, Contact Master</label>";
            }
        }
    } else {
        $message = "<label>Wrong Email Address</label>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Form</title>
  <link
    href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css"
    rel="stylesheet"
  >
  <style>
    body {
      background: linear-gradient(135deg, #007bff, #6c757d);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
    }

    .card {
      border: none;
      border-radius: 15px;
      box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .btn-primary {
      background-color: #007bff;
      border: none;
      transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
      background-color: #0056b3;
    }

    .form-control:focus {
      box-shadow: none;
      border-color: #007bff;
    }
  </style>
</head>
<body>
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-6">
        <div class="card p-4">
          <h2 class="text-center mb-4">Login to Bethelbd</h2>
          <form method="post">
          <?php echo $message; ?>
            <div class="mb-3">
              <label for="email" class="form-label">Email Address</label>
              <input
                type="email"
                class="form-control"
                id="user_email"
                name="user_email"
                placeholder="Enter your email"
                required
              >
            </div>
            <div class="mb-3">
              <label for="password" class="form-label">Password</label>
              <input
                type="password"
                class="form-control"
                id="user_password"
                name="user_password"
                placeholder="Enter your password"
                required
              >
            </div>
         
            <button type="submit" class="btn btn-primary w-100" name="login">Login</button>
          </form>
          
         
        </div>
      </div>
    </div>
  </div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
