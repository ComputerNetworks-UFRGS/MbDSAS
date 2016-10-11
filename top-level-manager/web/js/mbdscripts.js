/**
** Code for multiselectable items table
**
** @url http://www.jqueryscript.net/table/jQuery-Plugin-To-Select-Multiple-Rows-In-A-Table-multiselect.html
**/

$(function () {
	var scripts = [];
	var mlms = [];

    $('#table1, #table2').multiSelect({
        actcls: 'success',
        selector: 'tbody tr',
        except: ['tbody'],
        statics: ['.danger', '[data-no="1"]'],
    });

    $("#script-next-btn").click(function(){
    	$("#first-step").hide();
    	$("#second-step").show();

        scripts = [];

    	$("#table1 tr.success").each(function(index){
            scripts.push($(this).attr("value"));
        });
    });

    $("#script-back-btn").click(function(event){
    	$("#first-step").show();
    	$("#second-step").hide();

        $("#table1 tr").each(function(index){
            for(i in scripts){
                if($(this).attr("value") == scripts[i]){
                    $(this).addClass("success");
                }
            }
        });

        event.stopPropagation();
    });


    $("#script-execute-btn").click(function(){
        mlms = $("#table2 tr.success").attr("value");


    });
/*
    $.ajax({
        type:'post',
            data: pars,
            dataType: 'html',
            async: false,
            url: Network.url,
            success: function(data){
                if(data != ""){
                    data = JSON.parse(data);
                    var mainDiv = $(data.div);
                    var i;

                    for(i = 0; i < data.itens.length; i++){
                        var item = data.itens[i];
                        var itemDiv = $("<div>")
                        .addClass("network-option");
                        
                        (function(item){
                            link = $("<a>")
                            .html(item.ssid)
                            .attr("href", "#")
                            .click(function(){
                                Network.changeToLocalNetwork(item);
                            });
                        }(item));
                        
                        itemDiv.html(link);
                        mainDiv.append(itemDiv);
                    }
                    $("#local-networks").html(mainDiv);
                    
                }else{
                    Cards.remove(kLocalk);
                }
            },
        error: function(error){
                alert(error.responseText);
            }
    });*/

})
