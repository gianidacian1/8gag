<script src="{SITE_URL}/templates/js/frontend/jquery-3.0.0.min.js"></script>

<div id="list">

	<!-- BEGIN post_list -->
	<div id="content">
		<a href="{SITE_URL}/post/read/id/{POST_ID}"><h3 id={POST_ID}>{POST_TITLE}</h3></a>
			<button id="btn-redd"  onclick="show({POST_ID},'{POST_CONTENT}')">+</button>
			<div id="element_{POST_ID}">
			</div>
<!-- 		<div  id = "details_{POST_ID}" class="picture"> -->
 <!-- 		<img  src="{SITE_URL}/uploads/images/{POST_CONTENT}" height="300" --> 
<!-- 			width="300" > -->
			
<!-- 			</div> -->
	</div>

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


function show(id,content)
{
	var image_loaded =document.getElementById('id_' +id);
	if(image_loaded == null)
	{
		$.ajax({
		url:site_url + '/post/image-show',
		method: "POST",
		data:{ id : id,content :content},
		success:function(response){
		var c= JSON.parse(response);
		var d=c['content'];
		appendImage(c['id'],c['content']);
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