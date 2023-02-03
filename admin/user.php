<?php include('top.php');

if(isset($_GET['type']) && $_GET['type']!== '' && isset($_GET['id']) && $_GET['id']>0)
{
  $type=get_safe_value($_GET['type']);
  $id=get_safe_value($_GET['id']);
  


if($type=='active' || $type='deactive'){
  $status=1;
  if($type=='deactive'){
    $status=0;
  }
  mysqli_query($con,"update user set status='$status'where id='$id'");
  redirect('user.php');
  }
}
$sql="select * from user order by id desc";
$res=mysqli_query($con,$sql);


?>

<div class="card">
            <div class="card-body">
              <h1 class="grid_title">User Master</h1>
              <div class="row grid_box">

                <div class="col-12">
                  <div class="table-responsive">
                    <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="10%">S.r. No #</th>
                            <th width="40%">Name</th>
                            <th  width="25%">Email</th>
                            <th  width="25%">mobile</th>
                            <th  width="25%">Added On</th>
                            <th  width="15%">Actions</th>
                            
                        </tr>
                      </thead>
                      <tbody>
                        <?php if(mysqli_num_rows($res)>0) { 
                          $i=1;
                          while($row=mysqli_fetch_assoc($res)){
                          ?>
                        
                        <tr>
                            <td><?php echo $i?></td>
                            <td><?php echo $row['name']?></td>
                            <td><?php echo $row['email']?></td>
                            <td><?php echo $row['mobile']?></td>
                            <td><?php $date=strtotime($row['added_on']);
                            echo date('d-m-Y');
                            ?></td>
                            <td>
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


