<?php
/**
 * Created by PhpStorm.
 * User: joris
 * Date: 2017-04-21
 * Time: 9:50 AM
 */

/**
 * BuddyPress - Members Register
 *
 * @package BuddyPress
 * @subpackage bp-legacy
 */


?>




<div id="buddypress">


    <?php

    /**
     * Fires at the top of the BuddyPress member registration page template.
     *
     * @since 1.1.0
     */
    do_action( 'bp_before_register_page' ); ?>

    <div class="page" id="register-page">


            <?php if ( 'completed-confirmation' == bp_get_current_signup_step() ) : ?>

                <div id="template-notices" role="alert" aria-atomic="true">
                    <?php

                    /** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
                    do_action( 'template_notices' ); ?>

                </div>

                <?php

                /**
                 * Fires before the display of the registration confirmed messages.
                 *
                 * @since 1.5.0
                 */
                do_action( 'bp_before_registration_confirmed' ); ?>

                <div id="template-notices" role="alert" aria-atomic="true">
                    <?php if ( bp_registration_needs_activation() ) : ?>
                        <p class="account-confirmation"><?php _e( 'You have successfully created your account! To begin using this site you will need to activate your account via the email we have just sent to your address.', 'buddypress' ); ?></p>
                    <?php else : ?>
                        <p class="account-confirmation"><?php _e( 'You have successfully created your account! Please log in using the username and password you have just created.', 'buddypress' ); ?></p>
                    <?php endif; ?>
                </div>

                <?php

                /**
                 * Fires after the display of the registration confirmed messages.
                 *
                 * @since 1.5.0
                 */
                do_action( 'bp_after_registration_confirmed' ); ?>

            <?php endif; // completed-confirmation signup step ?>

        <?php
        /**
         * The login form for the user.
         */
        ?>
        <div class="login-section" id="basic-details-section">
            <h2><?php _e( 'Login', 'badgefactor-theme' ); ?></h2>
            <?php wp_login_form(); ?>
        </div>


        <?php

        /**
         * Fires before the display of member registration account details fields.
         *
         * @since 1.1.0
         */
        do_action( 'bp_before_account_details_fields' ); ?>

        <div class="register-section" id="basic-details-section">
            <h2><?php _e( 'Register', 'badgefactor-theme' ); ?></h2>
            <form action="" name="signup_form" id="signup_form" class="standard-form" method="post" enctype="multipart/form-data">

                <?php /***** Basic Account Details ******/ ?>


                <label class="field-required" for="signup_username"><?php _e( 'Username', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                <?php

                /**
                 * Fires and displays any member registration username errors.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_signup_username_errors' ); ?>
                <input type="text" name="signup_username" id="signup_username" value="<?php bp_signup_username_value(); ?>" <?php bp_form_field_attributes( 'username' ); ?>/>

                <label class="field-required" for="signup_email"><?php _e( 'Email Address', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                <?php

                /**
                 * Fires and displays any member registration email errors.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_signup_email_errors' ); ?>
                <input type="email" name="signup_email" id="signup_email" value="<?php bp_signup_email_value(); ?>" <?php bp_form_field_attributes( 'email' ); ?>/>

                <label class="field-required" for="signup_password"><?php _e( 'Choose a Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                <?php

                /**
                 * Fires and displays any member registration password errors.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_signup_password_errors' ); ?>
                <input type="password" name="signup_password" id="signup_password" value="" class="password-entry" <?php bp_form_field_attributes( 'password' ); ?>/>
                <div id="pass-strength-result"></div>

                <label class="field-required" for="signup_password_confirm"><?php _e( 'Confirm Password', 'buddypress' ); ?> <?php _e( '(required)', 'buddypress' ); ?></label>
                <?php

                /**
                 * Fires and displays any member registration password confirmation errors.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_signup_password_confirm_errors' ); ?>
                <input type="password" name="signup_password_confirm" id="signup_password_confirm" value="" class="password-entry-confirm" <?php bp_form_field_attributes( 'password' ); ?>/>


                <?php

                /**
                 * Fires and displays any extra member registration details fields.
                 *
                 * @since 1.9.0
                 */
                do_action( 'bp_account_details_fields' ); ?>


                <?php /***** Extra Profile Details ******/ ?>

                <?php if ( bp_is_active( 'xprofile' ) ) : ?>

                    <?php

                    /**
                     * Fires before the display of member registration xprofile fields.
                     *
                     * @since 1.2.4
                     */
                    do_action( 'bp_before_signup_profile_fields' ); ?>


                    <?php /* Use the profile field loop to render input fields for the 'base' profile field group */ ?>
                    <?php if ( bp_is_active( 'xprofile' ) ) : if ( bp_has_profile( array( 'profile_group_id' => 1, 'fetch_field_data' => false ) ) ) : while ( bp_profile_groups() ) : bp_the_profile_group(); ?>

                        <?php while ( bp_profile_fields() ) : bp_the_profile_field(); ?>

                            <div<?php bp_field_css_class( 'editfield' ); ?>>

                                <?php
                                $field_type = bp_xprofile_create_field_type( bp_get_the_profile_field_type() );
                                $field_type->edit_field_html();

                                /**
                                 * Fires before the display of the visibility options for xprofile fields.
                                 *
                                 * @since 1.7.0
                                 */
                                do_action( 'bp_custom_profile_edit_fields_pre_visibility' );

                                if ( bp_current_user_can( 'bp_xprofile_change_field_visibility' ) ) : ?>
                                    <p class="field-visibility-settings-toggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
                                        <?php
                                        printf(
                                            __( 'This field can be seen by: %s', 'buddypress' ),
                                            '<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
                                        );
                                        ?>
                                        <button type="button" class="visibility-toggle-link"><?php _ex( 'Change', 'Change profile field visibility level', 'buddypress' ); ?></button>
                                    </p>

                                    <div class="field-visibility-settings" id="field-visibility-settings-<?php bp_the_profile_field_id() ?>">
                                        <fieldset>
                                            <legend><?php _e( 'Who can see this field?', 'buddypress' ) ?></legend>

                                            <?php bp_profile_visibility_radio_buttons() ?>

                                        </fieldset>
                                        <button type="button" class="field-visibility-settings-close"><?php _e( 'Close', 'buddypress' ) ?></button>

                                    </div>
                                <?php else : ?>
                                    <p class="field-visibility-settings-notoggle" id="field-visibility-settings-toggle-<?php bp_the_profile_field_id() ?>">
                                        <?php
                                        printf(
                                            __( 'This field can be seen by: %s', 'buddypress' ),
                                            '<span class="current-visibility-level">' . bp_get_the_profile_field_visibility_level_label() . '</span>'
                                        );
                                        ?>
                                    </p>
                                <?php endif ?>

                                <?php

                                /**
                                 * Fires after the display of the visibility options for xprofile fields.
                                 *
                                 * @since 1.1.0
                                 */
                                do_action( 'bp_custom_profile_edit_fields' ); ?>

                                <p class="description"><?php bp_the_profile_field_description(); ?></p>

                            </div>

                        <?php endwhile; ?>

                        <input type="hidden" name="signup_profile_field_ids" id="signup_profile_field_ids" value="<?php bp_the_profile_field_ids(); ?>" />

                    <?php endwhile; endif; endif; ?>

                    <?php

                    /**
                     * Fires and displays any extra member registration xprofile fields.
                     *
                     * @since 1.9.0
                     */
                    do_action( 'bp_signup_profile_fields' ); ?>

                    <?php

                    /**
                     * Fires after the display of member registration xprofile fields.
                     *
                     * @since 1.1.0
                     */
                    do_action( 'bp_after_signup_profile_fields' ); ?>

                <?php endif; ?>

                <?php if ( 'request-details' == bp_get_current_signup_step() ) : ?>

                <div id="template-notices" role="alert" aria-atomic="true">
                    <?php

                    /** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
                    do_action( 'template_notices' ); ?>

                </div>



                <div class="submit">
                    <input type="submit" name="signup_submit" id="signup_submit" value="<?php esc_attr_e( 'Complete Sign Up', 'buddypress' ); ?>" />
                </div>
                <div class='clearfix'></div>




                <?php

                /**
                 * Fires before the display of the registration submit buttons.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_before_registration_submit_buttons' ); ?>

               

                <?php

                /**
                 * Fires after the display of the registration submit buttons.
                 *
                 * @since 1.1.0
                 */
                do_action( 'bp_after_registration_submit_buttons' ); ?>

                <?php wp_nonce_field( 'bp_new_signup' ); ?>

            <?php endif; // request-details signup step ?>

               

            </form>
        </div><!-- #basic-details-section -->





            <?php if ( 'registration-disabled' == bp_get_current_signup_step() ) : ?>

                <div id="template-notices" role="alert" aria-atomic="true">
                    <?php

                    /** This action is documented in bp-templates/bp-legacy/buddypress/activity/index.php */
                    do_action( 'template_notices' ); ?>

                </div>

                <?php

                /**
                 * Fires before the display of the registration disabled message.
                 *
                 * @since 1.5.0
                 */
                do_action( 'bp_before_registration_disabled' ); ?>

                <p><?php _e( 'User registration is currently not allowed.', 'buddypress' ); ?></p>

                <?php

                /**
                 * Fires after the display of the registration disabled message.
                 *
                 * @since 1.5.0
                 */
                do_action( 'bp_after_registration_disabled' ); ?>
            <?php endif; // registration-disabled signup step ?>

            

          

            <?php

            /**
             * Fires and displays any custom signup steps.
             *
             * @since 1.1.0
             */
            do_action( 'bp_custom_signup_steps' ); ?>


        <div class="clearfix"></div>
    </div>

    <?php

    /**
     * Fires at the bottom of the BuddyPress member registration page template.
     *
     * @since 1.1.0
     */
    do_action( 'bp_after_register_page' ); ?>

</div><!-- #buddypress -->
