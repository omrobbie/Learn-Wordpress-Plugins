<?php
	if(! class_exists('WP_List_Table')) {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	}

	class Table_biodata extends WP_List_Table {
		function get_columns() {
			$column = array(
				'cb'		=> '<input type="checkbox" />',
				'foto'		=> 'Foto',
				'nip'		=> 'NIP',
				'nama'		=> 'Nama',
				'alamat'	=> 'Alamat',
				'telp'		=> 'Telepon'
			);
			return $column;
		}

		function prepare_items() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'biodata';
			$query = "select * from " . $table_name;

			// aktifkan fungsi pencarian
			if(isset($_POST['s'])) {
				$cari = $_POST['s'];
				$query .= " where nip like '%$cari%' or nama like '%$cari%' or alamat like '%$cari%'";
			}
			//---

			// aktifkan fungsi sort
			$orderby = !empty($_GET['orderby']) ? $_GET['orderby'] : 'nama';
			$order = !empty($_GET['order']) ? $_GET['order'] : 'asc';
			$query .= " order by $orderby $order";
			//---

			// aktifkan pagination
			$perpage = $this->get_items_per_page('data_per_page', 4);
			$currentpage = $this->get_pagenum();
			$totalitems = $wpdb->query($query);
			$offset = ($currentpage-1) * $perpage;
			$query .= " limit $offset, $perpage";
			//---

			$rows = $wpdb->get_results($query);

			// set pagination
			$this->set_pagination_args(array(
				'total_items'	=> $totalitems,
				'per_page'		=> $perpage
			));
			//---

			$columns = $this->get_columns();
			$hidden = array();
			// $sortable = array();
			$sortable = $this->get_sortable_columns();

			$this->_column_headers = array($columns, $hidden, $sortable);
			$this->items = $rows;
		}

		function column_default($item, $column_name) {
			return $item->column_name;
		}

		function get_sortable_columns() {
			$sortable = array(
				'foto'		=> array('foto', false),
				'nip'		=> array('nip', false),
				'nama'		=> array('nama', false),
				'alamat'	=> array('alamat', false),
				'telp'		=> array('telp', false)
			);
			return $sortable;
		}

		function column_nip($item) {
			$actions = array(
				'edit'		=> sprintf('<a href="?page=%s&nip=%s">Edit</a>', 'bio_edit', $item->nip),
				'delete'	=> sprintf('<a href="?page=%s&action=delete&nip=%s">Hapus</a>', 'bio_mainmenu', $item->nip)
			);
			return sprintf('%1$s %2$s', $item->nip, $this->row_actions($actions));
		}

		function column_foto($item) {
			return '<img src="' . $item->foto . '" width="100"';
		}

		function column_cb($item) {
			return sprintf('<input type="checkbox" name="nip[]" value="%s" />', $item->nip);
		}

		function get_bulk_actions() {
			$actions = array(
				'delete'	=> 'Hapus'
			);
			return $actions;
		}
	}
?>