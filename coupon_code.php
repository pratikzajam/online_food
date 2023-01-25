<?php include('top.php');




if(isset($_GET['type']) && $_GET['type']!== '' && isset($_GET['id']) && $_GET['id']>0)
{
  $type=get_safe_value($_GET['type']);
  $id=get_safe_value($_GET['id']);
  if($type=='delete'){
    mysqli_query($con,"delete from coupon_code where id='$id'");
    redirect('coupon_code.php');
  }
  


if($type=='active' || $type='deactive'){
  $status=1;
  if($type=='deactive'){
    $status=0;
  }
  mysqli_query($con,"update coupon_code set status='$status'where id='$id'");
  redirect('coupon_code');
  }
}
$sql="select * from coupon_code order by id desc";
$res=mysqli_query($con,$sql);


?>

<div class="card">
            <div class="card-body">
              <h1 class="grid_title">Coupon Code Master</h1>
              <a href="manage_coupon_code.php" class="add_link">Add coupon_code</a>
              <div class="row grid_box">

                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.r. No #</th>
                            <th width="15%"> Code/value</th>
                            <th width="15%"> Type</th>
                            <th  width="15%">Cart Min</th>
                            <th  width="15%">Expired_on</th>
                            <th  width="15%">Added on</th>
                            <th  width="20%">Actions</th>
                            </tr>
                      </thead>
                      <tbody>
                        <?php if(mysqli_num_rows($res)>0) { 
                          $i=1;
                          while($row=mysqli_fetch_assoc($res)){
                          ?>
                        
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $row['coupon_code']?> <br/> <?php echo $row['coupon_value']?></td>
                            <td><?php echo $row['coupon_type']?></td>
                            <td><?php echo $row['cart_min_value']?></td>
                            <td><?php 
                            if($row['expired_on']=='0000-00-00'){
                            }else{
                            echo $row['expired_on'];
                           } 
                           ?>
                          </td>
                            <td><?php $date=strtotime($row['added_on']);
                            echo date('d-m-Y');
                            ?></td>
                            <td>
                            <a href="manage_coupon_code.php?id=<?php echo $row['id']?>"><label class="badge badge-success hand_curosr">Edit</label></a>
                            &nbsp; 
                              <?php
                            if($row['status']==1)
                            {?>
                            <a href="?id=<?php echo $row['id']?>&type=deactive"><label class="badge badge-info hand_cursor">deactive</label></a>
                            <?php
                            }else{
                              ?>
                              <a href="?id=<?php echo $row['id']?>&type=active"><label class="badge badge-success hand_cursor">Active</label></a>
                              <?php
                            }
                            ?>
                            <a href="?id=<?php echo $row['id']?>&type=delete"><label class="badge badge-danger delete_red hand_cursor">Delete</label></a>
                            &nbsp;
                            
                          </td>
                            
                            
                            
                            
                            
                        </tr>
                        <?php } } else { ?>
                          <tr>
                          <td colspan="5">No data Found</td>
                        </tr>
                       <?php
                      $i++;
                      }?>
                      </tbody>
                    </table>
                  </div>
				</div>
              </div>
            </div>
          </div>

<?php include('footer.php');?>


