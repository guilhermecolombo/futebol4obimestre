<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Futebol 3</title>
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		
		<link rel = "stylesheet" href = "css/bootstrap.min.css" />
		
		<script src = "js/jquery-3.4.1.min.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		<?php
		include("conexao.php");
		
		$consulta_estado= "SELECT * FROM estado";
		$resultado_estado = mysqli_query($conexao,$consulta_estado) or die("Erro");
		
		?>
		<script>
			
			var id = null;
			var filtro = null;
			$(function(){
				
				paginacao(0);
				
				$("#filtrar").click(function(){

					$.ajax({
						url:"paginacao_cidade.php",
						type:"post",
						data:{
								nome_filtro: $("input[name='nome_filtro']").val()
								
						},
						success: function(d){
							
							$("#paginacao").html(d);
							filtro = $("input[name='nome_filtro']").val();
							paginacao(0);
						}
					});
				});
				
				$(document).on("click",".alterar",function(){
					id = $(this).attr("value");
					$.ajax({
						url: "carrega_cidade_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome_cidade']").val(vetor.nome_cidade);
							$("select[name='cod_estado']").val(vetor.cod_estado);
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar Cidade");
						}
					});
				});
				
				function paginacao(p) {
					$.ajax ({
						url: "carrega_cidade.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							
							$("#identificador").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class='id'>" + matriz[i].id_cidade + "</td>";
								linha += "<td class='nome_cidade'>" + matriz[i].nome_cidade + "</td>";
								linha += "<td class='cod_estado'>" + matriz[i].uf + "</td>";
								linha += "<td><button type = 'button' class = 'alterar' value ='" + matriz[i].id_cidade + "'>Alterar</button> | <button type = 'button' class ='remover' value ='" + matriz[i].id_cidade + "'>Remover</button></td>";
								linha += "</tr>";
								$("#identificador").append(linha);
							}
						}
					});
				}
				
				$(document).on("click",".pg",function(){
					p = $(this).val();
					p = (p-1)*5;
					paginacao(p);
				});
				
				$(document).on("click",".cadastrar",function(){
					$.ajax({ 
						url: "insere_cidade.php",
						type: "post",
						data: {
								nome_cidade:$("input[name='nome_cidade']").val(), 
								cod_estado:$("select[name='cod_estado']").val()
							},
						success: function(data){
							if(data==1){
								$("input[name='nome_cidade']").val('');
								$("select[name='cod_estado']").val('');
								$("#resultado").html("Cidade efetuado!");
								paginacao(0);
								$.ajax({
									url: "paginacao_cidade.php",
									post: "post",
									data:{nome_filtro:filtro},
									success:function(d){
										$("#paginacao").html(d);
									}
								});
							}else {
								console.log(data);
							}
						}
					});
				});
				$(document).on("click",".alteracao",function(){
					$.ajax({ 
						url: "altera_cidade.php",
						type: "post",
						data: {id: id, nome_cidade:$("input[name='nome_cidade']").val(), cod_estado:$("select[name='cod_estado']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteracao efetuada!");
								paginacao(0);
								$("input[name='nome_cidade']").val("");
								$("select[name='cod_estado']").val("");
								$(".alteracao").attr("class","cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else {
								console.log(data);
							}
						}
					});
				});
				$(document).on("click",".remover",function(){
					id = $(this).val();
					$.ajax({ 
						url: "excluir_cidade.php",
						type: "post",
						data: {id: id},
						success: function(data){
							console.log(data);
							if(data==1){
								$("#resultado").html("Excluir efetuada!");
								paginacao(0);
							}
						}
					});
				});
				$(document).on("click",".nome_cidade",function(){
					td = $(this);
					nome_cidade = td.html();
					td.html("<input type='text' id='nome_cidade_alterar' name='nome_cidade' value='" + nome_cidade + "' />");
					td.attr("class","nome_cidade_alterar");	
				});
				
				$(document).on("blur",".nome_cidade_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_cidade.php",
						type:"post",
						data:{
							coluna:'nome_cidade',
							valor:$("#nome_cidade_alterar").val(),
							id: id_linha
							},
						success: function(data){
							console.log(data);
							td = $(".nome_cidade_alterar");
							nome_cidade = $("#nome_cidade_alterar").val();
							td.html(nome_cidade);
							td.attr("class","nome_cidade");
						}
					});
				});
				
				$(document).on("click",".cod_estado",function(){
					td = $(this);
					cod_estado = td.html();
					estado = "<select id='cod_estado_alterar' name='cod_estado'>";
					estado += $("#estado").html();
					estado += "</select>";
					td.html(estado);
					
					td.attr("class","cod_estado_alterar");	
				});
				
				$(document).on("blur",".cod_estado_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_cidade.php",
						type:"post",
						data:{
							coluna:'cod_estado',
							valor:$("#cod_estado_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".cod_estado_alterar");
							cod_estado = $("#cod_estado_alterar").val();							
							nome_estado = $("#cod_estado_alterar").find("option[value='" + cod_estado + "']").html();
							td.html(nome_estado);
							td.attr("class","cod_estado");
						}
					});
				});
		});
		</script>
		
	</head>
	<?php
	include("cabecalho.php");
	?>
	<body>
		
		<h3>Cidade</h3>
		
		<form>
			<div class="form-row">
			<div class="form-group col-md-4">
			<input type = "text" name = "nome_cidade"  class="form-control" placeholder = "Nome..." /> <br /><br />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			 Estado:<select id="estado" name="cod_estado">
                    <option></option>
    
                    <?php

                        while($linha=mysqli_fetch_assoc($resultado_estado)){
                            $fk_estado = $linha["id_estado"];
                            $uf = $linha["uf"];
                            echo "<option value='$fk_estado'>$uf</option>";
                        }
                    ?>
                </select>
                <br /><br />
			</div>
			</div>
			<div class="form-group row">
			<div class="form-group col-md-12">
			<input type = "button" class = "cadastrar" class="form-control" value = "Cadastrar" />
			</div>
			</div>
		</form>
		
		<br />
		
		<div id = "resultado"></div>
		
		<br />
		
		<h3>Cidade</h3>
		<div class="form-row">
		<div class="form-group col-md-3">
		<form name='filtro'>
			<input type="text" class="form-control" name="nome_filtro"
				placeholder="filtrar por nome..." />
				
			<button type="button" class="form-control" id="filtrar">Filtrar</button>
			</div>
			</div>
			<br /><br />
		</form>
		
		<table border = '1'>
						
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome Cidade</th>
					<th>Estado (UF)</th>
					<th>Acao</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<div id="paginacao">
		<?php
			
			include("conexao.php");
				

			include("paginacao_cidade.php");
			
		?>
		</div>
	</body>
	
</html>