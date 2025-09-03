<?php 
  include_once ('header.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

 include_once ('side_content.php');
 $count = 0;
  if(!isset($_GET['reg_id'])){
	echo "<script> window.location.href='course.php';</script>";
	exit();
}else{
  $reg_id = $_GET['reg_id'];
  $result = $db->query("SELECT * FROM course_registration WHERE course_reg_id = $reg_id");
     
	  while($reg = $result->fetch_assoc()): 
		$member_firstname = $reg['course_reg_firstname'];
		$member_surname = $reg['course_reg_surname'];
		$member_email = $reg['course_reg_email'];
		$member_gender = $reg['course_reg_gender'];
		$member_age = $reg['course_reg_age'];
		$member_country = $reg['course_reg_country_origin'];
        $course_reg_country_residence = $reg['course_reg_country_residence'];
		$member_affiliate = $reg['course_reg_affiliate'];
		$member_highest_degree = $reg['course_reg_highest_degree'];
		$member_position = $reg['course_reg_position'];
        $course_reg_degree_progress = $reg['course_reg_degree_progress'];
		$course_reg_research_interest = $reg['course_reg_research_interest'];
		$course_reg_current_project = $reg['course_reg_current_project'];
		$course_reg_prev_asfi_course = $reg['course_reg_prev_asfi_course'];
		$course_reg_course_id = $reg['course_reg_course_id'];
		$course_reg_title = $reg['course_reg_title'];
        $course_reg_motivation = $reg['course_reg_motivation'];
		$course_reg_date = $reg['course_reg_date'];
        $paymentContent = $reg['paymentContent'];
		$submitCode = $reg['submitCode'];
        $payment_status = $reg['payment_status'];
		$how_you_heard_about_course = $reg['how_you_heard_about_course'];
        $membership_number = $reg['membership_number'];
    

	 endwhile;

   if(!empty($paymentContent)){
    $paymentContent = json_decode($paymentContent, true);

    $paymentPrice = $paymentContent['paymentPrice'];
    $Text = $paymentContent['Text'];
    $currency = $paymentContent['currency'];
  }

  if(isset($_GET['paid'])){
    $paid= $db->query("UPDATE `course_registration` SET `payment_status` = 'Paid' WHERE `course_registration`.`course_reg_id`=$reg_id");
    if($paid){

      echo "<script> alert('Payment Confirmed');
      window.location.href='reg_course_details.php?reg_id=$reg_id';	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='reg_course_details.php?reg_id=$reg_id';	</script>";
    }
  }
  
   if(isset($_GET['remove'])){
    $remove= $db->query("DELETE FROM `course_registration` WHERE `course_registration`.`course_reg_id` = $reg_id");
    if($remove){
          $course_id = $_GET['course_id'];
          echo "<script> alert('Applicant Removed');
          window.location.href='asfi_reg_course.php?course_id=$course_id';	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='reg_course_details.php?reg_id=$reg_id';	</script>";
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
              <li><i class="fa fa-users"></i><a href="course.php">Courses</a></li>
              <li><i class="fa fa-users"></i><a href="asfi_reg_course.php?course_id=<?=$course_reg_course_id?>">Courses applicants</a></li>
              <li><i class="fa fa-user-md"></i><?=$member_firstname?> <?=$member_surname?></li>
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
                      <h3 class="title">Course Title: <b><?=$course_reg_title?></b></h3>
                      <h4> Application Date: <?=$course_reg_date?></h4>
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
                          <p>Name: <b> <?=$member_firstname?> <?=$member_surname?></b> </p>
                          <p> Gender: <b> <?=$member_gender?></b> </p>
                          <p> Email: <b> <?=$member_email?></b> </p>
                          <p> Age: <b> <?=$member_age?></b> </p>
                          <p>  Country Of Origin:  <b><?=$member_country?></b> </p>
                          <p> Country Of Residence:<b> <?=$course_reg_country_residence?> </b></p>
                          <p> Affiliation: <b><?=$member_affiliate?></b> <br>
                          <p> ASFI Membership: <b><?php if(empty($membership_number)){?>NO<?php }else{?>YES -  <?=$membership_number?><?php } ?></b> </p>
                        </div>
                    </div>	
								    <div class="col-md-2"></div>	
                    <div class="col-md-5">
                        <div class="section-title">
                        <p> Highest Degree: <b><?=$member_highest_degree?></b> </p>
                          <p>Current Position: <b><?=$member_position?>  </b></p>
                          <p>Degree In Progress: <b><?=$course_reg_degree_progress?></b> </p>
                          <p>Research Interest :<b><?=$course_reg_research_interest?></b></p>
                          <p> Current Project: <b><?=$course_reg_current_project?></b> </p>
                          <p>Any ASFI courses previously?: <b><?=$course_reg_prev_asfi_course?></b></p>
                          <p>Short Motivation:<small><b><i><?=$course_reg_motivation?></i></b></small></p>
                          <p>Learn about this course:<b><?=$how_you_heard_about_course?></b></p>
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
                      <h4> https://africansciencefrontiers.com/payment-page.php?SubmitCode=<?=$submitCode?></h4>
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
								<a href="reg_course_details.php?reg_id=<?=$reg_id?>&paid" class="btn btn-danger" > Confirm Payment</a>
								
								
							<?php }else{?>  
									<button class="btn btn-success" disabled>Paid</button>

							<?php }?>  
								 
								<button class="btn btn-primary" data-toggle="modal" data-target="#sendMail">Send A Message</button>
								
								<a href="reg_course_details.php?reg_id=<?=$reg_id?>&remove&course_id=<?=$course_reg_course_id?>" class="btn btn-danger" > Remove Applicant</a>
								
								
								
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
