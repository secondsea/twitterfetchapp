<html>
	<head>
				<link href="include/style.css" rel="stylesheet" type="text/css" />
	</head>
	<body>
<?php
require_once('apifetch.php');
$api=new api;
?>
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div id="twitform">
		
				<legend>Twitter Tweet Search</legend>
			        
						<label for="s1" id="s1">Text to search</label>
						<input type="text" name="tweettext"  id="s1">
					</br>
							<label for="s2">User name</label>
						<input type="text"  name="username" id="s2">
					</br>
					
						<label for="s3">Max Tweets</label>
						<input type="numeric" name="maxtweets" id="s3">
					</br>
					   <label for="s4">Location </label>
					   <input type="text"  name="location" >
					   radius
						<select name="radius">
							<option value="5">5 miles</option>
							<option value="10">10 miles</option>
							<option value="20">20 miles</option>
							<option value="50">50 miles</option>
					</select><br>
				   <input type="submit" name="submit" value="Submit Form"><br>
		
			</div>
		</form>
		
		<div id="content">
			<div id="error">
			

			</div>
		<?php 




// field names


// Loop over field names, make sure each one exists and is not empty



if(isset($_POST['submit']))
{
	
	$api->postarray=$_POST;
	$api->emptycheck();
	if($api->fillcount>0) 
	{
		$api->buildget();
	} 


if (in_array('err', $api->errflags)) {
  $api->runerrors();
}
else 
{
	$api->listtweets();
}
	 

			 
			 
	 
			 		
			 
}



//}  ?>
		</div>
	</body>
</html>
