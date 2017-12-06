<?php
 $user_id = get_current_user_id();
?>
<?php
/**
 * BadgeFactore
 *
 * @since 1.1.0
 */
do_action( 'bf_before_profile_content' );
?>
<section>
    <ul class="home-page-development-button-list">
        <li class="home-page-development-button-list-item">
            <a class="home-page-development-button" href="<?php echo bp_loggedin_user_domain() . 'profile/edit/'; ?>"><?php _e('Modify my profile', 'badgefactor-theme'); ?></a>
        </li>
        <li class="home-page-development-button-list-item">
            <a class="home-page-development-button" href="<?php echo bp_loggedin_user_domain(); ?>"><?php _e('Access my public profile', 'badgefactor-theme')?></a>
        </li>
    </ul>
</section>

<div class="profile-members-badges-heading"><span class="separator-prefix"></span>
    <span class="separator-prefix"></span>
    <h3 class="profile-members-badges-heading-title"><?php _e('My obtained badges', 'badgefactor-theme'); ?></h3>
</div>
<ul class="profile-members-badges-list">
    <?php
    $htmlTemplates = '';
    foreach ($GLOBALS['badgefactor']->get_user_achievements($user_id) as $achievement) {

            $badgePost = get_post($achievement->badge_id);

            $currentBadgeUrl = $currentUserNiceUrl . '/badges/' . $currentUserData->user_nicename . '-' . $badgePost->post_name;


            $htmlTemplates .= '<li class="profile-members-badge"><figure class="profile-members-badge-figure">
                            <a href="' . $currentBadgeUrl . '">' . badgeos_get_achievement_post_thumbnail( $achievement->achievement_id ) . '</a>
                            <figcaption class="profile-members-badge-details">
                                <span class="profile-members-badge-description">'.get_the_title( $achievement->achievement_id ) .'</span>
                            </figcaption>';
            if ($user_id == get_current_user_id())
            {
                switch ($GLOBALS['badgefactor']->is_achievement_private($achievement->badge_id))
                {
                    case true:
                        $htmlTemplates .= '<button class="private-status private" data-achievement-id="'. $achievement->badge_id . '"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></button>';
                        break;
                    case false:
                    default:
                        $htmlTemplates .= '<button class="private-status public" data-achievement-id="'. $achievement->badge_id . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';
                        break;
                }
            }
            $htmlTemplates .= '</figure></li>';
    }
    echo $htmlTemplates;
    ?>
</ul>
<?php
/**
 * BadgeFactore
 *
 * @since 1.1.0
 */
do_action( 'bf_after_profile_content' );
?>
