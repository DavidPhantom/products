
function productItemChangeNumber(value, numID, mess) {
	$.ajax({
		url: 'update_sql_table.php',
		type: 'POST',
		data: { val: value, id: numID},
		success: function() {
			alert('OK - '+ mess);
			var quantity = Number($("p[class="+numID+"]").attr('value'));
			quantity += value;
			$( "p[class="+numID+"]").replaceWith("<p class="+numID+" value="+quantity+">"+quantity+"</p>");
			},
		error: function() {
			alert('Ошибка');
			}
	});
}

function returnToDefaultStateProductTable() {
	$.ajax({
		url: 'recreate_sql_table.php',
		type: 'GET',
		success: function() {
			alert('OK - Таблица удалена и заново создана');
			location.reload();			
		},
		error: function() {
			alert('Ошибка');
		}
	});
}

function hiddenProductItem(numRow, numID){
	$( "tr:eq("+numRow+")").hide( "slow" );
		$.ajax({
			url: 'update_sql_table.php',
			type: 'POST',
			data: { hiddenBool: true, id: numID},
			success: function() {
				alert('OK - Строка скрыта');
			},
			error: function() {
				alert('Ошибка');
			}
		});
}

$( "button[name]" ).click(function() {
	var buttonName = this.name;
	var numID = this.value;
	switch( buttonName ) {
				case 'hiddenProductItemBtn':
					hiddenProductItem(this.id, this.value);
					break;
                case 'plusProductItemBtn' :
					productItemChangeNumber(1, numID, 'Один товар прибавлен');
                    break;

                case 'minusProductItemBtn' :
					productItemChangeNumber(-1, numID, 'Один товар убавлен');
					break;

                case 'returnDefaultStateTableBtn' :
					returnToDefaultStateProductTable();
	};
});
