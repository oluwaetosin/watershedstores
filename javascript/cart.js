// JavaScript Document
$(document).ready(function(e) {
 $('#cart').hide().slideDown();
 $('table tr').hover(function(){
	 $(this).css('background-color','rgba(204,204,0,0.5)');
	 },function(){
	 $(this).css('background-color','rgba(255,255,255,1)');
		 })
});

/*<ul class="image-container">
 <li><img src="images/boutique/image1.png" width="280" height="243" ></li>
 <li><img src="images/boutique/image1.png" width="280" height="243" ></li>
 <li><img src="images/boutique/image1.png" width="280" height="243" ></li>
 </ul>*/