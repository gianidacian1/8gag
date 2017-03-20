<link rel="stylesheet" type="text/css" href="{SITE_URL}/templates/css/frontend/stil1.css" />
<link rel="stylesheet" type="text/css" href="{SITE_URL}/templates/css/frontend/style.css" />
<link rel="stylesheet" type="text/css" href="{SITE_URL}/templates/css/admin/darkblue/style.css" />
<!-- <script src="{SITE_URL}/templates/js/frontend/read.js"></script> -->

<div class="POST" post_id="{POST_ID}">

	<!-- BEGIN post_list -->
	<div class="post_header">
		<div class="post_title">
			<div id="title"><h2>{POST_TITLE}</h2></div>
				<div id="button-navigation">
					<a href="{SITE_URL}/post/read/id/{POST_PREV}" id="prev-button-post">Prev</a>
					<a href="{SITE_URL}/post/read/id/{POST_NEXT}" id="next-button-post">Next</a>
			</div>
		</div>
			<div class="post_data">
				<div class="post_datetime">{POST_DATETIME}</div>
			</div>
	</div>
	
	<div class="post_content">
		<img src="{SITE_URL}/uploads/images/{POST_CONTENT}" id="picture"
			height="400" width="500">
	</div> 
<!-- 	{POST_TIME_SUBMITTED} -->
	submitted  by <a href="{SITE_URL}/user/account">{POST_USERNAME}</a> to 
<a href'">/r/{POST_CATEGORYNAME}</a>
<button type = "submit" id="like" onclick="rating({POST_ID})" class="{ACTIVE_IMG}_state " data-active="{ISACTIVE}" >{ACTIVE_IMG}</button>
</br>
	{POST_COMMENTS_NUMBER} comments
			<div id="comment_box">
				<textarea id="text" name="txtcomm"
					placeholder="Post your Comment Here ..." ></textarea> 
			<!-- 		//rows="2" cols="40" -->
			</div>
			<div id="button_post">
			<button id="comment_button" type="submit" name="post_comment"
					onclick="postComment()">Post</button>
				
			</div>

	<!-- BEGIN buttons_post -->
	
		<table class="action_table">
			<tr>
				<td width="25%"><a href="{SITE_URL}/post/edit/id/{POST_ID}"
					title="Edit/Update" class="edit_state">Edit</a></td>
				<td width="25%"><a href="{SITE_URL}/post/delete/id/{POST_ID}"
					title="Delete" class="delete_state">Delete</a></td>
			</tr>
		</table>
	<!-- END buttons_post -->
	<!-- BEGIN comment_list -->
	<div id="comment_list_big" style="background-color: white">
	
		<div id="new_comm"></div>
		
		<div id="comment_list_{COMMENTS_ID}" style="padding-left:10px;background-color:white;padding-bottom:20px;padding-top:10px;">
			 <a href="" class="comment_list_text_{COMMENTS_ID}">{COMMENTS_USERNAME}</a>
				<div id="comment_text">
				{COMMENTS_TEXT} 
				</div>
				
<!-- 				<button onclick="reply({COMMENTS_ID})" id="reply_id_{COMMENTS_ID}" style="border:none; background:none; color:red; padding-left:90%;">Reply</button> -->
			
<!-- 				<div class = "reply_list_{REPLY_ROOT}"> -->
			</div>
			</div>
		
		<!-- END comment_list -->

		</div>
<!-- END post_list -->

</div>

