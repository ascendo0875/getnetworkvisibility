document.addEventListener('userIsInteracting', function (e) {

    const slidersDefinitions = [
       
        {
            selector : '.side-articles',
            configs  : {
                autoplay: false,
                dots: false,
                arrows: false,
                infinite: false,
                speed: 400,
                slidesToShow: 1.5, 
                slidesToScroll: 1.5, 
                swipeToSlide: true,
                mobileFirst: true,
                adaptiveHeight: true,          
                responsive: [
                    {
                        breakpoint: 1024,
                        settings: 'unslick'
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 3.5,   
                            slidesToScroll: 3 
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 2.5, 
                            slidesToScroll: 3    
                        }
                    }
                ]
            },
            
        },
        
        {
            
         selector : '.featured-items.is-slider',
            configs  : {
                autoplay: false,
                dots: false,
                arrows: true,
                infinite: false,
                speed: 400,
                slidesToShow: 4,
                slidesToScroll: 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1000,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,    
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,    
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,    
                        }
                    }
                ]
            }       
            
        },

        {

         selector : '.carousel-items.is-slider',
            configs  : {
                autoplay: false,
                dots: false,
                arrows: true,
                infinite: false,
                speed: 400,
                slidesToShow: 4,
                slidesToScroll: 4,
                adaptiveHeight: true,
                responsive: [
                    {
                        breakpoint: 1000,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,    
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2,
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1,
                        }
                    }
                ]
            }

        },
        
        {
            selector : '.topics-slider',
            configs  : {
                autoplay: false,
                dots: false,
                arrows: true,
                infinite: false,
                speed: 400,
                slidesToShow: 2,
                slidesToScroll: 2,
                mobileFirst: true,
                adaptiveHeight: true,
                exclude: 'break',
                responsive: [
                    {
                        breakpoint: 800,
                        settings: 'unslick'
                    },
                    {
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 4, 
                            slidesToScroll: 4   
                        }
                    },
                    {
                        breakpoint: 450,
                        settings: {
                            slidesToShow: 3, 
                            slidesToScroll: 3      
                        }
                    } 
                ]
            },
            
        }


    ];

    const slidersOnPage = slidersDefinitions.filter((a) => {
       return $(a.selector).length;
    });

    if(slidersOnPage.length){
        import(/* webpackChunkName: "slick-sliders" */'./slick-sliders.core').then(
            (module) => module.run(slidersOnPage)
        );
    }


}, false);
