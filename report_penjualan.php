<?php 
include 'config.php';

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$sql = "SELECT
count(*) as number,
CONCAT(b.document_code,' - ',	b.document_number) as document_header,
a.`user`,
b.sub_total*count(*) as total,
DATE_FORMAT(a.date,'%d %M %Y') as date_buy,
c.product_name 
FROM
tb_transaction_header a
INNER JOIN tb_transaction_detail b ON a.document_number = b.document_number
JOIN tb_product c ON b.product_code = c.product_code 
WHERE
a.USER = 'erwin@gmail.com' 
AND ( a.flag_checkout = 0 OR a.flag_checkout IS NULL )";
$result = mysqli_query($db, $sql);
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
              <h4>Report Penjualan</h4>
            
              <table class="table">
                <thead>
                    <tr>
                        <td>Transaction</td>
                        <td>User</td>
                        <td>Total</td>
                        <td>Date</td>
                        <td>Item</td>
                    </tr>
                </thead>
                <tbody>
                   <?php while($data = mysqli_fetch_assoc($result)){ ?>
                    <tr>
                        <td><?php echo $data["document_header"] ?></td>
                        <td><?php echo $data["user"] ?></td>
                        <td><?php echo 'Rp. '.number_format($data["total"], 0, '', '.'). ' ,-' ?></td>
                        <td><?php echo $data["date_buy"] ?></td>
                        <td><?php echo $data["product_name"] ?></td>
                    </tr>
                    <?php } ?>
                </tbody>
              </table>
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
