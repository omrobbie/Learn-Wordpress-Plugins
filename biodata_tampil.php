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

	// aktifkan menu tambah data
	function bio_input() {
?>
		<div class="wrap">
			<h2>Tambah Biodata Guru</h2>
			<form action="?page=bio_mainmenu" method="post">
				<table class="form-table">
					<tbody>
						<tr>
							<th><label>NIP</label></th>
							<td><input type="text" name="nip"></td>
						</tr>
						<tr>
							<th><label>Nama</label></th>
							<td><input type="text" name="nama" size="40"></td>
						</tr>
						<tr>
							<th><label>Alamat</label></th>
							<td><input type="text" name="alamat" size="80"></td>
						</tr>
						<tr>
							<th><label>Telp</label></th>
							<td><input type="text" name="telp" size="40"></td>
						</tr>
						<tr>
							<th><label>Foto</label></th>
							<td>
								<div id="tampil-foto"></div>
								<input type="text" name="foto" id="foto" size="40">
								<input type="button" class="button pilih-foto" value="Pilih">
							</td>
						</tr>
					</tbody>
				</table>
				<p><input type="submit" name="tambah" class="button button-primary" value="Tambah" Data=""></p>
			</form>
		</div>
<?php
	}

	// memanggil class untuk menampilkan data dari database
	require_once(ROOTDIR . 'biodata_class.php');
?>