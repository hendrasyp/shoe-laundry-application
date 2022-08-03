<?php


class Moneyspelling
{
	// array of possible numbers => words
	private $word_array = array(1=>"One",2=>"Two",3=>"Three",4=>"Four",5=>"Five",6=>"Six",7=>"Seven",8=>"Eight",9=>"Nine",10=>"Ten",11=>"Eleven",12=>"Twelve",13=>"Thirteen",14=>"Fourteen",15=>"Fifteen",16=>"Sixteen",17=>"Seventeen",18=>"Eighteen",19=>"Nineteen",20=>"Twenty",21=>"Twenty-One",22=>"Twenty-Two",23=>"Twenty-Three",24=>"Twenty-Four",25=>"Twenty-Five",26=>"Twenty-Six",27=>"Twenty-Seven",28=>"Twenty-Eight",29=>"Twenty-Nine",30=>"Thirty",31=>"Thirty-One",32=>"Thirty-Two",33=>"Thirty-Three",34=>"Thirty-Four",35=>"Thirty-Five",36=>"Thirty-Six",37=>"Thirty-Seven",38=>"Thirty-Eight",39=>"Thirty-Nine",40=>"Forty",41=>"Forty-One",42=>"Forty-Two",43=>"Forty-Three",44=>"Forty-Four",45=>"Forty-Five",46=>"Forty-Six",47=>"Forty-Seven",48=>"Forty-Eight",49=>"Forty-Nine",50=>"Fifty",51=>"Fifty-One",52=>"Fifty-Two",53=>"Fifty-Three",54=>"Fifty-Four",55=>"Fifty-Five",56=>"Fifty-Six",57=>"Fifty-Seven",58=>"Fifty-Eight",59=>"Fifty-Nine",60=>"Sixty",61=>"Sixty-One",62=>"Sixty-Two",63=>"Sixty-Three",64=>"Sixty-Four",65=>"Sixty-Five",66=>"Sixty-Six",67=>"Sixty-Seven",68=>"Sixty-Eight",69=>"Sixty-Nine",70=>"Seventy",71=>"Seventy-One",72=>"Seventy-Two",73=>"Seventy-Three",74=>"Seventy-Four",75=>"Seventy-Five",76=>"Seventy-Six",77=>"Seventy-Seven",78=>"Seventy-Eight",79=>"Seventy-Nine",80=>"Eighty",81=>"Eighty-One",82=>"Eighty-Two",83=>"Eighty-Three",84=>"Eighty-Four",85=>"Eighty-Five",86=>"Eighty-Six",87=>"Eighty-Seven",88=>"Eighty-Eight",89=>"Eighty-Nine",90=>"Ninety",91=>"Ninety-One",92=>"Ninety-Two",93=>"Ninety-Three",94=>"Ninety-Four",95=>"Ninety-Five",96=>"Ninety-Six",97=>"Ninety-Seven",98=>"Ninety-Eight",99=>"Ninety-Nine",100=>"One Hundred",200=>"Two Hundred",300=>"Three Hundred",400=>"Four Hundred",500=>"Five Hundred",600=>"Six Hundred",700=>"Seven Hundred",800=>"Eight Hundred",900=>"Nine Hundred");

	// thousand array,
	private $thousand = array("", "Thousand, ", "Million, ", "Billion, ", "Trillion, ", "Zillion, ");

	// variables
	private $val, $currency0, $currency1;
	private $val_array, $dec_value, $dec_word, $num_value, $num_word;
	var $val_word;

	public function number_word($in_val = 0, $in_currency0 = "", $in_currency1 = "") {

		$this->val = $in_val;
		$this->currency0 = $in_currency0;
		$this->currency1 = $in_currency1;

		// remove commas from comma separated numbers
		$this->val = abs(floatval(str_replace(",","",$this->val)));

		if ($this->val > 0) {

			// convert to number format
			$this->val = number_format($this->val, '2', ',', ',');

			// split to array of 3(s) digits and 2 digit
			$this->val_array = explode(",", $this->val);

			// separate decimal digit
			$this->dec_value = intval($this->val_array[count($this->val_array) - 1]);

			if ($this->dec_value > 0) {

				// convert decimal part to word;
				$this->dec_word = $this->word_array[$this->dec_value]." ".$this->currency1;
			}

			// loop through all 3(s) digits in VAL array
			$t = 0;

			// initialize the number to word variable
			$this->num_word = "";

			for ($i = count($this->val_array) - 2; $i >= 0; $i--) {

				// separate each element in VAL array to 1 and 2 digits
				$this->num_value = intval($this->val_array[$i]);

				// if VAL = 0 then no word
				if ($this->num_value == 0) {
					$this->num_word = "".$this->num_word;
				}

				// if 0 < VAL < 100 or 2 digits
				elseif (strlen($this->num_value."") <= 2) {
					$this->num_word = $this->word_array[$this->num_value]." ".$this->thousand[$t].$this->num_word;

					// add 'and' if not last element in VAL
					if ($i == 1) {
						$this->num_word = " and ".$this->num_word;
					}
				}

				// if VAL >= 100, set the hundred word
				else {
					$this->num_word = $this->word_array[substr($this->num_value, 0, 1)."00"]. (intval(substr($this->num_value, 1, 2)) > 0 ? " and " : "") .$this->word_array[intval(substr($this->num_value, 1, 2))]." ".$this->thousand[$t].$this->num_word;
				}
				$t++;
			}

			// add currency to word
			if (!empty($this->num_word)) {
				$this->num_word .= " ".$this->currency0;
			}
		}

		// join the number and decimal words
		return $this->val_word = $this->num_word." ".$this->dec_word;
	}


}
