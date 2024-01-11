document.addEventListener('userIsInteracting', function (e) {

    gaProcessLinks();
	
    function gaProcessLinks(){
        $('a').each(function(index) {
            var href = $(this).attr("href");
            if(typeof(href) != "undefined"){
                if (!$(this).hasClass("ga-processed") && (ga_isExternalUrl(href) || ga_isDocument(href) || ga_isEmail(href) || $(this).hasClass("track-me")) ){
                    if(
                        (ga_isExternalUrl(href))
                        ||
                        (ga_isDocument(href) || ga_isEmail(href) || $(this).hasClass("track-me"))){
                            $(this).attr("target", "_blank");
                            $(this).addClass("ga-processed");
                    }

                }
            }
        });
    }

    function ga_isExternalUrl(href){
        return (href.indexOf("http") != -1 && href.indexOf(window.location.hostname) == -1) ;

    }

    function ga_isDocument(href){
        var track_files = new Array('.pdf', '.doc', '.xls', '.xlsx', '.PDF', '.DOC', '.XLS', '.XLSX');
        for(var f = 0; f < track_files.length; f++){
            if(href.indexOf(track_files[f]) == (href.length - track_files[f].length) && ((href.length - track_files[f].length) != -1)){
                return true;
            }
        }

        return false;
    }

    function ga_isEmail(href){
        href = href.toLowerCase();
        if(href.indexOf('mailto:') != -1){
            return true;
        }else{
            return false;
        }
    }

}, false);

