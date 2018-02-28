<?php 
  require_once('core.php');

  $message = "";
  $database = new Database;
  $db = $database->getConnection();

  

  function sanitize($array = []):array
  {
  	foreach($array as $key => $value) {
  		if (!is_array($value)) {
  			$array[$key] =  htmlspecialchars(strip_tags($value));
  		} else {
  			for ($i =0; $i < count($value); $i++) {
  				$array[$key][$i] =  htmlspecialchars(strip_tags($value[$i]));
  			}
  		}
  		
  	}

  	return $array;
  }

 
  $data = [];
 
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  	$data = sanitize($_POST);

  	if (!empty($data['inicial_data'])) {
  		$data['inicial_data'] = date("Y-m-d", strtotime(str_replace('/','-',$data['inicial_data'])));
  	}

  	for($i = 0; $i < count($data['data_quarto']); $i++) {
  		$data['data_quarto'][$i] = date("Y-m-d", strtotime(str_replace('/','-',$data['data_quarto'][$i])));
  	}

  	$query = "SELECT empresa_codigo, quarto_item, quarto_status_codigo, inicial_data, final_data from documento_quarto
		WHERE empresa_codigo=:empresa_codigo AND quarto_item=:quarto_item 
		documento_numero=:documento_numero	
		AND quarto_status_codigo IN(1,2) LIMIT 0,1";

	$stmt = $db->prepare($query);


	$stmt->bindParam(":empresa_codigo", $data['empresa_codigo']);
	$stmt->bindParam(":quarto_item", $data['quarto_item']);
	$stmt->bindParam(":documento_numero", $data['documento_numero']);

	$stmt->execute();

	$documento_quarto = $stmt->fetch(PDO::FETCH_ASSOC);

	if(count($documento_quarto) > 0) {
 
		$query = "UPDATE documento_quarto
	 	 SET 
	 		inicial_data=:inicial_data,
	 		final_data=:final_data,
	
	 	WHERE empresa_codigo = :empresa_codigo 
	 	AND quarto_item = :quarto_item
	 	AND documento_numero=:documento_numero";

	 	$stmt = $db->prepare($query);

	 	$data_quarto = end($data['data_quarto']);

		$stmt->bindParam(":inicial_data", $data['inicial_data']);
		$stmt->bindParam(":final_data", $data_quarto);
		$stmt->bindParam(":empresa_codigo", $data['empresa_codigo']);
		$stmt->bindParam(":quarto_item", $data['quarto_item']);
		$stmt->bindParam(":documento_numero", $data['documento_numero']);
		
	
	 	$stmt->execute();

	 	for($i = 0; $i < count($data['data_quarto']); $i++) {
	 		$query = "SELECT empresa_codigo, quarto_item, data from documento_datas
			WHERE empresa_codigo=:empresa_codigo AND quarto_item=:quarto_item 
			documento_numero=:documento_numero	
			AND data=:data LIMIT 0,1";

			$stmt = $db->prepare($query);


			$stmt->bindParam(":empresa_codigo", $data['empresa_codigo']);
			$stmt->bindParam(":quarto_item", $data['quarto_item']);
			$stmt->bindParam(":documento_numero", $data['documento_numero']);
			$stmt->bindParam(":data", $data['data_quarto'][$i]);

			$stmt->execute();
			$documento_data = $stmt->fetch(PDO::FETCH_ASSOC);

			if (count($documento_data) == 0) {
				$query = "INSERT INTO documento_datas SET
				empresa_codigo=:empresa_codigo,
				quarto_item=:quarto_item,
				data=:data			
				documento_numero=:documento_numero";

				$stmt = $db->prepare($query);				
				

				$stmt->bindParam(":empresa_codigo", $data['empresa_codigo']);
				$stmt->bindParam(":quarto_item", $data['quarto_item']);
				$stmt->bindParam(":documento_numero", $data['documento_numero']);
				$stmt->bindParam(":data", $data['data_quarto'][$i]);
				
				$stmt->execute();
			
			}
		}
	

		$query = "DELETE from documento_datas
		WHERE empresa_codigo=:empresa_codigo AND quarto_item=:quarto_item 
		documento_numero=:documento_numero	
		 AND data NOT IN(:datas)";

		$stmt = $db->prepare($query);

		$datas = implode(',',$data['data_quarto']);

		$stmt->bindParam(":empresa_codigo", $data['empresa_codigo']);
		$stmt->bindParam(":quarto_item", $data['quarto_item']);
		$stmt->bindParam(":documento_numero", $data['documento_numero']);
		$stmt->bindParam(":datas", $datas);

		$stmt->execute();			

	  	
	  	$message = 'Quarto Atualizado';
	}
}
  
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
	<p style="color:red"><?= $message; ?></p>
	<form method="post">
		<p>
			<label>Empresa código</label>
			<input type="text" name="empresa_codigo" readonly="readonly" value="1">
		</p>
		<p>
			<label>Quarto Item</label>
			<input type="text" name="quarto_item" readonly="readonly" value="1">
		</p>
		<p>
			<label>Documento Numero</label>
			<input type="text" name="documento_numero" required="required">
		</p>
		<p>
			<label>Quarto Código</label>
			<input type="text" name="quarto_codigo" required="required">
		</p>
		<p>
			<label>Data Inicial:</label>
			<input type="text" name="inicial_data" required="required">
		</p>
		
		<p>
			<label>Data Quarto:</label>
			<input type="text" name="data_quarto[]" required="required"><button type="button" id='add_data'>Adicionar data</button>
		</p>
		
		<p>
			<button type="submit">Enviar</button>
		</p>
		
	</form>
</body>
<!-- JS para criar botao de adcionar data -->
<script type="text/javascript">
	document.getElementById("add_data").onclick = function()
	{
		var field = document.getElementsByName("data_quarto[]")
		var last = field[field.length - 1];
		var newField = last.cloneNode(true);
		newField.value = "";

		last.parentNode.insertBefore(newField, last.nextSibling);
	}
</script>
</html>