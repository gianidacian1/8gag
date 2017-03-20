
<form action="{SITE_URL}/post/comment-edit/id/{COMMENT_ID}" method="post">
	<input type="hidden" name="userToken" value="{USERTOKEN}">
	<div class="box-shadow" style="width: 500px">
		<div class="box_header"> Edit Comment</div>
		<ul class="form">
			
			<li class="clearfix"><label>Comment<span
					class="required">*</span></label> 
					<textarea row="4" cols="50" name="text">{COMMENT_TEXT}</textarea></li>
			
			
	</form>
			<li class="clearfix"><label>&nbsp;</label> <input type="submit"
				class="button" value="Update Comment"></li>
		</ul>
	</div>
</form>
