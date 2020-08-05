<?php
    require('header.php');
    if(!$_SESSION['username']){
        header("Location: styles.php");
        exit();
    }
?>

        <main role="main">
        <div class="container py-3">
            <h1>Submit a style</h1>
            <p class="lead text-muted">
                Before you continue, you should have two files ready. The style xml-file and a preview image (about 800x600 pixels) in
                jpg or png format, that shows the style(-s) in a representative way.
            </p>
            <?php
            if(isset($_GET['error'])){
                echo('<p class="text-warning">');
                if($_GET['error']=="incomplete"){
                    echo("The form was missing some information. Sorry, but you will need to try again.");
                } else if($_GET['error']=="license"){
                    echo("You must agree to releasing your style as Creative Commons 0 (public domain) to upload to the style-hub.");
                } else if($_GET['error']=="file"){
                    echo("File errors. Make sure you have selected both files, and that they are the correct type and not to large.");
                } else if($_GET['error']=="sql-error"){
                    echo("Database errors. There was an error trying to insert your information into the database.");
                }
                echo('</p>');
            }
            ?>
            <form action="include/style_submit.inc.php" method="POST" enctype="multipart/form-data">
            <!-- Files -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitStyle">Style XML-file</label>
                <input type="file" class="form-control-file" id="submitStyle" name="submitStyle">
                <small id="xmlHelp" class="form-text text-muted">Exported from QGIS style manager (max 500kb).</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitPreview">Style Preview (jpg/png)</label>
                <input type="file" class="form-control-file" id="submitPreview" name="submitPreview">
                <small id="xmlHelp" class="form-text text-muted">Style preview image (max 500kb).</small>
            </div>
            </div>
            <!-- Style name and user -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitName">Style Name</label>
                <input type="text" class="form-control" id="submitName" aria-describedby="namelHelp" name="styleName" value="<?php echo($_GET['name']) ?>">
                <small id="nameHelp" class="form-text text-muted">Identifyable and representable of your style.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitCreator">Style Creator</label>
                <input type="text" class="form-control" id="submitCreator" aria-describedby="submitHelp" name="styleCreator" value="<?php echo($_GET['creator']) ?>">
                <small id="submitHelp" class="form-text text-muted">This is the person who created the style.</small>
            </div>
            </div>
            <!-- Description of style -->
            <div class="form-group">
                <label for="submitDescription">Description</label>
                <textarea class="form-control" id="submitDescription" rows="3" name="styleDescription"><?php echo($_GET['desc']) ?></textarea>
                <small id="descriptionHelp" class="form-text text-muted">Short description of the style that may help users in searching for the "right one".</small>
            </div>
            <div class="form-group">
            <label for="submitDescription">Style file contains one or more of the folowing type(s):</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="ismarker">
                    <label class="form-check-label" for="inlineCheckbox1">Marker</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="isline">
                    <label class="form-check-label" for="inlineCheckbox1">Line</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="isfill">
                    <label class="form-check-label" for="inlineCheckbox1">Fill</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="isramp">
                    <label class="form-check-label" for="inlineCheckbox1">Color Ramp</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="istext">
                    <label class="form-check-label" for="inlineCheckbox1">Text</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="islabel">
                    <label class="form-check-label" for="inlineCheckbox1">Label</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="inlineCheckbox1" value="1" name="ispatch">
                    <label class="form-check-label" for="inlineCheckbox1">Legend Patch</label>
                </div>
            </div>
            <small id="descriptionHelp" class="form-text text-muted">It will be easier for users if the style files contain only one styel, or connected styles in a theme.</small>
            </div>
            <div class="form-chech bg-light">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="submitCC0" name="license" value="1">
                <label class="form-check-label" for="submitCC0">The style is hereby released as Creative Commons 0 (CC-0)</label>
            </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div>
        

      </main>
<?php
    require('footer.php');
?>