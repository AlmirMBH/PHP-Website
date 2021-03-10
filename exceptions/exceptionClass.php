<?php


class CustomizedException extends Exception{

    public function exceptionMessage(){        
    //public function __toString(){        
        $exceptionLogs = '';        
        $exceptionLog = date('d-m-Y H:i:s', time()) . 
                    "\n" . "Code: [{$this->getCode()}]" . "\n" . 
                    "Issue: " . $this->getMessage() . "\n" . 
                    "Script name: " . $this->getFile() . "\n" . 
                    "Line number: " . $this->getLine();

            if(file_exists('exceptions.txt')){           
                    $exceptionLogs = file_get_contents('exceptions.txt');
            }
            file_put_contents('exceptions.txt', "\n" . $exceptionLog . "\n" . $exceptionLogs . "\n");
            return "<div style='color:red; border:1px solid red; padding:4px; text-align:center; margin:60px'>" . $exceptionLog . "</div>";
        }
}




function exception($a){
    if($a < 2){
        //throw new Exception();
        throw new CustomizedException("Invalid number!"); // invoked as getMessage() see below
    }else{
        echo "The number is ok";
    }
}

$a = 1;

try{
    exception($a);
}
catch(CustomizedException $e){        
       echo $e->exceptionMessage();
       //echo $e; // if __toString(){} is used instead of exceptionMessage()
}

?>