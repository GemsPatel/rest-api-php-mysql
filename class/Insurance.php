<?php
class insurance{   
    
    private $insuranceTable = "insurance";
    public $insuranceId;
    public $insurance_amount;
    public $insurance_type;
    public $agent_name;   
    public $duration; 
    public $insurance_status; 
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function read(){
		if($this->insuranceId) {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->insuranceTable." WHERE insuranceId = ?");
			$stmt->bind_param("i", $this->insuranceId);
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->insuranceTable);
		}
		$stmt->execute();
		$result = $stmt->get_result();
		return $result;
	}
	
	function create(){
		
		$stmt = $this->conn->prepare("INSERT INTO ".$this->insuranceTable."(`insurance_amount`, `insurance_type`, `agent_name`, `duration`) VALUES(?,?,?,?)");
		
		$this->insurance_amount = htmlspecialchars(strip_tags($this->insurance_amount));
		$this->insurance_type = htmlspecialchars(strip_tags($this->insurance_type));
		$this->agent_name = htmlspecialchars(strip_tags($this->agent_name));
		$this->duration = htmlspecialchars(strip_tags($this->duration));
		
		$stmt->bind_param("ssss", $this->insurance_amount, $this->insurance_type, $this->agent_name, $this->duration);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
		
	function update(){
	 
		$stmt = $this->conn->prepare("
			UPDATE ".$this->insuranceTable." SET insurance_amount= ?, insurance_type = ?, agent_name = ?,  duration = ? WHERE insuranceId = ?");
	 
		$this->insuranceId = htmlspecialchars(strip_tags($this->insuranceId));
		$this->insurance_amount = htmlspecialchars(strip_tags($this->insurance_amount));
		$this->insurance_type = htmlspecialchars(strip_tags($this->insurance_type));
		$this->agent_name = htmlspecialchars(strip_tags($this->agent_name));
		$this->duration = htmlspecialchars(strip_tags($this->duration));
	 	
		$stmt->bind_param("isssi", $this->insurance_amount, $this->insurance_type, $this->agent_name, $this->duration, $this->insuranceId);
		
		if($stmt->execute()){
			return true;
		}

		return false;
	}
	
	function delete(){
		
		$stmt = $this->conn->prepare(" DELETE FROM ".$this->insuranceTable." WHERE insuranceId = ?");
		$this->id = htmlspecialchars(strip_tags($this->insuranceId));
		$stmt->bind_param("i", $this->insuranceId);
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}

	function request(){
		
		$stmt = $this->conn->prepare("UPDATE ".$this->insuranceTable." SET  insurance_status = ? WHERE insuranceId = ?");		 
		$this->insuranceId = htmlspecialchars(strip_tags($this->insuranceId));
		$this->insurance_status = htmlspecialchars(strip_tags($this->insurance_status));
	 	
		$stmt->bind_param("si", $this->insurance_status, $this->insuranceId);
		
		if($stmt->execute()){
			return true;
		}
		
		return false;
	}

	function checkInsurance(){
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->insuranceTable." WHERE insuranceId = ?");
		$this->insuranceId = htmlspecialchars(strip_tags($this->insuranceId));
		$stmt->bind_param("i", $this->insuranceId);
		$stmt->execute();			
		$result = $stmt->get_result();
		return $result;
	}
}
?>