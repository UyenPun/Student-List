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

// Hàm để tạo giới tính ngẫu nhiên
function generateRandomGender()
{
    $genders = array("Nam", "Nữ");
    return $genders[array_rand($genders)];
}

// Hàm để tạo quê quán ngẫu nhiên
function generateRandomAddress()
{
    $addresses = array("Hanoi", "Ho Chi Minh City", "Da Nang", "Hue", "Can Tho", "Hai Phong", "Nha Trang", "Vung Tau");
    return $addresses[array_rand($addresses)];
}

// Hàm để tạo tên ngẫu nhiên
function generateRandomName()
{
    $names = array("John", "Jane", "Doe", "Smith", "Alice", "Bob", "Charlie", "David");
    return $names[array_rand($names)];
}

// Hàm để tạo ngày sinh ngẫu nhiên
function generateRandomDate()
{
    return date('Y-m-d', rand(strtotime("1950-01-01"), strtotime("2005-12-31")));
}

// Hàm để thêm người dùng mới với thông tin ngẫu nhiên
function addRandomUserToDatabase($connection)
{
    $name = generateRandomName();
    $birthday = generateRandomDate();
    $gender = generateRandomGender();
    $height = rand(150, 200);
    $weight = rand(40, 100);
    $address = generateRandomAddress();
    $score = rand(0, 10);

    $sql = "INSERT INTO userinformation (Ten, NgaySinh, GioiTinh, ChieuCao, CanNang, QueQuan, DiemThi) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $connection->prepare($sql);
    $stmt->bind_param("sssiisi", $name, $birthday, $gender, $height, $weight, $address, $score);
    $stmt->execute();
    $stmt->close();
}

// Xử lý xóa toàn bộ hàng từ bảng cơ sở dữ liệu
if (isset($_GET['delete_all'])) {
    $sql_delete_all = "TRUNCATE TABLE userinformation";
    if ($connection->query($sql_delete_all) === TRUE) {
        // Xóa thành công, chuyển hướng người dùng đến trang hiện tại
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        // Nếu có lỗi xảy ra trong quá trình xóa, hiển thị thông báo lỗi
        echo "Error deleting record: " . $connection->error;
    }
}

// Xử lý khi người dùng nhấn nút "Add Users"
if (isset($_POST['add_users']) && isset($_POST['quantity'])) {
    $quantity = intval($_POST['quantity']);
    if ($quantity > 0) {
        for ($i = 0; $i < $quantity; $i++) {
            addRandomUserToDatabase($connection);
        }
        // Chuyển hướng người dùng đến trang hiện tại để refresh danh sách
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
      <a href="?delete_all=true" class="btn btn-primary custom-gradient-4 ms-2" role="button">Delete All</a>
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