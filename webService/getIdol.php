<?php
	try{
		$uid = $ig->people->getUserIdForName($idolName);
		$response = json_decode(json_encode($ig->people->getInfoById($uid)));
		$resultArray['data'] = array(
									'userID' => $uid,
									'username' 			=> $response->user->username,
									'fullName' 			=> $response->user->full_name != '' ? $response->user->full_name : false,
									'profilePicture' 	=> !is_null($response->user->hd_profile_pic_url_info->url) ? $response->user->hd_profile_pic_url_info->url : false,
									'counts' => array(
											'Followers' => $response->user->follower_count,
											'Following' => $response->user->following_count, 
											'Media' => $response->user->media_count
										)
									);
	}
	catch (Exception $e) {
		$resultArray['result'] = 1;
		$resultArray['resultText'] = substr($e->getMessage(),strpos($e->getMessage(), ' ')+1);
	}
	///
	//if ($response->status=='ok')
	//	echo 'blabla';
	//else
	//	echo 'blublu';
?>