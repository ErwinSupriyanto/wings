<?php 
include 'config.php';

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sql = "SELECT * FROM tb_product";
$result = mysqli_query($db, $sql);

if (isset($_POST['submit'])) {
  $product_name = $_POST['product_name'];
  $price = $_POST['price'];
  
  $sql = "SELECT COUNT(*) FROM tb_transaction_header";
  $result = mysqli_query($db, $sql);
  $row = $result->fetch_row();
  $user = $_SESSION['username'];
  if ($row[0] == 0) {
      $angka     = 1; // Nilai Proses
      $fzeropadded  = sprintf("%03d", $angka);
      $selectData   = " SELECT * FROM tb_product WHERE product_code='$product_name' ";
      $result = mysqli_query($db, $selectData);
      $row = $result->fetch_array(MYSQLI_NUM);

      $date = date('Y-m-d');

      $queryHeader =  " INSERT INTO tb_transaction_header (document_code, document_number, user, total, date) VALUES ('TRX', '$fzeropadded', '$user', '$price', '$date') ";
      $document_code = mysqli_query($db, $queryHeader);

      if( $document_code ) {
        $queryDetail =  " INSERT INTO tb_transaction_detail (document_code, document_number, product_code, price, quantity, unit, sub_total, currency) VALUES ('TRX', '$fzeropadded', '$product_name', '$price', 1, '$row[6]', '$price', '$row[3]') ";
        $document_detail = mysqli_query($db, $queryDetail);  
      }
  } else {
      $angka      = $row[0]+1;
      $fzeropadded  = sprintf("%03d", $angka);
      $selectData   = " SELECT * FROM tb_product WHERE product_code='$product_name' ";
      $result = mysqli_query($db, $selectData);
      $row = $result->fetch_array(MYSQLI_NUM);

      $date = date('Y-m-d');

      $queryInsert =  " INSERT INTO tb_transaction_header (document_code, document_number, user, total, date) VALUES ('TRX', '$fzeropadded', '$user', '$price', '$date') ";
      $document_code = mysqli_query($db, $queryInsert);

      if( $document_code ) {
        $queryDetail =  " INSERT INTO tb_transaction_detail (document_code, document_number, product_code, price, quantity, unit, sub_total, currency) VALUES ('TRX', '$fzeropadded', '$product_name', '$price', 1, '$row[6]', '$price', '$row[3]') ";
        $document_detail = mysqli_query($db, $queryDetail);  
      }
  }

  $sql = "SELECT * FROM tb_product";
  $result = mysqli_query($db, $sql);
}
?>
 
 <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Penjualan</title>
        <!-- bootstrap 5 css -->
        <link
          rel="stylesheet"
          href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0-alpha2/css/bootstrap.min.css"
          integrity="sha384-DhY6onE6f3zzKbjUPRc2hOzGAdEf4/Dz+WJwBvEYL/lkkIsI3ihufq9hk9K4lVoK"
          crossorigin="anonymous"
        />
        <!-- custom css -->
        <!-- <link rel="stylesheet" href="style.css" /> -->
        <link
          rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css"
        />
        <style>
          li {
            list-style: none;
            margin: 20px 0 20px 0;
          }
    
          a {
            text-decoration: none;
          }
    
          .sidebar {
            width: 250px;
            height: 100vh;
            position: fixed;
            margin-left: -300px;
            transition: 0.4s;
          }
    
          .active-main-content {
            margin-left: 250px;
          }
    
          .active-sidebar {
            margin-left: 0;
          }
    
          #main-content {
            transition: 0.4s;
          }

          .image{
            height:20vh;
            width:6vw;
          }
        </style>
      </head>
    
      <body>
        <div>
          <div class="sidebar p-4 bg-primary" id="sidebar">
            <h4 class="mb-5 text-white">Penjualan</h4>
            <li>
              <a class="text-white" href="berhasil_login.php">
                <i class="bi bi-fire mr-2"></i>
                Product List
              </a>
            </li>
            <li>
              <a class="text-white" href="checkout_page.php">
                <i class="bi bi-view-list mr-2"></i>
                Checkout Page
              </a>
            </li>
            <li>
              <a class="text-white" href="report_penjualan.php">
                <i class="bi bi-view-list mr-2"></i>
                Report Penjualan
              </a>
            </li>
            <li>
                <a class="text-white" href="logout.php">
                    <i class="bi-door-closed"></i>
                    Logout
                </a>
            </li>
          </div>
        </div>
        <div class="p-4" id="main-content">
          <button class="btn btn-primary" id="button-toggle">
            <i class="bi bi-list"></i>
          </button>
          <div class="card mt-5">
            <div class="card-body">
              <h4>Product List</h4>
            
              <?php while($data = mysqli_fetch_assoc($result)){ ?>
                <div class="row">
                    <div class="col sm-2">
                        <img class="image" src="background.jpg">
                    </div>
                    <div class="col sm-8">
                        <a href="product_detail.php/?product=<?php echo $data['product_code']; ?>"><?php echo $data['product_name']; ?></a><br>
                        <?php if($data['discount'] != ""){ ?>
                            <label><del><?php echo $data['price']; ?><del>,-</label><br>
                            <?php $price = ($data['discount']/100)*$data['price']; ?>
                        <?php }else{ ?>
                            <label><?php echo $data['price']; ?>,-</label><br>
                        <?php } ?>
                        <label><?php echo $data['price']-$price; ?>,-</label>
                    </div>
                    <div class="col sm-2">
                        <form action="" method="POST" class="login-email">
                            <input type="hidden" class="form-control" name="product_name" value="<?php echo $data['product_code']; ?>">
                            <input type="hidden" class="form-control" name="price" value="<?php echo $data['price']-$price; ?>">
                            <button name="submit" class="btn btn-primary">BUY</button>
                        </form>
                    </div>
                </div>
              <?php } ?>
              <div class="row">
                <div class="col sm-12 text-center">
                    <a href="checkout_page.php" class="btn btn-primary">CHECKOUT</a>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <script>
    
          // event will be executed when the toggle-button is clicked
          document.getElementById("button-toggle").addEventListener("click", () => {
    
            // when the button-toggle is clicked, it will add/remove the active-sidebar class
            document.getElementById("sidebar").classList.toggle("active-sidebar");
    
            // when the button-toggle is clicked, it will add/remove the active-main-content class
            document.getElementById("main-content").classList.toggle("active-main-content");
          });
    
        </script>
      </body>
    </html>
