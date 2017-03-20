<div id="upload">
		<form action="{SITE_URL}/post/upload" method="post" enctype="multipart/form-data">
			<input type="text" name="title" value="{POST_TITLE}" ></li>
			<input type="file" name="upload" id="post">
			<input type="submit" name="submit" value="Upload Image">
		
			<select name="categoryId">
					<!-- BEGIN category_list -->
					<option value="{CATEGORY_ID}"{CATEGORY_{CATEGORY_ID}}>{CATEGORY_NAME}</option>
					<!-- END category_list -->
					
		</form>
</div>