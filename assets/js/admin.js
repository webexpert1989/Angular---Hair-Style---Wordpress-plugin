/**************************************************************
 *
 * javascript for admin page
 *
 **************************************************************/



/////////////
(function($){
    "use strict";
    
	$(document).ready(function(){
        
        // select image
        $("#hair-admin").on("click", "[data-upload]", function(e){
            e.preventDefault();

            var uploadBtn = $(this);

            var image = wp.media({ 
                title: uploadBtn.prev().val(),
                multiple: false // mutiple: true if you want to upload multiple files at once
            })
            .open().on("select", function(e){

                // This will return the selected image from the Media Uploader, the result is an object
                var uploaded_image = image.state().get("selection").first();

                // We convert uploaded_image to a JSON object to make accessing it easier
                // Output to the console uploaded_image
                var image_url = uploaded_image.toJSON().url;

                // Let's assign the url value to the input field
                uploadBtn.prev().val(image_url);

                if($(uploadBtn.attr("data-preview")).length){
                    var preview = $(uploadBtn.attr("data-preview")).children("img").length? $(uploadBtn.attr("data-preview")).children("img"): $("<img>").appendTo(uploadBtn.attr("data-preview"));
                    preview.attr({src: image_url});
                }			
            });
        });
        
        /////////////////////////////
        // add new color group
        $("#hair-admin #add-new-group").click(function(){
            $(this).before($("#new-group-tpl").html());
            changedGroup();
            return false;
        });
        
        // add new color group
        $("#hair-admin #main-group").on("click", "a.remove-group", function(){
            if(confirm("Really?")){
                $(this).parents(".fieldset").remove();
            }
            return false;
        });
        
        ///////////////////////////////
        // add main group
        $("#hair-admin #main-group").on("click", "a.group-add", function(){
            var validation = true;
            var d = new Array;
            
            $(this).parents("tfoot").find("input[type=text]").each(function(){
                if($.trim($(this).val())){
                    d[$(this).data("field-add")] = $.trim($(this).val());
                } else if(validation){
                    alert("Please enter " + $(this).attr("placeholder") + " correctly.");
                    $(this).focus();
                    validation = false;
                }
            });
            
            if(validation){
                // add new row
                var tpl = "<tr>" + $("#maingroup-row-tpl").html() + "</tr>";
                for(var k in d){
                    var regex = new RegExp("{{" + k + "}}", "g");
                    tpl = tpl.replace(regex, d[k]);
                }
                $(this).parents("table").children("tbody").append(tpl);
                
                $(this).parents("tfoot").find("input[type=text]").val("");
            }
            
            changedGroup();
            return false;
        });
        
        // remove color
        $("#hair-admin #main-group").on("click", "a.group-del", function(){
            var id = $(this).parents("tr").find("[data-field=\"id\"]").text();
            
            $("#hair-admin #color-group").find("[data-field=\"group-main\"]").each(function(){
                if($(this).val() == id){
                    id = "";
                }
            });
            
            if(id == ""){
                alert("You must reselect Parent Main Group fields in Colors before remove this main group.");
            } else {
                if(confirm("Really?")){
                    $(this).parents("tr").remove();

                    changedGroup();
                }
            }
            
            return false;
        });
        
        // enable edit color
        $("#hair-admin #main-group").on("click", "a.group-edit", function(){
            var d = new Array,
                tr = $(this).parents("tr");
            
            tr.find("[data-field]").each(function(){
                d[$(this).data("field")] = $(this).text();
            });
            
            var tpl = $("#maingroup-edit-tpl").html();
            for(var k in d){
                var regex = new RegExp("{{" + k + "}}", "g");
                tpl = tpl.replace(regex, d[k]);
            }
            tr.html(tpl);

            return false;
        });
        
        // save updated a color
        $("#hair-admin #main-group").on("click", "a.group-save", function(){
            var d = new Array,
                validation = true,
                tr = $(this).parents("tr");
            
            tr.find("[data-field]").each(function(){
                if($.trim($(this).val())){
                    d[$(this).data("field")] = $.trim($(this).val());
                } else if(validation){
                    alert("Please enter " + $(this).attr("placeholder") + " correctly.");
                    $(this).focus();
                    validation = false;
                }
            });
            
            if(validation){
                // add new row
                var tpl = $("#maingroup-row-tpl").html();
                for(var k in d){
                    var regex = new RegExp("{{" + k + "}}", "g");
                    tpl = tpl.replace(regex, d[k]);
                }
                tr.html(tpl);
            }
                        
            changedGroup();
            return false;
        });
        
        // change group info in colors
        var changedGroup = function(){
            var mg = new Array;
            
            $("#main-group tbody").find("tr").each(function(){
                mg.push({
                    id: $(this).find("[data-field=\"id\"]").text(),
                    name: $(this).find("[data-field=\"name\"]").text()
                });
            });
            
            // reset select box
            $("#hair-admin #color-group").find("[data-field=\"group-main\"]").each(function(){
                var v = $(this).val();
                var htmlOptions = "<option value=\"\">" + $(this).attr("placeholder") + "</option>";
                
                for(var i in mg){
                    htmlOptions += "<option value=\"" + mg[i].id + "\">" + mg[i].name + "</option>";
                }
                
                $(this).html(htmlOptions).val(v);
            });
        };
                
        //////////////////////////////////////
        // add color
        $("#hair-admin #color-group").on("click", "a.color-add", function(){
            var validation = true;
            var d = new Array;
            
            $(this).parents("tfoot").find("input[type=text]").each(function(){
                if($.trim($(this).val())){
                    d[$(this).data("field-add")] = $.trim($(this).val());
                } else if(validation){
                    alert("Please enter " + $(this).attr("placeholder") + " correctly.");
                    $(this).focus();
                    validation = false;
                }
            });
            
            if(validation){
                // add new row
                var tpl = "<tr>" + $("#color-row-tpl").html() + "</tr>";
                for(var k in d){
                    var regex = new RegExp("{{" + k + "}}", "g");
                    tpl = tpl.replace(regex, d[k]);
                }
                $(this).parents("table").children("tbody").append(tpl);
                
                $(this).parents("tfoot").find("input[type=text]").val("");
            } 
            
            return false;
        });
        
        // remove color
        $("#hair-admin #color-group").on("click", "a.color-del", function(){
            if(confirm("Really?")){
                $(this).parents("tr").remove();
            }
            
            return false;
        });
        
        // enable edit color
        $("#hair-admin #color-group").on("click", "a.color-edit", function(){
            var d = new Array,
                tr = $(this).parents("tr");
            
            tr.find("[data-field]").each(function(){
                d[$(this).data("field")] = $(this).text();
            });
            
            var tpl = $("#color-edit-tpl").html();
            for(var k in d){
                var regex = new RegExp("{{" + k + "}}", "g");
                tpl = tpl.replace(regex, d[k]);
            }
            tr.html(tpl);
            
            return false;
        });
        
        // save updated a color
        $("#hair-admin #color-group").on("click", "a.color-save", function(){
            var d = new Array,
                validation = true,
                tr = $(this).parents("tr");
            
            tr.find("[data-field]").each(function(){
                if($.trim($(this).val())){
                    d[$(this).data("field")] = $.trim($(this).val());
                } else if(validation){
                    alert("Please enter " + $(this).attr("placeholder") + " correctly.");
                    $(this).focus();
                    validation = false;
                }
            });
            
            if(validation){
                // add new row
                var tpl = $("#color-row-tpl").html();
                for(var k in d){
                    var regex = new RegExp("{{" + k + "}}", "g");
                    tpl = tpl.replace(regex, d[k]);
                }
                tr.html(tpl);
            }
            
            return false;
        });
        
        ////////
        // save hair
        $("#hair-save").click(function(){
            
            // hair name
            if(!$("#hair-name").val()){
                alert("Please enter Hair App Name correctly.");
                $("#hair-name").focus();
                return false;
            }
            
            // hair image
            if(!$("#hair-img").val()){
                alert("Please enter Hair Image correctly.");
                $("#hair-img").focus();
                return false;
            }
            
            // check color edit
            if($("#hair-admin").find("a.color-save").length){
                alert("Please complete Color Edit correctly.");
                return false;
            }
                        
            // take main group
            var main = [];
            
            $("#main-group tbody").find("tr").each(function(){
                main.push({
                    id: $(this).find("[data-field=\"id\"]").text(),
                    name: $(this).find("[data-field=\"name\"]").text()
                })
            });
                        
            // take colors
            var id_count = 1;
            var colors = [];
            var validation = true;
            
            $("#color-group").find(".fieldset").each(function(){
                var elem = $(this).find("tbody").find("tr");
                if(elem.length){
                    
                    var mainGroup = $(this).find("[data-field=\"group-main\"]").val();
                    var groupName = $(this).find("[data-field=\"group-name\"]").val();
                    if(groupName && mainGroup){
                    
                        colors.push({
                            main: mainGroup,
                            group: groupName,
                            items: []
                        });
                        
                        elem.each(function(){
                            colors[colors.length - 1].items.push({
                                id: id_count
                            });
                            id_count++;
                            
                            $(this).find("[data-field]").each(function(){
                                colors[colors.length - 1].items[colors[colors.length - 1].items.length - 1][$(this).data("field")] = $(this).text();
                            });
                        });
                        
                    } else {
                        // if group name field is empty
                        alert("Please enter Color Info correctly.");
                        validation = false;
                        return false;
                    }
                } else {
                    return false;
                }
            });
            
            if(!validation){
                return false;
            }
            
            // save hair info
            if($(this).data("id")){
                // update hair
                
                var loadingbar = $("<div></div").appendTo("body").addClass("preloader").fadeIn(300); // create preloader
                $.post(
                    global_var.ajaxurl, 
                    {
                        action:			"hair_edit",
                        the_issue_key:	global_var.the_issue_key,
                        
                        id: $(this).data("id"),
                        name: $("#hair-name").val(),
                        img: $("#hair-img").val(),
                        top: $("#hair-top").val(),
                        mainGroup: JSON.stringify(main),
                        colors: JSON.stringify(colors)
                    }, 
                    function(response){
                        // remove preloader
                        loadingbar.fadeOut(300, function(){
                            loadingbar.remove();
                        });

                        /////////////
                        response = $.parseJSON(response);

                        // success
                        if(response.success){
                            alert(response.success_txt);
                        } else {
                            // error
                            if(response.error){						
                                alert(response.error_txt);
                            } else {
                                alert("AJAX ERROR!");
                            }
                        }
                    }
                );
                
            } else {
                // save new hair
                
                var loadingbar = $("<div></div").appendTo("body").addClass("preloader").fadeIn(300); // create preloader
                $.post(
                    global_var.ajaxurl, 
                    {
                        action:			"hair_new",
                        the_issue_key:	global_var.the_issue_key,
                        
                        name: $("#hair-name").val(),
                        img: $("#hair-img").val(),
                        top: $("#hair-top").val(),
                        mainGroup: JSON.stringify(main),
                        colors: JSON.stringify(colors)
                    }, 
                    function(response){
                        // remove preloader
                        loadingbar.fadeOut(300, function(){
                            loadingbar.remove();
                        });

                        /////////////
                        response = $.parseJSON(response);

                        // success
                        if(response.success){
                            alert(response.success_txt);
                        } else {
                            // error
                            if(response.error){						
                                alert(response.error_txt);
                            } else {
                                alert("AJAX ERROR!");
                            }
                        }
                    }
                );
                
            }
            
            return false;
        });
        ///////////////

	});
    
})(jQuery);

        
// remove hair in list
var removeHair = function(msg, id, reload){
    (function($){
        if(id > 0){
            if(confirm(msg)){
                // ajax 
                var loadingbar = $("<div></div").appendTo("body").addClass("preloader").fadeIn(300); // create preloader
                
                $.post(
                    global_var.ajaxurl, 
                    {
                        action:			"hair_del",
                        the_issue_key:	global_var.the_issue_key,

                        id: id
                    }, 
                    function(response){
                        // remove preloader
                        loadingbar.fadeOut(300, function(){
                            loadingbar.remove();
                        });

                        /////////////
                        response = $.parseJSON(response);

                        // success
                        if(response.success){
                            alert(response.success_txt);
                            
                            if($("#hair-list-page").length){
                                location.href = $("#hair-list-page").attr("href");
                            } else {
                                location.reload();
                            }
                            
                        } else {
                            // error
                            if(response.error){						
                                alert(response.error_txt);
                            } else {
                                alert("AJAX ERROR!");
                            }
                        }
                    }
                );
            }
        } else {
            alert("Sorry, couldn't find Hair info.");
        }

    })(jQuery);

    return false;
};