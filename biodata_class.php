<?php
	if(! class_exists('WP_List_Table')) {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	}

	class Table_biodata extends WP_List_Table {
		function get_columns() {
			$column = array(
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

			// aktifkan fungsi sort
			$orderby = !empty($_GET['orderby']) ? $_GET['orderby'] : 'nama';
			$order = !empty($_GET['order']) ? $_GET['order'] : 'asc';
			$query .= " order by $orderby $order";
			//---

			$rows = $wpdb->get_results($query);
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
	}
?>