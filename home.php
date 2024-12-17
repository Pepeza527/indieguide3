<?php
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Página Home</title>
    <!-- Incluindo Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="estilos/home.css">

    
</head>
<body>
    <header class="custom-header">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <a class="navbar-brand" href="/">INDIE GUIDE AWARDS</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item"><a class="nav-link" href="festival.php">Festivais</a></li>
                <li class="nav-item"><a class="nav-link" href="addfest.php">Adicionar Festival</a></li>
                <li class="nav-item"><a class="nav-link" href="perfil.php">perfil</a></li> 
                <li class="nav-item"><a class="nav-link" href="cadastro.php">Cadastro</a></li>  
                </ul>
            </ul>
        </div>
    </nav>
    </header>

    <!-- <div class="container mt-5">
        <div class="jumbotron text-center">
            <h1 class="display-4">Bem-vindo ao Indie Critics</h1>
        </div>
    </div> -->

   
    <div id="carouselHeader" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselHeader" data-slide-to="0" class="active"></li>
            <li data-target="#carouselHeader" data-slide-to="1"></li>
            <li data-target="#carouselHeader" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100" src="https://deadline.com/wp-content/uploads/2018/09/rexfeatures_9843905i.jpg" alt="Festival de Veneza">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Venice Film Festival 77th Edition</h5>
                    <p>Aug 28 - Sep 7 2024</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="https://images.ctfassets.net/22n7d68fswlw/61xTmkgA1aIMqIURZSAjdb/9b63d82e76eb4eddc92eeb32401375ba/TIFF-Rogers_v3.jpg?w=1200&h=630" alt="Festival de Toronto">
                <div class="carousel-caption d-none d-md-block">
                    <h5>Toronto Internacional Film Festival</h5>
                    <p>SEPT 5-15 2024</p>
                </div>
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="https://images.ctfassets.net/3m6gg2lxde82/4USbojl2NR8E8NVZB7Jycn/c6659a53d06226ee78bacfc35e677208/cannes-2024-header.png?w=2048&h=1137&fit=fill&f=faces&q=90&fm=webp" alt="Festival de Cannes">
                <div class="carousel-caption d-none d-md-block">
                    <h5>77. Festival Internacional du Film de Cannes</h5>
                    <p>14.-25. MAI 2024</p>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselHeader" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselHeader" role="button" data-slide="next">
            <span class="sr-only">Próximo</span>
        </a>
    </div>
    <!-- Fim do carrossel principal -->

  <!-- Carrossel de Festivais -->
    <div id="festivalCarousel" class="carousel slide mt-5" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <div class="gallery">
                    <div class="festivais">
                        <a href="/festivais/">
                            <img src="https://www.awn.com/sites/default/files/styles/original/public/image/featured/1049546-49th-edition-international-film-festival-rotterdam-runs-january-22-february-2-2020.jpg?itok=11S7c707" alt="International Film Festival Rotterdam">
                            <p>International Film Festival Rotterdam</p>
                        </a>
                    </div>
                    <div class="festivais">
                        <a href="/festivais/">
                            <img src="https://www.olhardecinema.com.br/wp-content/uploads/2018/02/1920x1080berlinale.jpg" alt="68th Berlin International Film Festival">
                            <p>68th Berlin International Film Festival</p>
                        </a>
                    </div>
                    <div class="festivais">
                        <a href="/festivais/">
                            <img src="https://pop.proddigital.com.br/wp-content/uploads/sites/8/2023/08/01-29.jpg" alt="Festival de Gramado">
                            <p>Festival de Gramado</p>
                        </a>
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="gallery">
                    <div class="festivais">
                        <a href="/festivais/">
                            <img src="https://www.interestingfacts.org.uk/wp-content/uploads/2017/05/bafta-logo.jpg.webp" alt="BAFTA">
                            <p>BAFTA</p>
                        </a>
                    </div>
                    <div class="festivais">
                        <a href="/festivais/">
                            <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTq2wHJaYV41eybWjzZT-GeiYEhWtenHOcNgg&s" alt="Festival do Rio">
                            <p>Festival do Rio</p>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#festivalCarousel" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#festivalCarousel" role="button" data-slide="next">
            <span class="sr-only">Próximo</span>
        </a>
    </div>
     <!-- Banner do filme -->
     <div id="bannerFilmes" class="carousel slide banner-carousel" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <h2>Notícias</h2>
                <div class="banner-filme">
                    <img src="https://revistadecinema.com.br/wp-content/uploads/2024/04/amarela-800x445.png" alt="Civil War">
                    <div class="info-filme">
                        <h2>Curta brasileiro “Amarela” concorre à mostra principal do Toronto International Film Festival</h2>
                        <p>O curta-metragem “Amarela”, que disputou a Palma de Ouro de Melhor Curta-Metragem no 77º Festival de Cannes, 
                            foi selecionado para a mostra competitiva Short Cuts do TIFF – Toronto International Film Festival.</p>
                        <!-- <p>Diretor: Alex Garland</p>
                        <p>Roteirista: Alex Garland</p>
                        <p>Elenco: Kirsten Dunst - Wagner Moura - Cailee Spaeny</p> -->
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="banner-filme">
                    <img src="https://s2-g1.glbimg.com/527JJV72hZQQSswxyCjQ494fJOk=/0x0:1024x682/984x0/smart/filters:strip_icc()/i.s3.glbimg.com/v1/AUTH_59edd422c0c84a879bd37670ae4f538a/internal_photos/bs/2024/A/B/HN9PAzQpyfN19RkFoFaA/000-36fb4bf.jpg" alt="Alien: Romulus">
                    <div class="info-filme">
                        <h2>Fernanda Torres ganha prêmio no Critics Choice Awards por 'Ainda Estou Aqui'</h2>
                        <p>O Critics Choice Awards anunciou uma homenagem a Fernanda Torres por seu papel no filme "Ainda Estou Aqui". 
                            A premiação acontece dia 22 de outubro, no Egyptian Theatre, em Hollywood.</p>
                        <!-- <p>Diretor: Fede Alvarez</p>
                        <p>Roteirista: Fede Alvarez - Rodo Sayagues - Dan O'Bannon</p>
                        <p>Elenco: Cailee Spaeny - David Jonsson - Archie Renaux</p> -->
                    </div>
                </div>
            </div>
            <div class="carousel-item">
                <div class="banner-filme">
                    <img src="https://rollingstone.com.br/media/_versions/2024/10/a-substancia-com-demi-moore-e-margaret-qualley-ganha-data-de-estreia-nas-plataformas-digitais_widelg.jpg" alt="Cidade de Deus">
                    <div class="info-filme">
                        <h2>A Substância ganha data de estreia nas plataformas digitais</h2>
                        <p>Após uma passagem de sucesso pelos cinemas, A Substância, longa estrelado por Demi Moore (Proposta Indecente) e Margaret Qualley (Tipos de Gentileza),
                             ganhou data de estreia nas plataformas digitais. Mas quando e onde assistir à novidade?</p>
                        <!-- <p>Diretor: Fernando Meirelles - Kátia Lund</p>
                        <p>Roteirista:Paulo Lins - Bráulio Mantovani</p>
                        <p>Elenco: 
                            Alexandre Rodrigues - Leandro Firmino - Matheus Nachtergaele</p> -->
                    </div>
                </div>
            </div>
        </div>
        <a class="carousel-control-prev" href="#bannerFilmes" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#bannerFilmes" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
        </a>
    </div>
 <div class="container mt-5">
        <h2>Filmes de Destaques  2024</h2>
        <div class="movie-list">
            <img class="movie-poster" src="https://www.justwatch.com/images/poster/320209236/s718/ainda-estou-aqui.jpg" alt="Ainda Estou Aqui">
            <div class="movie-name">
                <h4>Ainda Estou Aqui</h4>
                <p>Diretor:  Walter Salles</p>
                <p>Festivais: Festival de veneza</p>
            </div>
        </div>
        <div class="movie-list">
            <img class="movie-poster" src="https://upload.wikimedia.org/wikipedia/pt/8/86/Anora_%28filme%29.jpg" alt="Anora">
            <div class="movie-name">
                <h4>Anora</h4>
                <p>Diretor: Sean Baker</p>
                <p>Festivais: Festival de Cannes</p>
            </div>
        </div>
        <div class="movie-list">
            <img class="movie-poster" src="https://upload.wikimedia.org/wikipedia/pt/f/ff/The_Substance_poster.jpg" alt="The Substance">
            <div class="movie-name">
                <h4>The Substance</h4>
                <p>Diretor:Coralie Fargeat</p>
                <p>Festivais: Festival de Cannes</p>
            </div>
        </div>
    </div>


    <!-- Incluindo jQuery e Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>