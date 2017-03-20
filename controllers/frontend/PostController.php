<?php
/**
 
 */

/**
 * User Controller
 * 
 * @author DotKernel Team <team@dotkernel.com>
 */
$session = Zend_Registry::get('session');

// instantiate classes related to User module: model & view
$postModel = new Post();
$postView = new Post_View($tpl);
$userId = isset($registry->session->user->id) ? $registry->session->user->id : '';
$postId = (isset($registry->request['id'])) ? $registry->request['id'] : '';

// all actions MUST set the variable $pageTitle
$pageTitle = $option->pageTitle->action->{$registry->requestAction};
switch($registry->requestAction)
{
	default:
	case 'list':
		$page = (isset($registry->request['page']) && $registry->request['page'] > 0) ? $registry->request['page'] : 1;
		$postList = $postModel->getPostList($page);
		$postView->listPost('list', $postList, $page);
	break;
	case 'read':
		$data = $postModel->getPostById($postId, $userId);
		$comment = 'asd';
		$commentList = $postModel->getCommentsList($postId);
		$replyList = $postModel->getReplysList($postId);
		$commentsNumber = $postModel->getCommentNumber($postId);
		$username = $postModel->getUploadUsername($postId);
		$to_time = $_SERVER['REQUEST_TIME'];
		$from_time = strtotime($data['date']);
		$time_submitted = round(abs($to_time - $from_time) / 3600) . " hours";
		
		//         $prev = $postModel->getBeforeLastPostUploadedId($postId);
		$LoggedUser = isset($registry->session->user->id) ? $registry->session->user->id : '';
		$rating = $postModel->checkIfRatingExists($userId, $postId);
		$ratingValue = $rating['value'];
		
		@$next = $postModel->nextPost($postId);
		@$prev = $postModel->prevPost($postId);
		$postNumber = $postModel->getLastPostUploadedId();
		$firstPost = $postModel->getFirstPostUploadedId();
		if(! $next)
		{
			@$next = $postNumber['id'];
		}
		
		if(! $prev)
		{
			$prev = $firstPost['id'];
		}
		$categoryName = $postModel->getCategoryName($postId);
		$logg = $postModel->commentData2($userId);
		$postView->read('read', $data, $comment, $userId, $postId, $commentList,$replyList, $commentsNumber['count(*)'],
								$username['username'], $time_submitted, $categoryName, $next, $prev, $logg, $ratingValue);
		
	break;
	case 'upload':
		$postData = array('title' => '', 'content' => '', 'categoryId' => '', 'userId' => '');
		if(! empty($_POST))
		{
			$destination = APPLICATION_PATH . '/uploads/images';
			$ext = pathinfo($_FILES['upload']['name'], PATHINFO_EXTENSION);
			
			if($ext == 'jpg')
			{
				$filename = md5(microtime()) . '.' . $ext;
				move_uploaded_file($_FILES['upload']['tmp_name'], $destination . '/' . $filename);
				$postData['title'] = (isset($_POST['title'])) ? strip_tags($_POST['title']) : '';
				$postData['content'] = $filename;
				$postData['userId'] = $userId;
				$postData['categoryId'] = (isset($_POST['categoryId'])) ? strip_tags($_POST['categoryId']) : '';
				// Zend_Debug::dump($postData, $label = null, $echo = true);exit;
				

				$postModel->insertPost($postData);
				
				header(
										'Location: ' . $registry->configuration->website->params->url . '/' .
																 $registry->requestController . '/' . 'list');
				exit();
			}
			else
			{
				$registry->session->message['txt'] = $option->warningMessage->extensionAdd;
				$registry->session->message['type'] = 'info';
			}
		}
		$categoryList = $postModel->getCategoryList();
		// Zend_Debug::dump($categoryList, $label = null, $echo = true);exit;
		$postView->upload('upload', $postData, $categoryList);
	break;
	
	case 'comment':
	
		$result = array("success" => false, "message" => "An error occured, please try again.");
		$data = array();
		if(! empty($_POST))
		{
			$data['text'] = $_POST['text'];
			$data['userId'] = $_POST['userId'];
			$data['postId'] = $_POST['postId'];
			$data['root'] = 0;
			
// 			Zend_Debug::dump($_POST, $label=null, $echo=true);exit;
// 			$com = $postModel->checkComments($data['userId'], $data['postId'], $data['text']);
// 			if($com == false)
// 			{
				$postModel->insertComment($data);
				$result = array('text' =>$data['text'], 'userId' =>$data['userId'],'postId' => $data['postId']);
// 			}
		}
		echo Zend_Json::encode($result);
		exit();
		$postView->comments('comments', $data);
	
	break;
	case 'reply':
		$result = array("success" => false, "message" => "An error occured, please try again.");
		$data = array();
// 		Zend_Debug::dump($_POST, $label=null, $echo=true);exit;
		if(! empty($_POST))
		{
			$data['root'] = $_POST['commentId'];
			$data['text'] = $_POST['replyText'];
			$data['userId'] = $userId;
			$data['postId'] = $_POST['replyPostId'];
// 			$commData = $postModel->commentData($commentId);
// 		if($data)
// 		{
			$result = array("success" => true, 'root'=>$data['root'], 'text'=>$_POST['replyText']);
			//insert reply
			$postModel->insertComment($data);
				
		}
		echo Zend_Json::encode($result);
		exit();
		break;
	case 'image-show':
		$data['id'] = $_POST['id'];
		$c = $postModel->getPostById($data['id']);
		$content = $c['content'];
		$data['content'] = $content;
		echo Zend_Json::encode($data);
		exit();
	break;
	case 'edit-comment':
		$data = ['text' => ''];
		$data == false;
		$commentId = (isset($registry->request['id'])) ? $registry->request['id'] : '';
		
		if(is_numeric($commentId))
		{
			$data = $postModel->getCommentById($commentId);
			
			$postId = $data['postId'];
			if(! empty($_POST))
			{
				$data['text'] = (isset($_POST['text'])) ? strip_tags($_POST['text']) : '';
				
				$postModel->updateComment($commentId, $data);
				
				header(
										'Location:' . $registry->configuration->website->params->url . '/' .
																 $registry->requestController . '/read/id/' . $postId);
				exit();
			}
			
			// $data = $postModel->getCommentById($commentId);
			$postView->editComment('updateComment', $data, $userId);
		}
		
		$uId = $data['userId'];
		$userId = $registry->session->user->id;
		$cId = $data['id'];
		if($uId != $userId && $cId != $commentId)
		{
			$registry->session->message['txt'] = $option->warningMessage->NoPostExist;
			$registry->session->message['type'] = 'warning';
			
			header('Location:' . $registry->configuration->website->params->url . '/' . $registry->requestController);
			exit();
		}
		if($data == false)
		{
			$registry->session->message['txt'] = $option->warningMessage->noCommentExist;
			$registry->session->message['type'] = 'warning';
			
			header('Location:' . $registry->configuration->website->params->url . '/' . $registry->requestController);
			exit();
		}
	break;
	case 'user':
		$postView->userProfile('user');
	break;
	case 'history':
		// userId,postId
		// list cu posturile
		$postView->userHistory('history');
	break;
	case 'like':
		$result = array("success" => false, "message" => "An error occured, please try again.");
		
		$data = [];
		$data['postId'] = $_POST['id'];
		$data['userId'] = $registry->session->user->id;
		
		$rating = $postModel->checkIfRatingExists($data['userId'],$data['postId']);
		$data['value'] = (int)$rating['value']*(-1)+1;
		if(!$rating )
		{
// 			$data['value'] = 1;
		$postModel->insertRating($data);
		$result = array("succes"=>true,"state" => "1");
		}
		else 
		{
				$data['value'] = (int)$rating['value']*(-1)+1;
				$postModel->updateRating($rating['id'],$data);
				$result = array("succes"=>true,"state" => $data['value']);
		}
		echo Zend_Json::encode($result);
		exit;
	break;
}

