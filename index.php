<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PDF TO TEXT CONVERTER</title>
    <!--To open external CSS for styling webpage-->
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <!--To create a section for webpage design-->
    <div class="hero">
        <div class="navbar">
            <video src="images/background.mp4" muted loop autoplay></video>
            <img src="images/logo.png" class="logo">

            <form action="index.php" method="POST" enctype="multipart/form-data">
                Select file to upload:
                <input class="pdf-file" type="file" name="pdf-file" accept="application/pdf">
                <input id="start_button" type="submit" value="Start" name="start_button">
            </form>
        </div>
        <!--To create a section for main page message-->
        <div class="content">
            <small>Welcome to PDF to TEXT Converter</small>
            <h1>Make Everything Quick And Simple</h1>
        </div>
        <nav>
            <ul>
                <li><a href="#">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
        </nav>
    </div>
    
    
    <?php
        
        if(isset($_POST["start_button"])) {                                             // To execute when the start_button is clicked
        $target_dir = "java/upload/";
        $target_file = $target_dir.basename($_FILES["pdf-file"]["name"]);
        $file_name = basename($_FILES["pdf-file"]["name"]);
        $file_type = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        $uploadedfile = 1;

        $store_name = fopen("java/retrieval.txt",'w');
        fwrite($store_name,$file_name);
        fclose($store_name);


        if($file_type != "pdf"){                                                        // To show warning if the file uploaded is in PDF format
            echo "<script>alert('The system only allows PDF Format File. Please upload again.')</script>";
            $uploadedfile = 0;
        }

        if($_FILES["pdf-file"]["size"] > 3145728){                                      // To show warning if maximum file size is exceeded which is 3 mb.
            echo "<script>alert('The file is uploaded exceed the maximum file size. Please compress the file and upload again.')</script>";
            $uploadedfile = 0;
        }

        if($uploadedfile==1) {                                                         // To upload file into folder if the file uploaded is a PDF format file     
            move_uploaded_file($_FILES["pdf-file"]["tmp_name"], $target_file);

            shell_exec("javac -cp java/pdfbox/* java/src/PDFBoxtoText.java");           //To call the pdfbox java program for conversion            
            shell_exec("java -cp java/pdfbox/* java/src/PDFBoxtoText.java");


            $folder = fopen("java/retrieval.txt",'r');
            $txt_retrieval = fgets($folder);
            
    ?>
            <!--To display download button to download converted file from pdf to text-->
            <div class="output-button-container">
                <div class="output-button-inner-container">
                    <h2>Your Text File Is Here: </h2>
                    <a href="java/text/<?php print $txt_retrieval; ?>" download="<?php print $txt_retrieval; ?>">   
                        <button class="download_button"><i class="fas fa-download icon"></i>Download</button>
                    </a>
                </div>
            </div>

    <?php

            exit();
        }
    }

    ?>
</body>
</html>