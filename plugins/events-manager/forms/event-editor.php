<?php
/* WARNUNG! Diese Datei kann sich in naher Zukunft ändern, da wir beabsichtigen, dem Ereigniseditor Funktionen hinzuzufügen. Versuche, wenn möglich, Anpassungen mit CSS, jQuery oder unseren Hooks und Filtern vorzunehmen. - 2021-02-14 */
/* 
 * Um die Kompatibilität zu gewährleisten, wird empfohlen, Klassen-, ID- und Formularnamensattribute beizubehalten, es sei denn, Du weißt was Du tust. 
 * Du musst auch das versteckte Feld _wpnonce in diesem Formular beibehalten.
 */
global $EM_Event, $EM_Notices, $bp;

//Überprüfe, ob der Benutzer auf diese Seite zugreifen kann
?>

<?php if( is_object($EM_Event) && !$EM_Event->can_manage('edit_events','edit_others_events') ) : ?>

	<div class="wrap">
		<h2><?php esc_html_e('Unautorisierter Zugriff','social-portal'); ?></h2>
		<p><?php echo sprintf(__('Du hast nicht die Rechte, diese %s zu verwalten.','social-portal'),__('Veranstaltung','social-portal')); ?></p>
	</div>

	<?php	return; ?>

<?php elseif( !is_object($EM_Event) ): ?>
	<?php	$EM_Event = new EM_Event(); ?>
<?php endif; ?>

<?php
$required = apply_filters('em_required_html','<i>*</i>');

echo $EM_Notices;
//Erfolgsmeldung
if ( ! empty( $_REQUEST['success'] ) && !get_option('dbem_events_form_reshow')  ) {
	 return false;
}
?>

<form enctype='multipart/form-data' class="standard-form em-event-form" id="event-form" method="post" action="<?php echo esc_url(add_query_arg(array('success'=>null))); ?>">
	<div class="wrap">
		<?php do_action('em_front_event_form_header'); ?>
		<?php if( get_option( 'dbem_events_anonymous_submissions' ) && ! is_user_logged_in() ): ?>
			<h3 class="event-form-submitter"><?php esc_html_e( 'Deine Details', 'social-portal'); ?></h3>
			<div class="inside event-form-submitter">

				<p>
					<label for="event-owner-name"><?php esc_html_e('Name', 'social-portal'); ?></label>
					<input type="text" name="event_owner_name" id="event-owner-name" value="<?php echo esc_attr($EM_Event->event_owner_name); ?>" />
				</p>

				<p>
					<label for="event-owner-email"><?php esc_html_e('Email', 'social-portal'); ?></label>
					<input type="text" name="event_owner_email" id="event-owner-email" value="<?php echo esc_attr($EM_Event->event_owner_email); ?>" />
				</p>

				<?php do_action('em_front_event_form_guest'); ?>
				<?php do_action('em_font_event_form_guest'); //deprecated ?>

			</div>
		<?php endif; ?>

		<h3 class="event-form-name"><?php esc_html_e( 'Veranstaltungsname', 'social-portal'); ?></h3>

		<div class="inside event-form-name">
			<input type="text" name="event_name" id="event-name" value="<?php echo esc_attr($EM_Event->event_name,ENT_QUOTES); ?>" /><?php echo $required; ?>
			<br />
			<?php esc_html_e('Der Ereignisname. Beispiel: Geburtstagsfeier', 'social-portal'); ?>
			<?php em_locate_template('forms/event/group.php',true); ?>
		</div>

		<h3 class="event-form-when"><?php esc_html_e( 'Wann', 'social-portal'); ?></h3>
		<div class="inside event-form-when">
			<?php
			if( empty($EM_Event->event_id) && $EM_Event->can_manage('edit_recurring_events','edit_others_recurring_events') && get_option('dbem_recurrence_enabled') ){
				em_locate_template('forms/event/when-with-recurring.php',true);
			}elseif( $EM_Event->is_recurring()  ){
				em_locate_template('forms/event/recurring-when.php',true);
			}else{
				em_locate_template('forms/event/when.php',true);
			}
			?>
		</div>

		<?php if( get_option('dbem_locations_enabled') ): ?>
			<h3 class="event-form-where"><?php esc_html_e( 'Wo', 'social-portal'); ?></h3>
			<div class="inside event-form-where">
				<?php em_locate_template('forms/event/location.php',true); ?>
			</div>
		<?php endif; ?>

		<h3 class="event-form-details"><?php esc_html_e( 'Details', 'social-portal'); ?></h3>
		<div class="inside event-form-details">
			<div class="event-editor">
				<?php if( get_option('dbem_events_form_editor') && function_exists('wp_editor') ): ?>
					<?php wp_editor($EM_Event->post_content, 'em-editor-content', array('textarea_name'=>'content') ); ?>
				<?php else: ?>
					<textarea name="content" rows="10" style="width:100%"><?php echo $EM_Event->post_content ?></textarea>
					<br />
					<?php esc_html_e( 'Details zur Veranstaltung.', 'social-portal')?> <?php esc_html_e( 'HTML erlaubt.', 'social-portal')?>
				<?php endif; ?>
			</div>
			<div class="event-extra-details">
				<?php if(get_option('dbem_attributes_enabled')) { em_locate_template('forms/event/attributes-public.php',true); }  ?>
				<?php if(get_option('dbem_categories_enabled')) { em_locate_template('forms/event/categories-public.php',true); }  ?>
			</div>
		</div>

		<?php if( $EM_Event->can_manage('upload_event_images','upload_event_images') ): ?>
			<h3><?php esc_html_e( 'Veranstaltungsbild', 'social-portal'); ?></h3>
			<div class="inside event-form-image">
				<?php em_locate_template('forms/event/featured-image-public.php',true); ?>
			</div>
		<?php endif; ?>

		<?php if( get_option('dbem_rsvp_enabled') && $EM_Event->can_manage('manage_bookings','manage_others_bookings') ) : ?>
			<!-- START Bookings -->
			<h3><?php esc_html_e('Buchungen/Anmeldung','social-portal'); ?></h3>
			<div class="inside event-form-bookings">
				<?php em_locate_template('forms/event/bookings.php',true); ?>
			</div>
			<!-- END Bookings -->
		<?php endif; ?>

		<?php do_action('em_front_event_form_footer'); ?>
	</div>
	<p class="submit">
		<?php if( empty($EM_Event->event_id) ): ?>
			<input type='submit' class='button-primary' value='<?php echo esc_attr(sprintf( __('%s senden','social-portal'), __('Veranstaltung','social-portal') )); ?>' />
		<?php else: ?>
			<input type='submit' class='button-primary' value='<?php echo esc_attr(sprintf( __('Aktualisiere %s','social-portal'), __('Veranstaltung','social-portal') )); ?>' />
		<?php endif; ?>
	</p>
	<input type="hidden" name="event_id" value="<?php echo $EM_Event->event_id; ?>" />
	<input type="hidden" name="_wpnonce" value="<?php echo wp_create_nonce('wpnonce_event_save'); ?>" />
	<input type="hidden" name="action" value="event_save" />
	<?php if( !empty($_REQUEST['redirect_to']) ): ?>
		<input type="hidden" name="redirect_to" value="<?php echo esc_attr($_REQUEST['redirect_to']); ?>" />
	<?php endif; ?>
</form>