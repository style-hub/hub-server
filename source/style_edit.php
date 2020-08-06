<?php
    session_start();
    
    if(!$_SESSION['username']){
        header("Location: styles.php");
        exit();
    }
    require('header.php');
    require('include/db_connect.inc.php');
    $_SESSION['current_page'] = 'style_edit.php';

    // Get the edit record
    $sql = "SELECT * FROM styles WHERE id=".$_GET['id'].";";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck == 1) {
        $row = mysqli_fetch_assoc($result);
            $styleId = $row['id'];
            $styleName = $row['stylename'];
            $styleDescription = $row['styledescription'];
            $imageUrl = $row['stylepreview'];
            $styleUrl = $row['stylexml'];
            $styleCreator = $row['stylecreator'];
            $ismarker = $row['ismarker'];
            $isline = $row['isline'];
            $isfill = $row['isfill'];
            $isramp = $row['isramp'];
            $istext = $row['istext'];
            $islabel = $row['islabel'];
            $ispatch = $row['ispatch'];
    }
?>

        <main role="main">
        <div class="container py-3">
            <h1>Edit your style</h1>
            <p class="lead text-muted">
                Here you can edit metadata about your style. You can also completely remove it from the hub if you want to.
            </p>
            <?php
            if(isset($_GET['error'])){
                echo('<p class="text-warning">');
                if($_GET['error']=="incomplete"){
                    echo("The form was missing some information. Sorry, but you will need to try again.");
                } else if($_GET['error']=="sql-error"){
                    echo("Database errors. There was an error trying to insert your information into the database.");
                }
                echo('</p>');
            }
            ?>
            <form action="include/style_edit.inc.php" method="POST" enctype="multipart/form-data">
            <!-- Files -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitStyle">Style XML-file</label>
                <input type="text" class="form-control-file" id="submitStyle" name="submitStyle" <?php echo('value="'.$styleUrl.'" readonly'); ?>>
                <small id="xmlHelp" class="form-text text-muted">Exported from QGIS style manager.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitPreview">Style Preview (jpg/png)</label>
                <input type="text" class="form-control-file" id="submitPreview" name="submitPreview" <?php echo('value="'.$imageUrl.'" readonly'); ?>>
                <small id="xmlHelp" class="form-text text-muted">Style preview image.</small>
            </div>
            </div>
            <!-- Style name and user -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitName">Style Name</label>
                <input type="text" class="form-control" id="submitName" aria-describedby="namelHelp" name="styleName" <?php echo('value="'.$styleName.'"'); ?>>
                <small id="nameHelp" class="form-text text-muted">Identifyable and representable of your style. (max 50 chars)</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitCreator">Style Creator</label>
                <input type="text" class="form-control" id="submitCreator" aria-describedby="submitHelp" name="styleCreator" <?php echo('value="'.$styleCreator.'"'); ?>>
                <small id="submitHelp" class="form-text text-muted">This is the person who created the style. (max 50 chars)</small>
            </div>
            </div>
            <!-- Description of style -->
            <div class="form-group">
                <label for="submitDescription">Description</label>
                <textarea class="form-control" id="submitDescription" rows="3" name="styleDescription"> <?php echo($styleDescription); ?></textarea>
                <small id="descriptionHelp" class="form-text text-muted">Short description of the style that may help users in searching for the "right one". No HTML allowed. (max 255 chars)</small>
            </div>
            <div class="form-group">
            <label for="submitDescription">Style file contains one or more of the folowing type(s):</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="ismarker" <?php if($ismarker){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Marker</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="isline" <?php if($isline){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Line</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="isfill" <?php if($isfill){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Fill</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="isramp" <?php if($isramp){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Color Ramp</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="istext" <?php if($istext){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Text</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="islabel" <?php if($islabel){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Label</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="ispatch" <?php if($ispatch){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="inlineCheckbox1">Legend Patch</label>
                </div>
            </div>
            <small id="descriptionHelp" class="form-text text-muted">It will be easier for users if the style files contain only related styles.</small>
            </div>
            <input type="hidden" name="id" value="<?php echo($styleId); ?>">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button type="submit" class="btn btn-danger float-right" name="delete">Delete</button>
            </form>
        </div>
        

      </main>
<?php
    require('footer.php');
?>