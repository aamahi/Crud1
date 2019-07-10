
document.addEventListener('DOMContentLoaded',function(){
    console.log('loader');
    var links = document.querySelectorAll(".delete");
    for (i=0; i<links.length; i++) {
    	links[i].addEventListener('click',function(e){
    		if (!confirm("Are Your Sure")) {
    			e.preventDefault();
    		}
    	});
    }
});