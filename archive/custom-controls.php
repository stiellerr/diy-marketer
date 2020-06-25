<?php  if(class_exists('WP_Customize_Control')){class DIYM_Google_Font_Select2 extends WP_Customize_Control{public function __construct($manager,$id,$args=array(),$options=array()){parent::__construct($manager,$id,$args);$this->fontList=$this->diym_getGoogleFonts('all');}public function enqueue(){wp_enqueue_script('diym-select2-js',DIYM_JS_URL.'select2.js',['jquery'],'4.0.13',true);wp_enqueue_script('diym-custom-controls-js',DIYM_JS_URL.'customizer.js',['diym-select2-js'],DIYM_VER,true);wp_enqueue_style('diym-custom-controls-css',DIYM_CSS_URL.'customizer.css',[],DIYM_VER,'all');wp_enqueue_style('diym-select2-css',DIYM_CSS_URL.'select2.css',[],'4.0.13','all');}public function render_content(){$defaultValue=$this->value(); ?> <div class="dropdown_select2_control"> <?php if(!empty($this->label)){ ?> <label for="<?php echo esc_attr($this->id); ?>" class="customize-control-title"> <?php echo esc_html($this->label); ?> </label> <?php } ?> <?php if(!empty($this->description)){ ?> <span class="customize-control-description"><?php echo esc_html($this->description); ?></span> <?php } ?> <input type="hidden" id="<?php echo esc_attr($this->id); ?>" class="customize-control-dropdown-select2" value="<?php echo esc_attr($this->value()); ?>" name="<?php echo esc_attr($this->id); ?>" <?php $this->link(); ?> > <select name="select2-list-single" class="customize-control-select2" data-placeholder="<?php echo $this->placeholder; ?>"> <?php  echo '<option></option>';foreach($this->fontList as $key =>$value){echo '<option value="'.$value->family.'" '.selected($value->family,$defaultValue,false).'>'.$value->family.'</option>';} ?> </select></div> <?php }public function diym_getGoogleFonts($count=30){$fontFile=DIYM_URL.'inc/google-fonts-alphabetical.json';$request=wp_remote_get($fontFile);if(is_wp_error($request)){return "";}$body=wp_remote_retrieve_body($request);$content=json_decode($body);if($count =='all'){return $content->items;}else{return array_slice($content->items,0,$count);}}}} ?>