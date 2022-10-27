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

     
		public function addEquipment($unique, $amename, $pcontent) {
			$query = "INSERT INTO tblusers (Photo, ptitle, pcontent) VALUES (?, ?, ?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sss', $unique, $ptitle, $pcontent);
				$stmt->execute();
				$stmt->close();

			}
		}

		public function addAment($unique, $amename, $amendesc) {
			$query = "INSERT INTO tblamenities (Photo, amename,amendesc) VALUES (?, ?,?)";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sss', $unique, $amename,$amendesc);
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

        public function displayAment() {
			$data = null;
			$query = "SELECT * FROM tblamenities ORDER BY PostingDate DESC";
			if ($sql = $this->conn->query($query)) {
				while ($row = mysqli_fetch_assoc($sql)) {
					$data[] = $row;
				}
			}
			return $data;
		}
		

		public function displaySingleUser($uid) {
			$data = null;
			$query = "SELECT * FROM tblusers WHERE id = ?";
			if($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param("i", $uid);
				$stmt->execute();
				$result = $stmt->get_result();
				$num_of_rows = $stmt->num_rows;
				while ($row = $result->fetch_assoc()) {
					$data[] = $row;
				}
				$stmt->close();
			}
			return $data;
		}

		public function updateUser($unique, $ptitle, $pcontent, $id) {
			$query = "UPDATE tblusers SET Photo = ?, ptitle = ?, pcontent = ? WHERE id = ?";

			if ($stmt = $this->conn->prepare($query)) {
				$stmt->bind_param('sssi', $unique, $ptitle, $pcontent, $id);
				$stmt->execute();
				$stmt->close();

			}
		}

	}
?>