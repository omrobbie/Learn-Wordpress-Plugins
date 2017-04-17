<?php
	function bio_widget_register() {
		register_widget("Bio_widgets");
	}
	add_action('widgets_init', 'bio_widget_register');

	class Bio_widgets extends WP_Widget{
		function Bio_widgets() {
			$widget_ops = array(
				'classname'		=> 'Bio_widgets',
				'description'	=> __('Menampilkan slideshow foto guru', 'biodata')
			);

			$control_ops = array(
				'width'		=> 200,
				'height'	=> 250,
			);
			parent::WP_Widget(false, $name = __('BIO: Slideshow Foto Guru', 'biodata'), $widget_ops);
		}

		function form($instance) {
			$bio_defaults['lebar'] = '200';
			$bio_defaults['tinggi'] = '300';
			$instance = wp_parse_args((array) $instance, $bio_defaults);

			$lebar = $instance['lebar'];
			$tinggi = $instance['tinggi'];
?>
			<p>
				<label for="<?php echo $this->get_field_id('lebar'); ?>">
					<?php _e('Lebar foto', 'biodata'); ?>:
				</label>
				<input
					type="text"
					id="<?php echo $this->get_field_id('lebar'); ?>"
					name="<?php echo $this->get_field_name('lebar'); ?>"
					value="<?php echo $lebar; ?>"
				/>
			</p>
			<p>
				<label for="<?php echo $this->get_field_id('tinggi'); ?>">
					<?php _e('Tinggi foto', 'biodata'); ?>:
				</label>
				<input
					type="text"
					id="<?php echo $this->get_field_id('tinggi'); ?>"
					name="<?php echo $this->get_field_name('tinggi'); ?>"
					value="<?php echo $tinggi; ?>"
				/>
			</p>
<?php
		}

		function update($new_instance, $old_instance) {
			$instance = $old_instance;
			$instance['lebar'] = $new_instance['lebar'];
			$instance['tinggi'] = $new_instance['tinggi'];
			return $instance;
		}

		function widget($args, $instance) {
			extract($args);
			extract($instance);

			$lebar = $instance['lebar'];
			$tinggi = $instance['tinggi'];

			global $wpdb;
			$table_name = $wpdb->prefix . 'biodata';
			$data = $wpdb->get_results('select * from ' . $table_name . ' order by rand() limit 10');
			echo $before_widget;
?>
			<h2 class="widget-title">Foto Guru</h2>
			<div class="slidefoto" style="width:<?php echo $lebar."px"; ?>; height:<?php echo $tinggi."px"; ?>;">
<?php
				foreach($data as $d) {
?>
					<img src="<?php echo $d->foto; ?>">
<?php
				}
?>
			</div>
<?php
			echo $after_widget;
		}
	}
?>