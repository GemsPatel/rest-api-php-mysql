<?php
class Loan{   
    
    private $loanTable = "loan";      
    public $loanId;
    public $loan_amount;
    public $loan_type;
    public $agent_name;
    public $rate_of_Interest;   
    public $duration; 
    public $loan_status; 
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function read(){	
		if($this->loanId) {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->loanTable." WHERE loanId = ?");
			$stmt->bind_param("i", $this->loanId);					
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->loanTable);		
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function create(){
		
		$stmt = $this->conn->prepare("INSERT INTO ".$this->loanTable."(`loan_amount`, `loan_type`, `agent_name`, `rate_of_Interest`, `duration`) VALUES(?,?,?,?,?)");
		
		$this->loan_amount = htmlspecialchars(strip_tags($this->loan_amount));
		$this->loan_type = htmlspecialchars(strip_tags($this->loan_type));
		$this->agent_name = htmlspecialchars(strip_tags($this->agent_name));
		$this->rate_of_Interest = htmlspecialchars(strip_tags($this->rate_of_Interest));
		$this->duration = htmlspecialchars(strip_tags($this->duration));
		
		
		$stmt->bind_param("issis", $this->loan_amount, $this->loan_type, $this->agent_name, $this->rate_of_Interest, $this->duration);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}
		
	function update(){
	 
		$stmt = $this->conn->prepare("
			UPDATE ".$this->loanTable." SET loan_amount= ?, loan_type = ?, agent_name = ?, rate_of_Interest = ?, duration = ? WHERE loanId = ?");
	 
		$this->loanId = htmlspecialchars(strip_tags($this->loanId));
		$this->loan_amount = htmlspecialchars(strip_tags($this->loan_amount));
		$this->loan_type = htmlspecialchars(strip_tags($this->loan_type));
		$this->agent_name = htmlspecialchars(strip_tags($this->agent_name));
		$this->rate_of_Interest = htmlspecialchars(strip_tags($this->rate_of_Interest));
		$this->duration = htmlspecialchars(strip_tags($this->duration));
	 	
		$stmt->bind_param("issisi", $this->loan_amount, $this->loan_type, $this->agent_name, $this->rate_of_Interest, $this->duration, $this->loanId);
		
		if($stmt->execute()){
			//print_r($stmt->errorInfo());
			return true;
		}
	 
		return false;
	}
	
	function delete(){
		
		$stmt = $this->conn->prepare("
			DELETE FROM ".$this->loanTable." 
			WHERE loanId = ?");
			
		$this->id = htmlspecialchars(strip_tags($this->loanId));
	 
		$stmt->bind_param("i", $this->loanId);
	 
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}

	function request(){
		
		$stmt = $this->conn->prepare("UPDATE ".$this->loanTable." SET  loan_status = ? WHERE loanId = ?");		 
		$this->loanId = htmlspecialchars(strip_tags($this->loanId));
		$this->loan_status = htmlspecialchars(strip_tags($this->loan_status));
	 	
		$stmt->bind_param("si", $this->loan_status, $this->loanId);
		
		if($stmt->execute()){
			return true;
		}
		
		return false;
	}

	function checkInsurance(){
		$stmt = $this->conn->prepare("SELECT * FROM ".$this->loanTable." WHERE loanId = ?");
		$this->loanId = htmlspecialchars(strip_tags($this->loanId));
		$stmt->bind_param("i", $this->loanId);
		$stmt->execute();			
		$result = $stmt->get_result();
		return $result;
	}
}
?>