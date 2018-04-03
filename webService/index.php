<?php
	//error_reporting(0);
	require __DIR__.'/../vendor/autoload.php';
	$username = 'hola.halo777';
	$password = 'lama!!123';
	$debug = false;
	$truncatedDebug = false;

	$ig = new \InstagramAPI\Instagram($debug, $truncatedDebug);
	
	try {
	    $ig->login($username, $password);
	    //$rankToken = \InstagramAPI\Signatures::generateUUID();
	} catch (\Exception $e) {
	    echo 'Something went wrong: '.$e->getMessage()."\n";
	    exit(0);
	}
	//Necessary params
	$request = $_POST['request'];
	$debug = isset($_POST['debug']) ? $_POST['debug'] : 0;
	
	$resultArray = array(
					'result' => 0,
					'resultText' => 'OK'
				);

	
	if (strcmp($request, 'getIdol')==0) {
		$idolName = $_POST['idolName'];
		include_once "getIdol.php";
	}

	else if (strcmp($request, 'insertIdol')==0) {
		$uid = $_POST['uid'];
		include_once "insertIdol.php";
	}

	else if (strcmp($request, 'getResults')==0) {
		$uid = $_POST['uid'];
		include_once "getResults.php";
	}

	else {
		$resultArray['result'] = '-1';
		$resultArray['resultText'] = 'Bad request';
	}
	

	echo json_encode($resultArray);
	/*include_once '/getDriveAccess.php';
		$file = new Google_Service_Drive_DriveFile;
		$file->setName('test');
		$file->setFileExtension('json');
		$response = $service->files->create($file,array(
		  'mimeType' => '',
		  'uploadType' => 'media'
		));
		var_dump($response);*/
?>

