<?php include_once('header.php');
include ('./includes/load_env.php');
  $paymentKey = $_ENV['PAYMENT_KEY'] ?? getenv('PAYMENT_KEY');

    if(!isset($_GET['SubmitCode'])){
        echo "<script> window.location.href='courses.php';</script>";
        exit();
    }else{
      $SubmitCode = $_GET['SubmitCode'];
      $result = $db->query("SELECT * FROM events_registration WHERE submitCode = '$SubmitCode'");
         
          while($reg = $result->fetch_assoc()): 
            $firstname = $reg['firstname'];
            $lastname = $reg['lastname'];
            $email = $reg['email'];
            $title = $reg['title'];
            $paymentContent = $reg['paymentContent'];
         endwhile;
    }

    if(!empty($paymentContent)){
        $paymentContent = json_decode($paymentContent, true);

        $paymentPrice = $paymentContent['paymentPrice'];
        $Text = $paymentContent['Text']. $paymentPrice;
        if($paymentPrice == ! 0){
            $currency = $paymentContent['currency'];
        }
       
    }else{
        
        echo "<script> 
            alert('Invalid Payment Link. Please Contact Our Support Team For Help. Thank You');
            window.location.href='contact.php';
        </script>";
        exit();
    }

?>
<title> Payment Page  || African Science Frontiers Initiatives (ASFI)</title>


    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Payment Page  </li>
                </ul>
            </div>
        </div>
    </section>
  <!-- Team Section Three -->

      <!-- Volunteer -->
      <section class="volunteer-section">
        <div class="auto-container">
            <div class="sec-title text-center">
                <h1>Congratulation Event Registration Successful</h1>
                <hr>
                <h3><?=$firstname?> <?=$lastname?></h3>
                <div class="text">===> 2nd Annual ASFI Virtual Multidisciplinary Conference & Boot Camp <===</div>
                <?php if($paymentPrice ==! 0){?>
                    <div class="text"><?=$Text?> </div>
                    <br>
                    <div class="link-btn text-center">

                        <form >
                            <script src="https://js.paystack.co/v1/inline.js"></script>
                            <button type="button" class="theme-btn btn-style-one" onclick="payWithPaystack()"> <span>Pay Now</span> </button> 
                        </form>

                        <script>
                            function payWithPaystack(){
                            var handler = PaystackPop.setup({
                            key: '<?php echo $paymentKey ?>',
                            email: '<?php echo $email?>',
                            amount: <?php echo $paymentPrice?>00,
                            currency: "<?=$currency?>",
                            metadata: {
                            custom_fields: [
                                {
                                    display_name: "Customer Name",
                                    variable_name: "Customer_Name",
                                    value: "<?php echo $firstname?> <?php echo $lastname?>"
                                },
                                {
                                    display_name: "Payment Code",
                                    variable_name: "paymentCode",
                                    value: "<?php echo $SubmitCode?> "
                                },
                                {
                                    display_name: "Email",
                                    variable_name: "email",
                                    value: "<?php echo $email?>"
                                }
                            ]
                            },
                                callback: function(response){
                                    alert('success. transaction ref is ' + response.reference);
                                },
                                onClose: function(){
                                    alert('window closed');
                                }
                            });
                            handler.openIframe();
                            }
                        </script>
                    </div>
                <?php }else{?>
                    <div class="text">Registration With Discount Code Is FREE. </div>
                <?php }?>
            </div>
            
        </div>
    </section>

<?php include_once('footer.php');?>