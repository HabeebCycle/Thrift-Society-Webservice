<?PHP

class SiteFunction{

	function get_invoice_number($inv){
		$nuv = strlen("".$inv);
		if($nuv<2){$inv = "00000".$inv;}elseif($nuv<3){$inv = "0000".$inv;}elseif($nuv<4){$inv = "000".$inv;}elseif($nuv<5){$inv = "00".$inv;}elseif($nuv<6){$inv = "0".$inv;}
		$invoice = "PX".$inv. $this->get_rand_char(2);
		return $invoice;
	}

	function get_staff_number($inv){
		$staff = "T0".$inv. $this->get_rand_digit(3);
		return $staff;
	}

	function get_rand_id($length){
	  if($length>0){
        $rand_id="";
        for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,61);
			$rand_id .= $this->assign_value($num);
		}
	  }
		return $rand_id;
	}

	function get_rand_digit($length){
	  if($length>0){
        $rand_id="";
        for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,9);
			$rand_id .= $num;
		}
	  }
		return $rand_id;
	}

	function get_rand_char($length){
	  if($length>0){
        $rand_id="";
        for($i=1; $i<=$length; $i++){
			mt_srand((double)microtime() * 1000000);
			$num = mt_rand(1,26);
			$rand_id .= $this->assign_big_char($num);
		}
	  }
		return $rand_id;
	}

	function assign_value($num){

		switch($num){
    case "1":
     $rand_value = "A";
    break;
    case "2":
     $rand_value = "B";
    break;
    case "3":
     $rand_value = "C";
    break;
    case "4":
     $rand_value = "D";
    break;
    case "5":
     $rand_value = "E";
    break;
    case "6":
     $rand_value = "F";
    break;
    case "7":
     $rand_value = "G";
    break;
    case "8":
     $rand_value = "H";
    break;
    case "9":
     $rand_value = "I";
    break;
    case "10":
     $rand_value = "J";
    break;
    case "11":
     $rand_value = "K";
    break;
    case "12":
     $rand_value = "L";
    break;
    case "13":
     $rand_value = "M";
    break;
    case "14":
     $rand_value = "N";
    break;
    case "15":
     $rand_value = "O";
    break;
    case "16":
     $rand_value = "P";
    break;
    case "17":
     $rand_value = "Q";
    break;
    case "18":
     $rand_value = "R";
    break;
    case "19":
     $rand_value = "S";
    break;
    case "20":
     $rand_value = "T";
    break;
    case "21":
     $rand_value = "U";
    break;
    case "22":
     $rand_value = "V";
    break;
    case "23":
     $rand_value = "W";
    break;
    case "24":
     $rand_value = "X";
    break;
    case "25":
     $rand_value = "Y";
    break;
    case "26":
     $rand_value = "Z";
    break;
    case "27":
     $rand_value = "1";
    break;
    case "28":
     $rand_value = "2";
    break;
    case "29":
     $rand_value = "3";
    break;
    case "30":
     $rand_value = "4";
    break;
    case "31":
     $rand_value = "5";
    break;
    case "32":
     $rand_value = "6";
    break;
    case "33":
     $rand_value = "7";
    break;
    case "34":
     $rand_value = "8";
    break;
    case "35":
     $rand_value = "9";
    break;
	case "36":
     $rand_value = "a";
    break;
    case "37":
     $rand_value = "b";
    break;
    case "38":
     $rand_value = "c";
    break;
    case "39":
     $rand_value = "d";
    break;
    case "40":
     $rand_value = "e";
    break;
    case "41":
     $rand_value = "f";
    break;
    case "42":
     $rand_value = "g";
    break;
    case "43":
     $rand_value = "h";
    break;
    case "44":
     $rand_value = "i";
    break;
    case "45":
     $rand_value = "j";
    break;
    case "46":
     $rand_value = "k";
    break;
    case "47":
     $rand_value = "l";
    break;
    case "48":
     $rand_value = "m";
    break;
    case "49":
     $rand_value = "n";
    break;
    case "50":
     $rand_value = "o";
    break;
    case "51":
     $rand_value = "p";
    break;
    case "52":
     $rand_value = "q";
    break;
    case "53":
     $rand_value = "r";
    break;
    case "54":
     $rand_value = "s";
    break;
    case "55":
     $rand_value = "t";
    break;
    case "56":
     $rand_value = "u";
    break;
    case "57":
     $rand_value = "v";
    break;
    case "58":
     $rand_value = "w";
    break;
    case "59":
     $rand_value = "x";
    break;
    case "60":
     $rand_value = "y";
    break;
    case "61":
     $rand_value = "z";
    break;
  }
	return $rand_value;

}

	function assign_big_char($num){

		switch($num){
    case "1":
     $rand_value = "A";
    break;
    case "2":
     $rand_value = "B";
    break;
    case "3":
     $rand_value = "C";
    break;
    case "4":
     $rand_value = "D";
    break;
    case "5":
     $rand_value = "E";
    break;
    case "6":
     $rand_value = "F";
    break;
    case "7":
     $rand_value = "G";
    break;
    case "8":
     $rand_value = "H";
    break;
    case "9":
     $rand_value = "I";
    break;
    case "10":
     $rand_value = "J";
    break;
    case "11":
     $rand_value = "K";
    break;
    case "12":
     $rand_value = "L";
    break;
    case "13":
     $rand_value = "M";
    break;
    case "14":
     $rand_value = "N";
    break;
    case "15":
     $rand_value = "0";
    break;
    case "16":
     $rand_value = "P";
    break;
    case "17":
     $rand_value = "Q";
    break;
    case "18":
     $rand_value = "R";
    break;
    case "19":
     $rand_value = "S";
    break;
    case "20":
     $rand_value = "T";
    break;
    case "21":
     $rand_value = "U";
    break;
    case "22":
     $rand_value = "V";
    break;
    case "23":
     $rand_value = "W";
    break;
    case "24":
     $rand_value = "X";
    break;
    case "25":
     $rand_value = "Y";
    break;
    case "26":
     $rand_value = "Z";
    break;
		}
	return $rand_value;
	}

	public function sendSingleMail($to,$subject,$msg,$headers){

		if(!isset($headers)){
			$headers = "From: Erudite Millennium Ltd. (Erudite Millennium) <info@eruditemillennium.com>";
		}

		$msge = wordwrap($msg,100);

		mail($to,$subject,$msge,$headers);
	}

	function RedirectToURL($url){
        header("Location: $url");
        exit;
    }

	function clearData($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	}

	function convertToWord($amount){
		$currency1 = "Naira";   //Change to the required currency name e.g United State Dollars.
		$currency2 = "Kobo";    //Change to fractional part of the required currency e.g cents.
		$part = explode(".",$amount);
		$sort = count($part);
		if($sort>1){
			$haspart = true;
		}else{
			$haspart = false;
		}
		return $this->getSingleDigit($part[0])." ".$currency1.(($haspart and $part[1]>0)?", ".$this->getDoubleDigit($part[1])." ".$currency2:"").(($haspart and $part[1]>0)?"":" Only");
	}

	function getSingleDigit($digit){
		$num = ["","One","Two","Three","Four","Five","Six","Seven","Eight","Nine"];
		if(strlen($digit)==1)
			return $num[$digit];
		else
			return $this->getDoubleDigit($digit);
	}

	function getDoubleDigit($digit){
		$num = array(10=>"Ten",11=>"Eleven",12=>"Twelve",13=>"Thirteen",14=>"Fourteen",15=>"Fifteen",16=>"Sixteen",17=>"Seventeen",18=>"Eighteen",19=>"Nineteen",20=>"Twenty",30=>"Thirty",40=>"Forty",50=>"Fifty",60=>"Sixty",70=>"Seventy",80=>"Eighty",90=>"Ninety");
		if(strlen($digit)<=2){
			$part1 = (int)($digit/10);
			$part2 = $digit%10;
			if($part1==1){
				return $num[$digit];
			}elseif($part2==0){
				return $num[$digit];
			}else{
				return ($part1>0?$num[$part1*10]:"").($part1>0?"-":"").$this->getSingleDigit($part2);
			}
		}else{
			return $this->getThreeDigit($digit);
		}
	}

	function getThreeDigit($digit){
		if(strlen($digit)<=3){
			$part1 = (int)($digit/100);
			$part2 = $digit%100;
			if($part2==0){
				return $this->getSingleDigit($part1)." Hundred";
			}else{
				return ($part1>0?$this->getSingleDigit($part1)." Hundred":"").($part1>0?" and ":"").$this->getDoubleDigit($part2);
			}
		}else{
			return $this->get4To6Digit($digit);
		}
	}

	function get4To6Digit($digit){
		if(strlen($digit)<7){
			$part1 = (int)($digit/1000);
			$part2 = $digit%1000;
			if($part2==0){
				return $this->getSingleDigit($part1)." Thousand";
			}else{
				return ($part1>0?$this->getSingleDigit($part1)." Thousand":"").($part1>0?", ":"").$this->getThreeDigit($part2);
			}
		}else{
			return $this->get7To9Digit($digit);
		}
	}

	function get7To9Digit($digit){
		if(strlen($digit)<10){
			$part1 = (int)($digit/1000000);
			$part2 = $digit%1000000;
			if($part2==0){
				return $this->getSingleDigit($part1)." Million";
			}else{
				return ($part1>0?$this->getSingleDigit($part1)." Million":"").($part1>0?", ":"").$this->get4To6Digit($part2);
			}
		}else{
			return $this->get10To12Digit($digit);
		}
	}

	function get10To12Digit($digit){
		if(strlen($digit)<13){
			$part1 = (int)($digit/1000000000);
			$part2 = $digit%1000000000;
			if($part2==0){
				return $this->getSingleDigit($part1)." Billion";
			}else{
				return ($part1>0?$this->getSingleDigit($part1)." Billion":"").($part1>0?", ":"").$this->get7To9Digit($part2);
			}
		}else{
			return $this->get13To15Digit($digit);
		}
	}

	function get13To15Digit($digit){
		if(strlen($digit)<16){
			$part1 = (int)($digit/1000000000000);
			$part2 = $digit%1000000000000;
			if($part2==0){
				return $this->getSingleDigit($part1)." Trillion";
			}else{
				return ($part1>0?$this->getSingleDigit($part1)." Trillion":"").($part1>0?", ":"").$this->get10To12Digit($part2);
			}
		}else{
			return $digit." - No correct word found!";
		}
	}

}
