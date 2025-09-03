<?php include_once('header.php');?>
<title>ASFI News & Article  || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/background/bg-13.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>ASFI News & Article</h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>ASFI News & Article</li>
                </ul>
            </div>
        </div>
    </section>

    <!-- Blog Section -->
    <section class="blog-section">
        <div class="auto-container">
            <div class="row">
            <?php 
                $result_posts = $db->query("SELECT * FROM posts ORDER BY post_id DESC LIMIT 9");
                while($post = $result_posts->fetch_assoc()):
                $post_date = date_create($post['post_date']);
                $b_id = $post['post_id'];
                $result_comment = $db->query("SELECT * FROM post_comment WHERE b_id = $b_id ");
            ?> 
                <!-- News Block Two -->
                <div class="col-lg-4 col-md-6 news-block-two style-three">
                    <div class="inner-box wow fadeInUp" data-wow-delay="200ms">
                        <div class="image">
                            <a href="news-details.php?blog_id=<?=$post['post_id']?>"><img src="admin/img/posts/<?=$post['post_image']?>" alt=""></a>
                            <div class="post-meta-info">
                                <a href="#"><span class="flaticon-comment"></span><?php echo $result_comment ->num_rows ?></a>
                            </div>
                        </div>
                        <div class="lower-content">
                        <div class="date"><?php echo date_format($post_date, 'j');?> <?php echo date_format($post_date, 'F');?>, <?php echo date_format($post_date, 'Y');?></div>
                            <h4><a href="news-details.php?blog_id=<?=$post['post_id']?>"><?=$post['post_title']?></a></h4>
                            <div class="author-info">
                                <div class="image"><img src="images/resource/author-thumb-1.jpg" alt=""></div>
                                <div class="author-title"><a href="#"><?=$post['post_author']?></a></div>
                                
                            </div>
                        </div>
                    </div>
                </div>
            <?php  endwhile;?>    
            </div>
        
        </div>
    </section>
<?php include_once('footer.php');?>