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

  if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    // GET method: Show the data of the student
    if (!isset($_GET["ID"])) {
      header("location: /student/index.php");
      exit;
    }

    $ID = $_GET["ID"];

    //read the row of the selected student from database table
    $sql = "SELECT * FROM userinformation WHERE ID = $ID";
    $result = $connection->query($sql);
    $row = $result->fetch_assoc();

    if (!$row) {
      header("location: /student/index.php");
      exit;
    }

    $ID = $row["ID"];
    $Ten = $row["Ten"];
    $NgaySinh = $row["NgaySinh"];
    $GioiTinh = $row["GioiTinh"];
    $ChieuCao = $row["ChieuCao"];
    $CanNang = $row["CanNang"];
    $QueQuan = $row["QueQuan"];
    $DiemThi = $row["DiemThi"];


  }
  else {
    // POST method: Update the data of the student
    $ID = $_POST["ID"];
    $Ten = $_POST["Ten"];
    $NgaySinh = $_POST["NgaySinh"];
    $GioiTinh = $_POST["GioiTinh"];
    $ChieuCao = $_POST["ChieuCao"];
    $CanNang = $_POST["CanNang"];
    $QueQuan = $_POST["QueQuan"];
    $DiemThi = $_POST["DiemThi"];

    do {
      if (empty($ID) || empty($Ten) || empty($NgaySinh)  || empty($GioiTinh) || empty($ChieuCao)|| empty($CanNang)|| empty($QueQuan)|| empty($DiemThi)) {
        $errorMessage = "All the fields are required";
        break;
      }

      $sql = "UPDATE userinformation " . // Thêm một khoảng trắng sau tên bảng
      "SET Ten = '$Ten', NgaySinh = '$NgaySinh', GioiTinh = '$GioiTinh', ChieuCao = '$ChieuCao', CanNang = '$CanNang', QueQuan = '$QueQuan', DiemThi = '$DiemThi' " . // Thêm một khoảng trắng ở đầu dòng và sau danh sách cột cập nhật
      "WHERE ID = '$ID'"; // Thêm một khoảng trắng ở đầu dòng


      $result = $connection->query($sql);

      if (!$result) {
        $errorMessage = "Invalid query: " . $connection->error;
        break;
      }

      $successMessage = "Client updated correctly";
      header("location: /student/index.php");
      exit;

    } while (true);

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
      <input type="hidden" name="id" value="<?php echo $ID ?>" />

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
          <input type="text" name="ChieuCao" value="<?php echo $ChieuCao ?>" class="form-control" />
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