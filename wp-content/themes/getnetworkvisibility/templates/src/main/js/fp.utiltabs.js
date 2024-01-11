document.addEventListener('userIsInteracting', function (e) {

    new UtilTabs();
    
    function UtilTabs(){
        this.isOpen = false;

        this.openTabs = function(){
            TweenLite.to($('.util-right'), .25, { css : {'right' : 0}, ease : Power2.easeOut});
            this.isOpen = true;
        }

        this.closeTabs = function(){
            TweenLite.to($('.util-right'), .25, { css : {'right' : -50}, ease : Power2.easeOut});
            this.isOpen = false;
        }

        this.bind = function(){
            var self = this;

            $('.util-right .share-button').click(function(e){
                if(self.isOpen){
                    self.closeTabs();
                }else{
                    self.openTabs();
                }

                return false;
            });
        }

        this.init = function(){

            this.bind();

        }

        this.init();

    }

}, false);
