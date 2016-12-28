<?php
// Stop direct call
if(preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF'])) {
	die('Please do not call this page directly.');
}

// is edge mode active?
if ($this->edge_mode['available'] and !empty($this->preferences['edge_mode'])){
	$this->edge_mode['active'] = true;
}

// output dynamic JS here as interim solution
echo '<script type="text/javascript">';
include $this->thisplugindir . '/includes/js-dynamic.php';
echo '</script>';

// dev tool - refresh option-icon css after updating icon-size-x in property options file
$refresh_css = true;
if ($refresh_css and TVR_DEV_MODE){
	include $this->thisplugindir . 'includes/regenerate-option-icons.inc.php';
}



// are we hiding the admin bar?
$this->preferences['admin_bar_preview'] ? $ui_class = 'show-admin-bar' : $ui_class = 'do-not-show-admin-bar';
$this->preferences['auto_capitalize'] ? $ui_class.= ' tvr-caps' : false;
$this->preferences['dark_editor'] ? $ui_class.= ' dark-editor' : false;

?>

<div id="tvr" class='wrap tvr-wrap <?php echo $ui_class; ?>'>
	<div id='tvr-ui'>

		<?php
		// make css file in use available to JS
		$css_min = $this->preferences['minify_css'] ? 'min.': '';
		$css_stub = $this->preferences['draft_mode'] ? 'draft' : 'active';
		?>

		<span id="ui-nonce"><?php echo wp_create_nonce('tvr_microthemer_ui_load_styles'); ?></span>
		<span id="fonts-api" rel="<?php echo $this->thispluginurl.'includes/fonts-api.php'; ?>"></span>
		<span id="ui-url" rel="<?php echo 'admin.php?page=' . $this->microthemeruipage; ?>"></span>
		<span id="css-min" rel="<?php echo $css_min; ?>"></span>
		<span id="css-stub" rel="<?php echo $css_stub; ?>"></span>
		<span id="admin-url" rel="<?php echo $this->wp_blog_admin_url; ?>"></span>
		<span id="micro-url" rel="<?php echo $this->micro_root_url; ?>"></span>
		<span id="user-browser" rel="<?php echo $this->check_browser(); ?>"></span>
		<span id="clean-ui-url" rel="<?php echo isset($_GET['_wpnonce']) ? 1 : 0; ?>"></span>

		<span id="ajaxUrl" rel="<?php echo $this->site_url .'/wp-admin/admin.php?page='.$this->microthemeruipage.'&_wpnonce='.wp_create_nonce('mcth_simple_ajax') ?>"></span>
		<span id="resetUrl" rel="<?php echo '&_wpnonce='.wp_create_nonce('tvr_microthemer_ui_reset');?>&action=tvr_ui_reset"></span>
		<span id="clearUrl" rel="<?php echo '&_wpnonce='.wp_create_nonce('tvr_microthemer_clear_styles');?>&action=tvr_clear_styles"></span>


		<span id='site-url' rel="<?php echo $this->site_url; ?>"></span>
		<span id="active-styles-url" rel="<?php echo $this->micro_root_url . 'active-styles.css' ?>"></span>
		<span id="revisions-url" rel="<?php echo 'admin.php?page=' . $this->microthemeruipage .
			'&_wpnonce='.wp_create_nonce('tvr_get_revisions'). '&action=get_revisions'; ?>"></span>

		<span id='all_devices_default_width' rel='<?php echo $this->preferences['all_devices_default_width']; ?>'></span>

		<span id='last-pg-focus' rel='<?php echo $this->preferences['pg_focus'] ?>'></span>
		<span id='plugin-url' rel='<?php echo $this->thispluginurl; ?>'></span>
		<span id='docs-url' rel='<?php echo 'admin.php?page=' . $this->docspage; ?>'></span>
		<span id='tooltip_delay' rel='<?php echo $this->preferences['tooltip_delay']; ?>'></span>
		<?php
		// edge mode settings
		if ($this->edge_mode['active']){
			?>
			<span id='edge-mode' rel='1'></span>
			<?php
			if (is_array($this->edge_mode['config'])){
				foreach ($this->edge_mode['config'] as $key => $value){
					echo '<span id="'.$key.'" rel="'.$value.'"></span>';
				}
			}
		}
		?>
		<span id='plugin-trial' rel='<?php echo $this->preferences['buyer_validated']; ?>'></span>
		<form method="post" name="tvr_microthemer_ui_serialised" id="tvr_microthemer_ui_serialised" autocomplete="off">
			<?php wp_nonce_field('tvr_microthemer_ui_serialised');?>
			<input type="hidden" name="action" value="tvr_microthemer_ui_serialised" />
			<textarea id="tvr-serialised-data" name="tvr_serialized_data">hello</textarea>
		</form>
		<?php

		// classes that affect display of things in the ui
		$main_class = '';

		// set interface classes
		$this->preferences['buyer_validated'] ? $main_class.= ' plugin-unlocked' : false;
		$this->preferences['show_interface'] ? $main_class.= ' show_interface' : false;
		($this->preferences['css_important'] != 1) ? $main_class.= ' manual-css-important' : false;
		$this->preferences['show_code_editor'] ? $main_class.= ' show_code_editor' : false;
		$this->preferences['show_rulers'] ? $main_class.= ' show_rulers' : false;
		$this->preferences['draft_mode'] ? $main_class.= ' draft_mode' : false;

		// edge mode interface classes
		if ($this->edge_mode['active']){
			if (is_array($this->edge_mode['config'])){
				foreach ($this->edge_mode['config'] as $key => $value){
					$main_class.= ' '.$key.'-'.$value;
				}
			}
		}

		// log ie notice
		$this->ie_notice();

		/*** Build Visual View ***/
		if (empty($this->preferences['last_viewed_selector'])){
			$last_viewed_selector = '';
		} else {
			$last_viewed_selector = $this->preferences['last_viewed_selector'];
		}
		?>
		<form method="post" name="tvr_microthemer_ui_save" id="tvr_microthemer_ui_save" autocomplete="off">
		<?php wp_nonce_field('tvr_microthemer_ui_save');?>
		<input type="hidden" name="action" value="tvr_microthemer_ui_save" />
		<textarea id="user-action" name="tvr_mcth[non_section][meta][user_action]"></textarea>
		<input id="last-edited-selector" type="hidden" name="tvr_mcth[non_section][meta][last_edited_selector]"
			value="<?php
			if (!empty($this->options['non_section']['meta']['last_edited_selector'])){
				echo $this->options['non_section']['meta']['last_edited_selector'];
			}
			?>" />
		<input id="last-viewed-selector" type="hidden" name="tvr_mcth[non_section][meta][last_viewed_selector]"
			value="<?php echo $last_viewed_selector; ?>" />
		<div id="visual-view" class="<?php echo $main_class; ?>">

			<div id="v-top-controls">
				<div id='hand-css-area'>
					<div id="custom-code-toolbar">
						<div class="heading">
							<?php esc_html_e('Enter your own custom CSS code', 'microthemer'); ?>
						</div>
					</div>

					<div id="code-editors-wrap" class="tvr-editor-area">
						<div id="css-tab-areas" class="query-tabs css-code-tabs">
						<span class="edit-code-tabs show-dialog"
							title="<?php esc_attr_e('Edit custom code tabs', 'microthemer'); ?>" rel="edit-code-tabs">
						</span>

							<?php
							// save the configuration of the css tab
							$css_focus = !empty($this->preferences['css_focus']) ?
								$this->preferences['css_focus'] : 'all-browsers';

							foreach ($this->custom_code_flat as $key => $arr) {
								echo '<span class="css-tab mt-tab css-tab-'.$arr['tab-key'].' show" rel="'.$arr['tab-key'].'">'.$arr['label'].'</span>';
							}

							?>
							<input class="css-focus" type="hidden"
								name="tvr_mcth[non_section][css_focus]"
								value="<?php echo $css_focus; ?>" />
						</div>
						<div class="tvr-inner-code">
							<?php
							foreach ($this->custom_code_flat as $key => $arr) {
								$code = '';
								if ($key == 'hand_coded_css' or $key == 'js'){
									$opt_arr = $this->options['non_section'];
									$name = 'tvr_mcth[non_section]';
								} else {
									$opt_arr = !empty( $this->options['non_section']['ie_css']) ?
										$this->options['non_section']['ie_css'] : array();
									$name = 'tvr_mcth[non_section][ie_css]';
								}
								if (!empty($opt_arr[$key])){
									$code = htmlentities($opt_arr[$key], ENT_QUOTES, 'UTF-8');
								}
								$name.= '['.$key.']';

								if ($arr['tab-key'] == $css_focus){
									$show_c = 'show';
								} else {
									$show_c = '';
								}
								?>
								<div rel="<?php echo $arr['tab-key']; ?>"
									class="css-code-wrap css-code-wrap-<?php echo $arr['tab-key']; ?> hidden <?php echo $show_c; ?>" data-code-type="<?php echo $arr['type']; ?>">
									<textarea id='css-<?php echo $arr['tab-key']; ?>' class="hand-css-textarea"
										name="<?php echo $name; ?>"
										autocomplete="off"><?php echo $code; ?></textarea>
									<pre id="custom-css-<?php echo $arr['tab-key']; ?>" rel="<?php echo $arr['tab-key']; ?>"
										 class="custom-css-pre"></pre>
									<?php echo $this->save_icon('custom'); ?>

								</div>
							<?php
							}
							?>
						</div>
					</div>
				</div>

				<div id="z-control">

					<div id="responsive-bar">
						<?php echo $this->global_media_query_tabs(); ?>
					</div>

					<div id="tvr-nav" class="tvr-nav">
						<div id="quick-nav" class="quick-nav">
							<span id="vb-focus-prev" class="scroll-buttons tvr-icon" title="<?php esc_attr_e("Go To Previous Selector", 'microthemer'); ?>"></span>
							<span id="vb-focus-next" class="scroll-buttons tvr-icon" title="<?php esc_attr_e("Go To Next Selector", 'microthemer'); ?>"></span>
							<?php
							// for quick debugging
							//$this->show_me = $this->json_format_ua('icon', 'item', 'val');
							echo $this->show_me;
							?>
						</div>
						<div id="tvr-main-menu" class="tvr-main-menu-wrap">
							<span class="main-menu-tip-trigger" title="<?php esc_attr_e("Manage folders & selectors", 'microthemer'); ?>"></span>
							<div id="main-menu-popdown" class="main-menu-popdown">
								<div id="add-new-section">
									<div class="inner-wrap">
										<div class='new-section'>
											<input type='text' data-ph-title="<?php esc_attr_e('Enter a new folder name', 'microthemer'); ?>" class='new-section-input' name='new_section[name]' value='' />
											<span class='new-section-add tvr-button'
												  title="<?php esc_attr_e('Create a new folder', 'microthemer'); ?>">
												<?php esc_html_e('Add Folder', 'microthemer'); ?>
											</span>
										</div>
									</div>
								</div>
								<div class="scrollable-area menu-scrollable">
									<ul id='tvr-menu'>
										<?php
										foreach ( $this->options as $section_name => $array) {
											// if non_section continue
											if ($section_name == 'non_section') {
												continue;
											}
											// section menu item (trigger function for menu selectors too)
											$this->menu_section_html($section_name, $array);
											++$this->total_sections;
										}
										?>
									</ul>
								</div>
								<!-- keep track of total sections & selectors -->
								<div id="ui-totals-count">

									<span id="section-count-state" class='section-count-state' rel='<?php echo $this->total_selectors; ?>'></span>
									<span class="tvr-icon folder-icon"></span>
									<span id="total-sec-count"><?php echo $this->total_sections; ?></span>
									<span class="total-folders"><?php esc_html_e('Folders', 'microthemer'); ?>&nbsp;&nbsp;</span>

									<span class="tvr-icon selector-icon"></span>
									<span id="total-sel-count"><?php echo $this->total_selectors; ?></span>
									<span><?php esc_html_e('Selectors', 'microthemer'); ?></span>

								</div>
							</div>
						</div>
						<span id="current-selector"></span>
						<div id="starter-message"><?php esc_html_e("Double-click anything on the page to begin restyling it.", 'microthemer'); ?></div>
					</div>

				</div>

				<div class="right-stuff-wrap">

					<div id="status-board" class="tvr-popdown-wrap">

						<!--<span class="tvr-icon info-icon"></span>-->
						<div id="status-short"></div>

						<div id="full-logs" class="tvr-popdown scrollable-area">
							<div id="tvr-dismiss">
								<span class="link dismiss-status"><?php esc_html_e('dismiss', 'microthemer'); ?></span>
								<span class="tvr-icon close-icon dismiss-status"></span>
							</div>
							<div class="heading"><?php esc_html_e('Microthemer Notifications', 'microthemer'); ?></div>
							<?php
							echo $this->display_log();
							?>

							<div id="script-feedback"></div>
						</div>
					</div>

				</div>


				<ul id='tvr-options'>
					<?php
					foreach ( $this->initial_options_html as $key => $html) {
						echo $html;
					}
					?>

				</ul>


				<div class="frame-shadow"></div>
			</div>

			<div id="v-frontend-wrap">
				<div id="rHighlight-wrap" class="ruler-stuff">
					<div id="min-neg" class="ruler-stuff"></div>
					<div id="max-neg" class="ruler-stuff"></div>
				</div>
				<div id="rHighlight" class="ruler-stuff"></div>

				<div id="v-frontend">
					<?php
					// resolve iframe url
					$strpos = strpos($this->preferences['preview_url'], $this->home_url);
					// allow user updated URL, if they navigated to a valid page on own site
					if ( !empty($this->preferences['preview_url']) and ($strpos === 0)) {
						$iframe_url = esc_attr($this->preferences['preview_url']);
					} else {
						// default to home URL if invalid page
						$iframe_url = $this->home_url;
					}
					?>
					<iframe id="viframe" frameborder="0" name="viframe"
							rel="<?php echo $iframe_url; ?>" src="<?php echo $this->thispluginurl; ?>includes/place-holder2.html"></iframe>
					<div id="iframe-dragger"></div>

				</div>

				<div id="v-mq-controls" class="ruler-stuff">
					<span id="iframe-pixel-width"></span>
					<span id="iframe-max-width"></span>
					<div id="v-mq-slider" class="tvr-slider"></div>
					<span id="iframe-min-width"></span>


				</div>

				<?php
				// do we show the mob devices preview?
				!$this->preferences['show_rulers'] ? $device_preview_class = 'hidden' : $device_preview_class = '';
				?>
				<div id="common-devices-preview" class="tvr-popright-wrap <?php echo $device_preview_class; ?>">
					<div class="tvr-popright">
						<div id="current-screen-width"></div>
						<div class="scrollable-area">
							<ul class="mob-preview-list">
								<?php
								foreach ($this->mob_preview as $i => $array){
									echo '
									<li id="mt-screen-preview-'.$i.'"
									class="mt-screen-preview" rel="'.$i.'">
									<span class="mt-screen-preview mob-wxh">'.$array[1].' x '.$array[2].'</span>
									<span class="mt-screen-preview mob-model">'.$array[0].'</span>
									</li>';
								}
								?>
							</ul>
						</div>
					</div>
				</div>
				<div id="height-screen" class="hidden"></div>
			</div>

			<div id="advanced-wizard">

				<div class="heading dialog-header">
					<span class="dialog-icon"></span>
					<span class="text"><?php esc_html_e('Create a Selector', 'microthemer'); ?> <!--<a href="#" target="_blank">(learn how)</a>--></span>
						<span class="cancel-wizard cancel tvr-icon close-icon"
							title="<?php esc_attr_e("Close the selector wizard", 'microthemer'); ?>"></span>
				</div>

				<div id="selector-wizard">
					<div class="quick-create">

						<div class="quick-wrap wiz-name">
							<label title="<?php esc_attr_e("Give your selector a memorable name that describes the element or set of elements on the page", 'microthemer'); ?>"><?php esc_html_e('Name', 'microthemer'); ?>:</label>
								<span class="input-wrap wizard-name-wrap" >
									<input id='wizard-name' type='text' class='wizard-name wizard-input' name='wizard_name' value='' />
								</span>
						</div>

						<div class="quick-wrap wiz-folder">
							<label data-ph-title="<?php esc_attr_e("Organise your selector into a folder", 'microthemer'); ?>"><?php esc_html_e('Folder', 'microthemer'); ?>:</label>
								<span class="input-wrap wizard-folder-wrap" >
									<input type="text" class="combobox wizard-folder wizard-input"
										id="wizard_folder" name="wizard_folder" rel="cur_folders" value=""
										data-ph-title="<?php esc_attr_e("Enter new or select a folder...", 'microthemer'); ?>" />
									<span class="combo-arrow"></span>
								</span>
						</div>

					</div>
				</div>

				<div id="adv-tabs" class="query-tabs">
					<?php
					// save the configuration of the css tab
					if (empty($this->preferences['adv_wizard_tab'])){
						$adv_wizard_focus = 'refine-targeting';
					} else {
						$adv_wizard_focus = $this->preferences['adv_wizard_tab'];
					}
					$tab_headings = array(
						'refine-targeting' => esc_html__('Targeting', 'microthemer'),
						'html-inspector' => esc_html__('Inspector', 'microthemer')
					);
					foreach ($tab_headings as $key => $value) {
						if ($key == $adv_wizard_focus){
							$active_c = 'active';
						} else {
							$active_c = '';
						}
						echo '<span class="adv-tab mt-tab adv-tab-'.$key.' show '.$active_c.'" rel="'.$key.'">'.$tab_headings[$key].'</span>';
					}
					// this is redundant (preferences store focus) but kept for consistency with other tab remembering
					?>
					<input class="adv-wizard-focus" type="hidden"
						name="tvr_mcth[non_section][adv_wizard_focus]"
						value="<?php echo $adv_wizard_focus; ?>" />
				</div>

				<div class="wizard-panes">
					<div class="adv-area-refine-targeting adv-area hidden scrollable-area <?php
					if ($adv_wizard_focus == 'refine-targeting') {
						echo 'show';
					}
					?>">
						<div class="scrollable-refined">
							<div class="refine-inner-wrap">

								<ul id="code-suggestions"></ul>
							</div>
						</div>
					</div>

					<div class="adv-area-html-inspector adv-area hidden <?php
					if ($adv_wizard_focus == 'html-inspector') {
						echo 'show';
					}?>">

						<div id="refine-target">
							<div class="refine-target-controls">
								<span class="tvr-prev-sibling refine-button" title="<?php esc_attr_e("Move to Previous Sibling Element", 'microthemer'); ?>"></span>
								<div class="updown-wrap">
									<span class="tvr-parent refine-button" title="<?php esc_attr_e("Move to Parent Element", 'microthemer'); ?>"></span>
									<span class="tvr-child refine-button" title="<?php esc_attr_e("Move to Child Element", 'microthemer'); ?>"></span>
								</div>
								<span class="tvr-next-sibling refine-button" title="<?php esc_attr_e("Move to Next Sibling Element", 'microthemer'); ?>"></span>
							</div>
							<div class="refine-target-html">
								<span class="display-html"></span>
							</div>
						</div>

						<div id="html-computed-css">
							<div class="scrollable-area">

								<?php
								$i = 1;
								foreach ($this->property_option_groups as $property_group => $pg_label) {
									?>
									<ul id="comp-<?php echo $property_group; ?>" class="accordion-menu <?php if ($i&1) { echo 'odd'; } ?>">
										<li class="css-group-heading accordion-heading">
											<span class="menu-arrow accordion-menu-arrow tvr-icon" title="<?php esc_attr_e("Open/close group", 'microthemer'); ?>"></span>
											<span class="text-for-group"><?php echo $pg_label; ?></span>
										</li>
										<?php
										++$i;
										?>
									</ul>
								<?php
								}
								?>
							</div>
						</div>

					</div>
				</div>

				<div class="create-sel-wrap">
					<span class='wizard-add tvr-button' title="<?php esc_attr_e("Create a new selector", 'microthemer'); ?>"><?php esc_html_e('Create Selector', 'microthemer'); ?></span>
				</div>

			</div>

			<div id="v-left-controls-wrap">

				<div id="v-left-controls-old">
					<?php // echo $this->display_left_menu_icons(); ?>
				</div>

				<div id="v-left-controls">
					<?php echo $this->system_menu(); ?>
					<div class="notify-draft" title="<?php esc_attr_e("To publish your changes, simply turn draft mode off", 'microthemer'); ?>">
						<span class="draft-mode tvr-icon nd-icon"></span>
						<span class="nd-text"><?php esc_html_e('Draft mode: ON', 'microthemer'); ?></span>
					</div>
					<?php
					if (!$this->preferences['buyer_validated']){
						?>
						<div class="cta-wrap">
							<a class="cta-button buy-cta tvr-button red-button" href="http://themeover.com" target="_blank"
							   title="<?php esc_attr_e('Purchase a license to use the full program', 'microthemer'); ?>">
								<span class="tvr-icon"></span>
								<span class="cta-label"><?php esc_html_e('Buy', 'microthemer'); ?></span>
							</a>
							<span class="cta-button unlock-cta tvr-button show-dialog"
								  title="<?php esc_attr_e("If you have purchased Microthemer you can enter your email address to unlock the full program. If you have not yet purchased Microthemer, you cannot unlock the full version.", 'microthemer'); ?>" rel="unlock-microthemer">
								<span class="tvr-icon show-dialog" rel="unlock-microthemer"></span>
								<span class="cta-label show-dialog" rel="unlock-microthemer"><?php esc_html_e("Unlock", 'microthemer'); ?></span>
							</span>
						</div>
					<?php
					}
					?>
				</div>





			</div>

		</div>

		<?php
		$interface_class = $this->preferences['show_interface'] ? 'on' : '';
		?>
		<div id="m-logo" class="v-left-button m-logo <?php echo $interface_class; ?> ui-toggle uit-par"
			 data-aspect="show_interface"
			 title="<?php esc_attr_e("Expand/collapse the interface", 'microthemer'); ?>" rel="http://themeover.com/"></div>


		<?php
		// store the active media queries so they can be shared with design packs
		if (is_array($this->preferences['m_queries'])){
			foreach ($this->preferences['m_queries'] as $key => $m_query) {
				echo '
			<input type="hidden" name="tvr_mcth[non_section][active_queries]['.$key.'][label]" value="'.esc_attr($m_query['label']).'" />
			<input type="hidden" name="tvr_mcth[non_section][active_queries]['.$key.'][query]" value="'.esc_attr($m_query['query']).'" />';
			}
		}
		?>

		</form>


	</div><!-- end tvr-ui -->

	<?php
	if (!$this->optimisation_test){
		?>
		<div id="dialogs">

			<!-- Unlock Microthemer -->
			<form name='tvr_validate_form' method="post"
				autocomplete="off" action="admin.php?page=<?php echo $this->microthemeruipage;?>" >
				<?php
				if ($this->preferences['buyer_validated']){
					$title = esc_html__('Microthemer Has Been Successfully Unlocked', 'microthemer');
				} else {
					$title = esc_html__('Enter your PayPal email to unlock Microthemer', 'microthemer');
				}
				echo $this->start_dialog('unlock-microthemer', $title, 'small-dialog'); ?>
				<div class="content-main">
					<?php
					if ($this->preferences['buyer_validated']){
						$class = '';
						if (!empty($this->preferences['license_type'])){
							echo '<p>' . esc_html__('License Type: ', 'microthemer') . '<b>'.$this->preferences['license_type'].'</b></p>';
						}
						?>
						<p><span class="link reveal-unlock"><?php esc_html_e('Validate software using a different email address', 'microthemer'); ?></span>
						</p>
					<?php
					} else {
						$class = 'show';
					}
					?>
					<div id='tvr_validate_form' class='hidden <?php echo $class; ?>'>
						<?php wp_nonce_field('tvr_validate_form'); ?>
						<?php
						if (!$this->preferences['buyer_validated']){
							$attempted_email = esc_attr($this->preferences['buyer_email']);
						} else {
							$attempted_email = '';
						}
						?>
						<ul class="form-field-list">
							<li>
								<label class="text-label" title="<?php esc_attr_e("Enter your PayPal or Email Address - or the email address listed on 'My Downloads'", 'microthemer'); ?>"><?php esc_html_e('Enter PayPal email or see email in "My Downloads"', 'microthemer'); ?></label>
								<input type='text' autocomplete="off" name='tvr_preferences[buyer_email]'
									value='<?php echo $attempted_email; ?>' />
							</li>
						</ul>

						<?php echo $this->dialog_button('Validate', 'input', 'ui-validate'); ?>



						<div class="explain">
							<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>

							<div class="full-about">
							<p><?php echo wp_kses(
								sprintf(
									__('To disable Free Trial Mode and unlock the full program, please enter your PayPal email address. If you purchased Microthemer from CodeCanyon, please send us a "Validate my email" message via the contact form on the right hand side of <a %s>this page</a> (you will need to log in to CodeCanyon first). Receiving this email allows us to verify your purchase.', 'microthemer'),
								'target="_blank" href="http://codecanyon.net/user/themeover"'),
									array( 'a' => array('href' => array(), 'target' => array()) )
							); ?></p>
								<p><?php echo wp_kses(
									__('<b>Note:</b> Themeover will record your domain name when you submit your email address for license verification purposes.', 'microthemer'),
									array( 'b' => array() )
								) ; ?></p>
								<p><?php echo wp_kses(
									sprintf(
										__('<b>Note:</b> if you have any problems with the validator <a %s>send Themeover a quick email</a> and we"ll get you unlocked ASAP.', 'microthemer'),
										'href="https://themeover.com/support/pre-sales-enquiries/" target="_blank"'
									),
									array( 'a' => array( 'href' => array(), 'target' => array() ), 'b' => array() )
								); ?></p>
							</div>
						</div>


					</div>

				</div>
				<?php
				if (!$this->preferences['buyer_validated']){
					echo $this->end_dialog(esc_html__('Validate', 'microthemer'), 'input', 'ui-validate');
				} else {
					echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog');
				}
				?>
			</form>

			<?php
			// this is a separate include because it needs to have separate page for changing gzip
			$page_context = $this->microthemeruipage;
			include $this->thisplugindir . 'includes/tvr-microthemer-preferences.php';
			?>

			<!-- Edit Media Queries -->
			<form id="edit-media-queries-form" name='tvr_media_queries_form' method="post" autocomplete="off"
				action="admin.php?page=<?php echo $this->microthemeruipage;?>" >
				<?php wp_nonce_field('tvr_media_queries_form'); ?>
				<input type="hidden" name="tvr_media_queries_submit" value="1" />
				<?php echo $this->start_dialog('edit-media-queries', esc_html__('Edit Media Queries (For Designing Responsively)', 'microthemer'), 'small-dialog'); ?>

				<div class="content-main">

					<ul class="form-field-list">
						<?php

						// yes no options
						$yes_no = array(
							'initial_scale' => array(
								'label' => __('Set device viewport zoom level to "1"', 'microthemer'),
								'explain' => __('Set this to yes if you\'re using media queries to make your site look good on mobile devices. Otherwise mobile phones etc will continue to scale your site down automatically as if you hadn\'t specified any media queries. If you set leave this set to "No" it will not override any viewport settings in your theme, Microthemer just won\'t add a viewport tag at all.', 'microthemer')
							)

						);
						// text options
						$text_input = array(
							'all_devices_default_width' => array(
								'label' => __('Default screen width for "All Devices" tab', 'microthemer'),
								'explain' => __('Leave this blank to let the frontend preview fill the full width of your screen when you\'re on the "All Devices" tab. However, if you\'re designing "mobile first" you can set this to "480px" (for example) and then use min-width media queries to apply styles that will only have an effect on larger screens.', 'microthemer')
							),
						);

						// mq set combo
						$media_query_sets = array(
							'load_mq_set' => array(
								'combobox' => 'mq_sets',
								'label' => __('Select a media query set', 'microthemer'),
								'explain' => __('Microthemer lets you choose from a list of media query "sets". If you are trying to make a non-responsive site look good on mobiles, you may want to use the default "Desktop-first device MQs" set. If you designing mobile first, you may want to try an alternative set.', 'microthemer')
							)
						);

						// overwrite options
						$overwrite = array(
							'overwrite_existing_mqs' => array(
								'default' => __('yes', 'microthemer'),
								'label' => __('Overwrite your existing media queries?', 'microthemer'),
								'explain' => __('You can overwrite your current media queries by choosing "Yes". However, if you would like to merge the selected media query set with your existing media queries please choose "No".', 'microthemer')
							)
						);

						$this->output_radio_input_lis($yes_no);

						$this->output_text_combo_lis($text_input);
						?>
						<li><span class="reveal-hidden-form-opts link reveal-mq-sets" rel="mq-set-opts"><?php esc_html_e('Load an alternative media query set', 'microthemer'); ?></span></li>
						<?php

						$this->output_text_combo_lis($media_query_sets, 'hidden mq-set-opts');

						$this->output_radio_input_lis($overwrite, 'hidden mq-set-opts');


						?>
					</ul>




					<div class="heading"><?php esc_html_e('Media Queries', 'microthemer'); ?></div>

					<div id="m-queries">
						<ul id="mq-list">
							<?php
							$i = 0;
							if (is_array($this->preferences['m_queries'])){
								foreach ($this->preferences['m_queries'] as $key => $m_query) {
									$this->edit_mq_row($m_query, $key, $i, false);
									++$i;
								}
							}
							?>
						</ul>

						<span id="add-m-query" class="tvr-button add-m-query" rel="<?php echo $i; ?>"><?php esc_html_e('+ New', 'microthemer'); ?></span>

						<!--<input type="hidden" name="tvr_preferences[user_set_mq]" value="1" />-->
						<span id="unq-base" rel="<?php echo $this->unq_base; ?>"></span>

					</div>

					<div class="explain">
						<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>

						<div class="full-about">

							<p><?php esc_html_e('If you\'re not using media queries in Microthemer to make your site look good on mobile devices you don\'t need to set the viewport zoom level to 1. You will be passing judgement over to the devices (e.g. an iPhone) to display your site by automatically scaling it down. But if you are using media queries you NEED to set this setting to "Yes" in order for things to work as expected on mobile devices (otherwise mobile devices will just show a proportionally reduced version of the full-size sites).', 'microthemer'); ?></p>
							<p><?php echo wp_kses (
								sprintf(
									__('You may want to read <a %s>this tutorial which gives a bit of background on the viewport meta tag</a>.', 'microthemer'),
									'target="_blank" href="http://www.paulund.co.uk/understanding-the-viewport-meta-tag"'
								),
								array( 'a' => array( 'href' => array(), 'target' => array() ) )
							); ?></p>
							<p><?php esc_html_e('Feel free to rename the media queries and change the media query code. You can also reorder the media queries by dragging and dropping them. This will determine the order in which the media queries are written to the stylesheet and the order that they are displayed in the Microthemer interface.', 'microthemer'); ?></p>
							<p><?php esc_html_e('<b>Tip:</b> to reset the default media queries simply delete all media query boxes and then save your settings', 'microthemer'); ?></p>
						</div>
					</div>

				</div>

				<?php echo $this->end_dialog(esc_html__('Update Media Queries', 'microthemer'), 'span', 'update-media-queries'); ?>
			</form>

			<!-- must be outside the form -->
			<ul id="m-query-hidden">
				<?php echo $this->edit_mq_row(); ?>
			</ul>

			<!-- Edit Custom Code Tabs -->
			<form id="edit-code-tabs" name='tvr_code_tabs_form' method="post" autocomplete="off"
				action="admin.php?page=<?php echo $this->microthemeruipage;?>" >
				<?php wp_nonce_field('tvr_code_tabs_form'); ?>
				<?php echo $this->start_dialog('edit-code-tabs', esc_html__('Manage Custom Code Editors', 'microthemer'), 'small-dialog'); ?>

				<div class="content-main">
					<ul id="code-list">
						<?php
						$i = 0;
						if (is_array($this->preferences['code_tabs'])){
							foreach ($this->preferences['code_tabs'] as $key => $value) {
								if (is_array($value)){
									foreach ($value as $key => $v2) {
										echo '<li>This is just a teaser: <b>'.$v2.'</b></li>';
									}
								} else {
									echo '<li>This is just a teaser: <b>'.$value.'</b></li>';
								}
								++$i;
							}
						}
						?>
					</ul>
					<p>You will be able to create new code editors and specify the language (CSS, SCSS, JavaScript)
					as well as browser targeting.</p>
				</div>
				<?php
				echo $this->end_dialog(esc_html__('Update Custom Code Tabs', 'microthemer'), 'input', 'update-custom-code-tabs');
				?>
			</form>

			<!-- manage custom code row template
			...
			-->



			<!-- Import dialog -->
			<form method="post" id="microthemer_ui_settings_import" autocomplete="off">
				<?php wp_nonce_field('tvr_import_from_pack'); ?>
				<?php echo $this->start_dialog('import-from-pack', esc_html__('Import settings from a design pack', 'microthemer'), 'small-dialog'); ?>

				<div class="content-main">
					<p><?php esc_html_e('Select a design pack to import', 'microthemer'); ?></p>
					<p class="combobox-wrap input-wrap">
						<input type="text" class="combobox" id="import_from_pack_name" name="import_from_pack_name" rel="directories"
							value="" />
						<span class="combo-arrow"></span>
					</p>
					<p class="enter-name-explain"><?php esc_html_e('Choose to overwrite or merge the imported settings with your current settings', 'microthemer'); ?></p>

					<ul id="overwrite-merge" class="checkboxes fake-radio-parent">
						<li><input name="tvr_import_method" type="radio" value="<?php esc_attr_e('Overwrite', 'microthemer'); ?>" id='ui-import-overwrite'
								class="radio ui-import-method" />
							<span class="fake-radio"></span>
							<span class="ef-label"><?php esc_html_e('Overwrite', 'microthemer'); ?></span>
						</li>
						<li><input name="tvr_import_method" type="radio" value="<?php esc_attr_e('Merge', 'microthemer'); ?>" id='ui-import-merge'
								class="radio ui-import-method" />
							<span class="fake-radio"></span>
							<span class="ef-label"><?php esc_html_e('Merge', 'microthemer'); ?></span>
						</li>
					</ul>
					<?php /*
					<p class="button-wrap"><?php echo $this->dialog_button(__('Import', 'microthemer'), 'span', 'ui-import'); ?></p>*/
					?>
					<div class="explain">
						<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>
						<div class="full-about">
							<p><?php echo wp_kses(
								sprintf(
									__('Microthemer can be used to restyle any WordPress theme or plugin without the need for pre-configuration. That\'s thanks to the handy "Double-click to edit" feature. But just because you <i>can</i> do everything yourself doesn\'t mean <i>have</i> to. That\'s where importable design packs come in. A design pack contains folders, selectors, hand-coded CSS, and background images that someone else has created while working with Microthemer. Of course it may not be someone else, you can create design packs too using the "<span %s>Export</span>" feature!', 'microthemer'),
									'class="link show-dialog" rel="export-to-pack"'
								),
								array( 'i' => array(), 'span' => array() )
							); ?> </p>
							<p><?php printf(
								esc_html__('Note: you can install other people\'s design packs via the "%s" window.', 'microthemer'),
								'<span class="link show-dialog" rel="manage-design-packs">' . __('Manage Design Packs', 'microthemer') . '</span>'
							); ?></p>
							<p><b><?php esc_html_e('You may want to make use of this feature for the following reasons:', 'microthemer'); ?></b></p>
							<ul>
							<li><?php printf(
								esc_html__('You\'ve downloaded and installed a design pack that you found on %s for restyling a theme, contact form, or any other WordPress content you can think of. Importing it will load the folders and hand-coded CSS contained within the design pack into the Microthemer UI.', 'microthemer'),
								'<a target="_blank" href="http://themeover.com/">themeover.com</a>'
								); ?></li>
								<li><?php esc_html_e('You previously exported your own work as a design pack and now you would like to reload it back into the Microthemer UI.', 'microthemer'); ?></li>
							</ul>
						</div>
					</div>
					<br /><br /><br /><br />
				</div>
				<?php echo $this->end_dialog(esc_html_x('Import', 'verb', 'microthemer'), 'span', 'ui-import'); ?>
			</form>



			<!-- Export dialog -->
			<form method="post" id="microthemer_ui_settings_export" action="#" autocomplete="off">
			<?php echo $this->start_dialog('export-to-pack', esc_html__('Export your work as a design pack', 'microthemer'), 'small-dialog'); ?>

			<div class="content-main export-form">
				<input type='hidden' id='only_export_selected' name='only_export_selected' value='1' />
				<input type='hidden' id='export_to_pack' name='export_to_pack' value='0' />
				<input type='hidden' id='new_pack' name='new_pack' value='0' />

				<p class="enter-name-explain"><?php esc_html_e('Enter a new name or export to an existing design pack. Uncheck any folders or custom CSS you don\'t want included in the export.', 'microthemer'); ?></p>
				<p class="combobox-wrap input-wrap">
					<input type="text" class="combobox" id="export_pack_name" name="export_pack_name" rel="directories"
						value="<?php //echo $this->readable_name($this->preferences['theme_in_focus']); ?>" autocomplete="off" />
					<span class="combo-arrow"></span>

				</p>


				<div class="heading"><?php esc_html_e('Folders', 'microthemer'); ?></div>
				<ul id="toggle-checked-folders" class="checkboxes">
					<li><input type="checkbox" name="toggle_checked_folders" />
						<span class="fake-checkbox toggle-checked-folders"></span>
						<span class="ef-label check-all-label"><?php esc_html_e('Check All', 'microthemer'); ?></span>
					</li>
				</ul>
				<ul id="available-folders" class="checkboxes"></ul>

				<div class="heading"><?php esc_html_e('Custom CSS', 'microthemer'); ?></div>
				<ul id="custom-css" class="checkboxes">
					<?php
					foreach ($this->custom_code_flat as $key => $arr) {
						$name = ($key == 'hand_coded_css' or $key == 'js') ?
							'export_sections' : 'export_sections[ie_css]';
						?>
						<li>
							<input type="checkbox" name="<?php echo $name; ?>[<?php echo $key; ?>]" />
							<span class="fake-checkbox custom-css-<?php echo $arr['tab-key']; ?>"></span>
							<span class="code-icon tvr-icon"></span>
							<span class="ef-label"><?php echo $arr['label']; ?></span>
						</li>
						<?php
					}
					?>
				</ul>
				<?php /*
				<p class="button-wrap"><?php echo $this->dialog_button('Export', 'span', 'export-dialog-button'); ?></p>
 */ ?>

				<div class="explain">
					<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>

					<div class="full-about">
						<p><?php echo wp_kses(
							sprintf(
								__('Microthemer gives you the flexibility to export your current work to a design pack for later use (you can <span %1$s>import</span> it back). Microthemer will create a directory on your server in %2$s which will be used to store your settings and background images. Your folders, selectors, and hand-coded css settings are saved to a configuration file in this directory called config.json.', 'microthemer'),
								'class="link show-dialog" rel="import-from-pack"',
								'<code>/wp-content/micro-themes/</code>'
								),
							array( 'span' => array() )
						); ?></p>
						<p><b><?php esc_html_e('You may want to make use of this feature for the following reasons:', 'microthemer'); ?></b></p>
						<ul>
							<li><?php printf(
								esc_html__('To make extra sure that your work is backed up (even though there is an automatic revision restore feature). After exporting your work to a design pack you can also download it as a zip package for extra reassurance. You can do this from the "%s" window.', 'microthemer'),
								'<span class="link show-dialog" rel="manage-design-packs">' . esc_html__('Manage Design Packs', 'microthemer') . '</span>'
							); ?></li>
							<li><?php esc_html_e('To save your current work but then start a fresh (using the "reset" option in the left-hand menu)', 'microthemer'); ?></li>
							<li><?php esc_html_e('To save one aspect of your design for reuse in other projects (e.g. styling for a menu). You can do this by organising the styles you plan to reuse into a folder and then export only that folder to a design pack by unchecking the other folders before clicking the "Export" button.', 'microthemer'); ?></li>
							<li><?php printf(
								esc_html__('To submit a design pack for sale or free download on %s', 'microthemer'),
								'<a target="_blank" href="http://themeover.com/">themeover.com</a>'
							); ?></li>
						</ul>
					</div>

				</div>

			</div>
			<?php echo $this->end_dialog(esc_html_x('Export', 'verb', 'microthemer'),
				'span', 'export-dialog-button', esc_attr__('Export settings')); ?>
			</form>


			<!-- View CSS -->
			<?php
			// get user config for scss/draft/minify
			$input_ext = $this->preferences['allow_scss'] ? 'scss': 'css';
			$input_file_stub = $this->preferences['draft_mode'] ? 'draft' : 'active';
			$min_stub = $this->preferences['minify_css'] ? 'min.': '';

			// all possible code view tabs (orig way wasn'ty easily maintainable)
			$jsf = $input_file_stub.'-scripts.js';
			$all_pos_tabs = array(
				'scss' => array(
					'do' => $this->preferences['allow_scss'],
					'ext' => 'scss',
					'file' => $input_file_stub.'-styles.scss'
				),
				'css' => array(
					'do' => 1,
					'ext' => 'css',
					'file' => $input_file_stub.'-styles.css'
				),
				'css_min' => array(
					'do' => $this->preferences['minify_css'],
					'ext' => 'css',
					'file' => 'min.'.$input_file_stub.'-styles.css',
					'minified' => 1
				),
				'js' => array(
					'do' => 1,
					'ext' => 'js',
					'file' => $jsf,
					'file_exists' => file_exists($this->micro_root_dir . $jsf)
				),
				'js_min'=> array(
					'do' => $this->preferences['minify_js'],
					'ext' => 'js',
					'file' => 'min'.$jsf,
					'file_exists' => file_exists($this->micro_root_dir . 'min'.$jsf),
					'minified' => 1
				),
				'other' => array(
					'do' => 0 // for showing external js files and ie if errors arise
				),
			);

			// set up tabs (new)
			foreach ($all_pos_tabs as $key => $arr){
				if ($arr['do']){
					$name = strtoupper($arr['ext']);
					$name.= !empty($arr['minified']) ? ' ('.esc_html__('Min', 'microthemer').')' : '';
					$tabs[] = $name;
				}
			}

			/* save config in useful way for HTML output
			$view_tabs = array(
				'input' => array(
					'do' => true,
					'ext' => $input_ext,
					'file' => $input_file_stub.'-styles.'.$input_ext,
					'minified' => ''
				),
				'output' =>array(
					'do' => ($input_ext == 'css' and empty($min_stub)) ? false : true,
					'ext' => 'css',
					'file' => $min_stub.$input_file_stub.'-styles.css',
					'minified' => $min_stub
				)
			);

			// set up tabs
			$tabs[] = strtoupper($input_ext);
			if ($view_tabs['output']['do']){
				$name = strtoupper($view_tabs['output']['ext']);
				$name.= $view_tabs['output']['minified'] ? ' ('.esc_html__('Minified', 'microthemer').')' : '';
				$tabs[] = $name;
			}
			*/

			// begin dialog
			echo $this->start_dialog('display-css-code', esc_html__('View the CSS code Microthemer generates', 'microthemer'), 'small-dialog', $tabs); ?>

			<div class="content-main dialog-tab-fields">

				<div id="view-css-areas">
					<?php
					$i = -1;
					foreach ($all_pos_tabs as $k => $arr){
						if (!$arr['do']) continue;
						++$i;
						$show = $i == 0 ? 'show' : '';
						?>
						<div class="dialog-tab-field dialog-tab-field-<?php echo $i; ?> hidden <?php echo $show; ?>">
							<div class="view-file">
								<a href="<?php echo $this->micro_root_url . $arr['file']; ?>" target="_blank">
									<?php echo $arr['file']; ?></a>
								<span>(<?php echo esc_html_e('not editable here', 'microthemer'); ?>)</span>
							</div>
							<div class="css-code-wrap">
								<textarea class="gen-css-holder"></textarea>
								<?php
								$min_class = !empty($arr['minified']) ? 'min' : '';
								$mode = $arr['ext'] != 'js' ? $arr['ext'] : 'javascript';
								?>
								<pre id="generated-css-<?php echo $i; ?>"
									 class="generated-css generated-css-<?php echo $k; ?> <?php echo $min_class; ?>"
									 data-mode="<?php echo $mode; ?>"></pre>
							</div>
						</div>
						<?php
					}
					?>
				</div>

				<div class="explain">
					<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>

					<div class="full-about">
						<p><?php esc_html_e('What you see above is the CSS code Microthemer is currently generating. This can sometimes be useful for debugging issues if you know CSS. Or if you want to reuse the code Microthemer generates elsewhere.', 'microthemer'); ?></p>
						<p><?php echo wp_kses(
							sprintf(
								__('<b>Did you know</b> - it\'s possible to disable or completely uninstall Microthemer and still use the customisations. You just need to paste a small piece of code in your theme\'s functions.php file. See this <a %s>forum post</a> for further information.', 'microthemer'),
								'target="_blank" href="http://themeover.com/forum/topic/microthemer-customizations-when-deactived/"'
							),
							array( 'a' => array( 'href' => array(), 'target' => array() ), 'b' => array() )
						); ?></p>
						<p><?php echo wp_kses(
							sprintf(
								__('<b>Also note</b>, Microthemer adds the "!important" declaration to all CSS styles by default. If you\'re up to speed on %1$s you may want to disable this behaviour on the <span %2$s>preferences page</span>. If so, you will still be able to apply "!important" declarations on a per style basis by clicking the faint "i"s that will appear to the right of all style option fields.', 'microthemer'),
								'<a target="_blank" href="http://themeover.com/beginners-guide-to-understanding-css-specificity/">' . esc_html__('CSS specificity', 'microthemer') . '</a>',
								'class="link show-dialog" rel="display-preferences"'
							),
							array( 'b' => array(), 'span' => array() )
						); ?></p>
					</div>

				</div>
			</div>
			<?php echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog'); ?>

			<!-- Restore Settings -->
			<?php echo $this->start_dialog('display-revisions', esc_html__('Restore settings from a previous save point', 'microthemer'), 'small-dialog'); ?>

			<div class="content-main">
				<div id='revisions'>
					<div id='revision-area'></div>
				</div>
				<span id="view-revisions-trigger" rel="display-revisions"></span>
				<div class="explain">
				<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>
					<div class="full-about">
					<p><?php esc_html_e('Click the "restore" link in the right hand column of the table to restore your workspace settings to a previous save point.', 'microthemer'); ?></p>
					</div>
				</div>
			</div>
			<?php echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog'); ?>

			<!-- Spread the word -->
			<?php echo $this->start_dialog('display-share', esc_html__('Show off your new discovery', 'microthemer'), 'small-dialog'); ?>
			<div class="content-main">
				<div class="explain">
					<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>
					<div class="full-about">
						<p><?php esc_html_e('cash back feature - coupon code to give new customer, affiliate commission for existing', 'microthemer'); ?></p>
						<p><?php esc_html_e('For now, just a simply share widget.', 'microthemer'); ?></p>
					</div>
				</div>
			</div>
			<?php echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog'); ?>

		</div>

		<!-- Manage Design Packs -->
		<?php echo $this->start_dialog('manage-design-packs', esc_html__('Install & Manage Design Packs', 'microthemer')); ?>
		<iframe id="manage_iframe" class="microthemer-iframe" frameborder="0" name="manage_iframe"
				rel="<?php echo 'admin.php?page='.$this->microthemespage; ?>"
				src="<?php echo $this->thispluginurl; ?>includes/place-holder2.html"
				data-frame-loaded="0"></iframe>
		<?php echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog'); ?>

		<!-- Program Docs -->
		<?php echo $this->start_dialog('program-docs', esc_html__('Help Centre', 'microthemer')); ?>
		<iframe id="docs_iframe" class="microthemer-iframe" frameborder="0" name="docs_iframe"
				rel="<?php echo 'admin.php?page=' . $this->docspage; ?>"
				src="<?php echo $this->thispluginurl; ?>includes/place-holder2.html"
				data-frame-loaded="0"></iframe>
		<?php echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog'); ?>

		<!-- Integration -->
		<?php
		echo $this->start_dialog('integration', esc_html__('Integration with 3rd party software', 'microthemer'), 'small-dialog');
		?>
		<div class="content-main">
			<div class="heading"><?php esc_html_e('WPTouch Mobile Plugin', 'microthemer'); ?></div>
			<p><?php /*echo wp_kses(
				sprintf(
					__('Microthemer can be used to style the mobile-only theme that WPTouch presents to mobile devices. In order to load the mobile theme in Microthemer\'s preview window, simply enable WPTouch mode using the toggle in the left toolbar. This toggle will only appear if Microthemer detects that you have installed and activated WPTouch. There is a <a %1$s>free</a> and <a %2$s>premium version</a> of WPTouch.', 'microthemer'),
					'target="_blank" href="<?php echo $this->wp_blog_admin_url; ?>plugin-install.php?tab=search&type=term&s=wptouch+mobile+plugin"',
					'target="_blank" href="http://www.wptouch.com/"'
				),
					array( 'a' => array( 'href' => array(), 'target' => array() ) )
				);
 */?></p>
			<div class="explain">
			<div class="heading link explain-link"><?php esc_html_e('About this feature', 'microthemer'); ?></div>
				<div class="full-about">
					<p><?php esc_html_e('When possible, we\'ll add little features to make it easier to use Microthemer with complementary products.', 'microthemer'); ?></p>
				</div>
			</div>
		</div>
		<?php echo $this->end_dialog(esc_html_x('Close', 'verb', 'microthemer'), 'span', 'close-dialog'); ?>
		<?php
	}
	?>



	<!-- error report form -->
	<form id="error-report-form" name="error_report" method="post">
		<textarea name="tvr_php_error"></textarea>
		<textarea name="tvr_serialised_data"></textarea>
		<textarea name="tvr_browser_info"></textarea>
	</form>

	<!-- html templates -->
	<form action='#' name='dummy' id="html-templates">
		<?php
		if (!$this->optimisation_test){
			?>
			<img id="loading-gif-template" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/ajax-loader-green.gif" />
			<img id="loading-gif-template-wbg" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/ajax-loader-wbg.gif" />
			<img id="loading-gif-template-mgbg" class="ajax-loader small" src="<?php echo $this->thispluginurl; ?>/images/ajax-loader-mgbg.gif" />
			<?php
			// template for displaying save error and error report option
			$short = __('Error saving settings', 'microthemer');
			$long =
				'<p>' . sprintf(
					esc_html__('Please %s. The error report sends us information about your current Microthemer settings, server and browser information, and your WP admin email address. We use this information purely for replicating your issue and then contacting you with a solution.', 'microthemer'),
					'<span id="email-error" class="link">' . __('click this link to email an error report to Themeover', 'microthemer') . '</span>'
				) . '</p>
				<p>' . wp_kses(
					__('<b>Note:</b> reloading the page is normally a quick fix for now. However, unsaved changes will need to be redone.', 'microthemer'),
					array( 'b' => array() )
				). '</p>';
			echo $this->display_log_item('error', array('short'=> $short, 'long'=> $long), 0, 'id="log-item-template"');
			// define template for menu section
			$this->menu_section_html('selector_section', 'section_label');
			// define template for menu selector
			$this->menu_selector_html('selector_section', 'selector_css', array('selector_code', 'selector_label'), 1);
			// define template for section
			echo $this->section_html('selector_section', array());
			// define template for selector
			echo $this->single_selector_html('selector_section', 'selector_css', '', true);
			// define mq template
			//echo $this->media_query_tabs('selector_section', 'selector_css', 'property_group', '', true);
			// define property group templates
			foreach ($this->propertyoptions as $property_group_name => $property_group_array) {
				echo $this->single_option_fields(
					'selector_section',
					'selector_css',
					array(),
					$property_group_array,
					$property_group_name,
					'',
					true);
			}
		}
		?>

	</form>
	<!-- end html templates -->


</div><!-- end #tvr -->
<?php
// output current settings to file (before any save), also useful for output custom debug stuff
if ($this->debug_current){
	$debug_file = $this->micro_root_dir . $this->preferences['theme_in_focus'] . '/debug-current.txt';
	$write_file = fopen($debug_file, 'w');
	$data = '';
	$data.= esc_html__('Custom debug output', 'microthemer') . "\n\n";
	//$data.= $this->debug_custom;
	//$data.= print_r($this->debug_custom, true);
	$data.= "\n\n" . esc_html__('The existing options', 'microthemer') . "\n\n";
	$data.= print_r($this->options, true);
	fwrite($write_file, $data);
	fclose($write_file);
}
