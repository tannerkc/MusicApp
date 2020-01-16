<?php
	class Artists {

		private $con;
		private $id;
		private $username;
		private $owner;

		Public function __construct($con, $data) {

			if(!is_array($data)){
				$query = mysqli_query($con, "SELECT * FROM playlists WHERE id='$data'");
				$data = mysqli_fetch_array($query);
			}
				$this->con = $con;
				$this->id = $data['id'];
				$this->owner = $data['owner'];
		}

		public function getId(){
			$idQuery = mysqli_query($this->con, "SELECT id FROM playlists WHERE owner='$this->owner' ORDER by id ASC");

			$array = array();

			while($row = mysqli_fetch_array($idQuery)){
				array_push($array, $row['id']);
			}
			return $array;
		}

		public function getArtists(){
			$query1 = mysqli_query($this->con, "SELECT songId FROM playlistsongs WHERE playlistId='$this->id' ORDER by id ASC");

			$array = array();

			while($row = mysqli_fetch_array($query1)){
				array_push($array, $row['songId']);
			}

			$query2 = mysqli_query($this->con, "SELECT artist FROM songs WHERE id IN (".implode(',',$array).")");
			if (!$query2) {
			    exit();
			}
			$array2 = array();

			while($row2 = mysqli_fetch_array($query2)){
				array_push($array2, $row2['artist']);
			}
			
			$query3 = mysqli_query($this->con, "SELECT name FROM artists WHERE id IN (".implode(',',$array2).")");

			$array3 = array();

			while($row3 = mysqli_fetch_array($query3)){
				array_push($array3, $row3['name']);
			}
			return $array3;
		}

}
?>