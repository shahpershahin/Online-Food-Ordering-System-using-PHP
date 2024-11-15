<?php 
include_once 'config/Database.php';
include_once 'class/Customer.php';

$database = new Database();
$db = $database->getConnection();

$customer = new Customer($db);

if($customer->loggedIn()) {	
	header("Location: index.php");	
}

$loginMessage = '';
if($_SERVER['REQUEST_METHOD'] == 'POST'):
if(!empty($_POST["login"]) && !empty($_POST["email"]) && !empty($_POST["password"])) {	
	$customer->email = $_POST["email"];
	$customer->password = $_POST["password"];	
	if($customer->login()) {
		header("Location: index.php");	
	} else {
		$loginMessage = 'Invalid login! Please try again.';
	}
} else {
	$loginMessage = 'Fill all fields.';
}
endif;
include('inc/header.php');
?>
<?php include('inc/container.php');?>
<style>
html,
body,
body>.container {
    height: 98%;
    width: 100%;
}
</style>
<div class="content h-100 d-flex w-100 justify-content-center align-items-center">
    <div class="col-lg-4 col-md-5 col-sm-10 col-xs-12">
        <div class="card card-info rounded-0">
            <div class="card-header">
                <div class="card-title h4 mb-0 fw-bold text-center">Customer Log In</div>
            </div>
            <div style="" class="card-body">
                <?php if ($loginMessage != '') { ?>
                <div id="login-alert" class="alert alert-danger col-sm-12 rounded-0 py-1"><?php echo $loginMessage; ?></div>
                <?php } ?>
				<?php if (isset($_SESSION['success'])) { ?>
                <div id="login-alert" class="alert alert-success col-sm-12 rounded-0 py-1"><?php echo $_SESSION['success']; ?></div>
                <?php 
					unset($_SESSION['success']);
					} 
				?>
                <form id="loginform" class="form-horizontal" role="form" method="POST" action="">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="email" name="email"
                            value="<?php if(!empty($_POST["email"])) { echo $_POST["email"]; } ?>" placeholder="Email" required>
                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" id="password" name="password"
                            value="<?php if(!empty($_POST["password"])) { echo $_POST["password"]; } ?>" placeholder="Password" required>
                        <span class="input-group-text"><i class="fa fa-lock"></i></span>
                    </div>
                    <div class="text-center">
                        <div class="col-sm-12 controls">
                            <input type="submit" name="login" value="Login" class="btn btn-primary rounded-0">
                            <a href="./register.php" class="btn btn-light bg-gradient border rounded-0">Sign Up</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include('inc/footer.php');?>