<?php
class User{

    private $userTable = "user";
    public $userId;
    public $email;
    public $name;
    public $phone_num;
    public $password;   
    public $occupation;
    public $adhar_number;
    public $annual_Income;
    public $agent;
    public $dob;
    public $address; 
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function login($email,$password){
		if($email && $password) {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->userTable." WHERE email = ? AND password = ?");
			$stmt->bind_param("ss", $email,$password);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}

	function checkEmail($email){
		if($email) {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->userTable." WHERE email = ?");
			$stmt->bind_param("s", $email);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}
	
	function register(){
		
		$stmt = $this->conn->prepare("INSERT INTO ".$this->userTable."(`email`, `name`, `phone_num`, `password`, `occupation` , `adhar_number` , `annual_Income` , `agent` , `dob` , `address`) VALUES(?,?,?,?,?,?,?,?,?,?)");
		
		$this->email = htmlspecialchars(strip_tags($this->email));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->phone_num = htmlspecialchars(strip_tags($this->phone_num));
		$this->password = htmlspecialchars(strip_tags($this->password));
		$this->occupation = htmlspecialchars(strip_tags($this->occupation));
		$this->adhar_number = htmlspecialchars(strip_tags($this->adhar_number));
		$this->annual_Income = htmlspecialchars(strip_tags($this->annual_Income));
		$this->agent = htmlspecialchars(strip_tags($this->agent));
		$this->dob = htmlspecialchars(strip_tags($this->dob));
		$this->address = htmlspecialchars(strip_tags($this->address));
		
		
		$stmt->bind_param("ssissiisss", $this->email, $this->name, $this->phone_num, $this->password, $this->occupation, $this->adhar_number, $this->annual_Income, $this->agent, $this->dob, $this->address);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}

	function read(){
        if($this->userId) {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->userTable." WHERE userId = ?");
            $stmt->bind_param("i", $this->userId);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result; 
    }
}
?>