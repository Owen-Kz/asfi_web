<?php 
  include_once ('header.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 include_once ('side_content.php');
 $count = 0;
  if(!isset($_GET['event_reg_id'])){
	echo "<script> window.location.href='events_reg.php';</script>";
	exit();
}else{
  $reg_id = $_GET['event_reg_id'];
  $result = $db->query("SELECT * FROM events_registration WHERE reg_id = $reg_id");
     
	  while($reg = $result->fetch_assoc()): 
		$event_id = $reg['event_id'];
		$firstname = $reg['firstname'];
		$lastname = $reg['lastname'];
		$email = $reg['email'];
		$title = $reg['title'];
		$gender = $reg['gender'];
        $age = $reg['age'];
		$highest_degree = $reg['highest_degree'];
		$country_origin = $reg['country_origin'];
		$country_residence = $reg['country_residence'];
        $wphone_number = $reg['wphone_number'];
		$affliliation = $reg['affliliation'];
		$membership = $reg['membership'];
		$member_Id = $reg['member_Id'];
		$paymentContent = $reg['paymentContent'];
		$submitCode = $reg['submitCode'];
        $payment_status = $reg['payment_status'];
		$reg_date = $reg['reg_date'];
	 endwhile;

     $resultEvent = $db->query("SELECT * FROM events WHERE event_id = $event_id ");
     while($regEvent = $resultEvent->fetch_assoc()): 
		$event_title = $regEvent['event_title'];
	 endwhile;

   if(!empty($paymentContent)){
    $paymentContent = json_decode($paymentContent, true);

    $paymentPrice = $paymentContent['paymentPrice'];
    $Text = $paymentContent['Text'];
    $currency = $paymentContent['currency'];
  }

  if(isset($_GET['paid'])){
    $paid= $db->query("UPDATE `events_registration` SET `payment_status` = 'Paid' WHERE `events_registration`.`reg_id`=$reg_id");
    if($paid){

      echo "<script> alert('Payment Confirmed');
      window.location.href='reg_event_details.php?event_reg_id=$reg_id';	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='reg_event_details.php?event_reg_id=$reg_id';	</script>";
    }
  }
  
   if(isset($_GET['remove'])){
    $remove= $db->query("DELETE FROM `events_registration` WHERE `events_registration`.`reg_id`=$reg_id");
    if($remove){
          $event_id = $_GET['event_id'];
          echo "<script> alert('Applicant Removed');
          window.location.href='events_reg.php?event_id=$event_id';	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='events_reg.php?event_id=$event_id';	</script>";
    }
  }
  
  		if(isset($_POST['send_mail'])){

			$message_body = $_POST['message_body'];
			$message_body = $db->real_escape_string($message_body);
			$message_body = str_replace("\r\n", '<br>', $message_body);


			$message_subject = $_POST['message_subject'];
			$message_subject = strip_tags($message_subject);
			$message_subject = $db->real_escape_string($message_subject);

			if(empty($message_body) || empty($message_subject)){
				echo "<script> alert('Please no empty field');</script>";
			}else{
				
				   //Load Composer's autoloader
                    require 'vendor/autoload.php';
                    //Instantiation and passing `true` enables exceptions
                    $mail = new PHPMailer(true);
                    try {
                        $mail->isSMTP();                                            //Send using SMTP
                        $mail->Host       = 'africansciencefrontiers.com';                     //Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                        $mail->Username   = 'mailme@africansciencefrontiers.com';                     //SMTP username
                        $mail->Password   = 'mailme@ASFI';                               //SMTP password
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         //Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
                        $mail->Port       = 587; 
                        //Recipients
                        
                        $mail->setFrom('courses@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                        $mail ->AddAddress($member_email);
                        
                        //Name is optional
                        $mail->addReplyTo('info@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
                    
                    
                        //Content
                        $mail->isHTML(true);                                  //Set email format to HTML
                        $mail->Subject = $message_subject;
                        $mail->Body    = $message_body;

                        $mail->send();
                            echo "<script> alert('Sent');
                            window.location.href='';	</script>";
                    } catch (Exception $e) {
                            echo "<script> alert('Not Sent');
                            window.location.href='';	</script>";
                    }
			}

		}
}
?>




    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user-md"></i> Profile</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-users"></i><a href="course.php">Events</a></li>
              <li><i class="fa fa-users"></i><a href="events_reg.php?event_id=<?=$event_id?>">Events Registration</a></li>
              <li><i class="fa fa-user-md"></i><?=$firstname?> <?=$lastname?></li>
            </ol>
          </div>
        </div>
       			<!-- container -->
			<div class="container">
				<!-- row -->
				<div class="row" id="div1">
				  <div class="col-md-2"></div>
					<div class="col-md-8" style="background:#ffffff;">
					<br>
              <div class="row">
                <div class="col-md-12"> 
                    <div class="section-title text-left">
                      <h3 class="title">Event Title: <b><?=$event_title?></b></h3>
                      <h4> Registration Date: <?=$reg_date?></h4>
                    </div>
                </div>
              </div>
              <hr>
					    <div class="row">
					      <div class="col-md-12"> 
					        <div class="section-title text-center">
										<h4 class="title">Applicant's Details</h4>
									</div>
							    <div class="row">
                    <div class="col-md-5">
                        <div class="section-title">
                          <p>Name: <b> <?=$firstname?> <?=$lastname?></b> </p>
                          <p> Gender: <b> <?=$gender?></b> </p>
                          <p> Email: <b> <?=$email?></b> </p>
                          <p> Age: <b> <?=$age?></b> </p>
                          <p>  Country Of Origin:  <b><?=$country_origin?></b> </p>
                          <p> Country Of Residence:<b> <?=$country_residence?> </b></p>
                         
                        </div>
                    </div>	
								    <div class="col-md-2"></div>	
                    <div class="col-md-5">
                        <div class="section-title">
                          <p> WhatsApp Number: <b><?=$wphone_number?></b></p>
                          <p> ASFI Membership: <b><?=$membership?></b> </p>
                          <p> ASFI Membership ID: <b><?=$member_Id?></b> </p>
                          <p> Affiliation: <b><?=$affliliation?></b></p>
                          <p> Highest Degree: <b><?=$highest_degree?></b> </p>
                      
                        </div>
                    </div>	
                  </div>								 
						    </div>
					    </div>
              <div class="row">
                <div class="col-md-12"> 
                    <div class="section-title text-center">
                      <h4 class="title"><b>Payment Status</b> </h4>
                      <h4><?=$Text?><?=$currency?><?= number_format($paymentPrice, 2)?></h4>
                      <h4> https://africansciencefrontiers.com/payment_page_event.php?SubmitCode=<?=$submitCode?></h4>
                    </div>
                </div>
              </div>
				    </div>
            <hr>
              

				
				</div>
				
				<!-- /row -->
			</div>
			<!-- /container -->
        <br>
          <div class="container">
				    <div class="row">
					        <div class="col-md-2"></div>
							<div class="col-md-8">							
							  <?php if(empty($payment_status)){?>
								  <a href="reg_event_details.php?event_reg_id=<?=$reg_id?>&paid" class="btn btn-danger" > Confirm Payment</a>
                <?php }else{?>  
                    <button class="btn btn-success" disabled>Paid</button>

                <?php }?>  
								 
								<button class="btn btn-primary" data-toggle="modal" data-target="#sendMail">Send A Message</button>
								
								<a href="reg_event_details.php?event_reg_id=<?=$reg_id?>&remove&event_id=<?=$event_id?>" class="btn btn-danger" > Remove Applicant</a>

								
					      </div>
		        </div>
          </div>

        <!-- page end-->
      </section>
    </section> 
      <?php include_once ('footer.php');?>


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
