<?php
    include 'config.php';

    error_reporting(0);
 
    session_start();
    
    if (isset($_SESSION['username'])) {
        header("Location: berhasil_login.php");
    }
    
    if (isset($_POST['submit'])) {
        $email = $_POST['email'];
        $password = md5($_POST['password']);
    
        $sql = "SELECT * FROM tb_login WHERE user='$email' AND password='$password'";
        $result = mysqli_query($db, $sql);
        if ($result->num_rows > 0) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['user'];
            header("Location: berhasil_login.php");
        } else {
            echo "<script>alert('Email atau password Anda salah. Silahkan coba lagi!')</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=	, initial-scale=1.0">
	<title>Penjualan - Login Page</title>

	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

	<style>	
		body {
		    font-family: Georgia, times new roman, Times, Merriweather, Cambria, Times, serif;
		    font-weight: 300;
		    font-size: 16px;
		    line-height: 2;
		    background: url(https://www.ahmadsyarifudin.id/template/2020/assets/images/bg/body-bg.png) no-repeat center;
		    /* color: #777; */
		    color: #4d4b4b;
		}
		.centerDiv {
			height: 100vh;
			width: 100%;
		}
	</style>	
</head>
<body>
	<div class="container-fluid">	
		<div class="row centerDiv">
			<div class="col-sm-12 my-auto">
				<div class="card border-0">
				  <div class="row">
				    <div class="col-md-4"></div>
				    <div class="col-md-4">
				      <div class="card-body">
				      	<div class="mb-5 text-center">
				      		<h2 class="h5 mt-5">LOGIN</h2>
				      	</div>
                          <form action="" method="POST" class="login-email">
                            <div class="input-group">
                                <input type="email" placeholder="Email" class="form-control" name="email" value="<?php echo $email; ?>" required>
                            </div>
                            <div class="input-group">
                                <input type="password" placeholder="Password" class="form-control" name="password" value="<?php echo $_POST['password']; ?>" required>
                            </div>
                            <div class="input-group">
                                <button name="submit" class="btn btn-primary w-100">Login</button>
                            </div>
                        </form>
				      </div>
				    </div>
                    <div class="col-md-4"></div>
				  </div>
				</div>
			</div>
		</div>
	</div>	

	<!-- JavaScript Bundle with Popper -->
	<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> -->
</body>
</html>
