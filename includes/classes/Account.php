<?php
	class Account {

		private $con;
		private $errorArray;

		Public function __construct($con) {
				$this->con = $con;
				$this->errorArray = array();
		}

		public function login($un, $pw){
			$pw = md5($pw);
			$query = mysqli_query($this->con, "SELECT * FROM users WHERE username='$un' AND password='$pw'");

			if(mysqli_num_rows($query) == 1) {
				return true;
			}
			else{
				array_push($this->errorArray, Constants::$loginFailed);
				return false;
			}
		}

		public function register($un, $fn, $ln, $em, $pw, $cpw) {
				$this->valid_user($un);
				$this->valid_fname($fn);
				$this->valid_lname($ln);
				$this->valid_email($em);
				$this->valid_password($pw, $cpw);

				if(empty($this->errorArray) == true) {
					//insert data to db
					return $this->insertUserDetails($un, $fn, $ln, $em, $pw);
				}
				else{
					return false;
				}
		}

		public function getError($error) {
			if(!in_array($error, $this->errorArray)) {
				$error = "";
			}
			return "<span class='errorMessage'>$error</span>";
		}

		private function insertUserDetails($un, $fn, $ln, $em, $pw) {
			$encryptedPw = md5($pw);
			$profilePic = "assets/img/profile-pics/default.jpg";
			$date = date("M j, y | g:i");

			$result = mysqli_query($this->con, "INSERT INTO users (username, firstName, lastName, email, password, joinDate, profilePic) VALUES ('$un', '$fn', '$ln', '$em', '$encryptedPw', '$date', '$profilePic')");
			return $result;
		}

		private function valid_user($un) {

			if(strlen($un) > 25 || strlen($un) < 6) {
				array_push($this->errorArray, Constants::$usernameCharacters);
				return;
			}

			$checkUsername = mysqli_query($this->con, "SELECT username FROM users WHERE username='$un'");
			if(mysqli_num_rows($checkUsername) != 0) {
				array_push($this->errorArray, Constants::$usernameTaken);
				return;
			}

		}

		private function valid_fname($fn) {
			if(strlen($fn) > 25) {
				array_push($this->errorArray, Constants::$fnameCharacters);
				return;
			}
		}

		private function valid_lname($ln) {
			if(strlen($ln) > 25) {
				array_push($this->errorArray, Constants::$lnameCharacters);
				return;
			}
		}

		private function valid_email($em) {
			if(!filter_var($em, FILTER_VALIDATE_EMAIL)) {
				array_push($this->errorArray, Constants::$emailInvalid);
				return;
			}
			$checkEmail = mysqli_query($this->con, "SELECT email FROM users WHERE email='$em'");
			if(mysqli_num_rows($checkEmail) != 0) {
				array_push($this->errorArray, Constants::$emailTaken);
				return;
		}
	}

		private function valid_password($pw, $cpw) {
			if($pw != $cpw) {
				array_push($this->errorArray, Constants::$pwNoMatch);
				return;
			}

			if(!preg_match('/^(?=.*[!@#$%^&*-])(?=.*[0-9])(?=.*[A-Z]).{6,25}$/', $pw)) {
				array_push($this->errorArray, Constants::$pwNotAlphanumeric);
				return;
			}
			if(strlen($pw) > 25 || strlen($pw) < 6) {
				array_push($this->errorArray, Constants::$pwCharacters);
				return;
		}
	}
}
?>