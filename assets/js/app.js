/**************************************************************
 *
 * javascript for app
 *
 **************************************************************/

"use strict";

if(typeof(hairApp) != "undefined"){
angular.module(hairApp, ["slickCarousel"])
    .controller(hairController, function($scope, $timeout){

        // import hair data
        $scope.hairImg = hairImg;
        $scope.colors = colors;
        $scope.groups = new Array;
        for(var i in mainGroup){
            var c = [];
            for(var j in colors){
                if(mainGroup[i].id == colors[j].main){
                    c.push(colors[j]);
                }
            }
            
            $scope.groups.push({
                id: mainGroup[i].id,
                name: mainGroup[i].name,
                colors: c
            });
        }

        
        // select default group
        if($scope.groups.length){
            $scope.selColor = $scope.groups[0].colors[0];
        } else {
            $scope.selColor = {};
        }
        
        // callback to select color group 
        $scope.colorSel = function(sel){
            $scope.selColor = sel;
        };
    
        $scope.colorGroupSel = function(g){
            if(g.colors.length == 1){
                $scope.colorSel(g.colors[0]);
            } 
        };
    
        // select default hair image
        $scope.selHair = $scope.colors[0].items[0]; 
        
        // callback to select hair 
        $scope.hairSel = function(sel){console.log(sel);
            $scope.selHair = sel;
        };
    
        /////////////////////////
    })

    .directive("hairWrap", ["$window", "$timeout", function($window, $timeout){
        return {
            restrict: "A",
            scope: {
                appID: "=hairWrap"
            },
            link: function(scope, element, attrs){

                scope.onResize = function(){
                    
                    if($window.innerWidth > 768){
                        
                        var wrap = jQuery(element).parent().parent();
                        
                        /*var w = !wrap.is("body") && wrap.width() < $window.innerWidth? wrap.width(): $window.innerWidth,
                            h = !wrap.is("body") && wrap.height() < $window.innerHeight? wrap.height() - headerHeight: $window.innerHeight - headerHeight;*/
                        /*var w = $window.innerWidth,
                            h = $window.innerHeight - headerHeight;
                        
                        var ratioW = w < hairAppSize.width? w / hairAppSize.width: 1,
                            ratioH = h < hairAppSize.height? h / hairAppSize.height: 1;
                                                
                        var scale = (ratioW < ratioH? ratioW: ratioH);*/
                        
                        /*jQuery(element)
                            .css({transform: "scale(" + scale + ")"})
                            .parent().css({
                                width: hairAppSize.width * scale + "px",
                                height: hairAppSize.height * scale + "px",
                            });*/
                        
                        jQuery(element).css({
                            height: ($window.innerHeight - headerHeight) + "px",
                            "max-height": parseInt(jQuery(element).width() * 0.75) + "px"
                        });
                        
                        jQuery("a.hair-buy-btn").remove();
                        
                    } else {
                       /* jQuery(element)
                            .css({transform: "scale(1)"})
                            .parent().css({
                                width: "100%",
                                height: "auto",
                            });*/
                        jQuery(element).css({
                            height: "auto",
                            "max-height": "none"
                        });
                    }
                    
                    return;
                };
                
                $timeout(function(){
                    scope.onResize();
                });

                angular.element($window).bind("resize", function(){
                    scope.onResize();
                });
            }
        }
    }])
    
    .directive("hairMaingroup", ["$window", "$timeout", function($window, $timeout){        
        return {
            restrict: "A",
            scope: {
                hairMainGroupID: "=hairMaingroup"
            },
            link: function(scope, element, attrs){

                scope.onResize = function(){
                    if(!jQuery(element).hasClass("slick-initialized")){
                        jQuery(element).slick({
                            centerMode: true,
                            centerPadding: "60px",
                            slidesToShow: 3,
                            responsive: [
                                {
                                    breakpoint: 420,
                                    settings: {
                                        arrows: false,
                                        centerMode: true,
                                        centerPadding: "40px",
                                        slidesToShow: 1
                                    }
                                },
                                {
                                    breakpoint: 640,
                                    settings: {
                                        arrows: false,
                                        centerMode: true,
                                        centerPadding: "60px",
                                        slidesToShow: 1
                                    }
                                },
                                {
                                    breakpoint: 769,
                                    settings: {
                                        arrows: false,
                                        centerMode: true,
                                        centerPadding: "60px",
                                        slidesToShow: 3
                                    }
                                },
                                {
                                    breakpoint: 9999999,
                                    settings: "unslick"
                                }
                            ]
                        });
                    }
                    
                    jQuery(element).find(".slick-slide").click(function(){
                        if(jQuery(window).width() > 768){
                            jQuery(this).children("ul").removeClass("active");
                        } else {
                            jQuery(this).children("ul").toggleClass("active");
                        }                        
                    });
                };
                
                $timeout(function(){
                    scope.onResize();
                    
                    jQuery(document).mouseup(function(e){
                        var container = jQuery(element).find("li");

                        if (!container.is(e.target) && container.has(e.target).length === 0){
                            container.find("ul").removeClass("active");
                        }
                    });
                    
                    jQuery(element).find("li ul li").click(function(){
                        jQuery(this).parent("ul").addClass("active");
                    });
                });

                angular.element($window).bind("resize", function(){
                    scope.onResize();
                    
                    if(jQuery(window).width() > 768){
                        jQuery(element).children("ul").removeClass("active");
                    }
                });
                
            }
        }
    }])
    
    .directive("hairGroup", ["$window", "$timeout", function($window, $timeout){        
        return {
            restrict: "A",
            scope: {
                hairGroupID: "=hairGroup"
            },
            link: function(scope, element, attrs){

                scope.onResize = function(){
                    if(!jQuery(element).hasClass("slick-initialized")){
                        jQuery(element).slick({
                            centerMode: true,
                            centerPadding: "60px",
                            slidesToShow: 3,
                            responsive: [
                                {
                                    breakpoint: 420,
                                    settings: {
                                        arrows: false,
                                        centerMode: true,
                                        centerPadding: "80px",
                                        slidesToShow: 1
                                    }
                                },
                                {
                                    breakpoint: 640,
                                    settings: {
                                        arrows: false,
                                        centerMode: true,
                                        centerPadding: "40px",
                                        slidesToShow: 3
                                    }
                                },
                                {
                                    breakpoint: 769,
                                    settings: {
                                        arrows: false,
                                        centerMode: true,
                                        centerPadding: "40px",
                                        slidesToShow: 3
                                    }
                                },
                                {
                                    breakpoint: 9999999,
                                    settings: "unslick"
                                }
                            ]
                        });
                    }
                };
                
                $timeout(function(){
                    scope.onResize();
                });

                angular.element($window).bind("resize", function(){
                    scope.onResize();
                });
            }
        }
    }])
    
    .directive("hairColor", ["$window", "$timeout", function($window, $timeout){
        const DblClickInterval = 300; //milliseconds
        var firstClickTime;
        var waitingSecondClick = false;

        return {
            restrict: "A",
            scope: {
                hairColorID: "=hairColor"
            },
            link: function(scope, element, attrs){   
                
                element.bind("click", function(e){
                    // apply on mobile only
                    if($window.innerWidth < 768){
                        
                        // remove "COMPRA" button
                        jQuery("[hair-color]").removeClass("active-shop").children("a.hair-buy-btn").remove();
                        
                        if(!waitingSecondClick){
                            firstClickTime = (new Date()).getTime();
                            waitingSecondClick = true;

                            setTimeout(function () {
                                waitingSecondClick = false;
                            }, DblClickInterval);
                        } else {
                            waitingSecondClick = false;

                            var time = (new Date()).getTime();
                            if (time - firstClickTime < DblClickInterval) {

                                // get double touch/click
                                if(jQuery(this).hasClass("active") && jQuery(this).data("shop")){
                                    jQuery(this).addClass("active-shop").append("<a href=\"" + jQuery(this).data("shop") + "\" target=\"_blank\" class=\"hair-buy-btn\">COMPRA</a>");
                                }
                            }
                        }
                    }
                });
                
                return;
            }
        }
    }]);
    
    (function($){
    	var src = [];
    	var mobileLogo = "/wp-content/uploads/2016/10/logo-sanotint-brown-shadow-1.png";
    	
    	// get default logo image src
    	$("#logo a img").each(function(i){
    	    src[i] = $(this).attr("src");
    	});
        
        var changeLogo = function(){
           if($(window).width() > 768){
              $("#logo a img").each(function(i){
    	          $(this).attr("src", src[i]);
              });
           } else {
              $("#logo a img").each(function(i){
    	          $(this).attr("src", mobileLogo);
              });
           }
        };
        changeLogo();
        
        $(window).resize(function(){
            changeLogo();
        });
        
    })(jQuery);
}
