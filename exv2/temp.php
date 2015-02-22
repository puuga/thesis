<?php include "db_connect_oo.php"; ?>
<?php
  //
?>
<!DOCTYPE html>
<html>
  <head>
    <?php include "head_meta.php"; ?>
    <title>template</title>

    <?php include "head_include.php"; ?>

    <script>
      $(document).ready(function() {
        $.material.init();
      });
    </script>

  </head>


  <body>
    <h1>You can add your site here.</h1>

    <h2>To ensure that material-design theme is working, check out the buttons below.</h2>

    <h3 class="text-muted">If you can see the ripple effect on clicking them, then you are good to go!</h3>


    <p class="bs-component">
        <a href="javascript:void(0)" class="btn btn-default">Default</a>
        <a href="javascript:void(0)" class="btn btn-primary">Primary</a>
        <a href="javascript:void(0)" class="btn btn-success">Success</a>
        <a href="javascript:void(0)" class="btn btn-info">Info</a>
        <a href="javascript:void(0)" class="btn btn-warning">Warning</a>
        <a href="javascript:void(0)" class="btn btn-danger">Danger</a>
        <a href="javascript:void(0)" class="btn btn-link">Link</a>
    </p>
    <p>
      <button type="button" class="btn btn-default" data-content="This is a snackbar! Lorem lipsum dolor sit amet..." data-toggle="snackbar" data-timeout="0">Show snackbar</button>
      <button type="button" class="btn btn-default" data-style="toast" data-content="This is a toast! Lorem lipsum dolor sit amet..." data-toggle="snackbar" data-timeout="0">Show toast</button>
    </p>
  </body>

</html>
<?php $conn->close(); ?>
