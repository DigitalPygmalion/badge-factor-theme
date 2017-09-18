<?php

/**
 * Created by PhpStorm.
 * User: joris
 * Date: 2017-04-20
 * Time: 6:14 PM
 */

// Creating the widget
class HeaderLoginWidget extends \WP_Widget
{

    public function __construct()
    {
        parent::__construct(
        // Base ID of your widget
            'bf_header_login_widget',

            // Widget name will appear in UI
            __('Header Login', 'badgefactor'),

            // Widget description
            array('description' => __('Login in the header bar', 'badgefactor'),)
        );
    }

    public static function load_widget()
    {
        register_widget('HeaderLoginWidget');
    }

    // Creating widget front-end
    // This is where the action happens
    public function widget($args, $instance)
    {
        // before and after widget arguments are defined by themes
        echo $args['before_widget'];

        // This is where you run the code and display the output
        ?>
        <li class="header-main-top-item">
            <span class="glyphicon glyphicon-user header-main-top-icon"></span>
            <ul class="header-main-top-sublist">
                <?php if(is_user_logged_in()): ?>
                    <?php $current_user = wp_get_current_user(); ?>
                    <?php if(!empty($current_user->user_login)): ?>
                        <li class="header-main-top-sublist-item">
                            <a class="header-main-top-sublist-link <?php !bp_is_home() ?: print 'current'; ?>" href="<?php echo  bp_loggedin_user_domain( get_current_user_id() ) . 'profile/'; ?>"><?php _e('My account', 'badgefactor-theme'); ?></a>
                        </li>
                    <?php endif; ?>
                    <li class="header-main-top-sublist-item">
                        <a class="header-main-top-sublist-link" href="<?php echo wp_logout_url('/'); ?>" title="<?php _e('Log out', 'badgefactor'); ?>">
                            <?php _e('Log out', 'badgefactor'); ?>
                        </a>
                    </li>
                <?php else: ?>
                    <li class="header-main-top-sublist-item">
                        <a class="header-main-top-sublist-link" href="<?php echo get_permalink( $GLOBALS['badgefactor']->bf_login_page() ); ?>">
                            <?php _e('Log in', 'badgefactor'); ?>
                        </a>
                    </li>
                    <li class="header-main-top-sublist-item">
                        <a class="header-main-top-sublist-link" href="<?php echo get_permalink( $GLOBALS['badgefactor']->bf_login_page() ); ?>"><?php _e('Register', 'badgefactor-theme'); ?></a>
                    </li>
                <?php endif; ?>
            </ul>
        </li>
        <?php
        echo $args['after_widget'];
    }

    // Widget Backend
    public function form($instance)
    {
    }

    // Updating widget replacing old instances with new
    public function update($new_instance, $old_instance)
    {
        return $old_instance;
    }
}

add_action( 'widgets_init', array(HeaderLoginWidget::class, 'load_widget') );
