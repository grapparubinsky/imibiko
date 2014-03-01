<?php
include("include/config.php");
if($_POST)
  {
  $sql_res=mysqli_query("SELECT id, nome, cognome, anziano, servitore FROM proclamatori WHERE anziano = '1' OR servitore = '1' ORDER BY cognome");
  while($row=mysql_fetch_array($sql_res))
  {
  $name=$row['nme'].' '.$row['cognome'];
  $idp=$row['id'];
  ?>
  <div class="show" align="left">
  <span class="name"><?php echo $name; ?></span>&nbsp;<br/><?php echo $id; ?><br/>
  </div>
  <?php
  }
}