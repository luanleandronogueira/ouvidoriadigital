<?php include "controller.php" ?>
<html lang="pt-br">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title><?php getTitulo(); ?></title>

<?php getHeader(); ?>
<link href="layout_files/conteudo.css" rel="stylesheet" type="text/css">

</head>
<body class="" style="">
<?php 
	//chama o topo da pagina
	getTopoMenu(); 
	
	//chama os botoes de atalho
	getBotoes();
	
	//chama botoes de rede sociais
	getRedeSociais();
	
	?>	
  <main id="main">

    <!-- ======= Breadcrumbs ======= -->
    <section id="breadcrumbs" class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Pesquisa de Satisfação</h2>
          <ol>
            <li><a href="index.php">Home</a></li>
			        <li>Pesquisa de Satisfação</li>
            
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs -->

    <!-- ======= Portfolio Details Section ======= -->
    <section id="portfolio-details" class="portfolio-details">
      <div class="container">

        <div class="portfolio-description">
           <iframe src="https://docs.google.com/forms/d/e/1FAIpQLScLmkuf-A2Fx-yR0nASB8LgOLMJdKnzyPVsv5IW0Yl096_Exw/viewform?embedded=true" width="640" height="1723" frameborder="0" marginheight="0" marginwidth="0">Carregando…</iframe>
         
      </div>
    </section>

  </main><!-- End #main -->
    
<script>
//rolar barra até o elemento
window.location.href='#main';
</script>

<?php getRodape(); ?>

 </body>
</html>