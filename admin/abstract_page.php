<?php 
  include_once ('header.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
 
 include_once ('side_content.php');
 $count = 0;
  if(!isset($_GET['abstract_id'])){
	echo "<script> window.location.href='asfi_abstract.php';</script>";
	exit();
}else{
  $abstract_id = $_GET['abstract_id'];
  $result = $db->query("SELECT * FROM abstract WHERE abstract_id = $abstract_id");
     
	  while($reg = $result->fetch_assoc()): 
		$presenter_biography = $reg['presenter_biography'];
		$presentation_type = $reg['presentation_type'];
		$State_of_study = $reg['State_of_study'];
		$theme = $reg['theme'];
		$special_request = $reg['special_request'];
		$title = $reg['title'];
        $author = $reg['author'];
		$affliliation = $reg['affliliation'];
		$abstract = $reg['abstract'];
		$date = $reg['date'];
        $author_email = $reg['author_email'];
		$gender = $reg['gender'];
		$author_title = $reg['author_title'];
        $country_origin = $reg['country_origin'];
		$country_residence = $reg['country_residence'];
		$highest_degree = $reg['highest_degree'];
		$wphone_number = $reg['wphone_number'];
        $presenter = $reg['presenter'];
        $keywords =$reg['keywords'];
        $lateBreaker = $reg['lateBreaker'];
    endwhile;


   if(isset($_GET['delete'])){
    $paid= $db->query("DELETE FROM `abstract` WHERE `abstract`.`abstract_id` = $abstract_id");
    if($paid){

      echo "<script> alert('Abstract Deleted Successfully');
      window.location.href='asfi_abstract.php';	</script>";
    }else{
          echo "<script> alert('Not Working');
          window.location.href='abstract_page.php?abstract_id=$abstract_id';	</script>";
    }
  }

  if(isset($_POST['send_mail'])){
    $message_subject = $_POST['message_subject'];
    $message_subject = strip_tags($message_subject);
    $message_subject = $db->real_escape_string($message_subject);
    
    $message_body = $_POST['message_body'];
    $message_body = strip_tags($message_body);
    $message_body = $db->real_escape_string($message_body);

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
         
         $mail->setFrom('conference2023@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
         $mail ->AddAddress($author_email);
         
         //Name is optional
         $mail->addReplyTo('conference2023@africansciencefrontiers.com', 'African Science Frontiers Initiatives (ASFI)');
     
     
         //Content
         $mail->isHTML(true);                                  //Set email format to HTML
         $mail->Subject = $message_subject;
         $mail->Body    = $message_body;

         $mail->send();
             $_SESSION['alert'] = "Message Sent successful.";
             $_SESSION['alert_code'] = "success";
             $_SESSION['alert_link'] = '';	
     } catch (Exception $e) {
             $_SESSION['alert'] = "Message Sent successful.";
             $_SESSION['alert_code'] = "error";
             $_SESSION['alert_link'] = '';
     }
    
  }

}
?>




    <!--main content start-->
    <section id="main-content">
      <section class="wrapper">
        <div class="row">
          <div class="col-lg-12">
            <h3 class="page-header"><i class="fa fa-user-md"></i> Abstract Details</h3>
            <ol class="breadcrumb">
              <li><i class="fa fa-home"></i><a href="index.php">Home</a></li>
              <li><i class="fa fa-users"></i><a href="asfi_abstract.php">Abstracts</a></li>
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
                                <div class="section-title">
                                    <h3 class="title"><b>DATE OF SUBMISSION</b></h3>
                                    <p> <?=$date?></p>
                                    <hr>
                                    <h3 class="title"><b>NAME OF SUBMITING AUTHOR OR PRESENTER</b></h3>
                                    <p> <?=$presenter?></p>
                                    <hr>
                                    <h3 class="title"><b>AUTHOR'S TITLE</b></h3>
                                    <p> <?=$author_title?></p>
                                    <hr>
                                    <h3 class="title"><b>AUTHOR'S EMAIL</b></h3>
                                    <p> <?=$author_email?></p>
                                    <hr>
                                    <h3 class="title"><b>AUTHOR'S WHATSAPP PHONE NUMBER</b></h3>
                                    <p> <?=$wphone_number?></p>
                                    <hr>
                                    <h3 class="title"><b>AUTHOR'S GENDER</b></h3>
                                    <p> <?=$gender?></p>
                                    <hr>
                                    <h3 class="title"><b>AUTHOR'S HIGHEST DEGREE EARNED</b></h3>
                                    <p> <?=$highest_degree?></p>
                                    <hr>
                                    <h3 class="title"><b>COUNTRY OF RESIDENCE</b></h3>
                                    <p> <?=$country_residence?></p>
                                    <hr>
                                    <h3 class="title"><b>COUNTRY OF ORIGIN</b></h3>
                                    <p> <?=$country_origin?></p>
                                    <hr>
                                    <h3 class="title"><b>PRESENTER BIOGRAPHY</b></h3>
                                    <p> <?=$presenter_biography?></p>
                                    <hr>
                                    <h3 class="title"><b>NAMES OF CO-AUTHORS</b></h3>
                                    <p> <?=$author?></p>
                                    <hr>
                                    <h3 class="title"><b>PRESENTATION TYPE</b></h3>
                                    <p> <?=$presentation_type?></p>
                                    <hr>
                                    <h3 class="title"><b>STATE OF STUDY</b></h3>
                                    <p> <?=$State_of_study?></p>
                                    <hr>
                                    <?php if (!empty($theme)): ?>
                                        <h3 class="title"><b>THEME</b></h3>
                                        <p> <?=$theme?></p>
                                        <hr>
                                    <?php endif; ?>
                                    <h3 class="title"><b>SPECIAL REQUESTS</b></h3>
                                    <p> <?=$special_request?></p>
                                    <hr>
                                    <h3 class="title"><b>TITLE</b></h3>
                                    <p> <?=$title?></p>
                                    <hr>
                                    <h3 class="title"><b>AFFILIATION(S)</b></h3>
                                    <p> <?=$affliliation?></p>
                                    <hr>
                                    <h3 class="title"><b> KEYWORDS </b></h3>
                                    <p> <?=$keywords?> </p>
                                    <hr>
                                    <h3 class="title"><b>ABSTRACT</b></h3>
                                    <p> <?=nl2br($abstract)?></p>
                                    <hr>
                                    <?php if (!empty($lateBreaker)): ?>
                                        <h3 class="title"><b>Implications of the research for practice or research:</b></h3>
                                        <p> <?=nl2br($lateBreaker)?></p>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
				    </div>				
				</div>
				
				<!-- /row -->
			</div>
			<!-- /container -->
            <br>
          <div class="container">
				    <div class="row">
					        <div class="col-md-2"></div>
							<div class="col-md-8">							
							  
								  <a href="abstract_page.php?abstract_id=<?=$abstract_id?>&delete" class="btn btn-danger" > Delete Abstract</a>
               
                                    <a href="exportPDF.php?abstract_id=<?=$abstract_id?>" class="btn btn-success" >Export To PDF</a>        
								<button class="btn btn-primary" data-toggle="modal" data-target="#sendMail">Send A Message</button>
								
					      </div>
		        </div>
          </div>
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
