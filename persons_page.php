<section class="grid_8 left_list">
  <h2>Persons</h2>
  <table>
    <tr>
      <th>Name</th>
      <th>Surname</th>
      <th>Phone</th>
      <th>Location</th>
      <th>Room</th>
    </tr>
<?php
    $allPersons = $persons->getAllPersons();
    if($allPersons->rowCount() > 0)
    {
      while($person = $allPersons->fetchObject())
      {
?>
        <tr onMouseOver="this.className='highlight'" onMouseOut="this.className='normal'" onclick="location.href='?id=<?php echo $person->id?>';">
          <td><?php echo $person->name ?></td>
          <td><?php echo $person->surname ?></td>
          <td><?php echo $person->phone ?></td>
          <td><?php echo $person->location ?></td>
          <td><?php echo $person->room ?></td>
        </tr>
<?php
      }
    }
?>    
  </table>
</section>
<section class='grid_4'>
  <form action='index.php' method='post'>
  <?php
    $personEdit = '';
    if(isset($_GET['id'])) 
    {
      $personEdit = $persons->getPerson($s->san($_GET['id']));
      ?>
      <input type='hidden' name='id' value='<?php echo $personEdit->id ?>' />
      <h2>Edit person</h2>
  <?php
    }
    else {
  ?>
      <h2>New person</h2>
  <?php
    }
  ?>
    <div class='grid_6'><label for='name'>Name</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter name" required id="name" name="name" value='<?php echo $personEdit ? $personEdit->name : ""?>'></div>
    <div class='grid_6'><label for='surname'>Surame</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter surname" id="surname" name="surname" value='<?php echo $personEdit ? $personEdit->surname : ""?>'></div>
    <div class='grid_6'><label for='phone'>Phone</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter phone" id="phone" name="phone" value='<?php echo $personEdit ? $personEdit->phone : ""?>'></div>
    <div class='grid_6'><label for='location'>Location</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter location" id="location" name="location" value='<?php echo $personEdit ? $personEdit->location : ""?>'></div>
    <div class='grid_6'><label for='room'>Room</label></div>
    <div class='grid_6'><input type="text" placeholder="Enter room" id="room" name="room" value='<?php echo $personEdit ? $personEdit->room : ""?>'></div>
    <div class="grid_6"><input type="submit" value="Clear"></div>
    <div class="grid_6"><input type="submit" name="<?php echo $personEdit ? 'submitPersonEdit' : 'submitPersonNew' ?>" value="Submit"></div>


  </form>
</section>
<section class="grid_12">
  <div class="grid_3">
    <video controls>
      <source src="https://www.w3schools.com/tags/movie.mp4" type="video/mp4">
    </video>
  </div>
  <div class="grid_2">
    <ul>
      <li>List item #1</li>
      <li>List item #2</li>
      <li>List item #3</li>
    </ul>
  </div>
  <div class="grid_2">
    <ol>
      <li>List item #1</li>
      <li>List item #2</li>
      <li>List item #3</li>
    </ol>
  </div>
  <div class="grid_5">
    <form action="index.html" method="post">
      <div class="grid_6">
        <label for="name">Name</label>
        <input type="text" placeholder="Enter Your name" required id="name" name="name">
      </div>
      <div class="grid_6">
        <label for="pwd">Password:</label>
        <input type="password" id="pwd" name="pwd">
      </div>
      <div class="clear"></div>
      <div class="grid_6">
        <label for="color">Color</label>
        <input type="color" name="color">
      </div>
      <div class="grid_6">
        <label for="date">Date:</label>
        <input type="date" id="date" name="date">
      </div>
      <div class="clear"></div>
      <div class="grid_6">
        <label for="number">Number (between 1 and 50):</label>
        <input type="number" id="number" name="number" min="0" max="50" step="5">
      </div>
      <div class="grid_6">
        <label for="vol">Volume (between 0 and 50):</label>
        <input type="range" id="vol" name="vol" min="0" max="50">
      </div>
      <div class="clear"></div>
      <div class="grid_12">
        <input type="submit" name="submit" value="Submit form">
      </div>
    </form>
  </div>
</section>
