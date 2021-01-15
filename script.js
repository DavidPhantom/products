<script>
function operations(value, numID, mess) {
	$.ajax({
		url: 'update_table.php',
		type: 'POST',
		data: { val: value, id: numID},
		success: function() {
			alert('OK - '+ mess);
			var quantity = Number($("p[class="+numID+"]").attr('value'));
			quantity += value;
			$( "p[class="+numID+"]").replaceWith("<p class="+numID+" value="+quantity+">"+quantity+"</p>");
			},
		error: function() {
			alert('Ошибка - '+ mess);
			}
	});
}

function return_to_default() {
	$.ajax({
		url: 'drop_table.php',
		type: 'GET',
		success: function() {
			alert('OK - Таблица удалена');   
		},
		error: function() {
			alert('Ошибка - Таблица не удалена');
		}
	});
	$.ajax({
		url: 'create_table.php',
		type: 'GET',
		success: function() {
			alert('OK - Таблица создана');   
		},
		error: function() {
			alert('Ошибка - Таблица не создана');
		}
	});
}

$( "button[id]" ).click(function() {
	var numRow = this.id;
	var numID = this.value;
	$( "tr:eq("+numRow+")").hide( "slow" );
	$.ajax({
        url: 'update_table.php',
		type: 'POST',
        data: { hidden: true, id: numID},
        success: function() {
            alert('OK - Строка скрыта');
        },
        error: function() {
            alert('Ошибка - Строка не скрыта');
        }
		});
});
$( "button[name]" ).click(function() {
	var mathOper = this.name;
	var numID = this.value;
	switch( mathOper ) {
                case 'plus' :
					operations(1, numID, 'Один товар прибавлен');
                    break;

                case 'minus' :
					operations(-1, numID, 'Один товар убавлен');
					break;

                case 'default' :
					return_to_default();
			};
});
</script>