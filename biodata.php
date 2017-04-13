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
		add_menu_page(
			'Biodata Guru',
			'Biodata Guru',
			'activate_plugins',
			'bio_mainmenu',
			'bio_mainmenu'
		);

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