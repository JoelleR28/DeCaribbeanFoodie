<?php
/**
 * Copyright (C) 2014-2025 ServMask Inc.
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 *
 * Attribution: This code is part of the All-in-One WP Migration plugin, developed by
 *
 * ███████╗███████╗██████╗ ██╗   ██╗███╗   ███╗ █████╗ ███████╗██╗  ██╗
 * ██╔════╝██╔════╝██╔══██╗██║   ██║████╗ ████║██╔══██╗██╔════╝██║ ██╔╝
 * ███████╗█████╗  ██████╔╝██║   ██║██╔████╔██║███████║███████╗█████╔╝
 * ╚════██║██╔══╝  ██╔══██╗╚██╗ ██╔╝██║╚██╔╝██║██╔══██║╚════██║██╔═██╗
 * ███████║███████╗██║  ██║ ╚████╔╝ ██║ ╚═╝ ██║██║  ██║███████║██║  ██╗
 * ╚══════╝╚══════╝╚═╝  ╚═╝  ╚═══╝  ╚═╝     ╚═╝╚═╝  ╚═╝╚══════╝╚═╝  ╚═╝
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( 'Kangaroos cannot jump here' );
}
?>

<div class="ai1wm-field-set">
	<div class="ai1wm-buttons">
		<div class="ai1wm-button-group ai1wm-button-export ai1wm-expandable">
			<div class="ai1wm-button-main">
				<span role="list" aria-label="<?php esc_attr_e( 'Export Site To', 'all-in-one-wp-migration' ); ?>"><?php esc_html_e( 'Export Site To', 'all-in-one-wp-migration' ); ?></span>
				<span class="ai1mw-lines">
					<span class="ai1wm-line ai1wm-line-first"></span>
					<span class="ai1wm-line ai1wm-line-second"></span>
					<span class="ai1wm-line ai1wm-line-third"></span>
				</span>
			</div>
			<ul class="ai1wm-dropdown-menu ai1wm-export-providers">
				<?php foreach ( apply_filters( 'ai1wm_export_buttons', array() ) as $button ) : ?>
					<li>
						<?php echo wp_kses( $button, ai1wm_allowed_html_tags() ); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>
	</div>
</div>
