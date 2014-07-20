<?php
	include("../config/database.php");
	$keyword = $_POST['data'];
	$sql = "select organization_name from organization_master where organization_name like '".$keyword."%' limit 0,100";
	$result = mysql_query($sql) or die(mysql_error());
	if(mysql_num_rows($result))
	{
		echo '<ul class="list">';
		while($row = mysql_fetch_array($result))
		{
			$str = strtolower($row['organization_name']);
			$start = strpos($str,$keyword); 
			$end   = similar_text($str,$keyword); 
			$last = substr($str,$end,strlen($str));
			$first = substr($str,$start,$end);
			
			$final = '<span class="bold">'.$first.'</span>'.$last;
		
			echo '<li><a href=\'javascript:void(0);\'>'.$final.'</a></li>';
		}
		echo "</ul>";
	}
	else
		echo 0;
?>	   
