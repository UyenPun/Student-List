<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Filter</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" />
  <style>
  .pagination {
    justify-content: center;
  }

  .pagination a {
    color: black;
    float: left;
    padding: 8px 16px;
    text-decoration: none;
    transition: background-color .3s;
    border: 1px solid #ddd;
    margin: 0 4px;
  }

  .pagination a.active {
    background-color: #4CAF50;
    color: white;
    border: 1px solid #4CAF50;
  }

  .pagination a:hover:not(.active) {
    background-color: #ddd;
  }
  </style>
</head>

<body>

  <div class="container my-5">
    <h2>Filter Users</h2>

    <form method="get" action="">
      <div class="row">
        <div class="col-md-3 mb-3">
          <label for="gender">Giới tính:</label>
          <select class="form-select" name="gender">
            <option value="">Tất cả</option>
            <option value="Nam">Nam</option>
            <option value="Nữ">Nữ</option>
          </select>
        </div>
        <div class="col-md-3 mb-3">
          <label for="height">Chiều cao (cm):</label>
          <input type="text" class="form-control" name="height">
        </div>
        <div class="col-md-3 mb-3">
          <label for="weight">Cân nặng (kg):</label>
          <input type="text" class="form-control" name="weight">
        </div>
        <div class="col-md-3 mb-3">
          <label for="city">Quê quán:</label>
          <input type="text" class="form-control" name="city">
        </div>
      </div>
      <div class="row">
        <div class="col-md-12">
          <button type="submit" class="btn btn-primary">Lọc</button>
        </div>
      </div>
    </form>

    <?php
    // Your PHP code for processing filter here
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "student";

    $connection = new mysqli($servername, $username, $password, $database);

    if ($connection->connect_error) {
        die("Connection failed: " . $connection->connect_error);
    }

    $where_clause = "";

    if (isset($_GET['gender']) && !empty($_GET['gender'])) {
        $gender = $_GET['gender'];
        $where_clause .= " AND GioiTinh = '$gender'";
    }
    if (isset($_GET['height']) && !empty($_GET['height'])) {
        $height = $_GET['height'];
        $where_clause .= " AND ChieuCao = $height";
    }
    if (isset($_GET['weight']) && !empty($_GET['weight'])) {
        $weight = $_GET['weight'];
        $where_clause .= " AND CanNang = $weight";
    }
    if (isset($_GET['city']) && !empty($_GET['city'])) {
        $city = $_GET['city'];
        $where_clause .= " AND QueQuan = '$city'";
    }

    // Phân trang
    $limit = 10; // Số lượng bản ghi trên mỗi trang
    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1; // Trang hiện tại
    $offset = ($page - 1) * $limit; // Offset

    $sort_options = array('id', 'name', 'birthday', 'gender', 'height', 'weight', 'city', 'score');
    $sort = isset($_GET['sort']) && in_array($_GET['sort'], $sort_options) ? $_GET['sort'] : 'id';
    $sort_columns = array(
        'id' => 'ID',
        'name' => 'Ten',
        'birthday' => 'NgaySinh',
        'gender' => 'GioiTinh',
        'height' => 'ChieuCao',
        'weight' => 'CanNang',
        'city' => 'QueQuan',
        'score' => 'DiemThi'
    );
    $sort_column = $sort_columns[$sort];

    $order = isset($_GET['order']) && $_GET['order'] === 'desc' ? 'DESC' : 'ASC';

    // Lấy tổng số lượng bản ghi
    $sql_count = "SELECT COUNT(*) AS total FROM userinformation WHERE 1=1 $where_clause";
    $result_count = $connection->query($sql_count);
    $row_count = $result_count->fetch_assoc();
    $total_records = $row_count['total'];

    // Tính toán số lượng trang
    $total_pages = ceil($total_records / $limit);

    $sql = "SELECT * FROM userinformation WHERE 1=1 $where_clause ORDER BY $sort_column $order LIMIT $limit OFFSET $offset";
    $result = $connection->query($sql);

    if (!$result) {
        die("Invalid query: " . $connection->error);
    }

    echo "<table class='table'>";
    echo "<thead>";
    echo "<tr>";
    echo "<th><a href='?sort=id'>ID</a></th>";
    echo "<th><a href='?sort=name'>Tên</a></th>";
    echo "<th><a href='?sort=birthday&order=asc'>Ngày Sinh ↑</a> | <a href='?sort=birthday&order=desc'>↓</a></th>";
    echo "<th><a href='?sort=gender'>Giới Tính</a></th>";
    echo "<th><a href='?sort=height&order=asc'>Chiều Cao ↑</a> | <a href='?sort=height&order=desc'>↓</a></th>";
    echo "<th><a href='?sort=weight&order=asc'>Cân Nặng ↑</a> | <a href='?sort=weight&order=desc'>↓</a></th>";
    echo "<th><a href='?sort=city'>Quê Quán</a></th>";
    echo "<th><a href='?sort=score&order=asc'>Điểm Thi ↑</a> | <a href='?sort=score&order=desc'>↓</a></th>";
    echo "</tr>";
    echo "</thead>";
    echo "<tbody>";

    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['ID'] . "</td>";
        echo "<td>" . $row['Ten'] . "</td>";
        echo "<td>" . $row['NgaySinh'] . "</td>";
        echo "<td>" . $row['GioiTinh'] . "</td>";
        echo "<td>" . $row['ChieuCao'] . "</td>";
        echo "<td>" . $row['CanNang'] . "</td>";
        echo "<td>" . $row['QueQuan'] . "</td>";
        echo "<td>" . $row['DiemThi'] . "</td>";
        echo "</tr>";
    }

    echo "</tbody>";
    echo "</table>";

    // Hiển thị phân trang
    echo "<div class='pagination'>";
    if ($total_pages > 1) {
        for ($i = 1; $i <= $total_pages; $i++) {
            echo "<a href='?page=$i";
            // Giữ các tham số sort và order khi chuyển trang
            if (isset($_GET['sort'])) {
                echo "&sort=" . $_GET['sort'];
            }
            if (isset($_GET['order'])) {
                echo "&order=" . $_GET['order'];
            }
            echo "'";
            if ($page == $i) {
                echo " class='active'";
            }
            echo ">$i</a>";
        }
    }
    echo "</div>";

    $connection->close();
    ?>

  </div>

</body>

</html>