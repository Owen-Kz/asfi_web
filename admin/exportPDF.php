<?php
    require 'vendor/autoload.php';
  if(!isset($_GET['abstract_id'])){
	echo "<script> window.location.href='asfi_abstract.php';</script>";
	exit();
    }else{

        include ('../includes/db_connect.php');

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
        endwhile;

    }

  // reference the Dompdf namespace
    use Dompdf\Dompdf;

    // instantiate and use the dompdf class
    $dompdf = new Dompdf();
    $htmlContent = "
                                    <h3><b>DATE OF SUBMISSION</b></h3>
                                    <p>$date</p>
                                    <hr>
                                    <h3><b>AUTHOR'S TITLE</b></h3>
                                    <p>$author_title</p>
                                    <hr>
                                    <h3><b>AUTHOR'S NAME</b></h3>
                                    <p>$author</p>
                                    <hr>
                                    <h3><b>AUTHOR'S EMAIL</b></h3>
                                    <p>$author_email</p>
                                    <hr>
                                    <h3><b>AUTHOR'S WHATSAPP PHONE NUMBER</b></h3>
                                    <p>$wphone_number</p>
                                    <hr>
                                    <h3><b>AUTHOR'S GENDER</b></h3>
                                    <p>$gender</p>
                                    <hr>
                                    <h3><b>AUTHOR'S HIGHEST DEGREE EARNED</b></h3>
                                    <p>$highest_degree</p>
                                    <hr>
                                    <h3><b>COUNTRY OF RESIDENCE</b></h3>
                                    <p>$country_residence</p>
                                    <hr>
                                    <h3><b>COUNTRY OF ORIGIN</b></h3>
                                    <p>$country_origin</p>
                                    <hr>
                                    <h3><b>PRESENTER BIOGRAPHY</b></h3>
                                    <p>$presenter_biography</p>
                                    <hr>
                                    <h3><b>PRESENTATION TYPE</b></h3>
                                    <p>$presentation_type</p>
                                    <hr>
                                    <h3><b>STATE OF STUDY</b></h3>
                                    <p>$State_of_study</p>
                                    <hr>
    
    ";
    
    if (!empty($theme)) {
        $htmlContent .= "
            <h3><b>THEME</b></h3>
            <p>$theme</p>
            <hr>
        ";
    }
    
    $htmlContent .= "
        <h3><b>SPECIAL REQUESTS</b></h3>
        <p>$special_request</p>
        <hr>
        <h3><b>TITLE</b></h3>
        <p>$title</p>
        <hr>
        <h3><b>AFFILIATION(S)</b></h3>
        <p>$affliliation</p>
        <hr>
        <h3><b>ABSTRACT</b></h3>
        <p>$abstract</p>
    ";

    $dompdf->loadHtml($htmlContent);

    // (Optional) Setup the paper size and orientation
    $dompdf->setPaper('A4', 'landscape');

    // Render the HTML as PDF
    $dompdf->render();

    // Output the generated PDF to Browser
    $dompdf->stream();

?>


