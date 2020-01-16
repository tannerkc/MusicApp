<?php
	class Album {

		private $con;
		private $id;
		private $title;
		private $genre;
		private $artistID;
		private $artworkPath;

		Public function __construct($con, $id) {
				$this->con = $con;
				$this->id = $id;

				$albumQuery = mysqli_query($this->con, "SELECT * FROM albums WHERE id='$this->id'");
				$album = mysqli_fetch_array($albumQuery);

				$this->title = $album['title'];
				$this->artistID = $album['artist'];
				$this->genre = $album['genre'];
				$this->artworkPath = $album['artworkPath'];
		}

		public function getId(){
			return $this->id;
		}

		public function getTitle(){
			return $this->title;
		}

		public function getArtist(){
			return new Artist($this->con, $this->artistID);
		}

		public function getGenre(){
			return $this->genre;
		}

		public function getArtworkPath(){
			return $this->artworkPath;
		}

		public function getNumberOfSongs(){
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id'");
			return mysqli_num_rows($query);
		}

		public function getSongIds(){
			$query = mysqli_query($this->con, "SELECT id FROM songs WHERE album='$this->id' ORDER by albumOrder ASC");
			$array = array();

			while($row = mysqli_fetch_array($query)){
				array_push($array, $row['id']);
			}
			return $array;
		}

}
?>