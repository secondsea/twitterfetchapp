<?php 
	require_once('twitter-api-php-master/TwitterAPIExchange.php');
class api {
	
	public $postarrary =array();
	public $settings = array();
	public  $apikey ;
	public $fillcount;
	public $errflags = array();
	
	
	public function __construct()
	{
		
	require_once("include/keys.php");
		
	} // end contruct
		
		

	public function emptycheck()
	{
	//	$this->errflags= array();
		$fields = array('tweettext','username','location');
		$this->fillcount=0;
		foreach($fields as $field)
		{
			if (!empty($this->postarray[$field]))
			{
			$this->fillcount++;
			}
		}
	
	//}
		if ($this->fillcount==0)
		{
			$this->errflags["nofields"]="err";
			 if (!empty($this->postarray['maxtweets']) )
			{
				$this->errflags["intalone"] ="err";
			}
		
		} 
		
		
		
		
	} // end emptycheck
	

		
	
	public function buildget()
	{
		$this->getfield="?q=";
		if(!empty($this->postarray['username']))
		{
			$validflag=$this->validatename($this->postarray['username']);
		     if (!$validflag)
			 {
				$this->errflags["namebogus"]="err";
			 }
			else 
			{	
			
			$this->getfield=$this->getfield . "from:" . $this->postarray['username'];
			}
		}
				
		if(!empty($this->postarray['tweettext']))
		{
			if(!empty($this->postarray['username']))
			{
				$this->getfield=$this->getfield."+";
			}
			
			$this->getfield=$this->getfield . $this->postarray['tweettext'];
		}
		if(!empty($this->postarray['location']))
		{
			$this->validatelocation($this->postarray['location'],$this->postarray['radius']);
		}
						
		if(!empty($this->postarray['maxtweets']))
		{
			if(filter_var($this->postarray['maxtweets'], FILTER_VALIDATE_INT) !== false)
			{
   				$this->getfield=$this->getfield . "&count=" .$this->postarray['maxtweets'];
			}	
			else
			{
				$this->errflags["noint"]="err";
			}
		}
		
	
	}   // end buildget
	
	
	public function validatename($username)
	{       $validflag=true;
			$settings =$this->settings;
			$url="https://api.twitter.com/1.1/users/lookup.json";
			$requestMethod = "GET";
			$getuser="?screen_name=".$username; 
		    $twitter = new TwitterAPIExchange($settings);
			 $string = json_decode($twitter->setGetfield($getuser)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),$assoc = TRUE);
			  if(isset($string["errors"][0]['message']))
			 {
				 $validflag=false;
			 }
			 return $validflag;
	} //validate 	
	
	
	

	public function validatelocation($location,$radius)
	{
		
		
		$address  =urlencode($location); //address to geocode
		$url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.$address.'&key='.$this->apikey;
		$data = file_get_contents($url);
		$loc = json_decode($data);
		if ($loc->status =="OK")
		{ 
			$lat=$loc->results[0]->geometry->location->lat;
			$long=$loc->results[0]->geometry->location->lng;
			$this->getfield=$this->getfield . "&geocode=" . $lat . "," .$long . "," .$_POST['radius']."mi";
			//echo "<br><br> lat:  " . $lat . "<br> long:  " . $long . "<br>";
		}
		else
		{
			$this->errflags["badloc"]="err";
		}
	
	}  // end loc
		
		
		
		
		
		
	public function gettweets()
	{	
		$settings =$this->settings;
		$url=$url="https://api.twitter.com/1.1/search/tweets.json";
		$requestMethod = "GET";
		$twitter = new TwitterAPIExchange($settings);
		$string = json_decode($twitter->setGetfield($this->getfield)
             ->buildOauth($url, $requestMethod)
             ->performRequest(),$assoc = TRUE);
		return $string;
	}
		
		
		
		
	public function runerrors() 
	{
		echo '	<div class="err">';
		if(isset($this->errflags['nofields'])) {	echo "<p>Please enter one field</p>";}
		if(isset($this->errflags['namebogus'])) { echo "<p>User name invalid</p>";}
		if(isset($this->errflags['noint'])) {echo "<p>Number of Max Tweets is not an integer</p>";}
		if(isset($this->errflags['badloc'])) {echo "<p>Location invalid</p>";}
		if(isset($this->errflags["intalone"] )){echo "<p>Max Tweets must be accoumpanied by another value";}
		echo "</div>";
	}
		
		
		
		
				
	public function listtweets()
	{
	$string=$this->gettweets();
		if (empty($string['statuses']))
		{
			?>
			<div id="tweet">
				No tweets found for the criteria you entered.
			</div>
			
			<?php
		}
	 $idx=0;
	 echo "<p>Drag tweets to rearrange order</p>";
		foreach($string as $items)	
		{
			if (isset($item['retweeted_status']['entities']))
			{
				$is_rt = 1; // Set 1 if retweeted
			} 
			else
			{
				$is_rt = 0; // Set 0 if original
			}
			$idx++;
			$tidx=0;
	
			foreach($items as $item)
			{
				if(isset( $item['text']))
				{	
			 ?>   <a  id="toggle<?php echo $tidx; ?>" href="javascript:unhide('tweet<?php echo $tidx; ?>');">Hide</a> 
		<div id="tweet<?php echo $tidx; ?>"draggable="true" 
		ondragstart="dragStarted(event)"  
		ondragover="draggingOver(event)" 
		ondrop="dropped(event)">
		
			Tweet:<?php echo $item['text'] ?></br>
			Time and Date of Tweet: <?php echo $item['created_at']?></br>
			Screen name: <?php echo  $item['user']['screen_name'] ;?></br>
			Location: <?php echo  $item['user']["location"];?> </br>
			Source:<?php  echo $item["source"]  ?></br>
			</div>		
		 <?php
					$tidx++;	
					}  // end is text set
				} // end for each item
			} // end for each string
	//		echo "<pre>";
//print_r($string);
//echo "</pre>";		

		} // end list tweets
	
	
	
	
	
	
	
	
	
	
	
	
	
}//end class
?>