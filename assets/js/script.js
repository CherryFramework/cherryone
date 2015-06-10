jQuery(document).ready(function(){
    
    var searchHolder = jQuery('#header .search-form');
	var searchButton = jQuery('input[type="submit"]', searchHolder);
	var searchInput = jQuery('input[type="search"]', searchHolder);
	var timeoutId;

	searchButton.hover(
		function(){
			over();
		}
		,function(){
            out();
		}
	)
    searchInput.hover(
		function(){
			over();
		}
		,function(){
            out();
		}
	)
    
    function over(){
		searchInput.css({display:'block'}).stop().animate({
	        width: "200px",
	    }, 200 );
	    clearTimeout(timeoutId);
    }
    function out(){
		timeoutId = setTimeout(function(){
			searchInput.stop().animate({
		        width: "0px"
		    }, 200, function(){
		      searchInput.css({display:'none'});
		    } )
		},700);
    }
})