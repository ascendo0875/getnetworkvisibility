import { getBreakpoint } from "./fp.breakpoint";

/*

Moves one element based on SCSS breakpoints. 

1. Add data-reposition-element property
2. Add rules: 	data-reposition-element-[BREAKPOINT]-[OPERATION]="[jQUERY-SELECTOR]"
 - BREAKPOINT   		: defined in CSS
 - OPERATION    		: 'appendTo', 'prependTo', 'insertBefore', 'insertAfter'
 - jQUERY-SELECTOR 		: ... :)

Example:
<div class="home-blurb">
</div>

<div class="video-container">
	<div 
			class="video-home" 
			data-reposition-element 
			data-reposition-element-small-prependTo=".home-blurb" 
			data-reposition-element-large-prependTo=".video-container"
		>
			<a href="#"><img src="images/video.png" width="502" height="282" alt="" /><div class="arrow-right">&nbsp;</div></a>
	</div>
</div>

*/

$(window).ready(function(){
	new RepositionElements();
})

function RepositionElements(){
    const selfRE  			    = this;
    this.operations				= ['appendTo', 'prependTo', 'insertBefore', 'insertAfter'];

    this.apply = function(){
		$('[data-reposition-element]').each(function(index, item){
	        var breakpoint = getBreakpoint();
	        breakpoint	   = breakpoint.current;
	        for(var i = 0; i < selfRE.operations.length; i++){
        		var v = $(item).data('reposition-element-' + breakpoint + '-' + selfRE.operations[i].toLowerCase());
        		if(v){
					eval('$(item).' + selfRE.operations[i] + '($(v));');
        		}
	        }
		});
    }
    
	this.init = function(){
        
		$(window).resize(function(){
			selfRE.apply();
		});
		
		$(window).ready(function(){
			selfRE.apply();
		})
	}

    this.init();
}