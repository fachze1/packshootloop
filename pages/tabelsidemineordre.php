
 <!-- INDSÆTTES KUNDENAVN OG HENT FRA DB -->
 <!-- OVERSIGT HEADER -->

 <h2 class="text-center">Oversigt</h2>

 <!-- 2 oversigter der viser stats -->

 <!-- HENT DATA TIL MANGLER GODKENDELSE-->
 <?php
  $query = "SELECT COUNT(*) FROM psv2_orders WHERE client_id = '$id' AND order_approved IS NULL";
  $result = mysqli_query($dbCon, $query);
  $countgodkendelse = mysqli_fetch_assoc($result)['COUNT(*)'];
  ?>

 <!-- HENT DATA TIL ANTAL ORDRER-->
 <?php
  $query = "SELECT COUNT(*) FROM psv2_orders WHERE client_id = '$id' AND id IS NOT NULL";
  $result = mysqli_query($dbCon, $query);
  $countordrer = mysqli_fetch_assoc($result)['COUNT(*)'];
  ?>

 <!-- SKRIV DATA TIL STATS -->
 <div class="container text-center mt-4">
   <div class="row justify-content-lg-center">
     <div class="col-lg-2">
       <h6>Ordrer</h6>
       <span class="badge badge-pill badge-dark"><?php echo $countordrer; ?></span>
     </div>
     <div class="col-lg-2">
       <h6>Mangler godkendelse</h6>
       <span class="badge badge-pill badge-dark"><?php echo $countgodkendelse; ?></span>
     </div>
   </div>
 </div>


 <!-- TABLE TIL ORDRELISTE -->
 <div class="container">
   <table class="table w-0 mx-auto mt-5">
     <thead class="thead-dark">
       <tr class="text-center">
         <th data-placeholder="&#x1F50D;">Dato</th>
         <th data-placeholder="&#x1F50D;">OrdreID</th>
         <th class="sorter-false" data-placeholder="&#x1F50D;">Produktnavn</th>
         <th class="sorter-false filter-false">Antal</th>
         <th class="filter-false">Status</th>
         <th class="sorter-false filter-false"></th>
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
               <option selected="selected" value="10">10</option>
               <option value="20">20</option>
               <option value="30">30</option>
             </select>
             <select class="form-control-sm custom-select px-4 mx-1 pagenum" title="Select page number"></select>
           </div>
         </th>
       </tr>
     </tfoot>
     <tbody>
       <?php
      $query = "SELECT * FROM psv2_orders WHERE client_id = '$id'";
      $result = mysqli_query($dbCon, $query) or die(mysqli_error($dbCon));
      while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        // FORMATER DATO TIL LÆSELIG.
        $date = $row['created'];
        $newDate = date("d-m-Y", strtotime($date));
      ?>
       <tr>
         <td class="text-center"><?php echo $newDate ?></td>
         <td class="text-center"> <?php echo $row['id']; ?></td>
         <td><?php echo $row['product']; ?></td>
         <td class="text-center"><?php echo $row['qty']; ?></td>
         <td class="text-center">
           <?php
            if (!empty($row['order_rejected'])) {
              echo '<span class="badge badge-danger">Ordre afvist</span>';
            } elseif(empty($row['order_approved'])) {
              echo '<span class="badge badge-warning">Mangler godkendelse</span>';
            } else {
              echo '<span class="badge badge-success">Godkendt</span>';
            } ?></td>

<?php
		if (isset($_POST['order_id'])) {
      $orderid = $_POST['order_id'];
      $_SESSION['order_id'] = $orderid;
      header('Location: seordre.php');
      ob_flush();
    }
    ?>
         <form method="post">
           <td class="text-center">
             <button type="submit" class="btn btn-dark" name="order_id" value="<?php echo $row['id']; ?>">Se
               ordre</button>
           </td>
         </form>

       </tr>
       <?php
      }
      ?>
     </tbody>
   </table>
 </div>