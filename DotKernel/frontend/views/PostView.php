<?php

/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @copyright  Copyright (c) 2009-2015 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 * @version    $Id: UserView.php 981 2015-06-11 13:51:41Z gabi $
 */

/**
 * User View Class
 * class that prepare output related to User controller 
 * @category   DotKernel
 * @package    Frontend
 * @author     DotKernel Team <team@dotkernel.com>
 */
class Post_View extends View
{

	/**
	 * Constructor
	 * @access public
	 * @param Dot_Template $tpl
	 */
	public function __construct($tpl)
	{
		$this->tpl = $tpl;
		$this->settings = Zend_Registry::get('settings');
	}

	public function listPost($templateFile, $postList, $page = 1)
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'post_list', 'post_list_block');
		//     $this->tpl->setVar('PAGE', $page);
		//     $this->tpl->paginator($postList['pages']);
		foreach($postList as $post)
		{
			$this->tpl->setVar('POST_ID', $post['id']);
			$this->tpl->setVar('POST_TITLE', $post['title']);
			$this->tpl->setVar('POST_CONTENT', $post['content']);
			$this->tpl->setVar('POST_CATEGORYID', $post['categoryId']);
			$this->tpl->setVar('POST_DATE', $post['date']);
			$this->tpl->parse('post_list_block', 'post_list', true);
		}
		//         $this->tpl->setVar('POST_COMMENTS_NUMBER', $commentsNumber);
	}

	public function comments($templateFile, $commentList, $page = 1)
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'comment_list', 'comment_list_block');
		foreach($postList as $post)
		{
			$this->tpl->setVar('COMMENTS_TEXT', $commentList['text']);
			
			$this->tpl->parse('comment_list_block', 'comment_list', true);
		}
	}

	public function read($templateFile, $postData, $comment, $userId , $postId='', $commentList,$replyList, $commentsNumber, 
							$username, $time_submitted, $categoryName, $next, $prev , $LoggedUser, $ratingValue)
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'comment_list', 'comment_list_block');
// 		$this->tpl->setBlock('comment_list', 'reply_list', 'reply_list_block');
		
		//Comments list
		foreach($commentList as $value)
		{
			foreach($value as $k => $v)
			{
				$this->tpl->setVar('COMMENTS_' . strtoupper($k), $v);
			}
			
			$this->tpl->parse('comment_list_block', 'comment_list', true);
				
		}
		//post list
		foreach($postData as $key => $value)
		{
			$this->tpl->setVar('POST_' . strtoupper($key), $postData[$key]);
			$this->tpl->setVar('ACTIVE_IMG', $ratingValue == 1 ? 'Like' : 'Unlike');
				
			$this->tpl->parse('post_list_block', 'post_list', true);
// 			Zend_Debug::dump($postData, $label=null, $echo=true);
		}
		
		
		//extra tpl variables
		$this->tpl->setVar('POST_TEXT', $comment);
		
		$this->tpl->setVar('USER_ID', $userId);
		$this->tpl->setVar('POST_ID', $postId);
		$this->tpl->setVar('POST_USERNAME', $username);
		$this->tpl->setVar('POST_TIME_SUBMITTED', $time_submitted);
		$this->tpl->setVar('POST_CATEGORYNAME', $categoryName);
		
		$this->tpl->setVar('POST_COMMENTS_NUMBER', $commentsNumber);
		$this->tpl->setVar('POST_NEXT', $next);
		$this->tpl->setVar('POST_PREV', $prev);
		$this->tpl->setVar('COMMENT_LOGGED_USER', $LoggedUser);
		$this->tpl->setVar('ISACTIVE', $ratingValue);
		
		// 		$this->tpl->setBlock('tpl_main', 'comment_list', 'comment_list_block');
		

		// search the block in post_list_block
		// set it
		$this->tpl->setBlock('tpl_main', 'buttons_post', 'buttons_post_block');
		
		// if the user id is good, show the buttons -- no repeat
		

		// 		if($postData['userId'] == $userId)
		// 		{
		// 		    $this->tpl->setVar('POST_' . strtoupper($key), $postData['id']);
		// 		    $this->tpl->parse('buttons_post_block', 'buttons_post', false);
		// 		}
		// 		else
		// 		{
		// 		    // if not, don't write anything
		// 		    $this->parse('buttons_post_block' . $postData['id'], '', false);
		// 		}
	}

	public function upload($templateFile, $postData, $categoryList)
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
		$this->tpl->setBlock('tpl_main', 'category_list', 'category_list_block');
		foreach($postData as $key => $value)
		{
			$this->tpl->setVar('POST_' . strtoupper($key), $postData[$key]);
		}
		foreach($categoryList as $category)
		{
			$this->tpl->setVar('CATEGORY_ID', $category['id']);
			$this->tpl->setVar('CATEGORY_NAME', $category['name']);
			$this->tpl->parse('category_list_block', 'category_list', true);
		}
		$this->tpl->setVar('CATEGORY_SELECTED_' . $postData['categoryId'], ' selected ');
	}

	public function editComment($templateFile, $commentList = [], $userId = '')
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
		foreach($commentList as $key => $value)
		{
			$this->tpl->setVar('COMMENT_' . strtoupper($key), $commentList[$key]);
		}
		
		//$this->_showCommennts($commentList, $userId);
	}

	public function userProfile($templateFile)
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
	}

	public function userHistory($templateFile)
	{
		$this->tpl->setFile('tpl_main', 'post/' . $templateFile . '.tpl');
	}
}
