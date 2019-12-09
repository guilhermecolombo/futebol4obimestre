<!DOCTYPE html>

<html lang = "pt-BR">
	
	<head>
		
		<title>Futebol 3</title>
		<meta name = "viewport" content = "width=device-width, initial-scale=1" />
		
		<link rel = "stylesheet" href = "css/bootstrap.min.css" />
		
		<script src = "js/jquery-3.4.1.min.js"></script>
		<script src = "js/bootstrap.min.js"></script>
		<script>
			
			var id = null;
			var filtro = null;
			$(function(){
				
				paginacao(0);
				
				$("#filtrar").click(function(){

					$.ajax({
						url:"paginacao_estado.php",
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
						url: "carrega_estado_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome_estado']").val(vetor.nome_estado);
							$("input[name='uf']").val(vetor.uf);
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar Estado");
						}
					});
				});
				
				function paginacao(p) {
					$.ajax ({
						url: "carrega_estado.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							
							$("#identificador").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class='id'>" + matriz[i].id_estado + "</td>";
								linha += "<td class='nome_estado'>" + matriz[i].nome_estado + "</td>";
								linha += "<td class='uf'>" + matriz[i].uf + "</td>";
								linha += "<td><button type = 'button' class = 'alterar' value ='" + matriz[i].id_estado + "'>Alterar</button> | <button type = 'button' class ='remover' value ='" + matriz[i].id_estado + "'>Remover</button></td>";
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
						url: "insere_estado.php",
						type: "post",
						data: {
								nome_estado:$("input[name='nome_estado']").val(), 
								uf:$("input[name='uf']").val()
							},
						success: function(data){
							if(data==1){
								$("input[name='nome_estado']").val('');
								$("input[name='uf']").val('');
								$("#resultado").html("Estado efetuado!");
								paginacao(0);
								$.ajax({
									url: "paginacao_estado.php",
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
						url: "altera_estado.php",
						type: "post",
						data: {id: id, nome_estado:$("input[name='nome_estado']").val(), uf:$("input[name='uf']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteração efetuada!");
								paginacao(0);
								$("input[name='nome_estado']").val("");
								$("input[name='uf']").val("");
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
						url: "excluir_estado.php",
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
				$(document).on("click",".nome_estado",function(){
					td = $(this);
					nome_estado = td.html();
					td.html("<input type='text' id='nome_estado_alterar' name='nome_estado' value='" + nome_estado + "' />");
					td.attr("class","nome_estado_alterar");	
				});
				
				$(document).on("blur",".nome_estado_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_estado.php",
						type:"post",
						data:{
							coluna:'nome_estado',
							valor:$("#nome_estado_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".nome_estado_alterar");
							nome_estado = $("#nome_estado_alterar").val();
							td.html(nome_estado);
							td.attr("class","nome_estado");
						}
					});
				});
				
				$(document).on("click",".uf",function(){
					td = $(this);
					uf = td.html();
					td.html("<input type='text' id='uf_alterar' name='uf' value='" + uf + "' />");
					td.attr("class","uf_alterar");	
				});
				
				$(document).on("blur",".uf_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_estado.php",
						type:"post",
						data:{
							coluna:'uf',
							valor:$("#uf_alterar").val(),
							id: id_linha
							},
						success: function(d){
							console.log(d);
							td = $(".uf_alterar");
							uf = $("#uf_alterar").val();
							td.html(uf);
							td.attr("class","uf");
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
		
		<h3>Estado</h3>
		
		<form>
			<div class="form-row">
			<div class="form-group col-md-4">
			<input type = "text" name = "nome_estado"  class="form-control" placeholder = "Nome..." /> <br /><br />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			<input type = "text"  class="form-control" name = "uf" placeholder = "UF..." /><br /><br />
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
		
		<h3>Estado</h3>
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
					<th>Nome Estado</th>
					<th>UF</th>
					<th>Acao</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<div id="paginacao">
		<?php
			
			include("conexao.php");
				

			include("paginacao_estado.php");
			
		?>
		</div>
	</body>
	
</html>