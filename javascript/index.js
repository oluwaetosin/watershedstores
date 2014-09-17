// JavaScript Document
$(document).ready(function(e) {
    $('#slide').cycle();
	$.ajax({url:"engine/homepage.php",
	        dataType:"json",
	        beforeSend: function(){},
			complete: function(){},
			success: function(json){
				    var imageList = "<ul class='image-store'>";
					 
			     $.each(json,function(){
					    for(var i = 0; i < this.length; i ++){
						imageList += '<li><a href="viewProduct.php?name='+
						 this[i]['productName']+'&id='+this[i]['product_id']+
						 '" ><img src="images/boutique/'+this[i]['pictureName']+
						 '" width="280" height="243"></a><div class="info"><span class="info-name">' + this[i]['productName'] +
						 '</span><span class="info-price">'+ this[i]['price']+'</span><a href="viewProduct.php?name='+
						 this[i]['productName']+'&id='+this[i]['product_id']+
						 '" class="info-details">View Details</a></div></li>';
						}
						}); 
					 imageList += "</ul>";
					 $("div.image-holder").append(imageList).hide().fadeIn();
				}
		})
});

/*<ul class="image-container">
 <li><img src="images/boutique/image1.png" width="280" height="243" ></li>
 <li><img src="images/boutique/image1.png" width="280" height="243" ></li>
 <li><img src="images/boutique/image1.png" width="280" height="243" ></li>
 </ul>*/