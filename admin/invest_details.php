<?php include_once ('header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

include_once ('side_content.php');?>
<?php
include ('../includes/db_connect.php');


if(!isset($_GET['investment_id'])){
	echo "<script> window.location.href='invest.php';</script>";
	exit();
}else{
	$investment_id = $_GET['investment_id'];
}

 								$result_order = $db->query("SELECT * FROM investment WHERE investment_id=$investment_id ");
						
								while($order = $result_order->fetch_assoc()): 
									 $user_id = $order['user_id'];
									 $fullname = $order['fullname'];
									 $crop_title = $order['crop_title'];
									 $investment_level = $order['investment_level'];
									 $amount_invested = $order['amount_invested'];
									 $invest_status = $order['invest_status'];
									 $invest_date = $order['invest_date'];
								
								endwhile; 


								$result_user = $db->query("SELECT * FROM user_table WHERE user_id=$user_id ");
						
								while($user = $result_user->fetch_assoc()): 
									 $email = $user['email'];
									 $phone_number = $user['phone_number'];
									 $address = $user['address'];
									 $account_number = $user['account_number'];
									 $account_name = $user['account_name'];
									 $bank = $user['bank'];							
								
								endwhile; 



					if(isset($_POST['send_mail'])){

						$message_body = $_POST['message_body'];
						$message_body = $db->real_escape_string($message_body);

						$message_subject = $_POST['message_subject'];
						$message_subject = strip_tags($message_subject);
						$message_subject = $db->real_escape_string($message_subject);

						if(empty($message_body) || empty($message_subject)){
							echo "<script> alert('Please no empty field');</script>";
						}else{
				
				$query = $db->query("INSERT INTO messages (firstname, lastname, email, subject, message, date) VALUES('$first_name', '$last_name','$email', '$message_subject','$message_body', CURRENT_TIMESTAMP)");
				if($query){

					 //Load Composer's autoloader
					 require 'vendor/autoload.php';
					 //Instantiation and passing `true` enables exceptions
					 $mail = new PHPMailer(true);
				 try {
					 $mail->isSMTP();                                            //Send using SMTP
					 $mail->Host       = 'mail.maxhubpharmacy.com';                     //Set the SMTP server to send through
					 $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
					 $mail->Username   = 'customercare@maxhubpharmacy.com';                     //SMTP username
					 $mail->Password   = 'pharmikeh6';                               //SMTP password
					 $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
					 $mail->Port       = 587;                                    //TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
				 
					 //Recipients
					 $mail->setFrom('customercare@maxhubpharmacy.com', 'Maxhub Pharmacy');
					   $mail ->AddAddress($email);
					   //Name is optional
					 $mail->addReplyTo('customercare@maxhubpharmacy.com', 'Maxhub Pharmacy');
				   
				 
					 //Content
					 $mail->isHTML(true);                                  //Set email format to HTML
					 $mail->Subject = $message_subject;
					 $mail->Body    = $message_body;
	   
					 $mail->send();
					 
					 echo "<script> 
					 alert('Message Sent');
					 </script>";	
				 } catch (Exception $e) {
				   
					 echo "<script> 
					 alert('Message Not Sent ');
					 </script>";	
				 }
				}else{
					echo "<script>alert('Message Not Sent '); </script>";
				}
			}

		}	
								
	   if(isset($_GET['paid'])){
				
			 $paid= $db->query("UPDATE `investment` SET `invest_status` = 'Paid' WHERE `investment`.`investment_id`= $investment_id");

			if($paid){
				echo "<script> alert('Payment Confirmed');
				window.location.href='?investment_id=$investment_id';	</script>";
			}else{
			    	echo "<script> alert('Not Working');
						window.location.href='?investment_id=$investment_id';	</script>";
			}
	    }
		 
		  if(isset($_GET['deactivate'])){
			 
			 $r1= $db->query("UPDATE `investment` SET `invest_status` = 'Closed' WHERE `investment`.`investment_id`= $investment_id");
			if($r1){
				echo "<script> alert('Investment Closed'); window.location.href='?investment_id=$investment_id';</script>";
			}
		 }

		 if(isset($_GET['activate'])){
			 
			$r1= $db->query("UPDATE `investment` SET `invest_status` = 'Active' WHERE `investment`.`investment_id`= $investment_id");
		   if($r1){
			   echo "<script> alert('Investment Activated'); window.location.href='?investment_id=$investment_id';</script>";
		   }
		}
		 
		
?>


<style>
.order-details {
  position: relative;
  padding: 0px 30px 30px;
  border-right: 1px solid #E4E7ED;
  border-left: 1px solid #E4E7ED;
  border-bottom: 1px solid #E4E7ED;
}

.order-details:before {
  content: "";
  position: absolute;
  left: -1px;
  right: -1px;
  top: -15px;
  height: 30px;
  border-top: 1px solid #E4E7ED;
  border-left: 1px solid #E4E7ED;
  border-right: 1px solid #E4E7ED;
}

.order-summary {
  margin: 15px 0px;
}

.order-summary .order-col {
  display: table;
  width: 100%;
}

.order-summary .order-col:after {
  content: "";
  display: block;
  clear: both;
}

.order-summary .order-col>div {
  display: table-cell;
  padding: 10px 0px;
}

.order-summary .order-col>div:first-child {
  width: calc(100% - 150px);
}

.order-summary .order-col>div:last-child {
  width: 150px;
  text-align: right;
}

.order-summary .order-col .order-total {
  font-size: 24px;
  color: #D10024;
}

.order-details .payment-method {
  margin: 30px 0px;
}

.order-details .order-submit {
  display: block;
  margin-top: 30px;
}
</style>
 <script>
	   function printContent(el){
		   var restorepage = document.body.innerHTML;
		   var printContent = document.getElementById(el).innerHTML;
		   document.body.innerHTML = printContent;
		   window.print();
		   document.body.innerHTML = restorepage
	   }
	
	</script> 
     
	 	 <div class="row">
                    <div class="col-md-12">
                        <h2>ORDER DETAILS</h2>
                    </div>
     </div>
	<div class="row">
       
		<!-- SECTION -->
		<div class="section" style="background:#ccc;">
		<br>
<br>
<br>
<br>
			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row" id="div1">
				    <div class="col-md-2"></div>
					<div class="col-md-10" style="background:#ffffff;">
						<div class="container">
							<div class="row">
								<div class="col-md-12"> 
										<div class="section-title text-left">
												<h3 class="title">Investment ID = <b>#<?=$investment_id?></b></h3>
												<h4>  Investment Date: <?=$invest_date?></h4>
										</div>
								</div>
							</div>
							<hr>
							<div class="row">
								<div class="col-md-12"> 
										<div class="section-title text-center">
												<h5 class="title">Investment Detail</h5>
											</div>
										<div class="row">
											<div class="col-md-6">
											<div class="section-title">
													
														<p>Investor's Name: <b><?=$fullname?></b> </p>
														<p>Investor's Email: <b><?=$email?></b> </p>
														<p>Investor's Phone Number: <b><?=$phone_number?></b> </p>
														<p>Investor's Address: <b><?=$address?></b> </p>
														<p>Bank Name: <b><?=$bank?></b> </p>
														<p>Account Name: <b><?=$account_name?></b> </p>
														<p>Account Number: <b><?=$account_number?></b> </p>

														<h4>Investment Status: <b><?php if($invest_status == ''){?>
																					<button class="btn btn-danger" disabled>Not Paid</button>
																				<?php }else{ if($invest_status == 'Active'){ ?>  
																					<button class="btn btn-success" disabled>Active</button>
																				<?php }if($invest_status == 'Expired'){ ?> 
																					<button class="btn btn-danger" disabled>Expired</button>
																				<?php }if($invest_status == 'Not Active'){ ?> 
																					<button class="btn btn-danger" disabled>Not Active</button>
																				<?php } } ?> </b></h4>


												</div>
											</div>	
											<div class="col-md-6">
												<div class="section-title">
													<h4>Crop Details</h4>
														<p>Crops Name: <b><?=$crop_title?></b> </p>
														<p>Amount Invested: <b><?=$amount_invested?></b> </p>
														<p>Investment Date: <b><?=$invest_date?></b> </p>
												</div>
											</div>	
										</div>								 
								</div>
							</div>
					 <hr>
				
				<!-- /row -->
			</div>
			<!-- /container -->
			<br>
			<div class="container">
				    <div class="row">
					        <div class="col-md-2"></div>
							<div class="col-md-8">
							
							<?php if($invest_status == ''){?>
								<a href="?investment_id=<?=$investment_id?>&paid" class="btn btn-danger" > Confirm Payment</a>
							<?php }else{?>  
								<button class="btn btn-default" disabled>Paid</button>
								<?php if($invest_status == 'Active'){?>
									<a href="?investment_id=<?=$investment_id?>&deactivate" class="btn btn-danger" >Close Investment</a>
								<?php }else{?> 
									<?php if($invest_status == 'Closed'){?>
										<a href="" class="btn btn-danger" disabled>Closed Investment</a>
									<?php }else{?> 
										<a href="?investment_id=<?=$investment_id?>&activate" class="btn btn-success" >Activate Investment</a>
									<?php }?>  
								<?php }?>
							<?php }?>  
							
								
								<button class="btn btn-success" data-toggle="modal" data-target="#sendMail">Send A Message</button>
								
								<button class="btn btn-primary" onclick="printContent('div1')">Print</button> 
					        </div>
							<br><br><br><br>
		             </div>
            </div>
		</div>
		
		
		
		
		<!-- /SECTION -->
<br>
<br>

           
    </div>		
                <!-- /. ROW  -->
	 
	 <?php include_once ('footer.php');?>
	 
	 
	 		   <!-- Modal -->
 <div id="sendMail" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Send Mail</h4>
      </div>
      <div class="modal-body">
       
	            <div class=' panel-primary' style='padding:10px;'>
                            <form action='' method='post' enctype='multipart/form-data'>
							     <div class='panel-body'>  
					                 <div class='input-group'>                      
                                         <label> Subject: <input type='text' name='message_subject' class='form-control' required /></label>
						             </div>
									<br><br>
                                     <div class='input-group'>
                                         <label> Message Body: <textarea name='message_body' class='form-control' cols='80' rows='5' required></textarea></label> 
										 <script>
												CKEDITOR.replace( 'message_body' );
											</script>
                                     </div>

				                  </div>
                                  <div class='panel-footer'>
                                      <div class='input-group'>
                                         <input type='submit' name='send_mail' value='Send' class='btn btn-primary form-control' />
                                      </div>
                                  </div>
                            </form>	 
                      </div>
	   
      </div>
    </div>

  </div>
</div>

    