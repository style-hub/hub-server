<?php
    require('header.php');
    require('include/db_connect.inc.php');
    $_SESSION['current_page'] = 'styles.php';
?>

      
      <main role="main">

        <section class="jumbotron text-center"><!-- Page landing area with information -->
          <div class="container">
            <h1>Style Hub</h1>
            <p class="lead text-muted">Collections of free to use QGIS style xml-files to download and import. 
              To use the url, click the copy button<sup>1</sup>, then paste the url in QGIS style manager import dialogue.
            </p>
            <?php
              if(!$_SESSION['username']){
              //if not logged in
            ?>
            <small>Login or Sign Up to submit styles.</small>
            <?php
              } else {
            ?>
            <a href="style_submit.php" type="button" name="submit_style" class="btn btn-primary">Submit Style</a>
            <?php
              }
            ?>
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
              <button type="submit" name="search" class="btn btn-info mb-2">Search</button>
            </div>
          </div>
        </form>
        </div>
        </div>
        </div>
        <?php
          // If there's a search string, get it.
          if(isset($_POST['search'])){
            $searchstring = $_POST['searchtext'];
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
        if(!$searchstring){
            $sql = "SELECT * FROM $db_table ORDER BY id DESC;";
        } else {
            $sql = "SELECT * FROM $db_table WHERE styledescription LIKE '%$searchstring%' OR stylename LIKE '%$searchstring%';";
        }
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                // Section below is repeated for every record in the database table
              $styleId = $row['id'];
              $styleName = $row['stylename'];
              $styleDescription = $row['styledescription'];
              $imageUrl = $row['stylepreview'];
              $styleUrl = $row['stylexml'];
              $styleCreator = $row['stylecreator'];
              $styleUsername = $row['byuser'];
         

      ?>

        <!-- This is the html code for each style record -->
        <div class="col-md-4">
          <div class="card mb-4 shadow-sm">
          <div class="card-header">
          <div class="d-flex justify-content-between align-items-center">
            <?php echo $styleName; 
              if($_SESSION['username'] == $styleUsername){
            ?>
            <a href="style_edit.php?id=<?php echo $styleId ?>">
              <span class="badge badge-light">EDIT</span>
            </a>
            <?php
              }
            ?>
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
          } } 
            
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
<div class="containter mx-auto">
  <div class="row mx-auto">
    <small class="text-muted mx-auto"><sup>1</sup> Copy button only works with https hosting. Use rightclick and copy with the XML-button as workaround.</small>
  </div>
</div>
<?php
    require('footer.php');
?>