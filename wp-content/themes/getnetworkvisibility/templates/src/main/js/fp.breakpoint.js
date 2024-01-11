export function getBreakpoint() {
    var style = null;
    if ( window.getComputedStyle && window.getComputedStyle(document.body, '::before') ) {
        style = window.getComputedStyle(document.body, '::before');
        style = style.content;
    } else {
        window.getComputedStyle = function(el) {
            this.el = el;
            this.getPropertyValue = function(prop) {
                var re = /(\-([a-z]){1})/g;
                if (re.test(prop)) {
                    prop = prop.replace(re, function () {
                        return arguments[2].toUpperCase();
                    });
                }
                return el.currentStyle[prop] ? el.currentStyle[prop] : null;
            };
            return this;
        };
        style = window.getComputedStyle(document.getElementsByTagName('head')[0]);
        style = style.getPropertyValue('font-family');
    }
    return JSON.parse( removeQuotes(style) );
}

function removeQuotes(string) {
    if (typeof string === 'string' || string instanceof String) {
        string = string.replace(/^['"]+|\s+|\\|(;\s?})+|['"]$/g, '');
    }
    return string;
}

export function isSmall(){
	var b = getBreakpoint();
	if(b.current && b.current == 'small'){
		return true;
	}else{
		return false;
	}
}

export function calcHeaderHeight() {
    let $wpadminbar = $('#wpadminbar');
    let $header = $('.site-header');
    let $anchors = $('.anchors');
    let $total = 0;

    if($wpadminbar.length > 0) {
        $total += $wpadminbar.outerHeight();
    }

    if($header.length > 0) {
        $total += $header.outerHeight();
    }

    if($anchors.length > 0) {
        $total += $anchors.outerHeight();
    }

    return $total;
}