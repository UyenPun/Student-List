<?php
$servername = "localhost";
$username = "root";
$password = "";
$database = "student";

// Create connection
$connection = new mysqli($servername, $username, $password, $database);

  $ID = "";
  $Ten = "";
  $NgaySinh = "";
  $GioiTinh = "";
  $ChieuCao = "";
  $CanNang = "";
  $QueQuan = "";
  $DiemThi = "";

  $errorMessage = "";
  $successMessage = "";

  if ($_SERVER["REQUEST_METHOD"] == 'POST') {
    $ID = $_POST["ID"];
    $Ten = $_POST["Ten"];
    $NgaySinh = $_POST["NgaySinh"];
    $GioiTinh = $_POST["GioiTinh"];
    $ChieuCao = $_POST["ChieuCao"];
    $CanNang = $_POST["CanNang"];
    $QueQuan = $_POST["QueQuan"];
    $DiemThi = $_POST["DiemThi"];

    do {
      if (empty($ID) || empty($Ten) || empty($NgaySinh)  || empty($GioiTinh) || empty($ChieuCao)|| empty($CanNang)|| empty($QueQuan)|| empty($DiemThi)){
        break;
      }

      // Add new student to database
      $sql = "INSERT INTO userinformation(ID, Ten, NgaySinh, GioiTinh, ChieuCao, CanNang, QueQuan, DiemThi) VALUES ('$ID', '$Ten', '$NgaySinh', '$GioiTinh', '$ChieuCao', '$CanNang', '$QueQuan', '$DiemThi')";
      $result = $connection->query($sql);

      if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
        break;
      }



      $ID = "";
      $Ten = "";
      $NgaySinh = "";
      $GioiTinh = "";
      $ChieuCao = "";
      $CanNang = "";
      $QueQuan = "";
      $DiemThi = "";

      $successMessage = "Student added correcltly";

      header("location: /student/index.php");
      exit;


    } while (false);
  }




?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container my-5">
    <h2>New Student</h2>

    <?php
    if (!empty($errorMessage)) {
      echo"
      <div class='row mb-3'>
      <div class='offset-sm-3 col-sm-6'>
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>$errorMessage</strong>
          <button type='button' class='btn-close' data-bs-dimiss='alert' aria-label='Close'></button>
        </div>
      </div>
    </div>
      ";
    }

    ?>

    <form method="post">
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">ID</label>
        <div class="col-sm-6">
          <input type="text" name="ID" value="<?php echo $ID ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">Ten</label>
        <div class="col-sm-6">
          <input type="text" name="Ten" value="<?php echo $Ten ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">NgaySinh</label>
        <div class="col-sm-6">
          <input type="text" name="NgaySinh" value="<?php echo $NgaySinh ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">GioiTinh</label>
        <div class="col-sm-6">
          <input type="text" name="GioiTinh" value="<?php echo $GioiTinh ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">ChieuCao</label>
        <div class="col-sm-6">
          <input type="text" name="ChieuCao" value="<?php echo $GioiTinh ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">CanNang</label>
        <div class="col-sm-6">
          <input type="text" name="CanNang" value="<?php echo $CanNang ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">QueQuan</label>
        <div class="col-sm-6">
          <input type="text" name="QueQuan" value="<?php echo $QueQuan ?>" class="form-control" />
        </div>
      </div>
      <div class="row mb-3">
        <label class="col-sm-3 col-form-label">DiemThi</label>
        <div class="col-sm-6">
          <input type="text" name="DiemThi" value="<?php echo $DiemThi ?>" class="form-control" />
        </div>
      </div>

      <?php
      if (!empty($successMessage)) {
        echo"
        <div class='alert alert-warning alert-dismissible fade show' role='alert'>
          <strong>$successMessage</strong>
          <button type='button' class='btn-close' data-bs-dimiss='alert' aria-label='Close'></button>
        </div>
        ";
      }
      ?>

      <div class="row mb-3">
        <div class="offset-sm-3 col-sm-3 d-grid">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
        <div class="col-sm-3 d-grid">
          <a href="/student/index.php" class="btn btn-outline-primary" role="button">Cancel</a>
        </div>
      </div>
    </form>
  </div>
</body>

</html>