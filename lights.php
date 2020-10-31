<?php

	$bridge = '<siltaip>';                                //Philips hue bridge ip address
	$username = '<username>';                             //Your username to philips hue bridge
	$wait = 250000;
	$timeout = 5;

	function gethue($light) {

		global $bridge,$username,$wait,$timeout;

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_FORBID_REUSE,1);

		$url = $bridge . "/api/" . $username . "/lights/". $light;

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
		usleep($wait);
		$vastaus = curl_exec($ch);
		echo $vastaus;
		curl_close($ch);

	}

	function sendhue($light,$state,$bright) {

		global $bridge,$username,$wait,$timeout;

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_TIMEOUT,$timeout);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch,CURLOPT_FORBID_REUSE,1);

		$attri = array('on' => ($state=="true")?true:false,'bri' => (int) $bright);
		$data_json = json_encode($attri);

		$url = $bridge . "/api/" . $username . "/lights/". $light. "/state";

		curl_setopt($ch,CURLOPT_URL,$url);
		curl_setopt($ch,CURLOPT_HTTPHEADER, array('Content-Type: application/json','Content-Length: '.strlen($data_json)));
		curl_setopt($ch,CURLOPT_CUSTOMREQUEST,'PUT');
		curl_setopt($ch,CURLOPT_POSTFIELDS,$data_json);
		usleep($wait);
		curl_exec($ch);
		curl_close($ch);


	}


	$mode=$_POST["mode"];
	$valo=$_POST["valo"];
	$tila=$_POST["valotila"];
	$bright=$_POST["kirkkaus"];

	if ($mode == "send") {
		sendhue($valo,$tila,$bright);
	}
	elseif ($mode == "get") {
		gethue($valo);
	}
	else {
		echo "meep";
	}
?>
