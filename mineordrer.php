<?php
ob_start();
?>

<?php
if (!isset($_SESSION)) session_start();
require_once('connection/conn.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="Anne Mette, Lasse og Morten">

  <title>Mine ordre - Packshoot</title>

  <script src="https://kit.fontawesome.com/b0508e4935.js" crossorigin="anonymous"></script>

<!-- CDN  BOOTSTRAP OG JQUERY-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"
  integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg=="
  crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"
  integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous">
</script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
  integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
  integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

<!-- TABLE SORTER -->
<script src="js/jquery.tablesorter.js"></script>
<script src="js/jquery.tablesorter.widgets.js"></script>
<link rel="stylesheet"
  href="https://cdnjs.cloudflare.com/ajax/libs/jquery.tablesorter/2.31.3/css/theme.bootstrap_4.min.css"
  integrity="sha512-2C6AmJKgt4B+bQc08/TwUeFKkq8CsBNlTaNcNgUmsDJSU1Fg+R6azDbho+ZzuxEkJnCjLZQMozSq3y97ZmgwjA=="
  crossorigin="anonymous" />

<!-- ZOOM -->
<script src='js/jquery.zoom.js'></script>

<!-- pager plugin -->
<link rel="stylesheet" href="css/jquery.tablesorter.pager.css">
<script src="js/jquery.tablesorter.pager.js"></script>

<!-- CSS FIL -->
<link href="css/style.css" rel="stylesheet">

  <style>
    .tablesorter-pager .btn-group-sm .btn {
      font-size: 1.2em;
      /* make pager arrows more visible */
    }
  </style>
    
</head>

<body>
<?php
		if (!isset($_SESSION['id'])) { //checks that the session contains the id, if not forbids access to the page
      echo "<p class='warn'>You are not authorized to access this page.</p>";
      header('Location: index.php');
      ob_flush();
			die();
		}
		elseif (isset($_SESSION['id'])) { //if the session contains a id, display the stored information
      $id = $_SESSION['id'];
		}
		?>


  <div class="d-flex" id="wrapper">

    <!-- Hent data til Virksomhedsnavn   -->
    <?php
  $query = "SELECT * FROM psv2_clients WHERE id = '$id'";
  $result = mysqli_query($dbCon, $query);
  $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
  ?>
    <!-- Sidebar -->
    <div class="bg-dark text-white border-right" id="sidebar-wrapper">
      <div class="sidebar-heading text-center"><?php echo $row['company']; ?></div>
      <div class="list-group list-group-flush">
        <span class="list-group-item list-group-item-action bg-dark text-white"><i class="fas fa-list-alt mx-2"></i>Mine ordrer</span>
      </div>
      <div class="card infoboks mx-auto">
        <div class="card-body text-center bg-light text-dark">
          <h5 class="card-title">Kontaktinfo:</h5>
          <p class="card-text">Kundeservice</p>
          <p class="card-text">+4571992110</p>
          <p class="card-text">service@packshoot.dk</p>
        </div>
      </div>
      <div class="text-center">
      <a href="pages/logout.php" type="button" class="btn btn-light text-dark mt-4 logud">Log ud</a>
      </div>
    </div>


    <div id="page-content-wrapper">
      <!-- Alt indhold på siden skal sættes ind HER -->
      <?php
require_once('pages/tabelsidemineordre.php');
?>
    </div>
</body>
<script src="js/javescript.js"></script>

</html>