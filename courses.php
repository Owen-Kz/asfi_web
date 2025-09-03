<?php include_once('header.php');?>
<title>Courses and workshops  || African Science Frontiers Initiatives (ASFI)</title>
    <!-- Page Title -->
    <section class="page-title" style="background-image:url(images/image6.jpg)">
        <div class="auto-container">
            <div class="content-box">
                <h1>Courses and workshops </h1>
                <ul class="bread-crumb">
                    <li><a class="home" href="index.php"><span class="fa fa-home"></span></a></li>
                    <li>Courses and workshops </li>
                </ul>
            </div>
        </div>
    </section>

  <!-- Causes Section Three -->
    <section class="causes-section-three style-two">
        <div class="auto-container">
            <div class="wrapper-box">
            <?php 
                    $result_courses = $db->query("SELECT * FROM `courses` ORDER BY course_id DESC  ");
                    while($courses = $result_courses->fetch_assoc()):
                ?>  
                <!-- Cause Block three -->
                <div class="cause-block-three style-two">
                    <div class="inner-box">
                        <div class="image">
                            <img src="admin/img/courses/<?=$courses['course_image']?>" alt="">
                        </div>
                        <div class="content-wrapper">
                            <!--Progress Levels-->
                            <div class="progress-levels style-two">
                                        
                                <!--Skill Box-->
                                <div class="progress-box wow fadeInRight" data-wow-delay="100ms" data-wow-duration="1500ms">
                                    <div class="inner">
                                        <div class="bar">
                                            <div class="bar-innner"><div class="bar-fill" data-percent="100"><div class="percent"></div></div></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="content">
                                <h4><a href="course-details.php?course_id=<?=$courses['course_id']?>"><?=$courses['course_title']?></a></h4>
                                <div class="text"><?php $body = $courses['course_details']; echo substr($body, 0, 100) , "...";?></div>
                               
                                <div class="donate-btn"><a href="course-details.php?course_id=<?=$courses['course_id']?>" class="theme-btn btn-style-eight"><span>See Course Details</span></a></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php  endwhile;?> 
            </div>
        </div>
    </section>

<?php include_once('footer.php');?>