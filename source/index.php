<?php
  // include header and set the current page session variable
  require('header.php');
  $_SESSION['current_page'] = 'index.php';
?>

<main role="main">

  <div id="myCarousel" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
      <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
      <li data-target="#myCarousel" data-slide-to="1"></li>
      <li data-target="#myCarousel" data-slide-to="2"></li>
    </ol>
    <div class="carousel-inner">
      <div class="carousel-item active"><!-- First and default carousel item -->
        <img class="bd-placeholder-img" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" src="include/carousel_bg_styles.jpg">
        <div class="container">
          <div class="carousel-caption text-left">
            <h1>Style Hub</h1>
            <p>Style XML-files you directly can "copy" and "paste" to QGIS Style Manager and import to your user profile.</p>
            <p><a class="btn btn-lg btn-primary" href="styles.php" role="button">Go to the Style-Hub</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item"><!-- Second carousel item -->
      <img class="bd-placeholder-img" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" src="include/carousel_bg_layouts.jpg">
        <div class="container">
          <div class="carousel-caption">
            <h1>Layout Hub</h1>
            <p>Preview and download QGIS layout templates.</p>
            <p><a class="btn btn-lg btn-primary" href="layouts.php" role="button">Go to the Layout-Hub</a></p>
          </div>
        </div>
      </div>
      <div class="carousel-item"><!-- Third carousel item -->
      <img class="bd-placeholder-img" width="100%" height="100%" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" src="include/carousel_bg_future.jpg">
        <div class="container">
          <div class="carousel-caption text-right">
            <h1>Future Hub</h1>
            <p>What would you want as a "Hub" for QGIS resources.</p>
            <p><a class="btn btn-lg btn-primary" href="#" role="button">You Decide...</a></p>
          </div>
        </div>
      </div>
    </div>

    <!-- Previous and Next carousel item "buttons" -->
    <a class="carousel-control-prev" href="#myCarousel" role="button" data-slide="prev">
      <span class="carousel-control-prev-icon" aria-hidden="true"></span>
      <span class="sr-only">Previous</span>
    </a>
    <a class="carousel-control-next" href="#myCarousel" role="button" data-slide="next">
      <span class="carousel-control-next-icon" aria-hidden="true"></span>
      <span class="sr-only">Next</span>
    </a>
  </div><!-- Carousel -->


  <!-- This is the marketing style main content. -->
  <div class="container marketing">

    <!-- Three columns of text below the carousel -->
    <div class="row">
      <div class="col-lg-4">
        <img class="bd-placeholder-img rounded-circle" width="140" height="140" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140" src="include/marketing_bg_styles.png"><title>Placeholder</title>
        <h2>Style Hub</h2>
        <p>Styles are xml-files that is easy to share between QGIS users.
        You import and export the style-xml from the QGIS Style Manager.</p>
        <p><a class="btn btn-secondary" href="styles.php" role="button">Explore &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
      <img class="bd-placeholder-img rounded-circle" width="140" height="140" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140" src="include/marketing_bg_layouts.png">
        <h2>Layout Hub</h2>
        <p>Layout Templates are resources that can be shared between QGIS users as files.
        The files are exported from the layout window and you can open them from the QGIS browser.</p>
        <p><a class="btn btn-secondary" href="layouts.php" role="button">Explore &raquo;</a></p>
      </div><!-- /.col-lg-4 -->
      <div class="col-lg-4">
      <img class="bd-placeholder-img rounded-circle" width="140" height="140" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: 140x140" src="include/marketing_bg_future.png">
        <h2>Future Hub</h2>
        <p>In the hub, there's plenty of room for expansion to new resource areas.
        Commitment by the community will decide how successfull the hub will be, and what it will contain.</p>
        
      </div><!-- /.col-lg-4 -->
    </div><!-- /.row -->


    

  </div><!-- /.container -->

  <div class="container"><!-- information area -->
  <div class="row">
  <div class="col-md-6">
    <h2>Style-Hub</h2>
    <p>Styles in QGIS are great! If you want to share your styles with others, then the Style-Hub is one
    simple way to do this. You can browse and search the hub, or login/sign up and submit your own styles.</p>
    <p>The best styles to submit are either "single" styles, or styles that belong togeather. A huge group 
    of styles will be really hard to overview for other users. All styles submitted must be releasable under 
    the Creative Commons 0 (CC-0) license. Which essentially mean it will be Public Domain.</p>
    <p>Your style should be "self contained", and any SVG-markers should be "embedded" in the style. 
    If you use font markers, try to remember to name the used font in the style description when 
    you upload it. Export your styles from the QGIS Style Manager as xml-files, and capture a nice image (max 500kb) 
    in jpg or png format that shows of your style in a nice way. Then submit it to the hub.</p>
    <p>Find out more about QGIS styles in the 
    <a href="https://docs.qgis.org/testing/en/docs/user_manual/style_library/index.html">official documentation</a>.</p>
  </div>

  <div class="col-md-6">
    <h2>Layout-Hub</h2>
    <p>Layouts in QGIS are really powerfull! When you have created a layout you want to share, save it
    as a layout template from the QGIS layout application.</p>
    <p>The layout templets are files with a "qpt" extension, that can be opened from the QGIS Browser.</p>
    <p>You can also save the layouts to your own layout templates folder in your QGIS profile.</p>
    <p>Layouts can be infinetly more complex than styles, so you need to look out for dependencies
    for your layout that is required for it to work properly. Try and use SVG for graphics and "embed"
    them in the layout. Use simple fonts in texts, and you should avoid using custom functions in your
    expressions.</p>
    <p>You could also use online fonts with css to make sure your style transfers ok. Se the "Postcard"
    layout for an example.</p>
    <p>Find out more about QGIS layouts in the 
    <a href="https://docs.qgis.org/testing/en/docs/user_manual/print_composer/index.html">official documentation</a>.</p>
  </div>

  <div class="col-md-6">
    <h2>Future of the site</h2>
    <p>This site is a work in progress! At any time things may change, and the hosting is not fixed. 
    If the community finds the hub usefull, it is the developers ambition (wish), that it may be included 
    in the official QGIS site at <a href="https://qgis.org">qgis.org</a> and that continued maintenance
    and developement can be done by a larger group of volunteers.</p>
    <p>All code and documentation is located on GitHub where a "project" has been started, and for now it's easy 
    to add additional developers that are interested in working with the site.</p>
    <p>If you are interested you can find me on Twitter <a href="https://twitter.com/klaskarlsson">@klaskarlsson</a>
    and the GitHub repository is located at <a href="https://github.com/style-hub/hub-server">GitHub.com/style-hub/hub-server</a>
    </p>
    <p>Not quite ready to accept feature requests yet, but if you find a problem you can open an 
    <a href="https://github.com/style-hub/hub-server/issues">issue</a> on GitHub.</p>
  </div>
  </div><!-- row -->
  </div><!-- container -->
  </main>

<?php
  // include footer
  require('footer.php');
?>