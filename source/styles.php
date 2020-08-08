<?php
  // Include header and database connection. Also set the current page session variable
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
                //if NOT logged in
                ?>
                <small>Login or Sign Up to submit styles.</small>
                <?php
              } else {
                // if logged in
                ?>
                <a href="style_submit.php" type="button" name="submit_style" class="btn btn-primary">Submit Style</a>
                <br><small>We humbly ask you to TEST your style-xml before you upload.</small>
                <?php
              }
            ?>

          </div>
        </section>
        

        <!-- Searching database form -->
        <div class="container mb-5">
          <form action="styles.php" method="POST">
            <div class="row form-row justify-content-md-center">
            <div class="col-auto">
              <input type="text" class="form-control form-control-sm" id="searchtext" name="searchtext" placeholder="Search for ...">
            </div>
            <div class="col-auto">
              <select class="form-control form-control-sm" name="filter">
                <option value="">No filter</option><!-- filter options -->
                <?php
                  if($_SESSION['username']){
                    //if logged in, add "your styles" option
                    echo('<option value="username">Your Styles</option>');
                  }
                ?>
                <option value="ismarker">Markers</option>
                <option value="isline">Lines</option>
                <option value="isfill">Fills</option>
                <option value="isramp">Color Ramps</option>
                <option value="istext">Texts</option>
                <option value="islabel">Labels</option>
                <option value="ispatch">Legend Patches</option>
              </select>
            </div>
            <div class="col-auto">
              <select class="form-control form-control-sm" name="sort"><!-- sorting order options -->
                <option value="">Newest first</option>
                <option value="featured">Featured first &#9733;</option>
                <option value="stylename">By Name</option>
                <option value="id">Oldest first</option>
              </select>
            </div>
            <div class="col-auto"><!-- submit button -->
              <button type="submit" name="search" class="btn btn-info btn-sm">Search/Apply</button>
            </div>      
            </div><!-- form-row -->
          </form>
        </div><!-- end search div -->
      
  <div class="album py-5 bg-light">
    <div class="container">
      <!--
        This is the main area where styles are listed in a "grid" controlled by Bootstrap
        adaptively.
        -->

      <div class="row">
      <?php
        // Test if the user has NOT clicked the search/apply button
        if(!isset($_POST['search'])){
          // Do not show all records at once, make pages
          if(!isset($_GET['firstitem'])){
            $startitem = 1;
          } else {
            $startitem = $_GET['firstitem'];
          }
          $iteminterval = 30;
          $pages = " LIMIT ".$startitem.", ".$iteminterval;
          $sql = "SELECT * FROM styles WHERE id>0 ORDER BY id DESC ".$pages.";";
        } else { // if the search button has been pressed then...
        $searchstring = $_POST['searchtext'];
        $pages = ";"; // no pages when searching

        // If no sort order is set
        if(!$_POST['sort']){
          $sort = " ORDER BY id DESC;";
        } else { // if a sort order IS set
          if($_POST['sort']=='stylename'){
            $sort = " ORDER BY stylename;";
          } else if ($_POST['sort']=='id'){
            $sort = " ORDER BY id;";
          } else if ($_POST['sort']=='featured'){
            $sort = " ORDER BY popular DESC, id DESC;";
          }
        }
        // If no filter is selected
        if(!$_POST['filter']){
            $filter = "";
            $filtered = false;
          } else { // if a filter IS selected
          if($_POST['filter']=='username'){
            $filter = ' AND byuser="'.$_SESSION['username'].'"';
          } else {
            $filter = ' AND '.$_POST['filter'].'=1';
          }
          $filtered = true;
        }
      
        // Create the SQL string for the list of styles to show
        if(!$searchstring){
            $sql = "SELECT * FROM styles WHERE id>0".$filter.$sort;
        } else {
          $filtered = true;
          $sql = "SELECT * FROM styles WHERE (styledescription LIKE '%".$searchstring."%' OR stylename LIKE '%".$searchstring."%') ".$filter.$sort;
        }
        } // end of search handeling sql

        // Get the raw database result
        $result = mysqli_query($conn, $sql);
        // count the number of rows
        $resultCheck = mysqli_num_rows($result);
        if ($resultCheck > 0) {
            // Set item counter
            $itemscounter=0;
            while($row = mysqli_fetch_assoc($result)) {
              // count the record as one item
              ++$itemscounter;
              // Section below is repeated for every record in the database table
              $styleId = $row['id'];
              $styleName = $row['stylename'];
              $styleDescription = $row['styledescription'];
              $imageUrl = $row['stylepreview'];
              $styleUrl = $row['stylexml'];
              $styleCreator = $row['stylecreator'];
              $styleUsername = $row['byuser'];
              $featured = $row['popular'];
              ?>

              <!-- This is the html code for each style record -->
              <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                  <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                    <?php echo($styleName);
                      if($featured>0){
                        echo(' &#9733;');
                      } 
                      if($_SESSION['username'] == $styleUsername OR $_SESSION['moderator']){
                        ?>
                        <a href="style_edit.php?id=<?php echo $styleId ?>">
                          <span class="badge badge-light">EDIT</span>
                        </a>
                        <?php
                      }
                    ?>
                    </div>
                  </div>
                  <div class="card-body">
                    <button type="button" class="btn" data-toggle="modal" data-target="#modal" data-whatever="<?php echo $imageUrl ?>"><img class="img-fluid" alt="Responsive image" src="<?php echo $imageUrl ?>"></button>
                    <p class="card-text"><?php echo $styleDescription ?></p>
                    <div class="d-flex justify-content-between align-items-center">
                      <div class="btn-group">
                        <a class="btn btn-sm btn-outline-secondary" href="<?php echo $styleUrl ?>" role="button">XML</a>
                        <button class="btn btn-sm btn-outline-secondary" onclick="updateClipboard('<?php echo $styleUrl ?>')">Copy</button>
                      </div>

                      <small class="text-muted"><?php 
                      if($_SESSION['moderator']){
                        echo ('<a href="users.php">'.$styleCreator.'</a>');
                      } else {
                        echo $styleCreator;
                      }
                      ?></small>
                    </div>
                  </div>
                </div>
              </div>
              <!-- End Repeating style record code -->

            <?php
            } 
        } 
      ?>
      </div><!-- Row -->

      <?php
      // Page navigation
      if(!isset($_POST['search'])){ // only do page navigation if search or filtering is not applied
      ?>
        <div class="container">
          <div class="row justify-content-md-center">
            <!-- navigation -->
            <?php 
            if($startitem>$iteminterval){
              echo('<a href="styles.php?firstitem='.($startitem-$iteminterval).'">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-left" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z"/>
              </svg></a>');
            }
            echo(' Page '.round(($startitem)/$iteminterval).' ');
            if($itemscounter==$iteminterval){
              echo('<a href="styles.php?firstitem='.($startitem+$iteminterval).'">
              <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-chevron-right" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
              </svg></a>');
            }
            ?>
          </div>
        </div>
      <?php
      } // End page navigation

      // If the list is filtered show a coloured indicator with text.
      if($filtered){
        ?>
        <div class="container">
          <div class="row bg-info justify-content-md-center">
            <small class="text-light">This is a filtered list. <a class="text-light" href="styles.php">[reset]</a></small>
          </div>
        </div>
        <?php
      }  
      ?>
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
        <img class="img-fluid rounded mx-auto d-block modal_img" src="">
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

<!-- This is a style specific footnote -->
<div class="containter mt-3">
  <div class="row justify-content-md-center">
    <small class="text-muted mx-auto"><sup>1</sup> Copy button only works with https hosting.</small>
  </div>
</div>

<?php
  // Include the footer
  require('footer.php');
?>