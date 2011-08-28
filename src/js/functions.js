function change_region(id, lang){
    $("#city_sel").html("...").load("/load.php?reg_id="+id+"&lang="+lang);
}