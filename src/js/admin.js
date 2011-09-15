var district=0;
var village=0;
function slide_block(block_pref,id){
	if($("#"+block_pref+id).is(":visible")){
		$("#legend_"+id).removeClass('opened_group');
		$("#legend_"+id).addClass('closed_group');
		$("#"+block_pref+id).slideToggle('medium');;
	}
	else{
		$("#legend_"+id).removeClass('closed_group');
		$("#legend_"+id).addClass('opened_group');
		$("#"+block_pref+id).slideToggle('medium');
	}
}

function load_villages(district_id){
	$("#villages").html('Завантаження...').load("/ajax/load_villages.php?district_id="+district_id);
	district=district_id;
	$("#street").val('');
	$.get('/ajax/get_streets_arr.php?district_id='+district+'&village_id='+village,
	    function(data){
        	$("#street").autocomplete(data.split('||'));
		});
}

function change_village(village_id){
	village=village_id;
	$("#street").val('');
	$.get('/ajax/get_streets_arr.php?district_id='+district+'&village_id='+village,
	    function(data){
	    	$("#street").autocomplete("destroy");
        	$("#street").autocomplete(data.split('||'));
		});
}

