<?php use Roots\Sage\Titles; ?>
<?php if (is_singular('organisation')): ?>
    <section class="profile-organisation-heading">
        <figure class="profile-organisation-heading-figure">
            <?php if (get_field('image')): ?>
                <img src="<?php echo wp_get_attachment_image_src(get_field('image'), 'square-225')[0]; ?>"
                     srcset="<?php echo wp_get_attachment_image_src(get_field('image'), 'square-225')[0]; ?> 1x, <?php echo wp_get_attachment_image_src(get_field('image'), 'square-450')[0]; ?> 2x"
                     class="profile-organisation-image">
            <?php endif; ?>
        </figure>
        <div class="profile-organisation-heading-infos">
            <h1 class="profile-organisation-name">
                <?php echo Titles\title(); ?>
            </h1>
            <ul class="profile-organisation-social-list">
                <?php if (get_field('linkedin_link')): ?>
                    <li class="profile-organisation-social-item">
                        <a target="_blank" class="profile-organisation-social-link"
                           href="<?php echo get_field('linkedin_link'); ?>" title="LinkedIn">
                            <i class="fa fa-fw fa-lg fa-linkedin profile-organisation-social-icon"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('twitter_link')): ?>
                    <li class="profile-organisation-social-item">
                        <a target="_blank" class="profile-organisation-social-link"
                           href="<?php echo get_field('twitter_link'); ?>" title="Twitter">
                            <i class="fa fa-fw fa-lg fa-twitter-square profile-organisation-social-icon"></i>
                        </a>
                    </li>
                <?php endif; ?>
                <?php if (get_field('facebook_link')): ?>
                    <li class="profile-organisation-social-item">
                        <a target="_blank" class="profile-organisation-social-link"
                           href="<?php echo get_field('facebook_link'); ?>" title="Facebook">
                            <i class="fa fa-fw fa-lg fa-facebook-square profile-organisation-social-icon"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </section>
<?php elseif (is_buddypress() && !bp_is_register_page()): ?>

    <?php
    $user = wp_get_current_user();
    $user_id = bp_displayed_user_id();
    $userData = $user_id ? get_userdata($user_id) : null;
    $userFacebook = $user_id ? get_user_meta($user_id, 'facebook', true) : null;
    $userLinkedin = $user_id ? get_user_meta($user_id, 'linkedin', true) : null;
    $userTwitter = $user_id ? get_user_meta($user_id, 'twitter', true) : null;
    $userGooglePlus = $user_id ? get_user_meta($user_id, 'google', true) : null;
    $userBio = $user_id ? get_user_meta($user_id, 'description', true) : null;
    $userWebsite = $user_id ? get_user_by('id', $user_id)->user_url : null;
    $userCountry = $user_id ? get_user_meta($user_id, 'country', true) : null;
    $userOrganisation = $user_id ? get_user_meta($user_id, 'organisation', true) : null;
    $userJob = $user_id ? get_user_meta($user_id, 'job', true) : null;

    ?>

    <?php if ($GLOBALS['badgefactor']->is_current_page_awarded_achievement()): ?>

        <?php


        // Check if current badge is a real badge name attributed
        $uri_array = (explode('/', rtrim($_SERVER['REQUEST_URI'], '/')));
        //$uri_array = end((explode('/', rtrim('parkour3-test-de-badge', '/'))));

        $string = end($uri_array);
        $find = $userData->user_nicename . '-';

        $replace = '';
        $slug = preg_replace(strrev("/$find/"),strrev($replace),strrev($string),1);
        $slug = strrev($slug);
        $badgePost = $GLOBALS['badgefactor']->get_page_by_slug($slug, OBJECT, 'submission');

        // get current user attributed badges list
        $currentUserBadgeList = $GLOBALS['badgefactor']->get_user_achievements($user_id);
        // Get current badges infos by url name
        foreach ($currentUserBadgeList as $singleBadgeId => $singleBadge) {
            if ($singleBadge->badge_id == $badgePost->ID) {
                $is_badgeAchieved = true;
                $currentBadgeInfos = $singleBadge;
            }
        }
        $currentBadgePost = get_post($currentBadgeInfos->achievement_id);

        // Default Badge image
        $badgeImage = get_stylesheet_directory_uri() . '/assets/img/default-badge-image.png';

        // Selected Badge image if it exist
        if (has_post_thumbnail($currentBadgePost->ID)) {
            $badgeImage = wp_get_attachment_image_src( get_post_thumbnail_id($currentBadgePost->ID), 'square-225' );
            $badgeImage = $badgeImage[0];
            $badgeImage_2x = wp_get_attachment_image_src( get_post_thumbnail_id($currentBadgePost->ID), 'square-450' );
            $badgeImage_2x = $badgeImage[0];
        }
        ?>

        <section class="page-main-heading">
            <h1 class="page-main-heading-title"><?php _e('Badge', 'badgefactor-theme'); ?></h1>
        </section>
        <?php global $wp;

    elseif ( bp_is_my_profile() && strpos($wp->request, 'profile') ): ?>
        <section class="page-main-heading">
            <h1 class="page-main-heading-title"><?php _e('My account', 'badgefactor-theme'); ?></h1>
        </section>
        <?php

    elseif (preg_match("/members\/(.*)/", $wp->request)): ?>
        <section class="profile-members-heading">
            <div class="col-xs-12">

                <div class="row member-picture-name">
                    <div class="col-xs-12">
                        <figure class="profile-members-heading-figure">
                            <img src="<?php echo bp_get_displayed_user_avatar( array('html' => false, 'type' => 'full')); ?>"
                                 class="profile-members-image" style="max-width: 175px; width: 100%; height: auto;">
                        </figure>
                        <div class="profile-members-heading-infos" style="width:100%;">

                            <h2 class="profile-members-name">
                                <?php echo bp_get_displayed_user_fullname(); ?>
                            </h2>

                            <ul class="profile-members-social-list">
                                <?php if ($userLinkedin): ?>
                                    <li class="profile-members-social-item">
                                        <a class="profile-members-social-link" href="#" title="LinkedIn">
                                            <i class="fa fa-fw fa-lg fa-linkedin profile-members-social-icon"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($userTwitter): ?>
                                    <li class="profile-members-social-item">
                                        <a class="profile-members-social-link" href="#" title="Twitter">
                                            <i class="fa fa-fw fa-lg fa-twitter-square profile-members-social-icon"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($userFacebook): ?>
                                    <li class="profile-members-social-item">
                                        <a class="profile-members-social-link" href="#" title="Facebook">
                                            <i class="fa fa-fw fa-lg fa-facebook-square profile-members-social-icon"></i>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            </ul>

                        </div>
                    </div>
                </div> <!-- END ROW -->

                <div class="row">
                    <div class="profile-members-content col-xs-12">
                        <?php echo $userBio; ?>
                    </div>
                </div><!-- END ROW -->

                <div class="row">
                    <div class="profile-members-header-content-container">
                        <!--          <div class="row">-->
                        <div class="col-md-12">
                            <dl class="profile-members-heading-content-desc-list">
                                <?php if ($userJob): ?>
                                <dt class="profile-members-heading-content-desc-list-title">Profession</dt>
                                <dd class="profile-members-heading-content-desc-list-text"><?php echo $userJob; ?></dd>
                                <?php endif; ?>
                                <?php if ($userOrganisation): ?>
                                <dt class="profile-members-heading-content-desc-list-title">Organisation</dt>
                                <dd class="profile-members-heading-content-desc-list-text"><?php echo $userOrganisation; ?></dd>
                                <?php endif; ?>
                                <?php if ($userCountry): ?>
                                <dt class="profile-members-heading-content-desc-list-title">Lieu</dt>
                                <dd class="profile-members-heading-content-desc-list-text"><?php echo $userCountry; ?></dd>
                                <?php endif; ?>
                                <?php if ($userWebsite): ?>
                                <dt class="profile-members-heading-content-desc-list-title">Site web</dt>
                                <dd class="profile-members-heading-content-desc-list-text"><a href="<?php echo $userWebsite; ?>" target="_blank"><?php echo $userWebsite; ?></a></dd>
                                <?php endif; ?>
                            </dl>
                        </div>
                        <!--          </div>-->

                    </div>
                </div><!-- END ROW -->


            </div>
        </section>
    <?php endif; ?>
<?php elseif (preg_match("/^badges$/", $wp->request)): ?>
    <section class="page-main-heading">
        <h1 class="page-main-heading-title">
            <?php _e('Badges', 'badgefactor-theme'); ?>
        </h1>
    </section>
<?php else: ?>

    <section class="page-main-heading">
        <h1 class="page-main-heading-title">
            <?php echo Titles\title(); ?>
        </h1>
    </section>
<?php endif; ?>
<?php
do_action( 'bf_display_notice' );
 ?>
