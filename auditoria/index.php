<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Auditoria Interna - RJC</title>
	<link href="css/estilo.css" rel="stylesheet">
	<style>
		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
			background: #f8fbff;
			color: #0b1d3f;
			min-height: 100vh;
			padding: 20px;
		}

		.main-container {
			max-width: 1100px;
			margin: 0 auto;
		}

		.header {
			background: rgba(255, 255, 255, 0.95);
			border-radius: 15px;
			padding: 40px;
			margin-bottom: 40px;
			border: 1px solid rgba(11, 29, 63, 0.2);
			box-shadow: 0 20px 60px rgba(11, 29, 63, 0.12);
			text-align: center;
			border-bottom: 3px solid rgba(11, 29, 63, 0.2);
		}

		.company-name {
			font-size: 1.8em;
			font-weight: 700;
			color: #0b1d3f;
			letter-spacing: 2px;
			text-shadow: 0 4px 10px rgba(11, 29, 63, 0.15);
			margin-bottom: 10px;
		}

		.page-title {
			font-size: 1.3em;
			color: rgba(11, 29, 63, 0.75);
			letter-spacing: 1px;
			font-weight: 400;
		}

		.back-button {
			position: absolute;
			top: 20px;
			left: 20px;
			padding: 10px 18px;
			background: rgba(11, 29, 63, 0.15);
			border: 1px solid rgba(11, 29, 63, 0.3);
			color: #0b1d3f;
			border-radius: 8px;
			cursor: pointer;
			text-decoration: none;
			font-size: 0.9em;
			transition: all 0.3s ease;
		}

		.back-button:hover {
			background: rgba(11, 29, 63, 0.25);
			border-color: rgba(11, 29, 63, 0.4);
		}

		.sections-container {
			display: grid;
			grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
			gap: 30px;
			margin-bottom: 40px;
		}

		.section-card {
			background: rgba(255, 255, 255, 0.85);
			border-radius: 12px;
			border: 1px solid rgba(11, 29, 63, 0.2);
			box-shadow: 0 10px 35px rgba(11, 29, 63, 0.12);
			overflow: hidden;
			transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
		}

		.section-card:hover {
			transform: translateY(-5px);
			border-color: rgba(11, 29, 63, 0.35);
			box-shadow: 0 20px 50px rgba(11, 29, 63, 0.15);
		}

		.section-header {
			background: linear-gradient(135deg, rgba(11, 29, 63, 0.05) 0%, rgba(11, 29, 63, 0.02) 100%);
			padding: 20px;
			border-bottom: 2px solid rgba(11, 29, 63, 0.2);
		}

		.section-title {
			font-size: 1.1em;
			font-weight: 600;
			color: #0b1d3f;
			letter-spacing: 1px;
			margin: 0;
		}

		.section-links {
			padding: 20px;
			display: flex;
			flex-direction: column;
			gap: 12px;
		}

		.link-item {
			display: block;
			padding: 12px 16px;
			background: rgba(11, 29, 63, 0.05);
			border-left: 3px solid rgba(11, 29, 63, 0.3);
			color: rgba(11, 29, 63, 0.75);
			text-decoration: none;
			border-radius: 4px;
			transition: all 0.3s ease;
			font-size: 0.95em;
		}

		.link-item:hover {
			background: rgba(11, 29, 63, 0.1);
			border-left-color: rgba(11, 29, 63, 0.6);
			color: #0b1d3f;
			padding-left: 20px;
		}

		.footer-line {
			text-align: center;
			padding-top: 30px;
			border-top: 1px solid rgba(11, 29, 63, 0.2);
			color: rgba(11, 29, 63, 0.7);
			font-size: 0.85em;
		}

		@media (max-width: 768px) {
			.header {
				padding: 30px 20px;
			}

			.company-name {
				font-size: 1.3em;
			}

			.page-title {
				font-size: 1em;
			}

			.sections-container {
				grid-template-columns: 1fr;
				gap: 20px;
			}
		}
	</style>
</head>

<body>
	<a href="../index.php" class="back-button">← Voltar</a>

	<div class="main-container">
		<div class="header">
			<div class="company-name">◆ R J C DEFESA E AEROESPACIAL</div>
			<div class="page-title">Sistema de Auditoria Interna</div>
		</div>

		<div class="sections-container">
			<?php
				// Seção 1: Bloco K
				echo '<div class="section-card">';
				echo '<div class="section-header">';
				echo '<h2 class="section-title">Relatórios Bloco K</h2>';
				echo '</div>';
				echo '<div class="section-links">';
				echo '<a href="nfxmovto/nfxmovto.php" class="link-item">▸ Nota x Movimento</a>';
				echo '<a href="nfxmovto/nfxop.php" class="link-item">▸ Nota x O.P</a>';
				echo '<a href="opxtransf/ordprod.php" class="link-item">▸ Ordem de Produção</a>';
				echo '<a href="nfxmovto/nfxproduto.php" class="link-item">▸ Vendas por Produto</a>';
				echo '</div>';
				echo '</div>';

				// Seção 2: Almoxarifado
				echo '<div class="section-card">';
				echo '<div class="section-header">';
				echo '<h2 class="section-title">Relatórios Almoxarifado</h2>';
				echo '</div>';
				echo '<div class="section-links">';
				echo '<a href="opxtransf/optransf.php" class="link-item">▸ O.P. e Transferências</a>';
				echo '<a href="almox_audit/movto.php" class="link-item">▸ Movimento de Estoque</a>';
				echo '<a href="estoque/index.php" class="link-item">▸ Cadastro de Produtos</a>';
				echo '<a href="estoque/rel_almox_folha.php" class="link-item">▸ Movto Almox x Folha</a>';
				echo '<a href="estoque/saldoblocok.php" class="link-item">▸ Saldo Estoque por Data</a>';
				echo '</div>';
				echo '</div>';

				// Seção 3: Análise de Custo
				echo '<div class="section-card">';
				echo '<div class="section-header">';
				echo '<h2 class="section-title">Análise de Custo</h2>';
				echo '</div>';
				echo '<div class="section-links">';
				echo '<a href="opxtransf/receitaxcusto.php" class="link-item">▸ Custo Por Produto</a>';
				echo '<a href="estoque/custo.php" class="link-item">▸ Custo das Mercadorias</a>';
				echo '<a href="estoque/receitas.php" class="link-item">▸ Cadastro de Receitas</a>';
				echo '</div>';
				echo '</div>';

				// Seção 4: Lançamento de Notas
				echo '<div class="section-card">';
				echo '<div class="section-header">';
				echo '<h2 class="section-title">Lançamento de Notas</h2>';
				echo '</div>';
				echo '<div class="section-links">';
				echo '<a href="correlacaoitem.php" class="link-item">▸ Correlação de Item</a>';
				echo '</div>';
				echo '</div>';
			?>
		</div>

		<div class="footer-line">
			<p>Sistema de Auditoria e Conformidade • RJC Defesa Aeroespacial LTDA</p>
		</div>
	</div>
</body>

</html>
