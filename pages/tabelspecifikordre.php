<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" />

<h2 class="text-center">Oversigt</h2>
<!-- 2 oversigter der viser stats -->
<!-- HENT DATA TIL HVILKEN ORDRER -->
<?php
$orderid = $_SESSION['order_id'];
?>

<!-- SKRIV DATA TIL STATS -->
<div class="container text-center mt-4">
    <div class="row justify-content-md-center">
        <div class="col-lg-2">
            <h6>Ordrer</h6>
            <div><span class="badge badge-pill badge-dark">#<?php echo $orderid;?></span></div>
            <div><span id="afvist" class="badge badge-pill badge-danger"></span></div>
            <div><span id="godkendt" class="badge badge-pill badge-success"></span></div>
        </div>
    </div>
</div>

<!-- Godkendknap -->
<?php
      $query = "SELECT * FROM psv2_orders WHERE id = '$orderid'";
      $result = mysqli_query($dbCon, $query) or die(mysqli_error($dbCon));
      $disableformrow = mysqli_fetch_array($result, MYSQLI_ASSOC);
            if (!empty($disableformrow['order_rejected'])) {
              echo '<div id="hideordreafvist" class="text-center"><span class="badge badge-danger">Ordre afvist. Du modtager en email/sms når dine billeder er færdig behandlet.</span></div>';
            } elseif(empty($disableformrow['order_approved'])) {
              echo '<div id="hidemanglergodkendelse" class="text-center"><span class="badge badge-warning">Mangler godkendelse</span></div>';
            } else {
              echo '<div id="hidegodkendt" class="text-center"><span class="badge badge-success">Ordren er godkendt!</span></div>';
            } ?>

<div class="m-3">
    <form method="post" action="godkend.php" id="godkendform">
        <input type="hidden" name="orderapproved" id="isorderapproved"
            value="<?php echo $disableformrow['order_approved'];?>"></input>
        <button type="button" id="godkendbtn" class="btn btn-success knapstorrelse pull-right mb-2">Godkend alle
            produktbilleder</button>
    </form>


    <!-- TABLE TIL ORDRELISTE -->
    <table class="table mx-auto mt-5">
        <thead class="thead-dark">
            <tr class="text-center">
                <th class="sorter-false filter-false">Packshots</th>
                <th class="sorter-false" data-placeholder="&#x1F50D;">Styles</th>
                <th class="filter-false sorter-false">Se kommentar</th>
            </tr>
        </thead>

        <!-- KODE TIL TABLEFOOTER -->
        <tfoot>
            <tr>
                <th colspan="7" class="ts-pager">
                    <div class="form-inline">
                        <div class="btn-group btn-group-sm mx-1" role="group">
                            <button type="button" class="btn btn-secondary first" title="first">⇤</button>
                            <button type="button" class="btn btn-secondary prev" title="previous">←</button>
                        </div>
                        <span class="pagedisplay"></span>
                        <div class="btn-group btn-group-sm mx-1" role="group">
                            <button type="button" class="btn btn-secondary next" title="next">→</button>
                            <button type="button" class="btn btn-secondary last" title="last">⇥</button>
                        </div>
                        <select class="form-control-sm custom-select px-4 mx-1 pagesize" title="Select page size">
                            <option selected="selected" value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                        </select>
                        <select class="form-control-sm custom-select px-4 mx-1 pagenum"
                            title="Select page number"></select>
                    </div>
                </th>
            </tr>
        </tfoot>

        <tbody>
            <?php
     $query = "SELECT * FROM psv2_orders_lines, psv2_orders WHERE psv2_orders_lines.order_id = '$orderid' AND psv2_orders.id = '$orderid'";
     $result = mysqli_query($dbCon, $query) or die(mysqli_error($dbCon));
     while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
     ?>
            <tr>
                <td class="text-center">
                    <!-- // Der laves en echo, hvor der udskrives ordrebilledernes destinationer.. -->
                    <div class="container text-center mt-2">
                        <div class="row justify-content-lg-center">
                            <div class="col-lg-4">
                                <span class='zoom ex2'>
                                    <img src="img/ordrer/<?php echo $orderid,"-", $rowcompany['company'], " ", $row['product'],"/", $row['style_1'],"1",".jpg";?>"
                                        alt="..." class="img-fluid imgsize">
                                </span>
                                <button type="button" class="btn btn-dark mt-2">Fuldopløsning eller marker fejl</button>
                            </div>
                            <div class="col-lg-4">
                                <span class='zoom ex2'>
                                    <img src="img/ordrer/<?php echo $orderid,"-", $rowcompany['company'], " ", $row['product'],"/", $row['style_1'],"2",".jpg";?>"
                                        alt="..." class="img-fluid imgsize">
                                </span>
                                <button type="button" class="btn btn-dark mt-2">Fuldopløsning eller marker fejl</button>
                            </div>
                        </div>
                    </div>


                </td>
                <td class="maxbredde">
                    <ul class="list-group">
                        <li class="list-group-item">
                            <h5>Style 1</h5>
                            <p><?php echo $row['style_1'];?>

                            </p>
                        </li>
                        <li class="list-group-item">
                            <h5>Style 2</h5>
                            <?php echo $row['style_2']; ?>
                        </li>
                        <li class="list-group-item">
                            <h5>Style 3</h5>
                            <?php echo $row['style_3']; ?>
                        </li>
                        <li class="list-group-item">
                            <h5>Style 4</h5>
                            <?php echo $row['style_4']; ?>
                        </li>
                    </ul>
                <td class="text-center">
                    <div class="container">
                        <div class="card">
                            <div class="card-body">
                                <?php echo $row['orderrejectcomment']; ?>
                            </div>
                        </div>
                    </div>
                </td>
                </td>
            </tr>

            <?php
     }
     ?>
        </tbody>
    </table>
</div>