jQuery(document).ready(function(){
    
    var searchHolder = jQuery('#header .search-form');
	var searchButton = jQuery('input[type="submit"]', searchHolder);
	var searchInput = jQuery('input[type="search"]', searchHolder);
    var focusIn = false;
    var searchOpen = false;
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
    
    searchInput.focus(focusInFn);
    searchInput.focusout(focusOutFn);
    
    searchButton.click(function(){
        if(!searchOpen) {
            return false;
        }
    })
    
    function over(){
		searchInput.css({display:'block'}).stop().animate({
	        width: "200px",
	    }, 200, function(){ searchOpen = true;} );
	    clearTimeout(timeoutId);
        
        searchHolder.addClass('search-open');
    }
    function out(){
        if(!focusIn){
    		timeoutId = setTimeout(function(){
    			searchInput.stop().animate({
    		        width: "0px"
    		    }, 200, function(){
    		      searchInput.css({display:'none'});
                  searchHolder.removeClass('search-open');
                  searchOpen = false;
    		    } )
    		},700);
        }
    }
    function focusInFn(){
        focusIn = true;
    }
    function focusOutFn(){
        focusIn = false;
        out();
    }
})