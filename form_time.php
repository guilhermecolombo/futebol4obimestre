<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Futebol 3</title>
		<meta charset="utf-8" />
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		
		<link rel = "stylesheet" href = "css/bootstrap.min.css" />
		
		<script src = "js/jquery-3.4.1.min.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		<?php
		include("conexao.php");
		
		$consulta_cidade= "SELECT * FROM cidade";
		$resultado_cidade = mysqli_query($conexao,$consulta_cidade) or die("Erro");
		
		?>
		<script>
			
			var id = null;
			var filtro = null;
			$(function(){
				
				paginacao(0);
				
				$("#filtrar").click(function(){

					$.ajax({
						url:"paginacao_time.php",
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
						url: "carrega_time_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome_time']").val(vetor.nome_time);
							$("select[name='cod_cidade']").val(vetor.cod_cidade);
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar Time");
						}
					});
				});
				
				function paginacao(p) {
					$.ajax ({
						url: "carrega_time.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							
							$("#identificador").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class='id'>" + matriz[i].id_time + "</td>";
								linha += "<td class='nome_time'>" + matriz[i].nome_time + "</td>";
								linha += "<td class='cod_cidade'>" + matriz[i].nome_cidade + "</td>";
								linha += "<td><button type = 'button' class = 'alterar' value ='" + matriz[i].id_time + "'>Alterar</button> | <button type = 'button' class ='remover' value ='" + matriz[i].id_time + "'>Remover</button></td>";
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
						url: "insere_time.php",
						type: "post",
						data: {
								nome_time:$("input[name='nome_time']").val(), 
								cod_cidade:$("select[name='cod_cidade']").val()
							},
						success: function(data){
							console.log(data);
							if(data==1){
								$("input[name='nome_time']").val('');
								$("select[name='cod_cidade']").val('');
								$("#resultado").html("Time efetuado!");
								paginacao(0);
								$.ajax({
									url: "paginacao_time.php",
									post: "post",
									data:{nome_filtro:filtro},
									success:function(d){
										$("#paginacao").html(d);
									}
								});
							}
						}
					});
				});
				$(document).on("click",".alteracao",function(){
					$.ajax({ 
						url: "altera_time.php",
						type: "post",
						data: {id: id, nome_time:$("input[name='nome_time']").val(), cod_cidade:$("select[name='cod_cidade']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteracao efetuada!");
								paginacao(0);
								$("input[name='nome_time']").val("");
								$("select[name='cod_cidade']").val("");
								$(".alteracao").attr("class","cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else {
								console.log(data);
							}
						}
					});
				});
				$(document).on("click",".excluir",function(){
					$.ajax({ 
						url: "excluir_time.php",
						type: "post",
						data: {id: id, nome_time:$("input[name='nome_time']").val(), cod_cidade:$("select[name='cod_cidade']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteração efetuada!");
								paginacao(0);
								$("input[name='nome_time']").val("");
								$("select[name='cod_cidade']").val("");
								$(".excluir").attr("class","cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else {
								console.log(e);
							}
						}
					});
				});
				$(document).on("click",".nome_time",function(){
					td = $(this);
					nome_time = td.html();
					td.html("<input type='text' id='nome_time_alterar' name='nome_time' value='" + nome_time + "' />");
					td.attr("class","nome_time_alterar");	
				});
				
				$(document).on("blur",".nome_time_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_time.php",
						type:"post",
						data:{
							coluna:'nome_time',
							valor:$("#nome_time_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".nome_time_alterar");
							nome_time = $("#nome_time_alterar").val();
							td.html(nome_time);
							td.attr("class","nome_time");
						}
					});
				});
				
				$(document).on("click",".cod_cidade",function(){
					td = $(this);
					cod_cidade = td.html();
					cidade = "<select id='cod_cidade_alterar' name='cod_cidade'>";
					cidade += $("#cidade").html();
					cidade += "</select>";
					td.html(cidade);
					
					td.attr("class","cod_cidade_alterar");	
				});
				
				$(document).on("blur",".cod_cidade_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_time.php",
						type:"post",
						data:{
							coluna:'cod_cidade',
							valor:$("#cod_cidade_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".cod_cidade_alterar");
							cod_cidade = $("#cod_cidade_alterar").val();							
							nome_cidade = $("#cod_cidade_alterar").find("option[value='" + cod_cidade + "']").html();
							td.html(nome_cidade);
							td.attr("class","cod_cidade");
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
		
		<h3>Time</h3>
		
		<form>
			<div class="form-row">
			<div class="form-group col-md-4">
			<input type = "text" name = "nome_time"  class="form-control" placeholder = "Nome..." /> <br /><br />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			 Cidade:<select id="cidade" name="cod_cidade">
                    <option></option>
    
                    <?php

                        while($linha=mysqli_fetch_assoc($resultado_cidade)){
                            $fk_cidade = $linha["id_cidade"];
                            $nome_cidade = $linha["nome_cidade"];
                            echo "<option value='$fk_cidade'>$nome_cidade</option>";
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
		
		<h3>Time</h3>
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
					<th>Nome Time</th>
					<th>Cidade</th>
					<th>Acao</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<div id="paginacao">
		<?php
			
			include("conexao.php");
				

			include("paginacao_time.php");
			
		?>
		</div>
	</body>
	
</html>