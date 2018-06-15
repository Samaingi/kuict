<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Main</title>
<link href="styles.css" rel="stylesheet" type="text/css"/>
<style type="text/css">
#button{
	color:#000099;
	font-style:oblique;
}
</style>
</head>

<body div class="tdColor">
<form name="forms" action="look.php" method="get">
<input type="text" name="Location" placeholder="Search location"  />
<!--<a onclick="submit" href="search.php?Location=<?php //echo $row['Location'] ?>"  class="">--><input type="submit" name="search" value="Search" /></a></form>
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
			  include 'conn.php';
			  error_reporting(0);
                  $sql = " SELECT * FROM property WHERE Id!=0";
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
                  <td><?php echo $row['Contact']; ?></td><td>
		<a class="" href="book.php">
		<input type="button" value="Book A Room" id="button" title="book"  />
		</a></td> </tr>
                <?php

                }
                }
                 ?>

              </tr>
       </table>
	   
	   </div>

</body>
</html>
