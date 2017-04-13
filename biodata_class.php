<?php
	if(! class_exists('WP_List_Table')) {
		require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');
	}

	class Table_biodata extends WP_List_Table {
		function get_columns() {
			$column = array(
				'nip'		=> 'NIP',
				'nama'		=> 'Nama',
				'Alamat'	=> 'Alamat',
				'Telp'		=> 'Telepon'
			);
			return $column;
		}

		function prepare_items() {
			global $wpdb;
			$table_name = $wpdb->prefix . 'biodata';
			$query = "select * from " . $table_name;
			$rows = $wpdb->get_results($query);
			$columns = $this->get_columns();
			$hidden = array();
			$sortable = array();

			$this->_column_headers = array($columns, $hidden, $sortable);
			$this->items = $rows;
		}

		function column_default($item, $column_name) {
			return $item->column_name;
		}
	}
?>