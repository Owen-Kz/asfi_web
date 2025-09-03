<?php include_once('header.php');


        if(isset($_POST['submit_contact'])){
        
            $form_name = $_POST['form_name'];
            $form_name = strip_tags($form_name);
            $form_name = $db->real_escape_string($form_name);
            
            $form_email = $_POST['form_email'];
            $form_email = strip_tags($form_email);
            $form_email = $db->real_escape_string($form_email);
            
            $form_message = $_POST['form_message'];
            $form_message = strip_tags($form_message);
            $form_message = $db->real_escape_string($form_message);

            
            if(empty($form_name) || empty($form_message)){
                $_SESSION['alert'] = "Fill all field and Please Try Again";
                $_SESSION['alert_code'] = "error";
                $_SESSION['alert_link'] = "";
            }else{
                $query = $db->query("INSERT INTO contact (contact_name, contact_email, contact_message, contact_date) 
                                                 VALUES('$form_name', '$form_email', '$form_message', CURRENT_TIMESTAMP)");
                // move image
                if($query){
                   
                    $_SESSION['alert'] = "Hello $form_name, Your Message has been Received. We will Get back to you shortly.";
                    $_SESSION['alert_code'] = "success";
                    $_SESSION['alert_link'] = "";
                   
                }else{
                    $_SESSION['alert'] = "Your Message has been Not Received. Please Try Again";
                    $_SESSION['alert_code'] = "error";
                    $_SESSION['alert_link'] = "";
                }
            }
            
        }
		

?>

<title>Contact Us || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>Contact Us</h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Contact Us</li>
                </ul>
            </div>
        </div>
    </section>
  <!-- Team Section Three -->

    <!-- Contact Form -->
    <section class="contact-form-section">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="default-form-area">
                        <div class="sec-title">
                            <h1>Leave us a message and we will get back to you.</h1>
                        </div>
                        <form  class="contact-form" action="" method="post">
                            <div class="row clearfix">
                                <div class="col-lg-6 col-md-6 column">        
                                    <div class="form-group">
                                        <input type="text" name="form_name" class="form-control" value="" placeholder="Name" required="">
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 column">
                                    <div class="form-group">
                                        <input type="email" name="form_email" class="form-control required email" value="" placeholder="Email" required="">
                                    </div>
                                </div>
                               
                                <div class="col-lg-12 col-md-12 column">
                                    <div class="form-group">
                                        <textarea name="form_message" class="form-control textarea required" placeholder="Message...."></textarea>
                                    </div>
                                    <div class="form-group flex-box">
                                        <div class="submit-btn">
                                            <button class="theme-btn btn-style-one" type="submit" name="submit_contact"><span>Send Message</span></button>
                                        </div>
                                       
                                    </div>
                                </div>                                            
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info-three">
                        <div class="single-info">
                            <h4>Office Address</h4>
                            <div class="text"></div>2b, Gold Estate, Banku Avenue, Wawa, Ogun State, Nigeria</div>
                        </div>
                        <div class="single-info">
                            <h4>Quick Contact</h4>
                            <div class="wrapper-box">
                                <a href="mailto:info@africansciencefrontiers.com">info@africansciencefrontiers.com </a> <br>
                                <a href="tel:+2347014363223">+234(0)-701-436-3223</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>                    
        </div>
    </section>

    <!-- Google Map -->
    <div class="google-map">
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d507238.0013690185!2d2.8452897734374902!3d6.672071400000017!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x103beba0a32bb41b%3A0xa0523a423db1d9a5!2sGold%20Estate!5e0!3m2!1sen!2sng!4v1706993821405!5m2!1sen!2sng" width="100%" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
    </div>
<?php include_once('footer.php');?>