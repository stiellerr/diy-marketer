<?php
    class office_time extends WP_Widget {
        
        function office_time() {
            $widget_ops = array(
                'description' => 'Use this widget to display your Office time information.'
            );
            parent::WP_Widget(false, __('LBT : Business Hours', 'lbt_translate'), $widget_ops);
        }
        
        function widget($args, $instance) {
            extract($args);
            $title     = $instance['title'];
            $monday_open    = $instance['monday_open'];
			$monday_close    = $instance['monday_close'];
         
            
			
			$tuesday_open   = $instance['tuesday_open'];
			$tuesday_close   = $instance['tuesday_close'];
			
			$wednesday_open   = $instance['wednesday_open'];
			$wednesday_close   = $instance['wednesday_close'];
			
			
			$thursday_open   = $instance['thursday_open'];
			$thursday_close   = $instance['thursday_close'];
			
			
			
			$friday_open   = $instance['friday_open'];
			$friday_close   = $instance['friday_close'];
			
			
			$saturday_open   = $instance['saturday_open'];
			$saturday_close   = $instance['saturday_close'];
			
			$sunday_open   = $instance['sunday_open'];
			$sunday_close   =$instance['sunday_close'];
			
			
?>
<?php
            echo $before_widget;
?>
<?php
            if ($title) {
                echo $before_title . $title . $after_title;
            }
?>

<div id="footer-hours-table">
  <div itemscope itemtype="http://schema.org/LocalBusiness">
	  <meta itemprop="image" content="<?php global $data;
	  $themepath =  get_template_directory_uri();
	  echo $data['lbt_logo'] == '' ?
		  "$themepath/images/logo.png" : $data['lbt_logo'];
	  ?>">
	  <meta itemprop="name" content="<?php echo $data['lbt_business_name']; ?>">
    <table width="100%" border="1" cellpadding="1">
     
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Monday </td>
        <td>
        <meta itemprop="opens" content="<?php  echo $monday_open;?>">
        <meta itemprop="closes" content="<?php  echo $monday_close;?>">
          <?php
                echo $monday_open;
				echo " - ";
				echo $monday_close;
			?>
</td>
      </tr>
    
    
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Tuesday </td>
        <td>
        <meta itemprop="opens" content="<?php  echo $tuesday_open;?>">
        <meta itemprop="closes" content="<?php  echo $tuesday_close;?>">
          <?php
                echo $tuesday_open;
				echo " - ";
				echo $tuesday_close;
			?>

</td>
      </tr>
    
      
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Wednesday </td>
        <td>
         <meta itemprop="opens" content="<?php  echo $wednesday_open;?>">
        <meta itemprop="closes" content="<?php  echo $wednesday_close;?>">
          <?php
                echo $wednesday_open;
				echo " - ";
				echo $wednesday_close;
			?>

        </td>
      </tr>
    
   
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Thursday </td>
        <td><meta itemprop="opens" content="<?php  echo $thursday_open;?>">
        <meta itemprop="closes" content="<?php  echo $thursday_close;?>">
          <?php
                echo $thursday_open;
				echo " - ";
				echo $thursday_close;
			?></td>
      </tr>
    
    
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Friday </td>
        <td><meta itemprop="opens" content="<?php  echo $friday_open;?>">
        <meta itemprop="closes" content="<?php  echo $friday_close;?>">
          <?php
                echo $friday_open;
				echo " - ";
				echo $friday_close;
			?></td>
      </tr>
    
     
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Saturday </td>
        <td><meta itemprop="opens" content="<?php  echo $saturday_open;?>">
        <meta itemprop="closes" content="<?php  echo $saturday_close;?>">
          <?php
                echo $saturday_open;
				echo " - ";
				echo $saturday_close;
			?></td>
      </tr>
    
    
      <tr itemprop="openingHoursSpecification" itemscope itemtype="http://schema.org/OpeningHoursSpecification">
        <td itemprop="name">Sunday </td>
        <td><meta itemprop="opens" content="<?php  echo $sunday_open;?>">
        <meta itemprop="closes" content="<?php  echo $sunday_close;?>">
          <?php
                echo $sunday_open;
				echo " - ";
				echo $sunday_close;
			?></td>
      </tr>
    
    </table>
  </div>
</div>
<!--footer socials-->
<?php
            echo $after_widget;
?>
<?php
        }
        
        function update($new_instance, $old_instance) {
            return $new_instance;
        }
        
        function form($instance) {
            $title     = esc_attr($instance['title']);
            $monday_open    = esc_attr($instance['monday_open']);
		    $monday_close    = esc_attr($instance['monday_close']);
			
			$tuesday_open   = esc_attr($instance['tuesday_open']);
			$tuesday_close   = esc_attr($instance['tuesday_close']);
			
			$wednesday_open   = esc_attr($instance['wednesday_open']);
			$wednesday_close   = esc_attr($instance['wednesday_close']);
			
			
			$thursday_open   = esc_attr($instance['thursday_open']);
			$thursday_close   = esc_attr($instance['thursday_close']);
			
			
			
			$friday_open   = esc_attr($instance['friday_open']);
			$friday_close   = esc_attr($instance['friday_close']);
			
			
			$saturday_open   = esc_attr($instance['saturday_open']);
			$saturday_close   = esc_attr($instance['saturday_close']);
			
			$sunday_open   = esc_attr($instance['sunday_open']);
			$sunday_close   = esc_attr($instance['sunday_close']);
			
        
            
?>
<p>
  <label for="<?php
            echo $this->get_field_id('title');
?>">
    <?php
            _e('Title:', 'lbt_translate');
?>
  </label>
  <input type="text" name="<?php
            echo $this->get_field_name('title');
?>"  value="<?php
            echo $title;
?>" class="widefat" id="<?php
            echo $this->get_field_id('title');
?>" />
</p>
<table>
<tr>
<th>Day</th><th>Open</th><th>Close</th>
</tr>
<tr>
<td> <label for="<?php
            echo $this->get_field_id('monday');
?>">
    <?php
            _e('Monday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('monday_open');
?>"  value="<?php
            echo $monday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('monday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('monday_close');
?>"  value="<?php
            echo $monday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('monday_close');
?>" /></td>
</tr>
<!-- Monday -->


<tr>
<td> <label for="<?php
            echo $this->get_field_id('tuesday');
?>">
    <?php
            _e('Tuesday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('tuesday_open');
?>"  value="<?php
            echo $tuesday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('tuesday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('tuesday_close');
?>"  value="<?php
            echo $tuesday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('tuesday_close');
?>" /></td>
</tr>
<!-- Tuesday -->

<tr>
<td> <label for="<?php
            echo $this->get_field_id('wednesday');
?>">
    <?php
            _e('Wednesday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('wednesday_open');
?>"  value="<?php
            echo $wednesday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('wednesday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('wednesday_close');
?>"  value="<?php
            echo $wednesday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('wednesday_close');
?>" /></td>
</tr>
<!-- Wed -->


<tr>
<td> <label for="<?php
            echo $this->get_field_id('thursday');
?>">
    <?php
            _e('Thursday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('thursday_open');
?>"  value="<?php
            echo $thursday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('thursday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('thursday_close');
?>"  value="<?php
            echo $thursday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('thursday_close');
?>" /></td>
</tr>
<!-- Thursday -->

<tr>
<td> <label for="<?php
            echo $this->get_field_id('friday');
?>">
    <?php
            _e('Friday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('friday_open');
?>"  value="<?php
            echo $friday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('friday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('friday_close');
?>"  value="<?php
            echo $friday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('friday_close');
?>" /></td>
</tr>
<!-- Friday -->


<tr>
<td> <label for="<?php
            echo $this->get_field_id('saturday');
?>">
    <?php
            _e('Saturday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('saturday_open');
?>"  value="<?php
            echo $saturday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('saturday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('saturday_close');
?>"  value="<?php
            echo $saturday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('saturday_close');
?>" /></td>
</tr>
<!-- Saturday -->

<tr>
<td> <label for="<?php
            echo $this->get_field_id('sunday');
?>">
    <?php
            _e('Sunday:', 'lbt_translate');
?>
  </label></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('sunday_open');
?>"  value="<?php
            echo $sunday_open;
?>" class="widefat" id="<?php
            echo $this->get_field_id('sunday_open');
?>" /></td>
<td> <input type="text" name="<?php
            echo $this->get_field_name('sunday_close');
?>"  value="<?php
            echo $sunday_close;
?>" class="widefat" id="<?php
            echo $this->get_field_id('sunday_close');
?>" /></td>
</tr>
<!-- Sudany -->

</table>
 
<?php
        }
    }
    register_widget('office_time');

