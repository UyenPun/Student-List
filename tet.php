<?php
// Kết nối đến cơ sở dữ liệu
$servername = "localhost";
$username = "root";
$password = "";
$database = "student";

// Tạo kết nối
$connection = new mysqli($servername, $username, $password, $database);

// Kiểm tra kết nối
if ($connection->connect_error) {
    die("Connection failed: " . $connection->connect_error);
}

// Hàm để tạo một người dùng mới với thông tin ngẫu nhiên và thêm vào cơ sở dữ liệu
function addRandomUserToDatabase($connection) {
    $name = generateRandomName();
    $birthday = generateRandomDate();
    $gender = rand(0, 1) == 0 ? "Male" : "Female";
    $height = rand(150, 200);
    $weight = rand(40, 100);
    $address = generateRandomAddress();
    $score = rand(0, 10);

    $sql = "INSERT INTO userinformation (Ten, NgaySinh, GioiTinh, ChieuCao, CanNang, QueQuan, DiemThi) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssiiii", $name, $birthday, $gender, $height, $weight, $address, $score);
    $stmt->execute();
    $stmt->close();
}

// Hàm tạo tên ngẫu nhiên
function generateRandomName() {
    $names = array("Alice", "Bob", "Charlie", "David", "Emma", "Frank", "Grace", "Henry", "Ivy", "Jack");
    return $names[array_rand($names)];
}

// Hàm tạo ngày sinh ngẫu nhiên
function generateRandomDate() {
    return date('Y-m-d', strtotime('-'.mt_rand(18*365, 50*365).' days'));
}

// Hàm tạo địa chỉ ngẫu nhiên
function generateRandomAddress() {
    $addresses = array("Hanoi", "Ho Chi Minh City", "Danang", "Hue", "Can Tho", "Hai Phong", "Nha Trang", "Vung Tau");
    return $addresses[array_rand($addresses)];
}

// Xử lý khi nhấn nút "Add Users"
if(isset($_POST['add_users']) && isset($_POST['quantity'])) {
    $quantity = intval($_POST['quantity']);
    if($quantity > 0) {
        for($i = 0; $i < $quantity; $i++) {
            addRandomUserToDatabase($connection);
        }
        // Chuyển hướng người dùng đến trang hiện tại để refresh danh sách
        header("Location: ".$_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Trang 1</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>
  <div class="container my-5">
    <h2 class="d-flex align-items-center">List of Student</h2>
    <div class="d-flex justify-content-between mb-3">
      <span>
        <a href="/student/create.php" class="btn btn-primary me-2" role="button">New Student</a>
        <a href="/student/filter.php" class="btn btn-primary me-2" role="button">Filter Student</a>
      </span>
      <form method="post" class="d-flex">
        <input type="number" name="quantity" class="form-control me-2" placeholder="Enter quantity" required>
        <button type="submit" name="add_users" class="btn btn-primary">Add Users</button>
      </form>
    </div>

    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Ten</th>
          <th>Ngay Sinh</th>
          <th>Gioi Tinh</th>
          <th>Chieu Cao</th>
          <th>Can Nang</th>
          <th>Que Quan</th>
          <th>Diem Thi</th>
          <th>Thao Tac</th>
        </tr>
      </thead>
      <tbody>
        <?php
                // Đọc tất cả các hàng từ bảng cơ sở dữ liệu
                $sql = "SELECT * FROM userinformation";
                $result = $connection->query($sql);

                if ($result->num_rows > 0) {
                    // Đọc dữ liệu của mỗi hàng
                    while ($row = $result->fetch_assoc()) {
                        echo "
                        <tr>
                            <td>{$row['ID']}</td>
                            <td>{$row['Ten']}</td>
                            <td>{$row['NgaySinh']}</td>
                            <td>{$row['GioiTinh']}</td>
                            <td>{$row['ChieuCao']}</td>
                            <td>{$row['CanNang']}</td>
                            <td>{$row['QueQuan']}</td>
                            <td>{$row['DiemThi']}</td>
                            <td>
                                <a class='btn btn-primary btm-sm' href='/student/edit.php?ID={$row['ID']}'>Edit</a>
                                <a class='btn btn-danger btm-sm' href='/student/delete.php?ID={$row['ID']}'>Delete</a>
                            </td>
                        </tr>
                        ";
                    }
                } else {
                    echo "<tr><td colspan='9'>No data available</td></tr>";
                }
                ?>
      </tbody>
    </table>
  </div>
</body>

</html>