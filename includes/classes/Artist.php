<?php
	class Artist {

		private $con;
		private $id;

		Public function __construct($con, $id) {
				$this->con = $con;
				$this->id = $id;
		}

		public function getId(){
			return $this->id;
		}

		public function getName(){
			$artistQuery = mysqli_query($this->con, "SELECT name FROM artists WHERE id='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['name'];
		}

		public function getPath(){
			$artistQuery = mysqli_query($this->con, "SELECT * FROM artists WHERE id='$this->id'");
			$artist = mysqli_fetch_array($artistQuery);
			return $artist['path'];
		}

		public function getSongIds(){
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE artist='$this->id' ORDER by plays DESC");
			$array = array();

			while($row = mysqli_fetch_array($query)){
				array_push($array, $row['id']);
			}
			return $array;
		}

}
?>