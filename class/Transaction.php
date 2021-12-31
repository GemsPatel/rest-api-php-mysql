<?php
class Transaction{   
    
    private $transactionTable = "transaction";      
    public $transactionId;
    public $transaction_amount;
    public $transaction_time;
    public $from_account;
    public $to_account;    
    private $conn;
	
    public function __construct($db){
        $this->conn = $db;
    }	
	
	function read(){	
		if($this->transactionId) {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->transactionTable." WHERE transactionId = ?");
			$stmt->bind_param("i", $this->transactionId);					
		} else {
			$stmt = $this->conn->prepare("SELECT * FROM ".$this->transactionTable);		
		}		
		$stmt->execute();			
		$result = $stmt->get_result();		
		return $result;	
	}
	
	function create(){
		
		$stmt = $this->conn->prepare("INSERT INTO ".$this->transactionTable."(`transaction_amount`, `transaction_time`, `from_account`, `to_account`) VALUES(?,?,?,?)");
		
		$this->transaction_amount = htmlspecialchars(strip_tags($this->transaction_amount));
		$this->transaction_time = htmlspecialchars(strip_tags($this->transaction_time));
		$this->from_account = htmlspecialchars(strip_tags($this->from_account));
		$this->to_account = htmlspecialchars(strip_tags($this->to_account));
		
		
		$stmt->bind_param("isii", $this->transaction_amount, $this->transaction_time, $this->from_account, $this->to_account);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}
		
	function update(){
	 
		$stmt = $this->conn->prepare("UPDATE ".$this->transactionTable." SET transaction_amount= ?, transaction_time = ?, from_account = ?, to_account = ? WHERE transactionId = ?");
	 
		$this->transactionId = htmlspecialchars(strip_tags($this->transactionId));
		$this->transaction_amount = htmlspecialchars(strip_tags($this->transaction_amount));
		$this->transaction_time = htmlspecialchars(strip_tags($this->transaction_time));
		$this->from_account = htmlspecialchars(strip_tags($this->from_account));
		$this->to_account = htmlspecialchars(strip_tags($this->to_account));
	 	
		$stmt->bind_param("isiii", $this->transaction_amount, $this->transaction_time, $this->from_account, $this->to_account, $this->transactionId);
		
		if($stmt->execute()){
			return true;
		}
	 
		return false;
	}
	
	function delete(){
		
		$stmt = $this->conn->prepare("
			DELETE FROM ".$this->transactionTable." 
			WHERE transactionId = ?");
			
		$this->id = htmlspecialchars(strip_tags($this->transactionId));
	 
		$stmt->bind_param("i", $this->transactionId);
	 
		if($stmt->execute()){
			return true;
		}
	 
		return false;		 
	}
}
?>