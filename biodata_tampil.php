<?php
	function bio_mainmenu() {
		global $wpdb;
		$table_name = $wpdb->prefix . 'biodata';

		// CRUD
		$message = "";
		if(isset($_POST['tambah'])) {
			$tambah = $wpdb->insert(
				$table_name,
				array(
					'nip'=>$_POST['nip'],
					'nama'=>$_POST['nama'],
					'alamat'=>$_POST['alamat'],
					'telp'=>$_POST['telp'],
					'foto'=>$_POST['foto']
				),
				array(
					'%s',
					'%s',
					'%s',
					'%s',
					'%s'
				)
			);
			if($tambah) $message = "Data berhasil di tambahkan";
		} elseif(isset($_POST['edit'])) {
			$update = $wpdb->update(
				$table_name,
				array(
					'nama'=>$_POST['nama'],
					'alamat'=>$_POST['alamat'],
					'telp'=>$_POST['telp'],
					'foto'=>$_POST['foto']
				),
				array('nip'=>$_POST['nip']),
				array(
					'%s',
					'%s',
					'%s',
					'%s'
				),
				array('%s')
			);
			if($update) $message = "Data berhasil di edit";
		} elseif(isset($_POST['action']) or isset($_POST['action2'])) {
			if($_POST['action'] == 'delete' or $_POST['action2'] == 'delete') {
				$arrnip = $_POST['nip'];
				foreach($arrnip as $nip) {
					$wpdb->query($wpdb->prepare('delete from ' . $table_name . ' where nip=%s', $nip));
				}
				$message = "Data berhasil di hapus";
			}
		} elseif(isset($_GET['action'])) {
			if($_GET['action'] == 'delete') {
				$hapus = $wpdb->query($wpdb->prepare('delete from ' . $table_name . ' where nip=%s', $_GET['nip']));
				if($hapus) $message = "Data berhasil di hapus";
			}
		}
		//---

		$tbbiodata = new Table_biodata();
?>
		<div class="wrap">
			<h2>Biodata Guru <a href="?page=bio_input" class="add-new-h2">Tambah Data</a></h2>
<?php
			// tampilkan pesan CRUD $message
			if($message!="") {
?>
				<div id="message" class="updated notice is-dismissible">
					<p><?php $message; ?></p>
					<button type="button" class="notice-dismiss"></button>
				</div>
<?php
			}
			//---

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

	// aktifkan menu pemilihan foto
	function bio_get_image() {
		wp_enqueue_script('jquery');
		wp_enqueue_media();
?>
		<script type="text/javascript">
			jquery(document).ready(function($) {
				$('.pilih-foto').click(function(e) {
					e.preventDefault();
					var image = wp.media({
						title		: 'Pilih Foto',
						multiple	: false
					}).open()
					.on('select', function(e) {
						var uploaded_image = image.state().get('selection').first();
						var image_url = uploaded_image.tojson().url;
						$('#foto').val(image_url);
						$('#tampil-foto').html('<img src="' + image_url + '" width="150">');
					});
				});
			});
		</script>
<?php
	}

	// aktifkan menu tambah data
	function bio_input() {
		// gunakan media library
		bio_get_image();
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

	function bio_edit() {
		bio_get_image();
		global $wpdb;
		$table_name = $wpdb->prefix . 'biodata';
		$data = $wpdb->get_results($wpdb->prepare(
			"select * from " . $table_name . " where nip=%s", $_GET['nip']
		));

		foreach($data as $d) {
			$nip = $d->nip;
			$nama = $d->nama;
			$alamat = $d->alamat;
			$telp = $d->telp;
			$foto = $d->foto;
		}
?>
		<div class="wrap">
			<h2>Edit Biodata Guru</h2>
			<form action="?page=bio_mainmenu" method="post">
				<input type="hidden" name="nip" value="<?php echo $nip; ?>">
				<table class="form-table">
					<tbody>
						<tr>
							<th><label>Nama</label></th>
							<td><input type="text" name="nama" value="<?php echo $nama; ?>"></td>
						</tr>
						<tr>
							<th><label>Alamat</label></th>
							<td><input type="text" name="alamat" value="<?php echo $alamat; ?>" size="40"></td>
						</tr>
						<tr>
							<th><label>Telp</label></th>
							<td><input type="text" name="telp" value="<?php echo $telp; ?>" size="60"></td>
						</tr>
						<tr>
							<th><label>Foto</label></th>
							<td>
								<div id="tampil-foto">
									<img src="<?php echo $foto; ?>" width="150">
								</div>
								<input type="text" name="foto" id="foto" size="40">
								<input type="button" class="button pilih-foto" value="Pilih">
							</td>
						</tr>
					</tbody>
				</table>
				<p><input type="submit" name="edit" class="button button-primary" value="Edit Data"></p>
			</form>
		</div>
<?php
	}

	// memanggil class untuk menampilkan data dari database
	require_once(ROOTDIR . 'biodata_class.php');
?>