<!DOCTYPE html>
<?php // Parameters for MySQL connection.
    $db_server = 'localhost';
    $database = 'hub';
    $db_table = 'styles';
    $db_user = 'user';
    $db_password = '1#Password';
?>
<html>
<head>
    <meta charset="utf8">
    <!-- Code is based on Bootstrap JS, using jquery etc. -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>QGIS Style-Hub</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
    <script>
      /* Function to copy text to user clip-board. Requires HTTPS or running on "localhost" to work */
      function updateClipboard(newClip) {
          navigator.clipboard.writeText(newClip).then(function() {
          /* clipboard successfully set */
          
        }, function() {
          /* clipboard write failed */
          alert('Your browser don\'t allow clipboard interaction with HTML5')
        });
      }

    </script>

      <!-- Custom styles for this bootstrap template -->
      <link href="album.css" rel="stylesheet">
</head>
<body>
<header>
        <div class="collapse bg-dark" id="navbarHeader"><!-- This is nomally hidden and shown via "hamburger menu" -->
          <div class="container">
            <div class="row">
              <div class="col-sm-8 col-md-7 py-4"> 
                <h4 class="text-white">About</h4>
                <p class="text-muted">Here you can browse free styles for QGIS. 
                All styles are downloadable, or you can copy the style urls and use them in QGIS to import the styles.<br>
                <br>This is a DEMO site and not a permanent solution. 
                It is under sporadic development and you can join the effort on GitHub. 
                The server requires a secure webserver (HTTPS), PHP and MySQL database to function properly.</p>
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
        <div class="navbar navbar-dark bg-dark shadow-sm"><!-- Main header/navbar area -->
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

        <section class="jumbotron text-center"><!-- Page landing area with information -->
          <div class="container">
            <h1>Style Hub</h1>
            <p class="lead text-muted">Collections of free to use QGIS style xml-files to download and import. 
              To use the url, click the copy button<sup>1</sup>, then paste the url in QGIS style manager import dialogue.
            </p>
            <a href="edit.php" type="button" class="btn btn-primary">Submit Style</a>
          </div>
        </section>
        
        <!-- Searching database -->
        <div class="album py-3 bg-light">
        <div class="container">
        <div class="row">
        <form action="#" method="POST" class="form-inline mx-auto">
          <div class="form-row mx-auto">
            <div class="col">
              <input type="text" class="form-control mb-5" id="searchtext" name="searchtext" placeholder="Search for ...">
            </div>
            <div class="col">
              <button type="submit" class="btn btn-info mb-2">Search</button>
            </div>
          </div>
        </form>
        </div>
        </div>
        </div>
        <?php
          // If there's a search string, get it.
          $searchstring = style_input($_POST['searchtext']);
          
          function style_input($data) {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
          }
        ?>
      
  <div class="album py-2 bg-light">
    <div class="container">
      <!--
        This is the main area where styles are listed in a "grid" controlled by Bootstrap
        adaptively.
        -->
      <div class="row">

      <?php
        try { // Try connect to database
            $db = new PDO("mysql:host=$db_server;dbname=$database", $db_user, $db_password);
            if(!$searchstring){
              $sql = "SELECT * FROM $db_table";
            } else {
              $sql = "SELECT * FROM $db_table WHERE styledescription LIKE '%$searchstring%' OR stylename LIKE '%$searchstring%'";
            }
            foreach($db->query($sql) as $row) {
              // Section below is repeated for every record in the database table
              $styleId = $row['id'];
              $styleName = $row['stylename'];
              $styleDescription = $row['styledescription'];
              $imageUrl = $row['stylepreview'];
              $styleUrl = $row['stylexml'];
              $styleCreator = $row['stylecreator'];

      ?>

        <!-- This is the html code for each style record -->
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
          <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <?php echo $styleName ?>
            <a href="edit.php?id=<?php echo $styleId ?>">
              <span class="badge badge-light">...</span>
            </a>
          </div></div>
          <div class="card-body">
            <button type="button" class="btn" data-toggle="modal" data-target="#modal" data-whatever="<?php echo $imageUrl ?>"><img class="img-fluid" alt="Responsive image" src="<?php echo $imageUrl ?>"></button>
            <p class="card-text"><?php echo $styleDescription ?></p>
            <div class="d-flex justify-content-between align-items-center">
              <div class="btn-group">
                <a class="btn btn-sm btn-outline-secondary" href="<?php echo $styleUrl ?>" role="button">XML</a>
                <button class="btn btn-sm btn-outline-secondary" onclick="updateClipboard('<?php echo $styleUrl ?>')">Copy</button>
              </div>
              <small class="text-muted"><?php echo $styleCreator ?></small>
              </div>
            </div>
          </div>
        </div>
        <!-- End Repeating style record code -->

        <?php
          } // If connection to database failed earlier:
            } catch (PDOException $e) {
              print "Error!: " . $e->getMessage() . "<br/>";
              die();
            }
        ?>
      </div>
    </div>
  </div>
</main>

<!-- Preview Style Modal. Visible when clicking on preview image -->
<div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modalLabel">Style Preview</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <img class="img-fluid rounded mx-auto d-block" src="">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
<script>
// Javascript code to control the modal. Called with 'data-toggle="modal"'
$('#modal').on('show.bs.modal', function (event) {
  var button = $(event.relatedTarget) // Button that triggered the modal
  var stylepreview = button.data('whatever') // Extract info from data-* attributes
  var modal = $(this)
  modal.find('.modal-body img').attr('src', stylepreview)
})
</script>
<!-- Preview Style Modal code ends-->

<!-- Footer for the page -->
<footer class="text-muted">
  <div class="container">
    <p class="float-right">
      <a href="#">Back to top</a>
    </p>
    <p><sup>1</sup> Copy Url button only works for HTTPS hosting. Use right-click copy on XML button instead.</p>
    <p>What is QGIS? <a href="https://qgis.org/">Visit the QGIS homepage</a> or read the <a href="https://docs.qgis.org/3.10/en/docs/user_manual/style_library/style_manager.html">Documentation</a> on styling.</p>
  </div>
</footer>

</body>
</html>