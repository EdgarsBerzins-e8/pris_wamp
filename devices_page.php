<section class="grid_8 left_list">
  <h2>Devices</h2>
  <table>
    <tr>
      <th>Device</th>
      <th>Model</th>
    </tr>
<?php
    $allDevices = $devices->getAllDevices();
    if($allDevices->rowCount() > 0)
    {
      while($device = $allDevices->fetchObject())
      {
?>
        <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" onclick="location.href='?page=devices&id=<?php echo $device->id?>';">
          <td><?php echo $device->device ?></td>
          <td><?php echo $device->model ?></td>
        </tr>
<?php
      }
    }
?>    
  </table>
</section>
<section class='grid_4'>
  <form action='index.php?page=devices' method='post'>
  <?php
    $deviceEdit = '';
    if(isset($_GET['id'])) 
    {
      $deviceEdit = $devices->getDevice($s->san($_GET['id']));
      ?>
      <input type='hidden' name='id' value='<?php echo $deviceEdit->id ?>' />
      <h2>Edit device</h2>
  <?php
    }
    else {
  ?>
      <h2>New device</h2>
  <?php
    }
  ?>
    <div class='grid_6'><label for='device'>Device</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter device" required id="device" name="device" value='<?php echo $deviceEdit ? $deviceEdit->device : ""?>'></div>
    <div class='grid_6'><label for='model'>Model</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter model" id="model" name="model" value='<?php echo $deviceEdit ? $deviceEdit->model : ""?>'></div>
    <div class="grid_6"><input type="submit" value="Clear"></div>
    <div class="grid_6"><input type="submit" name="<?php echo $deviceEdit ? 'submitDeviceEdit' : 'submitDeviceNew' ?>" value="Submit"></div>


  </form>
</section>
