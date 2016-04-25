//Orignally setttings
var OrignalImgUrl = '';
jQuery(document).ready(function() {
    hideSelects();
    var img = jQuery('.product-image').children('img');
    OrignalImgUrl = img.attr('src');
    //select change event
    isExistInAllParents();
    jQuery('.required-entry').change(function() {
        $selectLength = jQuery('.required-entry').length;
        $currentSelectIndex = jQuery('.required-entry').index(jQuery(this));
        for ($i = $currentSelectIndex; $i < $selectLength - 1; $i++) {
            $nextSelect = jQuery('.required-entry').eq($i + 1);
            $nextSelect.empty();
            $nextSelect.append('<option value="">Choose an Option...</option>');
            $nextSelect.prop("disabled", "disabled");
        }
        getOptionLabels(jQuery(this));
        $attrId = parseInt((jQuery(this).prop("id").replace(/[^\d.]/g, '')));
        setCorrectLabels($attrId);
    });
    //on color boxes event
    jQuery("body").on('click', '.colors', function() {
        jQuery(".colors").each(function() {
            jQuery(this).css("box-shadow", "0px 0px 0px white");
        });
        jQuery(this).css("box-shadow", "1px 3px 4px blue");
        jQuery(this).parent().parent().find('select').val(jQuery(this).prop("id"));
        jQuery(this).parent().parent().find('select').change();
        var bg = jQuery(this).css('background-image');
        bg = bg.replace('url(', '').replace(')', '').replace('"', '').replace('"', '');
        OrignalImgUrl = bg;
    });

    //on size boxes event

    jQuery("body").on('click', '.sizes', function() {
        jQuery(".sizes").each(function() {
            jQuery(this).css("box-shadow", "0px 0px 0px white");
        });
        jQuery(this).css("box-shadow", "1px 3px 4px blue");
        jQuery(this).parent().parent().find('select').val(jQuery(this).prop("id"));
        jQuery(this).parent().parent().find('select').change();
    });

    setCorrectLabels(0);

});

//Set the futher select tags options

function getOptionLabels($mthis) {
    $products = [];
    $optVal = $mthis.val();
    $attrId = parseInt(($mthis.prop("id").replace(/[^\d.]/g, '')));
    $data = JSON.parse(getAllData());
    $options = $data.attributes[$attrId].options;
    $options.forEach(function(cObj) {
        if (cObj.id == $optVal) {
            cObj.products.forEach(function(cPro) {
                $selectIndex = jQuery('.required-entry').index($mthis);
                
                if($selectIndex > 0){
                    $prevSelect = jQuery('.required-entry').eq($selectIndex - 1);
                    $prevSelectAttrId = parseInt(($prevSelect.prop("id").replace(/[^\d.]/g, '')));
                    //alert($prevSelect.val());
                    $prevSelectOptions = $data.attributes[$prevSelectAttrId].options;
                    $prevSelectOptions.forEach(function (subObj){
                        //console.log(subObj);
                        if(subObj.id==$prevSelect.val()) {
                            
                            if(subObj.products.indexOf(cPro) !=(-1)){
                                $products.push(cPro);
                            }
                        }
                    });
                    console.log($prevSelectOptions);
                }
                else{
                    $products.push(cPro);
                }
            });
        }
    });
    $selectIndex = jQuery('.required-entry').index($mthis);
    $nextSelect = jQuery('.required-entry').eq($selectIndex + 1);
    $nextSelectAttrId = parseInt(($nextSelect.prop("id").replace(/[^\d.]/g, '')));
    $nextSelectOptions = $data.attributes[$nextSelectAttrId].options;
    $nextSelect.empty();
    $nextSelect.append('<option value="">Choose an Option...</option>');
    $nextSelect.removeAttr('disabled');
    $nextSelectOptions.forEach(function($cObj) {
        $cObj.products.forEach(function($cPro) {
            if ($products.indexOf($cPro) != (-1)) {
                //console.log($products);
                if (jQuery('option[value=' + $cObj.id + ']').length <= 0) {
                    $nextSelect.append('<option value="' + $cObj.id + '">' + $cObj.label + '</option>');
                }
            }

        });

    });
}

//function for orrignally settings

function setCorrectLabels($cSelectId) {
    jQuery('select').each(function() {
        $attrId = parseInt((jQuery(this).prop("id").replace(/[^\d.]/g, '')));
        $data = JSON.parse(getAllData());
        $code = $data.attributes[$attrId].code;
        //if ($code == 'color' || $code == 'size') {
        if (!jQuery(this).is(":visible")) {
            jQuery(this).hide();
            $cSelect = jQuery(this);
            $options = $data.attributes[$attrId].options;
            //if ($code == 'color' && $cSelectId != $attrId) {
            jQuery('#' + $attrId).remove();
            $cSelect.parent().append('<div id="' + $attrId + '"></div>');
            $options.forEach(function($cObj) {

                if (jQuery('option[value=' + $cObj.id + ']').length > 0) {
                    //alert('got');
                    jQuery('#' + $attrId).append('<div id="' + $cObj.id + '" class="colors" style="background-color:' + $cObj.label + '; height: 50px; width: 50px; float: left; left: 5px; margin-right: 5px; border: solid 1px black; background-image:url(' + getBaseDir() + 'colorswatch/' + $attrId + '/' + $cObj.id + '/img); background-repeat: no-repeat;background-size:100%;"></div>');
                }
                else {
                    jQuery('#' + $attrId).append('<div style="background-color:white; height: 25px; float: left; left: 5px; margin-right: 5px; border: solid 1px #B3B3BB; padding:0px 5px 0px 5px;"><span style="color:#B3B3BB;">' + $cObj.label + '</span></div>');
                }
            });
            jQuery('#' + $attrId).append("<br><br><br>");
            //}
            /* if ($code == 'size' && $cSelectId != $attrId) {
             jQuery('#size_container').remove();
             
             $cSelect.parent().append('<div id="size_container"></div>');
             $options.forEach(function($cObj) {
             
             if (jQuery('option[value=' + $cObj.id + ']').length > 0) {
             jQuery('#size_container').append('<div id="' + $cObj.id + '" class="colors" style="background-color:white; height: 25px; float: left; left: 5px; margin-right: 5px; border: solid 1px black; padding:0px 5px 0px 5px;"><span>' + $cObj.label + '</span></div>');
             }
             else {
             jQuery('#size_container').append('<div style="background-color:white; height: 25px; float: left; left: 5px; margin-right: 5px; border: solid 1px #B3B3BB; padding:0px 5px 0px 5px;"><span style="color:#B3B3BB;">' + $cObj.label + '</span></div>');
             }
             });
             jQuery('#size_container').append("<br>");
             }*/
            //}
        }
    });
}
function hideSelects(){
    jQuery('select').each(function() {
    $attrId = parseInt((jQuery(this).prop("id").replace(/[^\d.]/g, '')));
    if(hasImage($attrId)){
            jQuery(this).hide();
    }  
    });
}
function hasImage(attId) {
    var yes;
    var url = getBaseUrl() + "colorswatch/index/isdir/";
//    new Ajax.Request(url, {
//        data:{dir:dir1},
//        method:'post',
//        onSuccess:function (data){
//            alert(data.responseText);
//            console.log(data.responseText);
//        }
//    });
   
    jQuery.ajax(url, {
        async: false,
        method: 'post',
        data: {
            dir: attId
        },
        success: function(data) {
            //alert(data);
            yes= data;
        }

    });
    //yes = parseInt(data);
    return parseInt(yes);
}
function isExistInAllParents(){
    var allProduct;
    var data=JSON.parse(getAllData());
    jQuery('select').each(function() {
    var attrId = parseInt((jQuery(this).prop("id").replace(/[^\d.]/g, '')));
    var options= data.attributes[attrId].options;
    console.log(options);
});
    /*attr.forEach(function(cObj){
       console.log(cObj); 
    });*/
    //alert(data.attributes);
}
   