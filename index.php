<html>
	<head>
				<link href="include/style.css" rel="stylesheet" type="text/css" />
					<script src="include/jquery-3.2.1.min.js"></script>
				<script>
				
				function dragStarted(evt){
					//start drag
				source=evt.target;
				evt.dataTransfer.setData("text/plain", evt.target.innerHTML);
                evt.dataTransfer.effectAllowed = "move";
				}
				
				function draggingOver(evt){
					//drag over
					evt.preventDefault();
					//specify operation
					evt.dataTransfer.dropEffect = "move";
					
				}
					
					function dropped(evt){
//drop
evt.preventDefault();
evt.stopPropagation();
//update text in dragged item
source.innerHTML = evt.target.innerHTML;
//update text in drop target
evt.target.innerHTML = evt.dataTransfer.getData("text/plain");


					}
				
  function unhide(divID) {
    var item = document.getElementById(divID);
    if (item) {
      item.className=(item.className=='hidden')?'unhidden':'hidden';
	  
	 idx=divID.substr(5);
	 if (item.className=='hidden'){
		 console.log('hidden');
	 $('#toggle'+idx ).text('Reveal');
	 }else {
		 
		  $('#toggle'+idx ).text('Hide');
	 }
	 
	 
    }
  }

			
				</script>
	</head>
	<body>
<?php
require_once('apifetch.php');
$api=new api;

if(isset($_POST['submit']))
{
	
	$api->postarray=$_POST;
	$api->emptycheck();
	if($api->fillcount>0) 
	{
		$api->buildget();
	} 


}
	// }
	 ?>

			 
			 
	 
			 		
			 
		<form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
		<div id="twitform">
		
				<legend>Twitter Tweet Search</legend>
			      
			
		

						<label for="s1" id="s1">Text to search</label>
						<input type="text" <?php if( isset($api->errflags['nofields']) ) {echo 'class="err"';}?> name="tweettext"  id="s1">
					</br>
							<label for="s2">User name</label>
						<input type="text" <?php if(isset($api->errflags['namebogus']) ||  isset($api->errflags['nofields']) ) {echo 'class="err"';}?>  name="username" id="s2">
					</br>
					
						<label for="s3">Max Tweets</label>
						<input type="text" 	<?php if(isset($api->errflags['noint'])||  isset($api->errflags['nofields'])) {echo  'class="err"';} ?> name="maxtweets" id="s3">
					</br>
					   <label for="s4">Location </label>
					   <input type="text" <?php if(isset($api->errflags['badloc'])||  isset($api->errflags['nofields'])) {echo 'class="err"';}?>  name="location" >
					   radius
						<select name="radius">
							<option value="5">5 miles</option>
							<option value="10">10 miles</option>
							<option value="20">20 miles</option>
							<option value="50">50 miles</option>
					</select><br>
				   <input type="submit" name="submit" class="button" value="Submit Form"><br>
				<?php 	if (in_array('err', $api->errflags)) {
  $api->runerrors();
}

	//$api->listtweets();
?>
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
	
//	$api->postarray=$_POST;
//	$api->emptycheck();
//	if($api->fillcount>0) 
//	{
//		$api->buildget();
//	} 


if (!(in_array('err', $api->errflags)) ){
//  $api->runerrors();

	$api->listtweets();
}

			 
			 
	 
			 		
			 
}



//}  ?>
		</div>
	</body>
</html>
