var site_url = "{SITE_URL}";
var uId = "{COMMENT_LOGGED_USER}" ;
//"{COMMENTS_USERNAME}";
var comment = $('#text').val();
var commentId = "{COMMENTS_ID}";
var postId = "{POST_ID}";

var userId = "{USER_ID}";

function rating(id)
{
	var state = "{ISACTIVE}";
	 targetElement =  $("#like");
			var active = targetElement.data('active');
			toggleState = active*(-1) + 1;
	$.ajax({
		  url: site_url + '/post/like',
		  method: "POST",
		  data: { id: id,state: toggleState},
		  success:
			  function(result){
//					if (result){
						var c = JSON.parse(result);
						console.log(c);
//						targetElement.data('active', result.isActive);
//						if (c['state'] === 1){
//							targetElement.removeClass('Unlike_state').addClass("Like_state");
//							targetElement.text('Like');
//							
//						}else{
//							targetElement.removeClass("Like_state").addClass("Unlike_state");
//							targetElement.text('Unlike');
//						}
//					}
		},
		
		  error: function(){
			 	  			}
		});
}
