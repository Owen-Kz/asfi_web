<?php 
  include_once ('header.php');
 include_once ('side_content.php');
 $count = 0;
  if(!isset($_GET['member_id'])){
	echo "<script> window.location.href='asfi_membership.php';</script>";
	exit();
}else{
  $member_id = $_GET['member_id'];
  $result = $db->query("SELECT * FROM members_registration WHERE member_id = $member_id");
     
	  while($reg = $result->fetch_assoc()): 
		$member_firstname = $reg['member_firstname'];
		$member_surname = $reg['member_surname'];
		$member_email = $reg['member_email'];
		$member_gender = $reg['member_gender'];
		$member_age = $reg['member_age'];
		$member_country = $reg['member_country'];
		$member_affiliate = $reg['member_affiliate'];
		$member_highest_degree = $reg['member_highest_degree'];
		$member_position = $reg['member_position'];
        $member_reg_date = $reg['member_reg_date'];
        $member_payment = $reg['member_payment'];
        $member_activation = $reg['member_activation'];
	 endwhile;
	 
	   if ($member_country === 'Nigeria') {
                    if ( $member_highest_degree === 'Bachelor' OR $member_highest_degree === 'Masters'  OR $member_highest_degree === 'MD') {
                        $paymentLink = 'https://paystack.com/pay/asfimem1ng';
                        $Text = 'Nigerian ASFI Membership Registration Discounted (BSc, MSc, MPhil, MA, MD)';
                        $currency ='NGN';
                        $paymentPrice ='10000';
                        
                    } else {
                        $paymentLink = 'https://paystack.com/pay/asfimem2ng';
                        $Text = 'Nigerian ASFI Membership Registration Regular (>= PhD)';
                        $currency ='NGN';
                        $paymentPrice ='20000';
                    }
                } else {
                    if ( $member_highest_degree === 'Bachelor' OR $member_highest_degree === 'Masters'  OR $member_highest_degree === 'MD'){
                        $paymentLink = 'https://paystack.com/pay/asfiMem1';
                        $Text = 'ASFI Membership Registration Discounted (BSc, MSc, MPhil, MA, MD)';
                        $currency ='USD';
                        $paymentPrice ='20';
                        
                    } else {
                        $paymentLink = 'https://paystack.com/pay/asfimem2';
                        $Text = 'ASFI Membership Registration Regular (>= PhD)';
                        $currency ='USD';
                        $paymentPrice ='40';
                    }
                }
}

  if(isset($_GET['paid'])){
    $paid= $db->query("UPDATE `members_registration` SET `member_payment` = 'Paid' WHERE `members_registration`.`member_id`= '$member_id' ");
    if($paid){

      echo "<script> alert('Payment Confirmed');
      window.location.href='member_details.php?member_id = $member_id';	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='member_details.php?member_id =$member_id ';	</script>";
    }
  }
  
   if(isset($_GET['remove_confirm'])){
    $remove= $db->query("DELETE FROM `members_registration` WHERE `members_registration`.`member_id` = '$member_id'");
    if($remove){
          echo "<script> alert('Member Deleted Successfully');
          window.location.href='asfi_membership.php;	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='member_details.php?member_id=$member_id';	</script>";
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
                        
                        $mail->setFrom('info@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
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
?>




    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user-md"></i> Profile</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-users"></i><a href="asfi_membership.php">Members</a></li>
              <li><i class="fa fa-user-md"></i><?=$member_firstname?> <?=$member_surname?></li>
            </ol>
          </div>
        </div>
        <div class="row">
          <!-- profile-widget -->
          <div class="col-lg-12">
            <div class="profile-widget profile-widget-info">
            <div class="panel-body ">
                        <h1><?=$member_firstname?> <?=$member_surname?></h1>
                        <div class="row">
                          
                         
                          <div class="bio-row">
                            <h4>Age : <?=$member_age?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Gender : <?=$member_gender?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Email : <?=$member_email?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Country : <?=$member_country?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Affiliation : <?=$member_affiliate?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Highest degree completed : <?=$member_highest_degree?></h4>
                          </div>
                          <div class="bio-row">
                            <h4>Current Position : <?=$member_position?></h4>
                          </div>
                       
                          <div class="bio-row">
                            <h4>Date Of Registration : <?=$member_reg_date?></h4>
                          </div>
                        </div>
                      </div>
            </div>
          </div>
        </div>
        <div class="row">
                <div class="col-md-12"> 
                    <div class="section-title text-center">
                      <h4 class="title"><b>Payment Status</b>: <?=$member_payment?> </h4>
                      <h4><?=$Text?> ==== <?=$currency?><?=number_format($paymentPrice, 2)?></h4>
                      <h4> <?=$paymentLink?></h4>
                    </div>
                </div>
              </div>
              
              <div class="container">
				    <div class="row">
					        <div class="col-md-2"></div>
							<div class="col-md-8">							
							<?php if($member_payment == 'Not paid'){?>
								<a href="member_details.php?member_id=<?=$member_id?>&paid" class="btn btn-danger" > Confirm Payment</a>
								
								
							<?php }else{?>  
									<button class="btn btn-success" disabled>Paid</button>

							<?php }?>  
								 
								<button class="btn btn-primary" data-toggle="modal" data-target="#sendMail">Send A Message</button>
								
								
								<?php if(isset($_GET['remove'])){?>
								
								    <a href="member_details.php?member_id=<?=$member_id?>&remove_confirm" class="btn btn-success" > Are You Sure you want to Delete Member?</a>
								
								<?php }else{?>
								
									<a href="member_details.php?member_id=<?=$member_id?>&remove" class="btn btn-danger" > Remove Member</a>
								
								<?php }?>  
								
								
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
