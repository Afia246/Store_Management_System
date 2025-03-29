<?php
    require('connection.php');
    session_start();
    $user_first_name = $_SESSION['user_first_name'];
    $user_last_name = $_SESSION['user_last_name'];

    if (!empty($user_first_name) && !empty($user_last_name)) {
?>

<?php
    $sql = "SELECT * FROM category";
    $query = $conn->query($sql);
    $total_category= mysqli_num_rows($query );
    $sql_product = "SELECT * FROM product";
    $query_product = $conn->query($sql_product);
    $total_product= mysqli_num_rows($query_product );
    $sql_store_product = "SELECT * FROM store_product";
    $query_store_product = $conn->query($sql_store_product);
    $total_store_product= mysqli_num_rows($query_store_product );
    $sql_spend_product = "SELECT * FROM spend_product";
    $query_spend_product = $conn->query($sql_spend_product);
    $total_spend_product= mysqli_num_rows($query_spend_product );


    $sql_product_name = "SELECT * FROM product";
$query_product_name = $conn->query($sql_product_name);

$data_list = array();

while ($data1 = mysqli_fetch_assoc($query_product_name)) {
    $product_id = $data1['product_id'];
    $product_name = $data1['product_name'];
    $data_list[$product_id] = $product_name;
}


?>
<!--store product table show-->
<?php
    $sql_store_product1 = "SELECT * FROM store_product ORDER BY store_product_id DESC LIMIT 10";
    $query_store_product1 = $conn->query($sql_store_product1);
  
?>
<?php
    $sql_spend_product1 = "SELECT * FROM spend_product ORDER BY spend_product_id DESC LIMIT 10";
    $query_spend_product1 = $conn->query($sql_spend_product1);
  
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="img/logo/logo.png" rel="icon">
  <title>Store MS Dashboard</title>
  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
  <link href="css/ruang-admin.min.css" rel="stylesheet">
</head>

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
   <?php include 'sidebar.php'?>
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        <?php include('topbar.php');?>
        <!-- Topbar -->

        <!-- Container Fluid-->
        <div class="container-fluid" id="container-wrapper">
          <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            <ol class="breadcrumb">
              <li class="breadcrumb-item"><a href="./">Home</a></li>
              <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
          </div>

          <div class="row mb-3">
            <!-- Earnings (Monthly) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Category</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_category?></div>
                      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-calendar fa-2x text-primary"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Earnings (Annual) Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Product</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_product?></div>
                    
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-shopping-cart fa-2x text-success"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- New User Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Store Product</div>
                      <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800"><?php echo $total_store_product?> </div>
              
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-users fa-2x text-info"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Pending Requests Card Example -->
            <div class="col-xl-3 col-md-6 mb-4">
              <div class="card h-100">
                <div class="card-body">
                  <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                      <div class="text-xs font-weight-bold text-uppercase mb-1">Total Spend Product</div>
                      <div class="h5 mb-0 font-weight-bold text-gray-800"><?php echo $total_spend_product?></div>
      
                    </div>
                    <div class="col-auto">
                      <i class="fas fa-comments fa-2x text-warning"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            
           <!-- Include Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



<!-- Latest Store Product -->
<div class="col-xl-6 col-lg-7 mb-4">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Latest Store Product</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sl = 0;
                        $store_product_names = [];
                        $store_product_quantities = [];
                        while ($data = mysqli_fetch_assoc($query_store_product1)) {
                            $store_product_id = $data['store_product_id'];
                            $store_product_name = $data['store_product_name'];
                            $store_product_quantity = $data['store_product_quantity'];
                            $store_product_entry_date = $data['store_product_entry_date'];
                            $sl++;
                            $store_product_names[] = isset($data_list[$store_product_name]) ? $data_list[$store_product_name] : 'Unknown';
                            $store_product_quantities[] = $store_product_quantity;
                    ?>
                    <tr>
                        <td><?php echo $sl; ?></td>
                        <td><?php echo $store_product_names[$sl - 1]; ?></td>
                        <td><?php echo $store_product_quantity; ?></td>
                        <td><?php echo $store_product_entry_date; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <canvas id="storeProductChart"></canvas>
        </div>
    </div>
</div>

<!-- Latest Spend Product -->
<div class="col-xl-6 col-lg-5">
    <div class="card">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Latest Spend Product</h6>
        </div>
        <div class="table-responsive">
            <table class="table align-items-center table-flush">
                <thead class="thead-light">
                    <tr>
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Quantity</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                        $sl = 0;
                        $spend_product_names = [];
                        $spend_product_quantities = [];
                        while ($data = mysqli_fetch_assoc($query_spend_product1)) {
                            $spend_product_id = $data['spend_product_id'];
                            $spend_product_name = $data['spend_product_name'];
                            $spend_product_quantity = $data['spend_product_quantity'];
                            $spend_product_entry_date = $data['spend_product_entry_date'];
                            $sl++;
                            $spend_product_names[] = isset($data_list[$spend_product_name]) ? $data_list[$spend_product_name] : 'Unknown';
                            $spend_product_quantities[] = $spend_product_quantity;
                    ?>
                    <tr>
                        <td><?php echo $sl; ?></td>
                        <td><?php echo $spend_product_names[$sl - 1]; ?></td>
                        <td><?php echo $spend_product_quantity; ?></td>
                        <td><?php echo $spend_product_entry_date; ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="card-body">
            <canvas id="spendProductChart"></canvas>
        </div>
    </div>
</div>

<!-- Chart.js Script -->
<script>
  
    // Data for Store Products
    var storeProductNames = <?php echo json_encode($store_product_names); ?>;
    var storeProductQuantities = <?php echo json_encode($store_product_quantities); ?>;

    // Store Product Chart
    var ctx1 = document.getElementById('storeProductChart').getContext('2d');
    new Chart(ctx1, {
        type: 'bar',
        data: {
            labels: storeProductNames,
            datasets: [{
                label: 'Quantity',
                data: storeProductQuantities,
                backgroundColor: 'rgba(54, 162, 235, 0.6)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });

    // Data for Spend Products
    var spendProductNames = <?php echo json_encode($spend_product_names); ?>;
    var spendProductQuantities = <?php echo json_encode($spend_product_quantities); ?>;

    // Spend Product Chart
    var ctx2 = document.getElementById('spendProductChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: spendProductNames,
            datasets: [{
                label: 'Quantity',
                data: spendProductQuantities,
                backgroundColor: 'rgba(255, 99, 132, 0.6)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

             
          </div>
          <!--Row-->

          

          <!-- Modal Logout -->
          <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabelLogout"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabelLogout">Ohh No!</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p>Are you sure you want to logout?</p>
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
                  <a href="login.html" class="btn btn-primary">Logout</a>
                </div>
              </div>
            </div>
          </div>

        </div>
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      <footer class="sticky-footer bg-white">
        <div class="container my-auto">
          <div class="copyright text-center my-auto">
            <span>copyright &copy; <script> document.write(new Date().getFullYear()); </script> - developed by
              <b><a href="" target="_blank">Afia Adilah,Sanaf Salehin,Sayeb Mohaimin</a></b>
            </span>
          </div>
        </div>
      </footer>
      <!-- Footer -->
    </div>
  </div>

  <!-- Scroll to top -->
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>

  <script src="vendor/jquery/jquery.min.js"></script>
  <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="vendor/jquery-easing/jquery.easing.min.js"></script>
  <script src="js/ruang-admin.min.js"></script>
  <script src="vendor/chart.js/Chart.min.js"></script>
  <script src="js/demo/chart-area-demo.js"></script>  
</body>

</html>
<?php
    } else {
        // Redirect to login page if session variables are not set
        header('Location: login.php');
    }
?>
