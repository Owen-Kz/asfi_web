<?php
include_once ('header.php');

// Add reCAPTCHA keys - REPLACE THESE WITH YOUR ACTUAL KEYS
define('RECAPTCHA_SITE_KEY', '6LcEcsUrAAAAACd3CAtZIO54BjvF7viwD__b0vTB');
define('RECAPTCHA_SECRET_KEY', '6LcEcsUrAAAAAP4RLg3FraLr0ZQU0WYmoBLg_g8D');

if(!isset($_GET['blog_id'])){
    echo "<script> window.location.href='news.php';	</script>";
    exit;
}else{
    $b_id = $_GET['blog_id'];
    $result = $db->query("SELECT * FROM posts WHERE post_id=$b_id");
    
    while($blog = $result->fetch_assoc()): 
        $post_title = $blog['post_title'];
        $post_body = $blog['post_body'];
        $post_image = $blog['post_image'];
        $post_date = $blog['post_date'];
        $post_date = date_create($post_date);
        $category = $blog['category'];
        $post_author = $blog['post_author'];
    endwhile;
                             
    if(isset($_POST['comment_submit'])){
        
        $full_name = $_POST['full_name'];
        $full_name = strip_tags($full_name);
        $full_name = $db->real_escape_string($full_name);
        
        $email = $_POST['email'];
        $email = strip_tags($email);
        $email = $db->real_escape_string($email);
        
        $comment_message = $_POST['comment_message'];
        $comment_message = strip_tags($comment_message);
        $comment_message = $db->real_escape_string($comment_message);
        
        // reCAPTCHA verification
        $recaptcha_response = $_POST['g-recaptcha-response'];
        
        if(empty($full_name) || empty($comment_message)){
            echo "<script>alert('Please Fill all Required Fields'); </script>";
        } elseif(empty($recaptcha_response)) {
            echo "<script>alert('Please complete the reCAPTCHA verification'); </script>";
        } else {
            // Verify reCAPTCHA
            $recaptcha_verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".RECAPTCHA_SECRET_KEY."&response={$recaptcha_response}");
            $recaptcha_data = json_decode($recaptcha_verify);
            
            if (!$recaptcha_data->success) {
                // reCAPTCHA verification failed
                echo "<script>alert('reCAPTCHA verification failed. Please try again.'); </script>";
            } else {
                // reCAPTCHA successful, proceed with comment submission
                $query = $db->query("INSERT INTO post_comment (full_name, email, comment_message, date, b_id)
                                VALUES('$full_name', '$email',  '$comment_message', current_timestamp(), '$b_id')");
                
                if($query){
                    echo "<script>alert('Comment submitted successfully!'); </script>";
                    // Refresh to show the new comment
                    echo "<script>window.location.href='news-details.php?blog_id=$b_id';</script>";
                    exit;
                }else{
                    echo "<script>alert('Error submitting comment. Please try again.'); </script>";
                }
            }
        }
    }
}	

$result_comment = $db->query("SELECT * FROM post_comment WHERE b_id = $b_id  ORDER BY id DESC ");
?>
<title><?=$post_title?> || African Science Frontiers Initiatives (ASFI)</title>

<!-- Add reCAPTCHA script -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

  <!-- Page Title -->
  <section class="page-title" style="background-image:url(images/background/bg-13.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1><?=$post_title?></h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li><?=$post_title?></li>
                </ul>
            </div>
        </div>
    </section>
    
    <div class="sidebar-page-container">
        <div class="auto-container">
            <div class="row">
                <div class="col-lg-2"></div>
                <div class="col-lg-8">
                    <div class="post-wrapper">
                        <!-- Single Blog Post -->
                        <div class="single-blog-post">
                            <div class="inner-box">
                                <div class="top-content">
                                    <h2><?=$post_title?></h2>
                                    <div class="post-info">
                                        <div class="author">
                                            <div class="author-thumb"><img src="images/resource/author-thumb-1.jpg" alt=""></div>
                                            <div class="author-title"><a href="#"><?=$post_author?></a></div>
                                        </div>
                                        <div class="date"><span class="flaticon-clock"></span><?php echo date_format($post_date, 'j');?> <?php echo date_format($post_date, 'F');?>, <?php echo date_format($post_date, 'Y');?></div>
                                        <div class="category"><span class="flaticon-folder"></span><?=$category?></div>
                                        <div class="views"><span class="flaticon-eye"></span><?php echo $result_comment->num_rows ?> Comments</div>
                                    </div>
                                    <div class="image"><img src="admin/img/posts/<?=$post_image?>" alt=""></div>
                                    <?=$post_body?>
                                                               
                                </div>
                                <br>
                                <hr>
                                <div class="bottom-content">
                                    
                                    <!-- Comment Reply -->
                                    <div class="comments-area">
                                        <div class="group-title">
                                            <h2>Read Comments (<?php echo $result_comment ->num_rows ?>)</h2>
                                        </div>

                                        <?php while($comment = $result_comment->fetch_assoc()): ?> 
                                        <!--Comment Box-->
                                        <div class="comment-box">
                                            <div class="comment">
                                                <div class="author-thumb"><img src="" alt=""></div>
                                                <div class="comment-inner">
                                                    <div class="comment-info"><?=$comment['full_name']?><span class="date"></span></div>
                                                    <div class="text"><?php echo nl2br($comment['comment_message']);?></div>
                                                </div>
                                            </div>
                                        </div>
                                        <?php endwhile?>
                                    </div>
                                    <!-- Comment form -->
                                    <div class="comment-form">  
                                        <div class="group-title">
                                            <h2>Leave a Comment</h2>
                                        </div>
                                        <form method="post" action="">
                                            <div class="row clearfix">
                                                
                                                <div class="col-md-12 form-group">
                                                    <textarea name="comment_message" placeholder="Comment..." required></textarea>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="text" name="full_name" placeholder="Name*" required>
                                                </div>
                                                <div class="col-md-6 form-group">
                                                    <input type="email" name="email" placeholder="Email*" required>
                                                </div>
                                               
                                                <!-- reCAPTCHA Widget -->
                                                <div class="col-md-12 form-group">
                                                    <div class="g-recaptcha" data-sitekey="<?php echo RECAPTCHA_SITE_KEY; ?>"></div>
                                                </div>
                                               
                                                <div class="col-md-12 form-group">
                                                    <button class="theme-btn btn-style-one" name="comment_submit" type="submit">
                                                        <span>Post Comment</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- End Form -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
<?php include_once('footer.php');?>