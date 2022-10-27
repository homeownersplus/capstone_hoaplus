<?php

	date_default_timezone_set('Asia/Manila');
	Class Model {
		private $server = "localhost";
		private $username = "root";
		private $password = "";
		private $dbname = "pdocrud";
		private $conn;

		public function __construct() {
			try {
				$this->conn = new mysqli($this->server, $this->username, $this->password, $this->dbname);	
			} catch (Exception $e) {
				echo "Connection failed" . $e->getMessage();
			}
		}	

        public function addEquipment($unique, $ptitle, $pcontent) {
			$query = "INSERT INTO tblusers (Photo, ptitle, pcontent) VALUES (?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sss', $unique, $ptitle, $pcontent);
				$stmt->execute();
				$stmt->close();

			}
		}

        public function displayUsers() {
			$data = null;
			$query = "SELECT * FROM tblusers ORDER BY PostingDate DESC";
			if ($sql = $this->conn->query($query)) {
				while ($row = mysqli_fetch_assoc($sql)) {
					$data[] = $row;
				}
			}
			return $data;
		}

	}
?>