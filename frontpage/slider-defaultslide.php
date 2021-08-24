<?php
global $emeon_a13;
$mytestcheck = "";

for($i=1; $i<=3; $i++){
	if(!empty($emeon_a13->get_option('slide_image'.$i))){
		$imgArr[] = $i;
	}
}
?>
  <div class="slider-main">
    <?php if(!empty($imgArr)){ ?>
    <div class="slider-wrapper theme-default">
      <div id="slider" class="nivoSlider">
      <?php foreach($imgArr as $val)	{
  			$check = 'slide_image'.$val;
  			$mytest = $emeon_a13->get_option($check);
        if(is_array($mytest)){
          $mytestcheck = $mytest['url'];
        }else{
          $mytestcheck = $mytest;
        }
			 ?>
        <img src="<?php echo esc_attr($mytestcheck); ?>" data-thumb="<?php echo esc_attr($mytestcheck); ?>" alt="<?php echo esc_attr($emeon_a13->get_option('slide_title'.$val)); ?>" title="<?php echo esc_attr('#htmlcaption'.$val) ; ?>"/>
        <?php } ?>
      </div>
      <?php foreach($imgArr as $val)	{ ?>
      <div id="htmlcaption<?php echo esc_attr($val); ?>" class="nivo-html-caption">
        <?php if(!empty($emeon_a13->get_option('slide_title'.$val))){ ?>
        <div class="title"><?php echo esc_html($emeon_a13->get_option('slide_title'.$val)); ?></div>
        <?php } ?>
        <?php if(!empty($emeon_a13->get_option('slide_description'.$val))){ ?>
        <div class="slidedesc"><?php echo esc_html($emeon_a13->get_option('slide_description'.$val)); ?></div>
        <?php } ?>
        <?php if(!empty($emeon_a13->get_option('slide_button'.$val))){ ?>
        <div class="slidebtn"><a class="slidelink" href="<?php echo esc_url($emeon_a13->get_option('slide_link'.$val)); ?>"><?php echo esc_html($emeon_a13->get_option('slide_button'.$val)); ?></a></div>
        <?php } ?>        
      </div>
      <?php } ?>
    </div>
    <?php } ?>
  </div>