<link rel="stylesheet" type="text/css" href="<?php echo "$pageHttps://$cdnUrl"; ?>/css/colorbox/colorbox.css" />
<script type="text/javascript" charset="utf-8" src="<?php echo "$pageHttps://$cdnUrl"; ?>/js/colorbox/jquery.colorbox.js"></script>
<script type="text/javascript" charset="utf-8" src="<?php echo "$pageHttps://$cdnUrl"; ?>/js/jquery.cycle2.js"></script>
<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>-->
<!--<script src="http://malsup.github.com/jquery.cycle2.js"></script>-->
<!-- CLNDR -->
<!-- http://kylestetz.github.io/CLNDR/ -->
<!-- https://github.com/kylestetz/CLNDR -->
<script type="text/javascript" src="js/moment.min.js"></script>
<script type="text/javascript" src="js/underscore-min.js"></script>
<script type="text/javascript" src="js/clndr.min.js"></script>
<!--<script type="text/javascript" src="/js/timeline.js"> currentDate = "1937-06-00"</script> -->
<!--<script src="<?php /*echo "$pageHttps://$cdnUrl";*/ ?>/Timeline/jquery.timeline.js"></script> -->
<!--<script src="js/jquery.touchSwipe.min.js"></script>-->

<script type="text/javascript">

$(document).ready(function(){
	var width=document.getElementById("sliderDiv").offsetWidth;
	var imageCount = document.getElementById("imageCount").innerHTML;
	//console.log("initial screen.width =" + width);
	//console.log("imageCount = " + imageCount);
		
	for(i = 0; i < imageCount; i++){
		var id = "img" + i;
		document.getElementById(id).style.clip="rect(0px, " + width +"px, 506px, 0px)";
	}
	
	/*if(!isIE8 && width>1279){
		var margin = (width-1380)/2;
		document.getElementById("calendar").style.marginRight= margin + "px";
		document.getElementById("calendar").style.width= 1380*0.5312 + "px";
		//console.log("maring = " + margin);
	}
	else{
		document.getElementById("calendar").style.marginRight= "initial";
		document.getElementById("calendar").style.width= "initial";
	}*/

	$(window).resize(function() {
	    //var width = window.innerWidth;
		var width=document.getElementById("sliderDiv").offsetWidth;
		var imageCount = document.getElementById("imageCount").innerHTML;
		//console.log("initial screen.width =" + width);
		//console.log("imageCount = " + imageCount);
		for(i = 0; i < imageCount; i++){
			var id = "img" + i;
			document.getElementById(id).style.clip="rect(0px, " + width +"px, 506px, 0px)";
		}
		/*if(width>1380){
			var margin = (width-1380)/2;
			document.getElementById("calendar").style.marginRight= margin + "px";
			document.getElementById("calendar").style.width= 1380*0.5312 + "px";
			//console.log("maring = " + margin);
		}
		else {
			//document.getElementById("calendar").style.marginRight= "initial";
			//document.getElementById("calendar").style.width= "initial";
		}*/
	});
	
</script>
<style>
#pager.cycle-pager li.cycle-pager-active {
	background-color: yellow;
}
.ie8 #pager.cycle-pager li.cycle-pager-active {
	background-color: "";
	background: url(/image/ie8_dot_yellow.png);
	background-size: 18px 18px;
}
.cycle-pager li {
	cursor: pointer;
}
#pager > * {
	cursor: pointer;
}
#pager li a:focus {
	background-color: red;
}
.prev {
	height: 57px;
	width: 52px;
	-webkit-box-shadow: 3px 3px 8px 0px rgba(255,255,255,0.47);
	-moz-box-shadow: 3px 3px 8px 0px rgba(255,255,255,0.47);
	box-shadow: 3px 3px 8px 0px rgba(255,255,255,0.47);
}
.next {
	height: 57px;
	width: 52px;
	-webkit-box-shadow: 3px 3px 8px 0px rgba(255,255,255,0.47);
	-moz-box-shadow: 3px 3px 8px 0px rgba(255,255,255,0.47);
	box-shadow: 3px 3px 8px 0px rgba(255,255,255,0.47);
}
.prev:hover, .next:hover {
	cursor: pointer;
	background-color: gray;
	opacity: 0.8;
}
</style>

<!--[if lt IE 10]><image class="bg_image" src ="/image/top_bg.jpg" style="position:absolute; top:0; width:100%; height:100%;"><![endif]-->
<div class="slider_box">

<!--slider 開始-->
<div id="sliderDiv" class="slider"> 
  <!--<div class="inner_pic"><img src="image/slider.png"></div>-->
  <div class="inner_pic">
    <div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-pause-on-hover="true" data-cycle-speed="2000" data-cycle-prev="#prev" 
        data-cycle-next="#next" data-cycle-pager="#pager" data-cycle-pager-template="" data-cycle-log="false" style="z-index:0;">
      <?php
			$sqlFile = "SELECT sn, name, nameExt, publishPassword FROM GtFile WHERE dirSn = ? AND type = ? ORDER BY rank DESC, sn DESC";
			$stmtFile = mysqli_prepare($dbLink, $sqlFile);
			$sn = 1;
			$result = mysqli_stmt_bind_param($stmtFile, 'ii', $sn, $GT_FILE_TYPE_SLIDESHOW_PHOTO);
			mysqli_stmt_execute($stmtFile);
			mysqli_stmt_store_result($stmtFile);
			mysqli_stmt_bind_result($stmtFile, $fileSn, $fileName, $fileExtension, $publishPassword);
			$imageCount = 0;
			while(mysqli_stmt_fetch($stmtFile)){
				if ($s3IsEnabled == 1) {
					$imageFile = "$pageHttps://$cdnS3Url/publish/$fileSn-$publishPassword/".urlencode($fileName);
					echo "<img id=\"img$imageCount\" class=\"cycle-slide\" src=\"$imageFile\" style=\"width:1920px; height:506px;\" alt=\"$fileName\">";
				} else {
					echo "<img id=\"img$imageCount\" class=\"cycle-slide\" src=\"/api/file/download_photo?sn=$fileSn\" style=\"width:1920px; height:506px;\" alt=\"$fileName\">";
				}
				$imageCount++;
			}

			echo "<div id=\"imageCount\" style=\"display:none\">$imageCount</div>";
					
			mysqli_stmt_free_result($stmtFile);
			mysqli_stmt_close($stmtFile);
		
		?>
      
      <!-- <img id="img1" class="cycle-slide" src="image/slider.png">
            <img id="img2" class="cycle-slide" src="image/slider.png">
            <img id="img3" class="cycle-slide" src="image/slider.png">
            <img id="img4" class="cycle-slide" src="image/slider.png">
            <img id="img5" class="cycle-slide" src="image/slider.png">--> 
    </div>
  </div>
  <!--<a href="#"><div class="prev" id="prev"></div></a>
     <a href="#"><div class="next" id="next"></div></a>-->
  <div class="prev" id="prev" style="top:0px; bottom:0px; margin-top: auto;  margin-bottom: auto";></div>
  <div class="next" id="next" style="top:0px; bottom:0px; margin-top: auto;  margin-bottom: auto"></div>
  <div class="photo_nav" id = "photo_nav">
    <ul id="pager" class="cycle-pager" >
      <?php 
	   	for ($i = 0; $i < $imageCount; $i++){
			if(preg_match('/(?i)msie [8]/',$_SERVER['HTTP_USER_AGENT'])){
				echo "<li></li>";
			}
			else{
				echo "<li></li>";
			}
		}
	   ?>
      <!--<li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>-->
    </ul>
  </div>
</div>
<!--slider_box--> 
<!--slider 結束--> 

<!--活動資訊 開始-->
<div class="other_content_first_child active_slider"> <a href="#">
  <div id="active_prev" class="active_prev"></div>
  </a> <a href="#">
  <div id="active_next" class="active_next"></div>
  </a>
  <div class="pin_left"></div>
  <div class="pin_right"></div>
  <div class="active_title"><?php echo $dirNameList[$dirIndexEvents] ?></div>
  <div id="active_pic" class="active_pic">
    <div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-pause-on-hover="true" data-cycle-speed="1000" data-cycle-prev="#active_prev" 
        	data-cycle-next="#active_next" data-cycle-log="false" data-cycle-caption="#slideshow-caption" data-cycle-caption-template="{{cycleTitle}}" style="z-index:1;"> <img src="image/active_pic.png" alt="抗戰史系列影展暨座談" class="cycle-slide" data-cycle-title="<a href='#'><span>[影展]</span></a> 抗戰史系列影展暨座談"> </div>
    <!--<img src="image/active_pic.png" alt="活動資訊">--> 
  </div>
  <!--active_pic-->
  <div class="active_list2">
    <div id="slideshow-caption"></div>
  </div>
</div>

<!--活動資訊 結束--> 

