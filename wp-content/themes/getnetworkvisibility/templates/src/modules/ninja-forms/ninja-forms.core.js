
export const run = (opts) => {

    new NFModifier(opts);

}

class NFModifier{

    constructor(props) {


        _.defaults(props, {
            classesToMoveOnNFField      : null,
            countryListWrapFixSelector  : '.listcountry-wrap.list-wrap' // For some reason, the default country dropdown is missing a class and looks different
        });

        this.opts = props;

        this.moveClassesToNFField();
        this.fixCountry();

    }

    moveClassesToNFField(){
        if(this.opts.classesToMoveOnNFField){
            this.opts.classesToMoveOnNFField.forEach((className, idx) =>{
                $('nf-field').each(function(){
                    if($('.' + className, $(this)).length){
                        $(this).addClass(className);
                    }
                });
            });
        }
    }

    fixCountry(){
        if(this.opts.countryListWrapFixSelector){

            $(this.opts.countryListWrapFixSelector).addClass('list-select-wrap');

        }
    }


}



