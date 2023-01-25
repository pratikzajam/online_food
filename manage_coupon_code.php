<?php include('top.php'); 
$name="";
$coupon_code="";
$coupon_type="";
$coupon_value="";
$cart_min_value="";
$expired_on="";
$id="";
$msg="";


if(isset($_GET['id']) && $_GET['id']>0){
  $id=get_safe_value($_GET['id']);
 $row=mysqli_fetch_assoc(mysqli_query($con,"select * from coupon_code where id='$id'"));
 $coupon_code=$row['coupon_code'];
 $coupon_type=$row['coupon_type'];
 $coupon_value=$row['coupon_value'];
 $cart_min_value=$row['cart_min_value'];
 $expired_on=$row['expired_on'];

}




if(isset($_POST['submit']))
{
  $coupon_code=get_safe_value($_POST['coupon_code']);
  $coupon_type=get_safe_value($_POST['coupon_type']);
  $coupon_value=get_safe_value($_POST['coupon_value']);
  $cart_min_value=get_safe_value($_POST['cart_min_value']);
  $expired_on=get_safe_value($_POST['expired_on']);
  $added_on=date('Y-m-d h:i:s');

  if($id=='')
  {
    $sql="select * from coupon_code where coupon_code='$coupon_code'";
  }
  else 
  {
    $sql="select * from coupon_code where coupon_code='$coupon_code' and id!='$id'";
  }
  if(mysqli_num_rows(mysqli_query($con,$sql))>0)
  {
    $msg="coupon code allready added ";
  }else{
  if($id==''){
   
   mysqli_query($con,"insert into coupon_code (coupon_code,coupon_type,coupon_value,cart_min_value,expired_on,status,added_on)values('$coupon_code','$coupon_type','$coupon_value',$cart_min_value,'$expired_on',1,'$added_on')");
  }else {
    mysqli_query($con,"update coupon_code set coupon_code='$coupon_code', coupon_type='$coupon_type' ,coupon_value='$coupon_value',cart_min_value='$cart_min_value',expired_on='$expired_on' where id='$id'");
  }
redirect('coupon_code.php');
  }

}
  



?>

<div class="row">
			<h1 class="card-title grid_title ml15">Manage coupon code</h1>
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <form class="forms-sample" method="Post">
                    <div class="form-group">
                      <label for="exampleInputName1">coupon_code</label>
                      <input type="text" class="form-control" name="coupon_code" value="<?php echo $coupon_code ?>" required placeholder="coupon_code">
                    </div>
                    <div class="error ">  <?php echo $msg ?> </div>
                    <div class="form-group">
                      <label for="exampleInputName1">coupon type</label>
                    <select name="coupon_type" value="<?php echo $coupon_type?>" required class="form-control">
                      <option value="">Select type</option>
                      <?php
                    $arr=array('p'=>'Percantage','F'=>'Fixed');
                    foreach($arr as $key=>$val){
                      if($key==$coupon_type){
                      echo "<option value='".$key."'>".$val."</option>";
                    }else{
                      echo "<option value='".$key."'>".$val."</option>";
                    }
                  }
                      ?>
                      </select>
                    </div>
                    <div class="form-group">
                    <label for="exampleInputName1">coupon value</label>
                      <input type="text" class="form-control" name="coupon_value" value="<?php echo $coupon_value?>" required placeholder="coupon value">
                </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">cart min value</label>
                      <input type="textbox" name="cart_min_value" value="<?php echo $cart_min_value?>" required class="form-control" id="exampleInputEmail3" placeholder="coupon_value">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Expired_on</label>
                      <input type="date" name="expired_on" value="<?php echo $expired_on?>" required class="form-control" id="exampleInputEmail3" placeholder="coupon_value">
                    </div>
              <button type="submit" name="submit" class="btn btn-primary mr-2">Submit</button>
                    
                  </form>
                </div>
              </div>
            </div>

<?php include('footer.php');?>


