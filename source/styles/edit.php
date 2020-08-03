<!DOCTYPE html>
<?php
    $db_server = 'localhost';
    $database = 'hub';
    $db_table = 'styles';
    $db_user = 'user';
    $db_password = '1#Password';

    $editStyle = 0; /* Flag to edit a record */
    $buttonText = 'Submit';

    $id = $_GET["id"];
    if ($id >> 0) {
        $editStyle = 1;
        $buttonText = 'Update';
        try {
            $db = new PDO("mysql:host=$db_server;dbname=$database", $db_user, $db_password);
            foreach($db->query("SELECT * FROM $db_table WHERE id = $id") as $row) {
                $styleName = $row['stylename'];
                $styleDescription = $row['styledescription'];
                $imageUrl = $row['stylepreview'];
                $styleUrl = $row['stylexml'];
                $styleCreator = $row['stylecreator'];
            }
        }  catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    } else {
        $styleName = "";
        $styleDescription = "";
        $imageUrl = "";
        $styleUrl = "";
        $styleCreator = "";
    }
?>
<html>
<head>
    <meta charset="utf8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>QGIS Style-Hub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
      function updateClipboard(newClip) {
          navigator.clipboard.writeText(newClip).then(function() {
          /* clipboard successfully set */
          
        }, function() {
          /* clipboard write failed */
          alert('Your browser don\'t allow clipboard interaction with HTML5')
        });
      }

    </script>

      <!-- Custom styles for this template -->
      <link href="album.css" rel="stylesheet">
</head>
<body>
<header>
        <div class="collapse bg-dark" id="navbarHeader">
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-7 py-4">
                <h4 class="text-white">About</h4>
                <p class="text-muted">Here you can browse free styles for QGIS. All styles are downloadable, or you can copy the style urls and use them in QGIS to import the styles. If you want you can submit your own styles to this repository and they will be included, pending time and a quick review.<br>
                <br>This is a static DEMO site and not a permanent solution. That should include a "submit" form for easy contributing, search and filters, showing dynamic content. This requires an active server with PHP, database, etc.</p>
              </div>
              <div class="col-sm-4 offset-md-1 py-4">
                <h4 class="text-white">Contact</h4>
                <ul class="list-unstyled">
                  <li><a href="https://twitter.com/klaskarlsson" class="text-white">Follow on Twitter</a></li>
                  <li><a href="mailto:klas.karlsson@geosupportsystem.se" class="text-white">Email maintainer</a></li>
                  <li><a href="https://github.com/style-hub/style-hub.github.io" class="text-white">Fork on GitHub</a></li>
                  <li><a href="https://github.com/orgs/style-hub/people" class="text-white">Become Collaborator</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <div class="navbar navbar-dark bg-dark shadow-sm">
          <div class="container d-flex justify-content-between">
            <a href="../" class="navbar-brand d-flex align-items-center">
                <strong>QGIS Hub</strong>
            </a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>
          </div>
        </div>
      </header>
      <main role="main">
      <div class="container">
            <h1>Submit a style</h1>
            <p class="lead text-muted">
                Before you continue, you should have two files ready. The style xml-file and image (800x600) in
                jpg or png format that shows the style(-s) in a representative way.
            </p>
            <form action="upload.php" method="POST" enctype="multipart/form-data">
            <?php if (!$editStyle){ ?>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitStyle">Style XML-file</label>
                <input type="file" class="form-control-file" id="submitStyle" name="submitStyle">
                <small id="xmlHelp" class="form-text text-muted">Exported from QGIS style manager.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitPreview">Style Preview (jpg/png)</label>
                <input type="file" class="form-control-file" id="submitPreview" name="submitPreview">
                <small id="xmlHelp" class="form-text text-muted">Style preview image.</small>
            </div>
            </div>
            <?php } else { ?>
                <input type="hidden" id="editStyle" name="editStyle" value="<?php echo $id ?>">
            <?php } ?>
            <div class="form-row">
            <div class="form-group col-md-6">
                <label for="submitName">Style Name</label>
                <input type="text" class="form-control" id="submitName" aria-describedby="namelHelp" name="styleName" value="<?php echo $styleName ?>">
                <small id="nameHelp" class="form-text text-muted">Identifyable and representable of your style.</small>
            </div>
            <div class="form-group col-md-6">
                <label for="submitCreator">Style Creator</label>
                <input type="text" class="form-control" id="submitCreator" aria-describedby="submitHelp" name="styleCreator" value="<?php echo $styleCreator ?>">
                <small id="submitHelp" class="form-text text-muted">This is You! Take some credit for your work.</small>
            </div>
            </div>
            <div class="form-group">
                <label for="submitDescription">Description</label>
                <textarea class="form-control" id="submitDescription" rows="3" name="styleDescription"><?php echo $styleDescription ?></textarea>
                <small id="descriptionHelp" class="form-text text-muted">Short description of the style that may help users in searching for the "right one".</small>
            </div>
            <div class="form-group form-check">
                <input type="checkbox" class="form-check-input" id="submitCC0">
                <label class="form-check-label" for="submitCC0">The style is hereby released as Creative Commons 0 (CC-0)</label>
            </div>
            <div class="d-flex justify-content-between align-items-center">
                <button type="submit" class="btn btn-primary" name="submit"><?php echo $buttonText ?></button>
                <?php
                    if ($editStyle){
                        ?>
                            <button type="submit" class="btn btn-danger" name="delete">Delete</button>
                        <?php
                    }
                ?>
            </div>
            </form>
        </div>
        

      </main>

<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Back to top</a>
    </p>
    <p>What is QGIS? <a href="https://qgis.org/">Visit the QGIS homepage</a> or read the <a href="https://docs.qgis.org/3.10/en/docs/user_manual/style_library/style_manager.html">Documentation</a> on styling.</p>
  </div>
</footer>

</body>
</html>