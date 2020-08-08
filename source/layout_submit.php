<?php
    // Include header
    require('header.php');
    if(!$_SESSION['username']){
        header("Location: layouts.php"); // only allow logged in users
        exit();
    }
?>

        <main role="main">
        <div class="container py-3">
            <h1>Submit a layout</h1>
            <p class="lead text-muted">
                Before you continue, you should have two files ready. The layout qpt-file and a preview image (about 800x800 pixels) in
                jpg or png format, that shows the layout in a representative way.
            </p>
            <?php
            if(isset($_GET['error'])){
                echo('<p class="text-warning">');
                if($_GET['error']=="incomplete"){
                    echo("The form was missing some information. Sorry, but you will need to try again.");
                } else if($_GET['error']=="license"){
                    echo("You must agree to releasing your layout as Creative Commons 0 (public domain) to upload to the layout-hub.");
                } else if($_GET['error']=="file"){
                    echo("File errors. Make sure you have selected both files, and that they are the correct type and not to large.");
                } else if($_GET['error']=="sql-error"){
                    echo("Database errors. There was an error trying to insert your information into the database.");
                }
                echo('</p>');
            }
            ?>
            <form action="include/layout_submit.inc.php" method="POST" enctype="multipart/form-data">
            <!-- Files -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitLayout">Layout QPT-file</label>
                <input type="file" class="form-control-file" id="submitLayout" name="submitLayout">
                <small id="xmlHelp" class="form-text text-muted">Saved as Template from QGIS layout (max 500kb).</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitPreview">Layout Preview (jpg/png)</label>
                <input type="file" class="form-control-file" id="submitPreview" name="submitPreview">
                <small id="xmlHelp" class="form-text text-muted">Layout preview image (max 500kb).</small>
            </div>
            </div>
            <!-- Style name and user -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitName">Layout Name</label>
                <input type="text" class="form-control" id="submitName" aria-describedby="namelHelp" name="layoutName" maxlength="50" value="<?php echo($_GET['name']) ?>">
                <small id="nameHelp" class="form-text text-muted">Identifyable and representable of your layout. (max 50 chars)</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitCreator">Layout Creator</label>
                <input type="text" class="form-control" id="submitCreator" aria-describedby="submitHelp" name="layoutCreator" maxlength="50" value="<?php echo($_GET['creator']) ?>">
                <small id="submitHelp" class="form-text text-muted">This is the person who created the layout. (max 50 chars)</small>
            </div>
            </div>
            <!-- Description of Layout -->
            <div class="form-group">
                <label for="submitDescription">Description</label>
                <textarea class="form-control" id="submitDescription" rows="3" name="layoutDescription"  maxlength="255"><?php echo($_GET['desc']) ?></textarea>
                <small id="descriptionHelp" class="form-text text-muted">Short description of the layout that may help users in searching for the "right one", include reference to any required resources. No HTML allowed. (max 255 chars)</small>
            </div>
            <div class="form-group">
            <label for="submitSize">Layout is of the folowing size:</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="istiny" value="1" name="istiny">
                    <label class="form-check-label" for="istiny">Tiny</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="issmall" value="1" name="issmall">
                    <label class="form-check-label" for="issmall">Small (A4/Letter)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="ismedium" value="1" name="ismedium">
                    <label class="form-check-label" for="ismedium">Medium (A2-A3/Tabloid-ANSI C)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="islarge" value="1" name="islarge">
                    <label class="form-check-label" for="islarge">Large</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="isscreen" value="1" name="isscreen">
                    <label class="form-check-label" for="isscreen">Screen (for web/digital)</label>
                </div>
            </div>
            <small id="descriptionHelp" class="form-text text-muted">It will be easier for users 
            if the layout files do not use elaborate fonts, and only single pages.</small>
            </div>
            <div class="form-chech bg-light">
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="submitCC0" name="license" value="1">
                <label class="form-check-label" for="submitCC0">The layout is hereby released as Creative Commons 0 (CC-0)</label>
            </div>
            </div>
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            </form>
        </div><!-- containter -->
        

      </main>
<?php
    // include footer
    require('footer.php');
?>