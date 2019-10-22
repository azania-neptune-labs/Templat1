
<?php

session_start();
// variable declaration
$_SESSION['success'] = "";

require_once('connection.php');

//Save Product
if(isset($_POST['SaveProduct'])){
	// receive all input values from the form
	$psName = mysqli_real_escape_string($con, $_POST['psName']);
	$pCode = mysqli_real_escape_string($con, $_POST['pCode']);
	$psDescription = mysqli_real_escape_string($con, $_POST['psDescription']);
	$pPrice = mysqli_real_escape_string($con, $_POST['pPrice']);
	$pQuantity = mysqli_real_escape_string($con, $_POST['pQuantity']);
	$pCategory = mysqli_real_escape_string($con, $_POST['pCategory']);
	
	$image = $_FILES["image"]["name"];
	
	move_uploaded_file($_FILES["image"]["tmp_name"],"UpLoadedImages/" . $_FILES["image"]["name"]);
	
	//Check If the Product Already exist
	$CheckProductQuery = "SELECT * FROM product 
				WHERE productName='$psName' 
				AND productAmount = '$pPrice'
				AND productDesciption = '$psDescription'
				AND productCode = '$pCode '
				AND productQuantity = '$pQuantity'
				AND productCategory = '$pCategory'
				";
	$Presults = mysqli_query($con, $CheckProductQuery);
	
	if(mysqli_num_rows($Presults) == 0){
		$InsertQuery = "INSERT INTO `product`(`productName`, `productAmount`, `productDesciption`, `productCode`, `productQuantity`, `productCategory`, `productImage`) 
						VALUES ('$psName','$pPrice','$psDescription','$pCode','$pQuantity','$pCategory', '$image')";
						
		$succesPResults = mysqli_query($con, $InsertQuery);
		if($succesPResults){
			echo "Prodyct inserted Successfully ";
			header("Location:index.php");
		}else{
			//Error Here
			echo "Error", mysqli_error($con);
		}
		
	}else{
		//Write Your Error Here
		echo "Error", mysqli_error($con);
	}
				
}

//Save Company

if(isset($_POST['SaveCompany'])){
	// receive all input values from the form
	$companyName = mysqli_real_escape_string($con, $_POST['companyName']);
	$TimeInOperation = mysqli_real_escape_string($con, $_POST['TimeInOperation']);
	$companyCategory = mysqli_real_escape_string($con, $_POST['companyCategory']);
	$TaxNumber = mysqli_real_escape_string($con, $_POST['TaxNumber']);
	$companyNumber = mysqli_real_escape_string($con, $_POST['companyNumber']);
	$BEElevel = mysqli_real_escape_string($con, $_POST['BEElevel']);
	
	//Check If the company exist
	$CheckCompanyQuery = "SELECT * FROM `tblcompany` 
							WHERE companyName = '$companyName'
							AND companyTimeOperation = '$TimeInOperation'
							AND companyCategory = '$companyCategory'
							AND companyTaxNumber = '$TaxNumber'
							AND companyNumber = '$companyNumber'
							AND companyBEELevel = '$BEElevel'
							";
	$Cresults = mysqli_query($con, $CheckCompanyQuery);
	
	if(mysqli_num_rows($Cresults) == 0){
		//echo "SaveCompany 1";
		$SaveCompanyQuery = "INSERT INTO `tblcompany`(`companyName`, `companyTimeOperation`, `companyCategory`, `companyTaxNumber`, `companyNumber`, `companyBEELevel`) 
							VALUES ('$companyName','$TimeInOperation','$companyCategory','$TaxNumber','$companyNumber','$BEElevel')";
		$succesCResults = mysqli_query($con, $SaveCompanyQuery);
		
		if($succesCResults){
			//echo "SaveCompany 2";
			//Success Message here
		}else{
			//Error Here
			echo "Error", mysqli_error($con);
		}
		
	}
}


//sign Up

	if(isset($_POST['Sign_Up'])){
		// receive all input values from the form
		$FirstName = mysqli_real_escape_string($con, $_POST['USER_NAM']);
		$LastName = mysqli_real_escape_string($con, $_POST['USER_SURNAME']);
		$EMAIL = mysqli_real_escape_string($con, $_POST['EMAIL']);
		$UserType = mysqli_real_escape_string($con, $_POST['UserType']);
		$userAddress = mysqli_real_escape_string($con, $_POST['userAddress']);
		$Phone_Num = mysqli_real_escape_string($con, $_POST['Phone_Num']);
		$USER_PASSWORD = mysqli_real_escape_string($con, $_POST['USER_PASSWORD']);
		$CONFIRM_PASSWORD = mysqli_real_escape_string($con, $_POST['CONFIRM_PASSWORD']);
		
		
		
		//Check If the company exist
		$SQL = "SELECT FirstName, LastName, email, UserType, phone,user_password, user_address FROM  `userdetails`
								WHERE email = '$EMAIL'
								AND user_password = '$USER_PASSWORD'
								";
		$Cresults = mysqli_query($con, $SQL);
		
		if(mysqli_num_rows($Cresults) == 0){
			$SQL = "INSERT INTO `userdetails`(FirstName, LastName,phone, email, user_address, user_password, userType) 
								VALUES ('$FirstName','$LastName','$Phone_Num','$EMAIL','$userAddress', '$USER_PASSWORD', '$UserType')";

			$succesCResults = mysqli_query($con, $SQL);
			if($succesCResults){
						//send();
						echo "Successfully Registered", "Now you can login to the system using ur Email and Passwords.";
						//header("Location:login.php");
					} 
					else
					{
						echo 'Unable to send email. Please try again.';
					}
			}
			else
			{
				//Error Here
				echo "user already registered", mysqli_error($con);
			}
			
	}



//Login
if(isset($_POST['Login'])){
	// receive all input values from the form
	$EMAIL = mysqli_real_escape_string($con, $_POST['EMAIL']);
	$USER_PASSWORD = mysqli_real_escape_string($con, $_POST['USER_PASSWORD']);
	
	//Check If the company exist
	$SQL = "SELECT * FROM `userdetails` 
							WHERE email = '$EMAIL'
							";
	$Cresults = mysqli_query($con, $SQL);
	
	if(mysqli_num_rows($Cresults) > 0){
			echo "Successfully Logged in";
			header("Location:index.php");
		}
		else
		{
			//Error Here
			echo "Error", mysqli_error($con);
		}
		
}

//review
if(isset($_POST['send'])){
	// receive all input values from the form
	$name = mysqli_real_escape_string($con, $_POST['name']);
	$EMAIL = mysqli_real_escape_string($con, $_POST['email']);
	$message = mysqli_real_escape_string($con, $_POST['message']);
	$product_rating = mysqli_real_escape_string($con, $_POST['product_rating']);
	$proId = mysqli_real_escape_string($con, $_POST['storages']);

	//Check If the company exist
	$SQL = "SELECT * FROM `reviews` WHERE email = '$EMAIL'";
 //$sl= "select productId from product where product.productId= '$product_rating'";
	$Cresults = mysqli_query($con, $SQL);
	
	if(mysqli_num_rows($Cresults) == 0){
		$SQL = "INSERT INTO `reviews`(FirstName,email, REVIEW, PRODUCT_RATING ,ProductId) 
		VALUES ('$name','$EMAIL','$message','$product_rating','$proId')";

			$succesCResults = mysqli_query($con, $SQL);	
			if($succesCResults){
				echo "Successfully registered";
				echo sweetAlert("Atenção!", "As senhas digitadas não conferem.", "warning");
			}else{
				//Error Here
				echo "Error", mysqli_error($con);
				echo "Not registered";
			}
		
		}
					
}
// function send()
// {
// 		//include PHPMailerAutoload.php
// 		// require 'libphp-phpmailer/PHPMailerAutoload.php';
// 		//create an instance of PhpMailer

// 		require 'libphp-phpmailer/class.phpmailer.php';
// 		require 'libphp-phpmailer/class.smtp.php';
// 		$mail = new PhpMailer;

// 		//set a host
// 		$mail->Host = 'smtp.gmail.com';

// 		//enable SMTP
// 		$mail-> isSMTP();

// 		//set authentication to true
// 		$mail->SMTPAuth = true;

// 		//set login details for Gmail (sender) 
// 		$mail->Username = 'youremail/company email';
// 		$mail->Password = 'email password';

// 		//set type of protection
// 		$mail->SMTPSecure = 'ssl';//or u can also use tls

// 		//set a port
// 		$mail->Port = 465; //or 587 if tls

// 		//set who is sending the email
// 		$mail->setFrom(''.'youremail/company email'.'');
// 		//$mail->SetForm('','leboh');

// 		//set recipient where we are sending email
// 		$mail->AddAddress(''.$email.'');

// 		$mail->isHTML(true);
// 		//set subject
// 		$mail->Subject='Change password';
// 		//set body
// 		$mail->Body ="Click the link below to change password 
// 		\n    \nThank you\n   
//     \nKind Regards\n\n";
    
//     if(!$mail->send()) {
//       echo "<script type=\"text/javascript\">window.alert('Email is not Sent.');
// 	  window.location.href = '/master%20Page/ForgotPass.html';</script>"; 

// 	  echo "<script type=\"text/javascript\">window.alert('Email error:. $mail->ErrorInfo. ');
// 	  window.location.href = '/master%20Page/ForgotPass.html'; </script>";
//     } else{
// 	   echo "<script type=\"text/javascript\">window.alert('Email is sent successfully.');
// 	   window.location.href = '/master%20Page/ForgotPass.html';
//        </script>"; 
//     }
// }




// use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\Exception;
// use PHPMailer\PHPMailer\SMTP;
// function send()
//  {
// 		// Import PHPMailer classes into the global namespace
// 		// These must be at the top of your script, not inside a function
		

// 		// Load Composer's autoloader
// 		require 'phpmailer/vendor/phpmailer/phpmailer/src/PHPMailer.php';
// 		require 'phpmailer/vendor/phpmailer/phpmailer/src/SMTP.php';
// 	    require 'C:/xampp\htdocs/stuff nje/BLACKBUYPHP/default/phpmailer/vendor/autoload.php';

// 		// Instantiation and passing `true` enables exceptions
// 		$mail = new PHPMailer(true);
// 		try {
// 			// $EMAIL = mysqli_real_escape_string($con, $_POST['EMAIL']);
// 			// $FirstName = mysqli_real_escape_string($con, $_POST['USER_NAM']);
// 			//Server settings
                          
// 			$mail->isSMTP();
// 			$mail->SMTPDebug = 2;
// 			$mail->Host = 'smtp.gmail.com';
// 			$mail->SMTPSecure = 'TLS';
// 			$mail->Port = 587;			
// 			$mail->SMTPAuth = true;
// 			$mail->Username = 'nathinkhoza96@gmail.com';
// 			$mail->Password = 'khoza@7474';
// 			$mail->setFrom(''.'nathinkhoza96@gmail.com'.'');
// 			$mail->addAddress('nathinkhoza96@gmail.com');

// 			$body= '<p><strong>Hello</strong> Thank you for using blackBuy</p>';
// 			// Content
// 			$mail->isHTML(true);                                  // Set email format to HTML
// 			$mail->Subject = 'sekunjalo mbhem';
// 			$mail->Body    = $body;
// 			$mail->AltBody = strip_tags($body);

// 			if(!$mail->send())
// 			{
// 				echo "Message could not be sent.";
// 			}
// 			else{
// 				echo 'Message has been sent';
// 			}
			
// 		} 
// 		catch (Exception $e) {
// 			echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
// 		}
//  }












?>
