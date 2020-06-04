	<footer><div class="row"><div class="col-12 col-md-6 col-lg-3 pt-4"> <?php if (
     is_active_sidebar('footer-1')
 ) {
     dynamic_sidebar('footer-1');
 } ?> </div><div class="col-12 col-md-6 col-lg-3 pt-4"> <?php if (is_active_sidebar('footer-2')) {
     dynamic_sidebar('footer-2');
 } ?> </div><div class="col-12 col-md-6 col-lg-3 pt-4"> <?php if (is_active_sidebar('footer-3')) {
     dynamic_sidebar('footer-3');
 } ?> </div><div class="col-12 col-md-6 col-lg-3 pt-4"> <?php if (is_active_sidebar('footer-4')) {
     dynamic_sidebar('footer-4');
 } ?> </div></div><div class="row"><div class="col"> <?php wp_nav_menu([
     'theme_location' => 'menu-2',
     'depth' => 1,
     'fallback_cb' => false,
 ]); ?> </div><div class="col-lg-auto text-center text-sm-left"> <?php printf(
     wp_kses(
         __(
             'Powered by <a href="%1$s">DIY Marketer</a> &copy; <span id="current-year">%2$d</span>',
             'diy-marketer'
         ),
         ['a' => ['href' => []], 'span' => ['id' => []]]
     ),
     esc_url(__('https://stieller.com/', 'diy-marketer')),
     esc_html__('2020', 'diy-marketer')
 ); ?> </div></div></footer><?php wp_footer(); ?>
