<?php
	try {
		$url = 'https://api.mlab.com/api/1/databases/analysis/collections/idols';
		if ($uid!=null)
			$url.='?q={"_id":"'.$uid.'"}';
		$url.='&apiKey=tvG8BMjzxtNwm3fRgQv4LNbcF2IIeWWc';
		
		//Get all idols where no data has been collected for yet

		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Connection: Keep-Alive'
	    ));

		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		$user = json_decode($response,true)[0];
		$resultArray['data'] = array('id' 				=> 	$user['_id'],
									'username'			=>	$user['userName'],
									'fullName'			=>	$user['fullName'],
									'profilePicture'	=>	$user['profilePicture'],
									'counts'			=>	$user['counts'],
									'final'				=>  true
									);
		$followerResults = array('fake'	=>	0, 'real' => count($user['followers'][0]), 'certainty'	=>	0);
		$url = 'https://api.mlab.com/api/1/databases/analysis/collections/users';
		$url.='?q={"_id":{"$in":'.json_encode($user['followers'][0],true).'}}';
		$url.='&apiKey=tvG8BMjzxtNwm3fRgQv4LNbcF2IIeWWc&';
		$ch = curl_init($url);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array(
	    'Content-Type: application/json',
	    'Connection: Keep-Alive'
	    ));

		curl_setopt($ch, CURLOPT_POST, 0);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$response = curl_exec($ch);
		curl_close($ch);
		$response = json_decode($response,true);
		$followerResults['certainty'] = $response[0]['results']['certainty']; //Since it is constant
		//See if final results
		if (count($response) != count($user['followers'][0]))
			$resultArray['data']['final'] = false;

		foreach ($response as $follower) {	
			$followerResults['fake'] += $follower['results']['isBot'];
			$followerResults['real'] -= $follower['results']['isBot'];
		}
		$resultArray['data']['results'] = $followerResults;
	}
	catch (Exception $e) {
		$resultArray['result'] = -1;
		$resultArray['resultText'] = $e->getMessage();
	}

?>