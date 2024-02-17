<?php 

  session_start();

  require 'connect.php';
  require 'functions.php';


  if(isset($_SESSION['username'], $_SESSION['password'])) {

?>

<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

	<title>Search Result - Student Information System</title>

	<link href="assets/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/css/main.css" rel="stylesheet">

  <style>
    section h1 {
      margin: 30px;
      color: rgb(255, 255, 255);
      font-weight: bolder;
      font-family: Verdana, Geneva, Tahoma, sans-serif;
  }

    body {
      background-image: linear-gradient(to left, #0F3443, #34E89E);
    }
    </style>
</head>
<body>

  <?php include 'header.php'; ?>

  <section>

    <?php 

      if(isset($_GET['search'])) {

        $s = clean($_GET['searchbox']);

        $query = "SELECT rollno, firstname, lastname, course, yrlevel, DATE_FORMAT(date_joined, '%m/%d/%Y') as date_joined, CONCAT(firstname, ' ', lastname) as fullname 
        FROM students WHERE CONCAT(firstname, ' ', lastname) = '$s' OR firstname = '$s' OR lastname = '$s' ORDER BY date_joined DESC LIMIT 5";
    ?>

    <div class="container">
      <h1 class="title">Search results for "<?php echo $s; ?>"</h1>
    <?php

        if($result = mysqli_query($con, $query)) {

          if(mysqli_num_rows($result) == 0) {

            echo "<p>No results matches to your query.</p>";
            echo "</div>";

          } else {
            echo "</div>";
            echo "<ul class='profile-results'>";

            while($row = mysqli_fetch_assoc($result)) {

          ?>

              <li>
                <div class="result-box box-left">
                  <div class='info'><strong>Roll Number:</strong> <span><?php echo $row['rollno']; ?></span></div>
                  <div class='info'><strong>Student Name:</strong> <span><?php echo $row['firstname']. " ".$row['lastname']; ?></span></div>
                  <div class='info'><strong>Course:</strong> <span><?php echo $row['course']; ?></span></div>
                  <div class='info'><strong>Year:</strong> <span><?php echo $row['yrlevel']; ?></span></div>
                  <div class='info'><strong>Date Joined:</strong> <span><?php echo $row['date_joined']; ?></span></div>
                </div>
              </li>

          <?php

            }

            echo "</ul>";

          }

        } else {
          die("Error with the query");
        }

      }

    ?>
  
    <div class="container">
      <a class="btn btn-primary" href="profile.php">Go back to My Profile</a>
    </div>
    

  </section>


	<script src="assets/js/jquery-3.1.1.min.js"></script>
  <script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/main.js"></script>
</body>
</html>

<?php 

  } else {
    header("location:index.php");
    exit;
  }

  mysqli_close($con);

?>