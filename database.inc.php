<?php
$con=mysqli_connect('localhost','root','','online_food');

if(!$con)
{
    echo "Failed to connect to mysql";
}
else{
    echo "connection is sucessful";
}

?>