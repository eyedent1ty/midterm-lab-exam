<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <title>Group 4: Midterm lab exam</title>
  <!-- Bootstrap for styling -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>
  <div class="container">
    <div class="row">
      <div class="col-md-4 col-sm-6">
        <!-- Form for inserting a new element in the array -->
        <form method="POST" class="mb-5">
          <h1>Insert</h1>
          <label for="insertPosition" class="form-label">Enter position (starts with 1): </label>
          <input type="number" class="form-control mb-3" placeholder="Position" id="insertPosition" name="insertPosition" required />

          <label for="value" class="form-label">Enter a value to be inserted: </label>
          <input type="number" class="form-control mb-3" placeholder="Value" id="value" name="value" required />

          <button type="submit" class="btn btn-success">Insert</button>
        </form>

        <!-- Form for deleting an existing element in the array -->
        <form method="POST" class="mb-5">
          <h1>Delete</h1>
          <label for="deletePosition" class="form-label">Enter position (starts with 1): </label>
          <input type="number" class="form-control mb-3" placeholder="Position" id="deletePosition" name="deletePosition" required />

          <button type="submit" class="btn btn-danger">Delete</button>
        </form>

        <!-- Form for displaying all the values in the array including its index -->
        <form method="POST" class="mb-5">
          <h1>View</h1>
          <label class="form-label d-block">Render elements</label>
          <button name="view" value="true" type="submit" class="btn btn-primary">View table</button>
        </form>
      </div>
      <div class="col-md-8 col-sm-6 text-center p-5">
        <?php
        session_start(); // preserve the previous version of array

        // Checks whether the arr is defined or not
        if (isset($_SESSION['arr'])) {
          $arr = $_SESSION['arr'];
        } else {
          $arr = []; // Set the default value for the arr
        }

        // When form is submitted:
        // Insert operation
        $insertPosition = $_POST['insertPosition'];
        $value = $_POST['value'];

        // Delete operation
        $deletePosition = $_POST['deletePosition'];

        // View operation
        $view = $_POST['view'] === 'true' ? true : false;

        // The current length of the array
        $arrLength = count($arr);

        // If the user sends the form for displaying the elements of the array
        if ($view) {
          if (empty($arr)) {
            // Display an error if the user click the view button when the array is empty
            echo '<h1 class="text-danger">Error: Array is empty</h1>';
            $renderArr = false;
          } else {
            $renderArr = true;
          }
        }

        // Checks to see if the user clicks the insert and the delete button
        if (isset($insertPosition) && isset($value)) {
          $index = $insertPosition - 1;
          // The index must be less than or equal to the length of the array and must be less than 0
          if ($index <= $arrLength && $index > -1) {
            // Adding a new element using array_splice built-in function from php
            array_splice($arr, $index, 0, $value);
            echo '<h1 class="text-success">Successfully added new element</h1>';
          } else {
            // Display an error if the user entered invalid position
            echo '<h1 class="text-danger">Error: Entered Invalid Position</h1>';
          }
        } else if (isset($deletePosition)) {
          $index = $deletePosition - 1;
          // The input for position must be less than to the length of the array
          if ($index < $arrLength && $index > -1) {
            // Deleting an existing element using array_splice built-in function from php
            array_splice($arr, $index, 1);
            echo '<h1 class="text-success">Successfully deleted existing element</h1>';
          } else if (empty($arr)) {
            // Display an error if the user try to delete an element even though the array is empty
            echo '<h1 class="text-danger">Error: Array is empty</h1>';
          } else {
            // Display an error if the user enter invalid position of an existing element
            echo '<h1 class="text-danger">Error: Entered Invalid Position</h1>';
          }
        }

        // Saved the value of the array
        $_SESSION['arr'] = $arr;
        ?>
        <!-- Renders the table if the user click the "view" button -->
        <?php if ($renderArr) : ?>
          <table class="table table-striped">
            <thead>
              <tr>
                <th scope="col">Position</th>
                <th scope="col">Value</th>
              </tr>
            </thead>
            <tbody>
              <!-- Iterate for every element in the array and display the key and value as table data -->
              <?php foreach ($arr as $key => $value) : ?>
                <tr>
                  <th scope="row"><?php echo $key + 1 ?></th>
                  <td><?php echo $value ?></td>
                </tr>
              <?php endforeach ?>
            </tbody>
          </table>
          <!-- End of iteration -->
        <?php endif ?>
      </div>
    </div>
  </div>
</body>

</html>