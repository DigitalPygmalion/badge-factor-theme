<?php
// Get current displayed user ID
$userID             = bp_displayed_user_id();
$currentUserData    = get_userdata( $userID );
$currentUserNiceUrl = get_permalink( get_option( 'bp-pages' )['members'] ) . $currentUserData->user_nicename;

get_header();
?>


<div class="container row">
    <section class="profile-members-badges">
        <div class="profile-members-badges-heading">
            <span class="separator-prefix"></span>
            <h3 class="profile-members-badges-heading-title"><?php _e( 'Badges Portfolio', 'badgefactor-theme' ); ?></h3>
        </div>
        <ul class="profile-members-badges-list">

			<?php
			$htmlTemplates = '';
			if ( ! $GLOBALS['badgefactor']->get_user_achievements( $userID ) ) {
				echo "<li class=\"profile-members-no-badge\">" . __( "This member hasn't earned a badge for the moment.", 'badgefactor-theme' ) . "</li>";
			} else {
				foreach ( $GLOBALS['badgefactor']->get_user_achievements( $userID ) as $achievement ) {

					if ( ! $GLOBALS['badgefactor']->is_achievement_private( $achievement->ID ) || $userID == get_current_user_id() ) {
						$badgePost = get_post( $achievement->ID );

						$r = preg_match( "/(.*?)(-\d+)$/", $badgePost->post_name, $matches );
						if ( $r > 0 ) {
							$badgePost->post_name = $matches[1];

						}

						$currentBadgeUrl = '/members/'.$currentUserData->user_nicename.'/badges/'.$badgePost->post_name;


						$htmlTemplates .= '<li class="profile-members-badge"><figure class="profile-members-badge-figure">
                            <a href="' . $currentBadgeUrl . '">' . badgeos_get_achievement_post_thumbnail( $achievement->ID ) . '</a>
                            <figcaption class="profile-members-badge-details">
                                <span class="profile-members-badge-description">' . get_the_title( $achievement->ID ) . '</span>
                            </figcaption>';
						if ( $userID == get_current_user_id() ) {
							switch ( $GLOBALS['badgefactor']->is_achievement_private( $achievement->ID ) ) {
								case true:
									$htmlTemplates .= '<button class="private-status private" data-achievement-id="' . $achievement->ID . '"><span class="glyphicon glyphicon-eye-close" aria-hidden="true"></span></button>';
									break;
								case false:
								default:
									$htmlTemplates .= '<button class="private-status public" data-achievement-id="' . $achievement->ID . '"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></button>';
									break;
							}
						}
						$htmlTemplates .= '</figure></li>';
					}
				}
			}

			echo do_shortcode( $htmlTemplates );
			?>
        </ul>
    </section>
</div>

<?php get_footer(); ?>
