<script src="{SITE_URL}/templates/js/frontend/jquery-3.0.0.min.js"></script>

<div id="list">
	<!-- BEGIN post_list -->
		
		<div class="post_content">
			
				<div id="title_content">
					<a href="{SITE_URL}/post/read/id/{POST_ID}" id="title"><h2>{POST_TITLE}</h2></a>
						<button id="btn-redd"  onclick="show({POST_ID})">
							<img  src="{SITE_URL}/images/but_icon.png" height="23" width="23">
						</button>
					
				</div>
<!-- 					<div id="image_thumbnail_list"> -->
<!-- 					<img  id="image_preview_{POST_ID}" src="{SITE_URL}/uploads/images/{POST_CONTENT}" height="70" width="70"> -->
<!-- 					</div> -->
		</div>
	<!-- 	imaginea dupa ce apesi buttonul -->
		<div id="element_{POST_ID}">
		</div>
<!-- 		{POST_DATE} -->
		</br>

		

		<!-- 	numarul de comentarii -->
<!-- 		<div> -->
<!-- 		{POST_COMMENTS_NUMBER} -->
<!-- 		</div> -->
	<!-- END post_list -->
</div>

<script>


var site_url = "{SITE_URL}";
function appendImage(id,image_name)
{
	var img = document.createElement("img");
	img.src=site_url + '/uploads/images/' +image_name;
	img.className = "post_image";
	img.id = "id_"+id;
	img.setAttribute('height', '300px');
	img.setAttribute('width', '300px');
	document.getElementById("element_"+ id).appendChild(img);
}

function show(id)
{
	var image_loaded =document.getElementById('id_' +id);
	if(image_loaded == null)
	{ 
		$.ajax({
		url:site_url + '/post/image-show',
		method: "POST",
		data:{ id : id},
		success:function(response){
		var c= JSON.parse(response);
		var d=c['content'];
		appendImage(id,d);
	  },
		error: function(){
		alert('failure');
		 	  }
		});
	}
	else
	{
		image_loaded.parentNode.removeChild(image_loaded);
	}
		
}
</script>