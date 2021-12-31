<?php
class Wallet{   
    
    private $walletTable = "wallet";
    public $userId;
    public $coin;
    public $walletId;
	
    public function __construct($db){
        $this->conn = $db;
    }

    function create(){
        
        $stmt = $this->conn->prepare("INSERT INTO ".$this->walletTable."(`userId`, `coin`) VALUES(?,?)");
        
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->coin = htmlspecialchars(strip_tags($this->coin));
        
        
        $stmt->bind_param("ii",$this->userId, $this->coin);
        
        if($stmt->execute()){
            return true;
        }
     
        return false;        
    }

     function update(){
        
        $stmt = $this->conn->prepare("UPDATE ".$this->walletTable." SET userId= ?, coin = ? WHERE walletId = ?");
        
        $this->walletId = htmlspecialchars(strip_tags($this->walletId));
        $this->userId = htmlspecialchars(strip_tags($this->userId));
        $this->coin = htmlspecialchars(strip_tags($this->coin));
        
        $stmt->bind_param('iii', $this->userId, $this->coin, $this->walletId);
        //print_r($stmt->__toString());die();
        
        if($stmt->execute()){
        //echo $stmt->fullQuery;die();
            return true;
        }
     
        return false;        
    }

    function delete(){
        
        $stmt = $this->conn->prepare("
            DELETE FROM ".$this->walletTable." 
            WHERE walletId = ?");
            
        $this->walletId = htmlspecialchars(strip_tags($this->walletId));
     
        $stmt->bind_param("i", $this->walletId);
     
        if($stmt->execute()){
            return true;
        }
     
        return false;        
    }

    function read(){    
        if($this->walletId) {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->walletTable." WHERE walletId = ?");
            $stmt->bind_param("i", $this->walletId);
        } else {
            $stmt = $this->conn->prepare("SELECT * FROM ".$this->walletTable);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        return $result; 
    }
}