<?php
	class Song {

		private $con;
		private $id;
		private $mysqliData;
		private $title;
		private $artistID;
		private $genre;
		private $albumid;
		private $duration;
		private $path;
		private $plays;

		Public function __construct($con, $id) {
				$this->con = $con;
				$this->id = $id;

				$query = mysqli_query($this->con, "SELECT * FROM songs WHERE id='$this->id'");
				$this->mysqliData = mysqli_fetch_array($query);

				$this->title = $this->mysqliData['title'];
				$this->artistID = $this->mysqliData['artist'];
				$this->genre = $this->mysqliData['genre'];
				$this->albumid = $this->mysqliData['album'];
				$this->duration = $this->mysqliData['duration'];
				$this->path = $this->mysqliData['path'];
				$this->plays = $this->mysqliData['plays'];
		}

		Public function getId(){
			return $this->id;
		}

		Public function getTitle(){
			return $this->title;
		}

		Public function getArtist(){
			return new Artist($this->con, $this->artistID);
		}

		Public function getAlbum(){
			return new Album($this->con, $this->albumid);
		}

		Public function getPath(){
			return $this->path;
		}

		Public function getDuration(){
			return $this->duration;
		}

		Public function getMysqliData(){
			return $this->mysqliData;
		}

		Public function getGenre(){
			return $this->genre;
		}

		Public function getPlays(){
			return $this->plays;
		}


	}
?>