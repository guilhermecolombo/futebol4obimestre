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
		$consulta_time= "SELECT * FROM time";
		$resultado_cidade = mysqli_query($conexao,$consulta_cidade) or die("Erro");
		$resultado_time = mysqli_query($conexao,$consulta_time) or die("Erro");
		
		?>
		<script>
			
			var id = null;
			var filtro = null;
			$(function(){
				
				paginacao(0);
				
				$("#filtrar").click(function(){

					$.ajax({
						url:"paginacao_jogador.php",
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
						url: "carrega_jogador_alterar.php",
						type: "post",
						data: {id: id},
						success: function(vetor){
							$("input[name='nome_jogador']").val(vetor.nome_jogador);
							$("input[name='email']").val(vetor.email);
							$("input[name='sexo']").val(vetor.sexo);
							$("input[name='data_nascimento']").val(vetor.data_nascimento);
							$("select[name='posicao']").val(vetor.posicao);
							$("select[name='cod_cidade']").val(vetor.cod_cidade);
							$("select[name='cod_time']").val(vetor.cod_time);
							$(".cadastrar").attr("class","alteracao");
							$(".alteracao").val("Alterar Jogador");
						}
					});
				});
				
				function paginacao(p) {
					$.ajax ({
						url: "carrega_jogador.php",
						type: "post",
						data: {pg: p, nome_filtro: filtro},
						success: function(matriz){
							console.log(matriz);
							$("#identificador").html("");
							for(i=0;i<matriz.length;i++){
								linha = "<tr>";
								linha += "<td class='id'>" + matriz[i].id_jogador + "</td>";
								linha += "<td class='nome_jogador'>" + matriz[i].nome_jogador + "</td>";
								linha += "<td class='email'>" + matriz[i].email + "</td>";
								linha += "<td class='sexo'>" + matriz[i].sexo + "</td>";
								linha += "<td class='data_nascimento'>" + matriz[i].data_nascimento + "</td>";
								linha += "<td class='posicao'>" + matriz[i].posicao + "</td>";
								linha += "<td class='cod_cidade'>" + matriz[i].nome_cidade + "</td>";
								linha += "<td class='cod_time'>" + matriz[i].nome_time + "</td>";
								linha += "<td><button type = 'button' class = 'alterar' value ='" + matriz[i].id_jogador + "'>Alterar</button> | <button type = 'button' class ='remover' value ='" + matriz[i].id_jogador + "'>Remover</button></td>";
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
						url: "insere_jogador.php",
						type: "post",
						data: {
								nome_jogador:$("input[name='nome_jogador']").val(), 
								email:$("input[name='email']").val(),
								sexo:$("input[name='sexo']").val(),
								data_nascimento:$("input[name='data_nascimento']").val(), 
								posicao:$("select[name='posicao']").val(), 
								cod_cidade:$("select[name='cod_cidade']").val(), 
								cod_time:$("select[name='cod_time']").val()
							},
						success: function(data){
							console.log(data);
							if(data==1){
								$("input[name='nome_jogador']").val('');
								$("input[name='email']").val('');
								$("input[name='sexo']").val('');
								$("input[name='data_nascimento']").val('');
								$("select[name='posicao']").val('');
								$("select[name='cod_cidade']").val('');
								$("select[name='cod_time']").val('');
								$("#resultado").html("Jogador efetuado!");
								paginacao(0);
								$.ajax({
									url: "paginacao_jogador.php",
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
						url: "altera_jogador.php",
						type: "post",
						data: {id: id, 
							nome_jogador:$("input[name='nome_jogador']").val(), 
							email:$("input[name='email']").val(),
							sexo:$("input[name='sexo']").val(),
							data_nascimento:$("input[name='data_nascimento']").val(), 
							posicao:$("select[name='posicao']").val(), 
							cod_cidade:$("select[name='cod_cidade']").val(), 
							cod_time:$("select[name='cod_time']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteracao efetuada!");
								paginacao(0);
								$("input[name='nome_jogador']").val("");
								$("input[name='email']").val("");
								$("input[name='sexo']").val("");
								$("input[name='data_nascimento']").val("");
								$("select[name='posicao']").val("");
								$("select[name='cod_cidade']").val("");
								$("select[name='cod_time']").val("");
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
						url: "excluir_jogador.php",
						type: "post",
						data: {id: id, 
							nome_jogador:$("input[name='nome_jogador']").val(), 
							email:$("input[name='email']").val(),
							sexo:$("input[name='sexo']").val(),
							data_nascimento:$("input[name='data_nascimento']").val(), 
							posicao:$("select[name='posicao']").val(), 
							cod_cidade:$("select[name='cod_cidade']").val(), 
							cod_time:$("select[name='cod_time']").val()},
						success: function(data){
							if(data==1){
								$("#resultado").html("Alteração efetuada!");
								paginacao(0);
								$("input[name='nome_jogador']").val("");
								$("input[name='email']").val("");
								$("input[name='sexo']").val("");
								$("input[name='data_nascimento']").val("");
								$("select[name='posicao']").val("");
								$("select[name='cod_cidade']").val("");
								$("select[name='cod_time']").val("");
								$(".excluir").attr("class","cadastrar");
								$(".cadastrar").val("Cadastrar");
							}else {
								console.log(e);
							}
						}
					});
				});
				$(document).on("click",".nome_jogador",function(){
					td = $(this);
					nome_jogador = td.html();
					td.html("<input type='text' id='nome_jogador_alterar' name='nome_jogador' value='" + nome_jogador + "' />");
					td.attr("class","nome_jogador_alterar");	
				});
				
				$(document).on("blur",".nome_jogador_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_jogador.php",
						type:"post",
						data:{
							coluna:'nome_jogador',
							valor:$("#nome_jogador_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".nome_jogador_alterar");
							nome_jogador = $("#nome_jogador_alterar").val();
							td.html(nome_jogador);
							td.attr("class","nome_jogador");
						}
					});
				});
				$(document).on("click",".email",function(){
					td = $(this);
					email = td.html();
					td.html("<input type='email' id='email_alterar' name='email' value='" + email + "' />");
					td.attr("class","email_alterar");	
				});
				
				$(document).on("blur",".email_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_jogador.php",
						type:"post",
						data:{
							coluna:'email',
							valor:$("#email_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".email_alterar");
							email = $("#email_alterar").val();
							td.html(email);
							td.attr("class","email");
						}
					});
				});
				$(document).on("click",".sexo",function(){
					td = $(this);
					sexo = td.html();
					td.html("<input type='text' id='sexo_alterar' name='sexo' value='" + sexo + "' />");
					td.attr("class","sexo_alterar");	
				});
				
				$(document).on("blur",".sexo_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_jogador.php",
						type:"post",
						data:{
							coluna:'sexo',
							valor:$("#sexo_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".sexo_alterar");
							sexo = $("#sexo_alterar").val();
							td.html(sexo);
							td.attr("class","sexo");
						}
					});
				});
				$(document).on("click",".data_nascimento",function(){
					td = $(this);
					data_nascimento = td.html();
					td.html("<input type='date' id='data_nascimento_alterar' name='data_nascimento' value='" + data_nascimento + "' />");
					td.attr("class","data_nascimento_alterar");	
				});
				
				$(document).on("blur",".data_nascimento_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_jogador.php",
						type:"post",
						data:{
							coluna:'data_nascimento',
							valor:$("#data_nascimento_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".data_nascimento_alterar");
							data_nascimento = $("#data_nascimento_alterar").val();
							td.html(data_nascimento);
							td.attr("class","data_nascimento");
						}
					});
				});
				$(document).on("click",".posicao",function(){
					td = $(this);
					//aqui você pega o valor que estava antes do click
					posicao = td.html();
					posicao_select = "<select id='posicao_alterar' name='posicao'>";
					posicao_select += "<option>Atacante</option>";
                    posicao_select += "<option>Goleiro</option>";
                    posicao_select += "<option>Zagueiro</option>";
					posicao_select += "</select>";
					td.html(posicao_select);
					
					td.attr("class","posicao_alterar");	
				});
				
				$(document).on("blur",".posicao_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_jogador.php",
						type:"post",
						data:{
							coluna:'posicao',
							valor:$("#posicao_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".posicao_alterar");
							posicao = $("#posicao_alterar").val();		
							//neste caso, não precisa fazer a etapa de baixo, porque a coluna "posicao" é uma string - não tem codigo pra ela no banco.
							//posicao = $("#posicao_alterar").find("option[value='" + posicao + "']").html();
							td.html(posicao);
							td.attr("class","posicao");
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
						url:"altera_coluna_jogador.php",
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
				$(document).on("click",".cod_time",function(){
					td = $(this);
					cod_time = td.html();
					time = "<select id='cod_time_alterar' name='cod_time'>";
					time += $("#time").html();
					time += "</select>";
					td.html(time);
					
					td.attr("class","cod_time_alterar");	
				});
				
				$(document).on("blur",".cod_time_alterar",function(){
					id_linha = $(this).closest("tr").find("button").val();
					
					$.ajax({
						url:"altera_coluna_jogador.php",
						type:"post",
						data:{
							coluna:'cod_time',
							valor:$("#cod_time_alterar").val(),
							id: id_linha
							},
						success: function(){
							td = $(".cod_time_alterar");
							cod_time = $("#cod_time_alterar").val();	
							nome_time = $("#cod_time_alterar").find("option[value='" + cod_time + "']").html();
							td.html(nome_time);
							td.attr("class","cod_time");
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
		
		<h3>Jogador</h3>
		
		<form>
			<div class="form-row">
			<div class="form-group col-md-4">
			<input type = "text" name = "nome_jogador"  class="form-control" placeholder = "Nome..." />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			<input type = "email" name = "email"  class="form-control" placeholder = "Email..." />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			Sexo:
			M <input type = "radio" name = "sexo" value = "M" />
			F <input type = "radio" name = "sexo" value = "F" />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			Data Nascimento<input type = "date" name = "data_nascimento"  class="form-control" />
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			 Posicao:<select name="posicao">
                    <option>Atacante</option>
                    <option>Goleiro</option>
                    <option>Zagueiro</option>
                </select>
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
			</div>
			</div>
			<div class="form-row">
			<div class="form-group col-md-4">
			 Time:<select id="time" name="cod_time">
                    <option></option>
    
                    <?php

                        while($linha=mysqli_fetch_assoc($resultado_time)){
                            $fk_time = $linha["id_time"];
                            $nome_time = $linha["nome_time"];
                            echo "<option value='$fk_time'>$nome_time</option>";
                        }
                    ?>
                </select>
			</div>
			</div>
			<div class="form-group row">
			<div class="form-group col-md-12">
			<input type = "button" class = "cadastrar" class="form-control" value = "Cadastrar" />
			</div>
			</div>
		</form>
		
		<div id = "resultado"></div>
		
		<h3>Jogador</h3>
		<div class="form-row">
		<div class="form-group col-md-3">
		<form name='filtro'>
			<input type="text" class="form-control" name="nome_filtro"
				placeholder="filtrar por nome..." />
				
			<button type="button" class="form-control" id="filtrar">Filtrar</button>
			</div>
			</div>
		</form>
		
		<table border = '1'>
						
			<thead>
				<tr>
					<th>ID</th>
					<th>Nome Jogador</th>
					<th>Email</th>
					<th>Sexo</th>
					<th>Data Nascimento</th>
					<th>Posicao</th>
					<th>Cidade</th>
					<th>Time</th>
					<th>Acao</th>
				</tr>
			 </thead>
		
			<tbody id = 'identificador'></tbody>
					
		</table>
		<br /><br />
		
		<div id="paginacao">
		<?php
			
			include("conexao.php");
				

			include("paginacao_jogador.php");
			
		?>
		</div>
	</body>
	
</html>