<?php
	/*
	Plugin Name: Biodata
	Plugin URI: https://github.com/omrobbie/learn-wordpress-plugins.git
	Description: Menampilkan biodata guru di halaman pengunjung
	Version: 1.0
	Author: omrobbie
	Author URI: http://omrobbie.com
	 */

	add_action('admin_menu', 'bio_untuk_menu');
	function bio_untuk_menu() {
		$hook = add_menu_page(
			'Biodata Guru',
			'Biodata Guru',
			'activate_plugins',
			'bio_mainmenu',
			'bio_mainmenu'
		);
		// aktifkan screen options
		add_action("load-$hook", 'bio_options');

		add_submenu_page(
			'bio_mainmenu',
			'Tambah Data',
			'Tambah Data',
			'administrator',
			'bio_input',
			'bio_input'
		);

		add_submenu_page(
			null,
			'Edit Data',
			'Edit Data',
			'administrator',
			'bio_edit',
			'bio_edit'
		);
	}

	// aktifkan screen options
	function bio_options() {
		global $tbbiodata;
		$option = 'per_page';
		$args = array(
			'label'		=> 'Data Guru',
			'default'	=> 5,
			'option'	=> 'data_per_page'
		);
		add_screen_option($option, $args);
		$tbbiodata = new Table_biodata;
	}
	add_filter('set-screen-option', 'bio_set_options', 10, 3);
	function bio_set_options($status, $option, $value) {
		return $value;
	}
	//---

	// aktifkan fungsi shortcode
	add_shortcode('biodata', 'bio_shortcode');
	function bio_shortcode($atts) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'biodata';
?>
		<table class="table stripped">
			<thead>
				<tr>
					<th>No</th>
					<th>Foto</th>
					<th>NIP</th>
					<th>Nama</th>
					<th>Alamat</th>
					<th>HP/Telp</th>
				</tr>
			</thead>
			<tbody>
				<?php
					$query = 'select * from ' . $table_name;
					$data = $wpdb->get_results($query);
					$no = 1;
					foreach($data as $d) {
				?>
						<tr>
							<td><?php echo $no; ?></td>
							<td><img src="<?php echo $d->foto; ?>" width="200"></td>
							<td><?php echo $d->nip; ?></td>
							<td><?php echo $d->nama; ?></td>
							<td><?php echo $d->alamat; ?></td>
							<td><?php echo $d->telp; ?></td>
						</tr>
				<?php
						$no++;
					}
				?>
			</tbody>
		</table>
<?php
		return ob_get_clean();
	}
	//---

	// tambahkan tabel saat plugin di aktifkan
	register_activation_hook(__FILE__, 'bio_actived');
	function bio_actived() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'biodata';

		ob_start();
		$sql = "create table if not exists " . $table_name . " (
					nip int(12) not null,
					nama varchar(50) not null,
					alamat varchar(100) not null,
					telp varchar(15) not null,
					foto text not null,
					primary key (nip)
				);";
		$wpdb->query($sql);
	}

	// hapus table saat plugin di non-aktifkan
	register_uninstall_hook(__FILE__, 'bio_deactived');
	function bio_deactivated() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'biodata';

		$sql = "drop table " . $table_name . ';';
		$wpdb->query($sql);
	}

	// panggil halaman pengaturan biodata
	define('ROOTDIR', plugin_dir_path(__FILE__));
	require_once(ROOTDIR . 'biodata_tampil.php');
?>