<section class="grid_8 left_list">
  <h2>Systems</h2>
  <table>
    <tr>
      <th>Name</th>
    </tr>
<?php
    $allSystems = $systems->getAllSystems();
    if($allSystems->rowCount() > 0)
    {
      while($system = $allSystems->fetchObject())
      {
?>
        <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" onclick="location.href='?page=systems&id=<?php echo $system->id?>';">
          <td><?php echo $system->name ?></td>
        </tr>
<?php
      }
    }
?>    
  </table>
</section>
<section class='grid_4'>
  <form action='index.php?page=systems' method='post'>
  <?php
    $systemEdit = '';
    if(isset($_GET['id'])) 
    {
      $systemEdit = $systems->getSystem($s->san($_GET['id']));
      ?>
      <input type='hidden' name='id' value='<?php echo $systemEdit->id ?>' />
      <h2>Edit system</h2>
  <?php
    }
    else {
  ?>
      <h2>New system</h2>
  <?php
    }
  ?>
    <div class='grid_6'><label for='name'>Name of system</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter system" required id="name" name="name" value='<?php echo $systemEdit ? $systemEdit->name : ""?>'></div>
    <div class="grid_6"><input type="submit" value="Clear"></div>
    <div class="grid_6"><input type="submit" name="<?php echo $systemEdit ? 'submitSystemEdit' : 'submitSystemNew' ?>" value="Submit"></div>


  </form>
</section>
