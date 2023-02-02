<?php include('top.php');
$category_id = "";
$dish = "";
$dish_details = "";
$image = "";
$status = "";
$added_on = "";
$id = "";
$msg = "";
$image_status = 'required';
$image_error = "";





if (isset($_GET['id']) && $_GET['id'] > 0) {
  $id = get_safe_value($_GET['id']);
  $row = mysqli_fetch_assoc(mysqli_query($con, "select * from dish where id='$id'"));
  $category_id = $row['category_id'];
  $dish = $row['dish'];
  $dish_details = $row['dish_details'];
  $image = $row['image'];
  $status = $row['status'];
  $added_on = $row['added_on'];
  $image_status = '';

}




if (isset($_POST['submit'])) {

  


  
  $category_id = get_safe_value($_POST['category_id']);
  $dish = get_safe_value($_POST['dish']);
  $dish_details = get_safe_value($_POST['dish_details']);
  $added_on = date('Y-m-d h:i:s');

  if ($id == '') {
    $sql = "select * from dish where dish='$dish'";
  } else {
    $sql = "select * from dish where dish='$dish' and id!='$id'";
  }
  if (mysqli_num_rows(mysqli_query($con, $sql)) > 0) {
    $msg = "dish is allready  added ";
  } else {
    $type = $_FILES['image']['type'];
    if ($id == '') {
      if ($type !== 'image/jpeg' && $type != 'image/png') {
        $image_error = "Invalid image format";
      } else {



        $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
        move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE . $image);
        mysqli_query($con, "insert into dish (category_id,dish,dish_details,status,added_on,image)values('$category_id','$dish','$dish_details',1,'$added_on','$image')");
        $did=mysqli_insert_id($con);
        $attributeArr = $_POST['attribute'];
        $priceArr = $_POST['price'];

        foreach ($attributeArr as $key=>$val) {
          $attribute =$val;
          $price = $priceArr[$key];
          mysqli_query($con,"insert into dish_details(dish_id,attribute,price,status,added_on) values('$did','$attribute','$price',1,'$added_on')");
          echo "insert into dish_details(dish_id,attribute,price,status,added_on) values('$did','$attribute','$price',1,'$added_on')";
         
           
        }


        redirect('dish.php');



      }
    } else {
      $image_condition = "";
      if ($_FILES['image']['name'] != "") {
        if ($type != 'image/jpeg' && $type = 'image/png') {

          $image_error = "Invalid image format";

        } else {
          $image = rand(111111111, 999999999) . '_' . $_FILES['image']['name'];
          move_uploaded_file($_FILES['image']['tmp_name'], SERVER_DISH_IMAGE . $image);
          $image_condition = ", image='$image' ";
          $oldImageRow = mysqli_fetch_assoc(mysqli_query($con, "select image from dish where dish='$dish' and id!='$id'"));
          $oldImage = $oldImage['image'];
          unlink(SERVER_DISH_IMAGE . $oldImage);


        }


      }
      if ($image_error == '') {
        $sql = "update dish set category_id='$category_id',dish='$dish',
  dish_details='$dish_details' $image_condition where id='$id'";
        mysqli_query($con, $sql);
        redirect('dish.php');
      }




    }

  }

}


$res_category = mysqli_query($con, "select * from category where status='1' order by category asc");


?>

<div class="row">
  <h1 class="card-title grid_title ml15">Dish</h1>
  <div class="col-12 grid-margin stretch-card">
    <div class="card">
      <div class="card-body">
        <form class="forms-sample" method="Post" enctype="multipart/form-data">
          <div class="form-group">
            <label for="exampleInputName1">Category</label>
            <select class="form-control" name="category_id" required>
              <option value="">select Category</option>
              <?php
              while ($row_category = mysqli_fetch_assoc($res_category)) {
                if ($row_category['id'] == $category_id) {
                  echo "<option value='" . $row_category['id'] . "'selected>" . $row_category['category'] . "</option>";
                } else {
                  echo "<option value='" . $row_category['id'] . "'>" . $row_category['category'] . "</option>";
                }
              }
              ?>
            </select>
          </div>
          <div class="form-group">
            <label for="exampleInputName1">Dish</label>
            <input type="text" class="form-control" name="dish" value="<?php echo $dish ?>" required placeholder="dish">
          </div>
          <div class="error mt8">
            <?php echo $msg ?>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">dish details</label>
            <textarea name="dish_details" placeholder="Dish Details"
              class="form-control"><?php $dish_details ?></textarea>
          </div>
          <div class="form-group">
            <label for="exampleInputEmail3">dish Image</label>
            <input type="file" name="image" placeholder="Dish Image" class="form-control" <?php echo $image_status ?> />
          </div>

          <div class="error mt8">
            <?php echo $image_error ?>
          </div>
          <div class="form-group" id="dish_box1">
            <label for="exampleInputEmail3">dish Details</label>
          <?php if($id==0) {?>
            <div class="row">
              <div class="col-6">
                <input type="text" class="form-control" name="attribute[]" placeholder="attribute">
              </div>
              <div class="col-6">
                <input type="text" class="form-control" placeholder="price" name="price[]" placeholder="price">
              </div>
            </div>
            <?php } else {
            $dish_details_res = mysqli_query($con, "select * from dish_details where dish_id='$id'");
            $ii = 1;
            while ($dish_details_row = mysqli_fetch_assoc($dish_details_res)) {

              ?>
              <div class="row mt8">
              <div class="col-5">
                <input type="text" class="form-control" name="attribute[]" placeholder="attribute" value="<?php echo $dish_details_row['attribute'] ?>">
              </div>
              <div class="col-5">
                <input type="text" class="form-control" placeholder="price" name="price[]" placeholder="price" value="<?php echo $dish_details_row['price'] ?>">
              </div>
            
              <?php if ($ii != 1) {
                ?>
           <button type="button" class="btn badge-danger mr-2" onclick="remove_more()">Remove</button>
               <?php
              }
              ?>
               
            
            </div>
               <?php
               $ii++;
            }}?>
            </div>
            
            
          
         
          <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
          <button type="buttton" class="btn badge-danger mr-2" onclick="add_more()">Add More</button>


        </form>
      </div>
    </div>
  </div>
  <input type="textbox" id="add_more" value="1" hidden />

  <script>
    function add_more() {
      var add_more = jQuery('#add_more').val();
      var html = '<div class="row mt8" id="box' + add_more + '"><div class="col-5"><input type="text" class="form-control" placeholder="Attribute" name="attribute[]" required></div><div class="col-5"><input type="text" class="form-control" placeholder="Price" name="price[]" required></div><div class="col-2"><button type="button" class="btn badge-danger mr-2" onclick=remove_more("' + add_more + '")>Remove</button></div></div>';
      jQuery('#dish_box1').append(html);
    }

    function remove_more(id) {
      jQuery('#box' + id).remove();
    }

  </script>


  <?php include('footer.php'); ?>