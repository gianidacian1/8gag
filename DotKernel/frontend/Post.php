<?php

/**
 * DotBoost Technologies Inc.
 * DotKernel Application Framework
 *
 * @category   DotKernel
 * @copyright  Copyright (c) 2009-2015 DotBoost Technologies Inc. (http://www.dotboost.com)
 * @license    http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
 * @version    $Id: User.php 981 2015-06-11 13:51:41Z gabi $
 */

/**
 * User Model
 * Here are all the actions related to the user
 * @category   DotKernel
 * @package    Frontend
 * @author     DotKernel Team <team@dotkernel.com>
 */
class Post extends Dot_Model_User
{
	private $_userAgent;
	private $_httpReferer;

	/**
	 * Constructor
	 * @access public
	 */
	public function __construct($userAgent = null, $httpReferer = null)
	{
		parent::__construct();
		// if no userAgent is given on function call mark it as empty - if the userAgent is empty keep it empty
		// if the userAgent stays empty it can be used for robot detecting or devices with blank UA (usually bots)
		// HTTP Reffer is optional so mark it empty if there is no HTTP Reffer
		$this->_userAgent = (! is_null($userAgent)) ? $userAgent : '';
		$this->_httpReferer = (! is_null($httpReferer)) ? $httpReferer : '';
	}

	public function getPostList($page = 1)
	{
		$select = $this->db->select()->from('post');
		
		$result = $this->db->fetchAll($select);
		
		return $result;
	}

	public function getCommentsList($postId, $page = 1)
	{
		$select = $this->db->select()
			->from('comments')
			->where('postId=?', $postId)
			->join('user', 'user.id = comments.userId', ['username' => 'user.username'])
			    ->order('data DESC');
		
		$result = $this->db->fetchAll($select);
		return $result;
	}
	
	public function getReplysList($postId, $page = 1)
	{
		$select = $this->db->select()
		->from('reply')
		->where('postId=?', $postId)
		->join('user', 'user.id = reply.userId', ['username' => 'user.username'])
// 		->order('data DESC')
		;
	
		$result = $this->db->fetchAll($select);
		return $result;
	}

	public function getUploadUsername($postId, $page = 1)
	{
		$select = $this->db->select()
			->from('user', ['username'])
			->join('post', 'post.userId = user.id', []);		
		$result = $this->db->fetchRow($select);
		return $result;
	}

	public function getCategoryName($postId, $page = 1)
	{
		$select = $this->db->select()
		->from('post',[])
		->joinLeft('category','post.categoryId =category.id ',['categoryName'=>'name']);
// 			
		$result = $this->db->fetchRow($select);
		return $result['categoryName'];
	}

	public function getCommentById($commentId)
	{
		$select = $this->db->select()
			->from('comments')
			->where('id=?', $commentId);
		
		$result = $this->db->fetchRow($select);
		return $result;
	}

	public function updateComment($id, $data)
	{
		$this->db->update('comments', $data, 'id = ' . $id);
		
		return true;
	}

	public function getCommentNumber($postId)
	{
		$select = $this->db->select()
			->from('comments', 'count(*)')
			->where('postId=?', $postId);
		
		$result = $this->db->fetchRow($select);
		return $result;
	}

	public function checkComments($userId, $postId, $text)
	{
		$select = $this->db->select()
			->from('comments')
			->where('userId=?', $userId)
			->where('postId=?', $postId)
			->where('text=?', $text);
		$result = $this->db->fetchAll($select);
		return (! empty($result));
	}

	public function insertComment($data)
	{
		try
		{
			$insert = $this->db->insert('comments', $data);
			
			return true;
		}
		catch(Exception $e)
		{
			echo 'Caught exception: ', $e->getMessage(), "\n";
			return false;
		}
	}
	
	public function insertReply($data)
	{
		try
		{
			$insert = $this->db->insert('reply', $data);
				
			return true;
		}
		catch(Exception $e)
		{
			echo 'Caught exception: ', $e->getMessage(), "\n";
			return false;
		}
	}
	
	public function insertRating($data)
	{
		$insert = $this->db->insert('rating', $data);
		return true;
	}
public function updateRating($id, $data)
	{
		$this->db->update('rating',$data, 'id = ' . $id);
		
		return true;
	}
	public function checkIfRatingExists($userId,$postId)
	{
		$select = $this->db->select()->from('rating')
		->where('userId=?',$userId)
		->where('postId=?', $postId)
		;
		$result = $this->db->fetchAll($select);
		return $result[0];
		
	}

	public function getPostById($postId)
	{
		$select = $this->db->select()
			->from('post')
			->where('id=?', $postId);
		
		$result = $this->db->fetchRow($select);
		return $result;
	}

	public function getCategoryList($page = 1)
	{
		$select = $this->db->select()->from('category');
		$result = $this->db->fetchAll($select);
		return $result;
	}

	public function insertPost($data)
	{
		try
		{
			$insert = $this->db->insert('post', $data);
			
			return true;
		}
		catch(Exception $e)
		{
			echo 'Caught exception: ', $e->getMessage(), "\n";
			return false;
		}
	}
	
	//     public  function nextPost($postId)
	//     {
	//         $select = $this->db->select()->from('post')->where('id=?',$postId);
	// 	    $result= $this->db->fetchRow($select);
	// 	    return $result;
	//     }
	public function nextPost($postId)
	{
		// length of ids
		$select = $this->db->select()->from('post', array('row_count' => 'COUNT(*)'));
		$result = $this->db->fetchRow($select);
		//         return  $result['row_count'];
		

		$length = (int) $result['row_count'];
		
		//array of all ids
		$select2 = $this->db->select()->from('post', 'id');
		$result2 = $this->db->fetchAll($select2);
		$l2 = count($result2);
		//           return  $l2;
		//finding curent id
		$select3 = $this->db->select()
			->from('post')
			->where('id=?', $postId);
		$result3 = $this->db->fetchRow($select3);
		$presentId = (int) $result3['id'];
		//         return $result3['id'];
		//next button
		for($i = 0; $i < $l2; $i ++)
		{
			if($presentId == $result2[$i]['id'] && $i + 1)
			{
				$next = $result2[$i + 1]['id'];
			}
		}
		return $next;
	}

	public function prevPost($postId)
	{
		// length of ids
		$select = $this->db->select()->from('post', array('row_count' => 'COUNT(*)'));
		$result = $this->db->fetchRow($select);
		//         return  $result['row_count'];
		

		$length = (int) $result['row_count'];
		
		//array of all ids
		$select2 = $this->db->select()->from('post', 'id');
		$result2 = $this->db->fetchAll($select2);
		$l2 = count($result2);
		//           return  $l2;
		//finding curent id
		$select3 = $this->db->select()
			->from('post')
			->where('id=?', $postId);
		$result3 = $this->db->fetchRow($select3);
		$presentId = (int) $result3['id'];
		//         return $result3['id'];
		//next button
		for($i = 0; $i < $l2; $i ++)
		{
			if($presentId == $result2[$i]['id'] && $i + 1)
			{
				$prev = $result2[$i - 1]['id'];
			}
		}
		return $prev;
	}

	private function saveHistory($id)
	{
		$select = $this->db->select()
			->from('post')
			->where('id=?', $id);
		$result = $this->db->fetchRow($select);
		return $result;
	}

	public function getLastPostUploadedId()
	{
		$select = $this->db->select()
			->from('post', 'id')
			->order('id asc')
			->limit('1');
		$result = $this->db->fetchRow($select);
		return $result;
	}

	public function getFirstPostUploadedId()
	{
		$select = $this->db->select()
			->from('post', 'id')
			->order('id desc')
			->limit('1');
		$result = $this->db->fetchRow($select);
		return $result;
	}
	
	public function commentData($id)
	{
		$select = $this->db->select()
			->from('comments')
			->where('comments.id=?', $id)
			->join('user', 'user.id = comments.userId', ['username' => 'user.username'])
			   ;
		
		$result = $this->db->fetchAll($select);
		
		return $result;
	}
	
	public function commentData2($id)
	{
		$select = $this->db->select()
		->from('user','username')
		->where('user.id=?', $id)
		
		;
	
		$result = $this->db->fetchRow($select);
	
		return $result['username'];
	}
}