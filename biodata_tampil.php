<?php
	function bio_mainmenu() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'biodata';

		$tbbiodata = new Table_biodata();
?>
		<div class="wrap">
			<h2>Biodata Guru <a href="?page=bio_input" class="add-new-h2">Tambah Data</a></h2>
<?php
			$tbbiodata->prepare_items();
?>
			<form method="post">
				<?php $tbbiodata->search_box('search', 'search_id'); ?>
			</form>

			<form method="post">
				<?php $tbbiodata->display(); ?>
			</form>
		</div>
<?php
	}

	// memanggil class untuk menampilkan data dari database
	require_once(ROOTDIR . 'biodata_class.php');
?>