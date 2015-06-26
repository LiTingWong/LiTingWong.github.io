<?php
//ini_set('display_errors', TRUE);
//error_reporting(E_ERROR);
include_once(getenv("DOCUMENT_ROOT")."/robot_sdk_pux4af98/gt_lib.php");



?>
<script type="text/javascript" charset="utf-8" src="<?php echo "$pageHttps://$cdnUrl"; ?>/js/jquery-1.11.1.min.js" ></script>
<script type="text/javascript" charset="utf-8" src="<?php echo "$pageHttps://$cdnUrl"; ?>/js/gt_lib.js"></script>
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
<script type="text/javascript" src="/js/timeline.js"></script> 

<link rel="stylesheet" type="text/css" href="<?php echo "$pageHttps://$cdnUrl"; ?>/css/jquery.circular-carousel.css" />
<script type="text/javascript" charset="utf-8" src="<?php echo "$pageHttps://$cdnUrl"; ?>/js/jquery.carouFredSel-6.2.1.js"></script>

<link rel="stylesheet" type="text/css" href="<?php echo "$pageHttps://$cdnUrl"; ?>/css/carousel.css" />
<script type="text/javascript" charset="utf-8" src="<?php echo "$pageHttps://$cdnUrl"; ?>/js/carousel.js"></script>

<!--<script src="<?php /*echo "$pageHttps://$cdnUrl";*/ ?>/Timeline/jquery.timeline.js"></script> --> 
<!--<script src="js/jquery.touchSwipe.min.js"></script>--> 




<script type="text/javascript">
/************ three slides carounsel ***********/
//carousel_!
$(function() {
	var $l = $('#carousel-left'),
		$c = $('#carousel-center'),
		$r = $('#carousel-right');
		
	$l.carouFredSel({
		auto: false,
		items: 1,
		direction: 'right',
		prev: {
			button: '#prev',
			fx: 'uncover',
			onBefore: function() {
				setTimeout(function() {
					$c.trigger( 'prev' );
				}, 100);
			}
		},
		next: {
			fx: 'cover'
		}
	});
	$c.carouFredSel({
		auto: false,
		items: 1,
		prev: {
			onBefore: function() {
				setTimeout(function() {
					$r.trigger( 'prev' );
				}, 100);
			}
		},
		next: {
			onBefore: function() {
				setTimeout(function() {
					$l.trigger( 'next' );
				}, 100);
			}
		}
	});
	$r.carouFredSel({
		auto: false,
		items: 1,
		prev: {
			fx: 'cover'
		},
		next: {
			button: '#next',
			fx: 'uncover',
			onBefore: function() {
				setTimeout(function() {
					$c.trigger( 'next' );
				}, 100);
			}
		}
	});
});
/************ end of three slides carounsel ***********/

/************ seven slides carousel **************/
$(document).ready(function(){
	 Carousel.init({
        target: $('.carousel')
    });
	//var auto = setInterval($('.carousel').moveCarousel($('.carousel').find('.carousel-wrapper li'), 'right', 'left'), 1000);
	//console.log($('.carousel'));
	//var auto = setInterval($('.carousel').find('.nav-right').trigger('click'), 1000);
	
	var timeoutHandler = null;
	function Aplay(){
		//$('.carousel').moveCarousel($('.carousel').find('.carousel-wrapper li'), 'right', 'left')
       	$('.carousel').find('.nav-right').trigger('click');
		timeoutHandler = setTimeout(function(){Aplay();},5000);
      }
      timeourHandler = setTimeout(Aplay(),50000);
	  

    $('#slider2').hover(function(){
        clearTimeout(timeoutHandler);
    },function(){
       timeoutHandler = setTimeout(function(){Aplay();},5000);
    });
});

/************ seven slides carousel **************/


</script>

<!-- 日曆template -->
<script id="calendar-template" type="text/template">


</script>

<style>


.sliderBox{
	wdith:100%;
	position:relative;
	height:600px;
	margin-top:50px;
	margin-bottom:50px;
}




</style>

<!--slider&今日活動 開始-->

<div class=sliderBox>
   
     <!--slider 開始-->
     <?php
		$sqlFile = "SELECT sn, name, nameExt FROM GtFile WHERE dirSn = ? AND type = ? ORDER BY rank DESC, sn DESC";
		$stmtFile = mysqli_prepare($dbLink, $sqlFile);
		$sn = 1;
		$result = mysqli_stmt_bind_param($stmtFile, 'ii', $sn, $GT_FILE_TYPE_SLIDESHOW_PHOTO);
		mysqli_stmt_execute($stmtFile);
		mysqli_stmt_store_result($stmtFile);
		mysqli_stmt_bind_result($stmtFile, $fileSn, $fileName, $fileExtension);
		$imageCount = 0;
		$strBuff = "";
		while(mysqli_stmt_fetch($stmtFile)){
			$strBuff = $strBuff. "<img src=\"/api/file/download_photo?sn=$fileSn\" style=\"width:450px; height:325px;\" alt=\"$fileName\">";
		}
		//var_dump($strBuff);
		echo '<div id="wrapper">';
			echo '<div id="carousel-left">';
			echo $strBuff;
			echo'</div>';
			
			echo '<div id="carousel-center" >';
			echo $strBuff;
			echo'</div>';
			
			echo '<div id="carousel-right">';
			echo $strBuff;
			echo'</div>';
			
			echo '<a id="prev" href="#">&lsaquo;</a><a id="next" href="#">&rsaquo;</a>';
		echo '</div>';
		mysqli_stmt_free_result($stmtFile);
		mysqli_stmt_close($stmtFile);
?>
</div>


<div id = "slider2" class=sliderBox>
    <div class="carousel">
        <?php 
			$sqlFile = "SELECT sn, name, nameExt FROM GtFile WHERE dirSn = ? AND type = ? ORDER BY rank DESC, sn DESC";
			$stmtFile = mysqli_prepare($dbLink, $sqlFile);
			$sn = 1;
			$result = mysqli_stmt_bind_param($stmtFile, 'ii', $sn, $GT_FILE_TYPE_SLIDESHOW_PHOTO);
			mysqli_stmt_execute($stmtFile);
			mysqli_stmt_store_result($stmtFile);
			mysqli_stmt_bind_result($stmtFile, $fileSn, $fileName, $fileExtension);
			$number = mysqli_stmt_num_rows($stmtFile);
			echo "<ul id = \"carousel-wrapper\" class=\"carousel-wrapper\" number=$number>";
        	while(mysqli_stmt_fetch($stmtFile)){
				echo "<li class=\"carousel-box\">";
				echo "<img src=\"/api/file/download_photo?sn=$fileSn&height=560\" alt=\"$fileName\">";
			}
			?>
        </ul>
        <div id = "activeBoxDiv"> 
        
        </div>
       <!-- <a class="nav-left">&lsaquo;</a>
		<a class="nav-right" style="right:0px;">&rsaquo;</a>-->
    </div>
</div>

    
     
     
     
     
     
     
     
     
     
     
     
     
    <!-- <div id="sliderDiv" class="slider">-->
     <!--<div class="inner_pic"><img src="image/slider.png"></div>-->
    <!-- <div class="inner_pic">
     	<div class="cycle-slideshow" data-cycle-fx="scrollHorz" data-cycle-pause-on-hover="true" data-cycle-speed="2000" data-cycle-prev="#prev" 
        data-cycle-next="#next" data-cycle-pager="#pager" data-cycle-pager-template="" data-cycle-log="false" style="z-index:0;">
        <?php
			/*$sqlFile = "SELECT sn, name, nameExt FROM GtFile WHERE dirSn = ? AND type = ? ORDER BY rank DESC, sn DESC";
			$stmtFile = mysqli_prepare($dbLink, $sqlFile);
			$sn = 1;
			$result = mysqli_stmt_bind_param($stmtFile, 'ii', $sn, $GT_FILE_TYPE_SLIDESHOW_PHOTO);
			mysqli_stmt_execute($stmtFile);
			mysqli_stmt_store_result($stmtFile);
			mysqli_stmt_bind_result($stmtFile, $fileSn, $fileName, $fileExtension);
			$imageCount = 0;
			while(mysqli_stmt_fetch($stmtFile)){
				echo "<img id=\"img$imageCount\" class=\"cycle-slide\" src=\"/api/file/download_photo?sn=$fileSn\" style=\"width:1920px; height:506px;\" alt=\"$fileName\">";
				$imageCount++;
				
			}

			echo "<div id=\"imageCount\" style=\"display:none\">$imageCount</div>";
					
			mysqli_stmt_free_result($stmtFile);
			mysqli_stmt_close($stmtFile);*/
		
		?>
        -->
        
           <!-- <img id="img1" class="cycle-slide" src="image/slider.png">
            <img id="img2" class="cycle-slide" src="image/slider.png">
            <img id="img3" class="cycle-slide" src="image/slider.png">
            <img id="img4" class="cycle-slide" src="image/slider.png">
            <img id="img5" class="cycle-slide" src="image/slider.png">-->
      <!--  </div>
     </div>-->
     <!--<a href="#"><div class="prev" id="prev"></div></a>
     <a href="#"><div class="next" id="next"></div></a>-->
    <!-- <div class="prev" id="prev" style="top:0px; bottom:0px; margin:auto 0 auto 1%"></div>
     <div class="next" id="next" style="top:0px; bottom:0px; margin:auto 1% auto 0"></div>-->
     
     <!--<div class="photo_nav">
       <ul id="pager" class="cycle-pager" >
       <?php 
	   	/*for ($i = 0; $i < $imageCount; $i++){
			echo "<li></li>";
		}*/
	   ?>
        <!--<li></li>
        <li></li>
        <li></li>
        <li></li>
        <li></li>-->
       <!--</ul>
     </div>
   </div><!--slider_box--> 
   <!--slider 結束-->
     
   
  <!--<div class="active_box" style="height:450px;">-->
     
     