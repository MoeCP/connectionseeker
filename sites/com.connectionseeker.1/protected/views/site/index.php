<?php
$this->pageTitle=Yii::app()->name." -- Find out what you need";

$cs=Yii::app()->clientScript;
$cs->registerCoreScript( 'jquery.ui' );
$cs->registerScriptFile(Yii::app()->theme->baseUrl . '/js/slides.min.jquery.js', CClientScript::POS_HEAD);


?>

<img src="<?php echo Yii::app()->theme->baseUrl; ?>/images/home-buttons.png" border="0" usemap="#Map" />
<map name="Map" id="Map">
  <area shape="rect" coords="33,8,212,52" href="<?php echo Yii::app()->createUrl('/site/publisher');?>" />
  <area shape="rect" coords="321,7,500,56" href="<?php echo Yii::app()->createUrl('/site/marketer');?>" />
</map>

<!--
<div id="slides">
    <div class="slides_container">
        <div class="slide">
            <a href="#" target="_blank">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/site/slide_1.jpg" width="940" height="370"></a>
            <div class="caption">
                <p>Do you worry about your website page rank?</p>
            </div>
        </div>
        <div class="slide">
            <a href="#" target="_blank">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/site/slide_2.jpg" width="940" height="370"></a>
            <div class="caption">
                <p>Do you wanna your website have a good reputation?</p>
            </div>
        </div>
        <div class="slide">
            <a href="#" target="_blank">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/site/slide_3.jpg" width="940" height="370"></a>
            <div class="caption">
                <p>Connection Seeker, it will build the links with good reputation you wanna!</p>
            </div>
        </div>
        <div class="slide">
            <a href="#" target="_blank">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/site/slide_4.jpg" width="940" height="370"></a>
            <div class="caption">
                <p>What are you waiting for?</p>
            </div>
        </div>
        <div class="slide">
            <a href="#" target="_blank">
            <img src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/site/slide_5.jpg" width="940" height="370"></a>
            <div class="caption">
                <p>Sign up today!</p>
            </div>
        </div>
    </div>
    <div class="clear"></div>

    <div id="tagline">
        <img width="304" height="84" src="<?php //echo Yii::app()->theme->baseUrl; ?>/images/site/marketing.png" alt="Sign up today">
    </div>

    <div id="signupbtns">
        <ol class="olbutton">
          <li>
            <a href="<?php //echo Yii::app()->createUrl('/site/marketer');?>">
              <span class="linkstyle"> Marketers </span>
             </a>
          </li>
          <li>
            <a href="<?php //echo Yii::app()->createUrl('/site/publisher');?>">
              <span class="linkstyle"> Publishers </span>
             </a>
          </li>
        </ol>
    </div>

    <div class="clear"></div>

</div>

<div class="clear"></div>

<div class="pagecontent">
Introduction Content Here!
<br />
<br />
</div>


<script>
    $(function(){
        $('#slides').slides({
            play: 5000,
            pause: 2500,
            hoverPause: true,
            animationStart: function(current){
                $('.caption').animate({
                    bottom:-35
                },100);
                if (window.console && console.log) {
                    // example return of current slide number
                    console.log('animationStart on slide: ', current);
                };
            },
            animationComplete: function(current){
                $('.caption').animate({
                    bottom:0
                },200);
                if (window.console && console.log) {
                    // example return of current slide number
                    console.log('animationComplete on slide: ', current);
                };
            },
            slidesLoaded: function() {
                $('.caption').animate({
                    bottom:0
                },200);
            }
        });
    });
</script>
-->