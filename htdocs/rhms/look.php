
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>Search results</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" type="text/css" href="style.css"/>
</head>
<body bgcolor="#CCCCCC">
<table >
          <tr><th>Id</th>
              <th>Image </th>
              <th>Owner</th>
			  <th>Title</th>
              <th>More_Infor</th>
			  <th>Location</th>
			  <th>Rent</th>
			  <th>Contact</th>
          </tr>
          <tr>
<?php
error_reporting(0);
require 'conn.php';
                  $sql = " SELECT property.Id,property.Image,property.Owner,property.Title,property.More_Infor,property.Rent,property.Contact FROM property WHERE Id LIKE '%$Id%'";
$result = mysql_query($sql) or die(mysql_error()); 
                   If(mysql_num_rows($result)>0)
                   {
                     while($row=mysql_fetch_array($result))
                     {  

                ?>

                  <tr><td><?php echo $row['Id'];?></td>
				  <td><img src="img/<?php echo $row['Image']; ?>" width="200" height="200" /></td> 
                  <td><?php echo $row['Owner']; ?></td> 
                  <td><?php echo $row['Title']; ?></td> 
				  <td><?php echo $row['More_Infor']; ?></td> 
				  <td><?php echo $row['Location']; ?></td> 
                  <td><?php echo $row['Rent']; ?></td> 
                  <td><?php echo $row['Contact']; ?></td> </tr>
                <?php

                }
                }
                 ?>
				
</body>
</html>