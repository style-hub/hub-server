<?php

            $servername = 'localhost';
            $username = 'user';
            $password = '1#Password';
            $dbname = 'hub';

            
            $style_name = style_input($_POST["styleName"]);
            $style_creator = style_input($_POST["styleCreator"]);
            $style_description = style_input($_POST["styleDescription"]);
            $style_id = style_input($_POST['editStyle']);
            

            function style_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }


            $images_dir = "images/";
            $style_dir = "resources/";
            $image_file = $images_dir . basename($_FILES["submitPreview"]["name"]);
            $style_file = $style_dir . basename($_FILES["submitStyle"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($image_file,PATHINFO_EXTENSION));
            $styleFileType = strtolower(pathinfo($style_file,PATHINFO_EXTENSION));

            // Check first if it is (NOT) an edit
            if (!$style_id >> 0) {
            // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["submitPreview"]["tmp_name"]);
                if($check !== false) {
                    echo "Preview is an image - " . $check["mime"] . ".<br>";
                    $uploadOk = 1;
                } else {
                    echo "Preview is not an image.<br>";
                    $uploadOk = 0;
                }
            }

            // Check if files already exists
            if (file_exists($image_file)) {
                echo "Sorry, preview image (<a href='" . $image_file . "'>" . $image_file . "</a>) file already exists.<br>";
                $uploadOk = 0;
            }
            if (file_exists($style_file)) {
                echo "Sorry, style file (<a href='" . $style_file . "'>" . $style_file . "</a>) file already exists.<br>";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Sorry, your preview file is too large 500 KB limit.<br>";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if($imageFileType != "jpg" && $imageFileType != "png" ) {
                echo "Sorry, only JPG & PNG preview files are allowed.<br>";
                $uploadOk = 0;
            }
            if($styleFileType != "xml" ) {
                echo "Sorry, only xml files are allowed.<br>";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "Sorry, your upload did not work. Check your files.<br>";

            // if everything is ok, try to upload file
            } else {
            if (move_uploaded_file($_FILES["submitPreview"]["tmp_name"], $image_file)) {
                echo "The file ". basename( $_FILES["submitPreview"]["name"]). " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your preview file.<br>";
            }
            if (move_uploaded_file($_FILES["submitStyle"]["tmp_name"], $style_file)) {
                echo "The file ". basename( $_FILES["submitStyle"]["name"]). " has been uploaded.<br>";
            } else {
                echo "Sorry, there was an error uploading your style file.<br>";
            }
            }
            }
            if(isset($_POST["delete"])) {
                $style_delete = TRUE;
            } else {
                $styeo_delete = FALSE;
            }
            // Create connection to MySQL server
            $conn = new mysqli($servername, $username, $password, $dbname);
            // Check connection
            if ($conn->connect_error) {
              die("Connection to database failed: " . $conn->connect_error);
            }

            if ($style_delete) {
                $sql = "DELETE FROM hub.styles
                WHERE id = $style_id";
            } else if ($style_id >> 0) {
                $sql = "UPDATE hub.styles SET 
                    stylename='$style_name', 
                    stylecreator='$style_creator', 
                    styledescription='$style_description'
                WHERE id = $style_id";
            } else{
                $sql = "INSERT INTO hub.styles (stylename, stylecreator, styledescription, stylexml, stylepreview)
                VALUES ('" . $style_name . "', '" . $style_creator . "', '" . $style_description . "', '" . $style_file . "', '" . $image_file . "')";
            }
            if ($conn->query($sql) === TRUE) {
                if($style_id >> 0) { 
                    $responce = 'updated';
                } else if ($style_delete) { 
                    $responce = 'deleted';
                } else { 
                    $responce = 'created';
                }
              echo "New record $responce successfully";
              echo "Your submission should now be visible on the <a href='index.php'>Style Hub</a>";
            } else {
              echo "Error: " . $sql . "<br>" . $conn->error;
            }

            $conn->close();
        
    
        ?>

    