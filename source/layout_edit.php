<?php
    session_start();
    
    if(!$_SESSION['username']){
        header("Location: layouts.php");
        exit();
    }
    require('header.php');
    require('include/db_connect.inc.php');
    $_SESSION['current_page'] = 'layout_edit.php';

    // Get the edit record
    $sql = "SELECT * FROM layouts WHERE id=".$_GET['id'].";";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if ($resultCheck == 1) {
        $row = mysqli_fetch_assoc($result);
            $layoutId = $row['id'];
            $layoutName = $row['layoutname'];
            $layoutDescription = $row['layoutdescription'];
            $imageUrl = $row['layoutpreview'];
            $layoutUrl = $row['layoutqpt'];
            $layoutCreator = $row['layoutcreator'];
            $istiny = $row['istiny'];
            $issmall = $row['issmall'];
            $ismedium = $row['ismedium'];
            $islarge = $row['islarge'];
            $isscreen = $row['isscreen'];
            $layoutFeatured = $row['pupular'];
    }
?>

        <main role="main">
        <div class="container py-3">
            <h1>Edit your layout</h1>
            <p class="lead text-muted">
                Here you can edit metadata about your layout. You can also completely remove it from the hub if you want to.
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
            <form action="include/layout_edit.inc.php" method="POST" enctype="multipart/form-data">
            <!-- Files -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitLayout">Layout QPT-file</label>
                <input type="text" class="form-control-file" id="submitLayout" name="submitLayout" <?php echo('value="'.$layoutUrl.'" readonly'); ?>>
                <small id="xmlHelp" class="form-text text-muted">Saved as Template from QGIS layout.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitPreview">Layout Preview (jpg/png)</label>
                <input type="text" class="form-control-file" id="submitPreview" name="submitPreview" <?php echo('value="'.$imageUrl.'" readonly'); ?>>
                <small id="xmlHelp" class="form-text text-muted">Layout preview image.</small>
            </div>
            </div>
            <!-- Layout name and user -->
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitName">Layout Name</label>
                <input type="text" class="form-control" id="submitName" aria-describedby="namelHelp" name="layoutName" <?php echo('value="'.$layoutName.'"'); ?>>
                <small id="nameHelp" class="form-text text-muted">Identifyable and representable of your layout. (max 50 chars)</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitCreator">Style Creator</label>
                <input type="text" class="form-control" id="submitCreator" aria-describedby="submitHelp" name="layoutCreator" <?php echo('value="'.$layoutCreator.'"'); ?>>
                <small id="submitHelp" class="form-text text-muted">This is the person who created the layout. (max 50 chars)</small>
            </div>
            </div>
            <!-- Description of layout -->
            <div class="form-group">
                <label for="submitDescription">Description</label>
                <textarea class="form-control" id="submitDescription" rows="3" name="layoutDescription"> <?php echo($layoutDescription); ?></textarea>
                <small id="descriptionHelp" class="form-text text-muted">Short description of the layout that may help users in searching for the "right one". No HTML allowed. (max 255 chars)</small>
            </div>
            <div class="form-group">
            <label for="submitDescription">Layout is of the following approximate size:</label>
            <div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="istiny" value="1" name="istiny" <?php if($istiny){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="istiny">Tiny</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="issmall" value="1" name="issmall" <?php if($issmall){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="issmall">Small ( A4 / Letter )</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="ismedium" value="1" name="ismedium" <?php if($ismedium){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="ismedium">Medium ( A2-A3 / Tabloid - ANSI C )</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="islarge" value="1" name="islarge" <?php if($islarge){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="islarge">Large</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="isscreen" value="1" name="isscreen" <?php if($isscreen){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="isscreen">Screen (for web/digital)</label>
                </div>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" id="iselement" value="1" name="iselement" <?php if($isscreen){echo('checked="true"');} ?>>
                    <label class="form-check-label" for="isscreen">Layout Item (part of layout)</label>
                </div>
            </div>
            <small id="descriptionHelp" class="form-text text-muted">It will be easier for users 
            if the layout files do not use elaborate font styles, and only single pages.</small>
            </div>
            <?php if($_SESSION['moderator']){ // Only show for moderators ?> 
            <div class="form-group">
                <label for="submitDescription">Featured layouts [9=high, 1=low, 0=not featured]:</label>
                <input type="text" class="form-control" id="submitFeatured" maxlength="1" aria-describedby="submitHelp" name="layoutFeatured" <?php echo('value="'.$layoutFeatured.'"'); ?>>
                <small id="submitHelp" class="form-text text-muted">"More" featured layouts have a higher number (1-9).</small>
            </div><!-- form-group"-->
            <?php } ?>
            <input type="hidden" name="id" value="<?php echo($layoutId); ?>">
            <button type="submit" class="btn btn-primary" name="submit">Submit</button>
            <button type="submit" class="btn btn-danger float-right" name="delete">Delete</button>
            </form>
        </div>
        

      </main>
<?php
    require('footer.php');
?>