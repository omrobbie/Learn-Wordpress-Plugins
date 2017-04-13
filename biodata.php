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
?>