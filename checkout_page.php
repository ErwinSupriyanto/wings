<?php 
include 'config.php';

session_start();
 
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
}

$user = $_SESSION["username"];

$sql = "SELECT
count(*) as numbers,
b.document_code,
b.document_number,
b.quantity,
b.sub_total,
b.unit,
c.price,
b.product_code,
c.product_name,
c.discount
FROM
tb_transaction_header a
INNER JOIN tb_transaction_detail b ON a.document_number = b.document_number
JOIN tb_product c ON b.product_code=c.product_code
WHERE a.user = '$user' AND ( a.flag_checkout = 0 OR a.flag_checkout IS NULL )";
$result = mysqli_query($db, $sql);
?>
 
 <!DOCTYPE html>
    <html lang="en">
      <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Penjualan</title>
        <!-- bootstrap 5 css -->
        <script src="https://code.jquery.com/jquery-3.6.3.js" integrity="sha256-nQLuAZGRRcILA+6dMBOvcRh5Pe310sBpanc6+QBmyVM=" crossorigin="anonymous"></script>
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
              <h4>Checkout Page</h4>
            
              <?php while($data = mysqli_fetch_assoc($result)){ ?>
                <div class="row">
                    <div class="col sm-12">
                        <div class="row">
                            <div class="col sm-2">
                                <img class="image" src="background.jpg">                                
                            </div>
                            <div class="col sm-10">
                                <label><?php echo $data['product_name']; ?></label><br>
                                <div class="row g-3 align-items-center">
                                  <div class="col-auto col-lg-1">
                                    <input type="text" min="1" max="3" id="counter" class="form-control" aria-describedby="counterNumber" value="<?php echo $data["numbers"]; ?>">
                                  </div>
                                  <div class="col-auto">
                                    <span id="counterNumber" class="form-text">
                                      <?php echo $data["unit"] ?>
                                    </span>
                                  </div>
                                </div>
                                <?php if($data['discount'] != ""){ ?>
                                    <?php $price = ($data['discount']/100)*$data['price']; ?>
                                <?php }else{ ?>
                                    <?php $price = $data['price']; ?>
                                <?php } ?>
                                <input type="hidden" id="pricetotal" value="<?php echo $data['price']-$price; ?>">
                                <label class="subtotal">Subtotal : Rp. <?php echo number_format(($data['price']-$price)*$data["numbers"], 0, '', '.'); ?>,-</label>
                            </div>
                        </div>
                    </div>
                </div>
              <?php } ?>
              <div class="row">
                <div class="col sm-12 text-center">
                    <span>TOTAL : Rp. ,-</span></br>
                    <button name="submit" class="btn btn-primary">CONFIRM</button>
                </div>
              </div>
            </div>
          </div>
        </div>
    
        <script>
          $("#counter").keypress(function(e){
            var charCode = (event.which) ? event.which : event.keyCode
            if ((charCode >= 48 && charCode <= 57)
            || charCode == 46
            || charCode == 44)
            

            alert($(this).val());
            return true;
            return false;

          });

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
