<?php if (isset($component)) { $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54 = $attributes; } ?>
<?php $component = App\View\Components\AppLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('app-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\AppLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
     <?php $__env->slot('title', null, []); ?> 💖 PARABÉNS, VC CONSEGUIU AMOR! <?php $__env->endSlot(); ?>

    <?php $__env->startPush('styles'); ?>
    <style>
        /* ===== RESET/OVERWRITE ===== */
        body {
            background: #0a0a0a;
            min-height: 100vh;
        }

        /* ===== FUNDO COM IMAGEM ESCURECIDA ===== */
        .amor-bg {
            position: fixed;
            inset: 0;
            z-index: 0;
            background: 
                linear-gradient(rgba(0, 0, 0, 0.8), rgba(0, 0, 0, 0.87)),
                url('<?php echo e(asset('images/fundo_amor.png')); ?>') center/cover no-repeat;
            background-attachment: fixed;
        }

        /* ===== CORAÇÕES PULSANTES (DEGRADÊ VIVO ROSA <-> VERMELHO) ===== */
        .pulsing-hearts {
            position: fixed;
            inset: 0;
            z-index: 0;
            pointer-events: none;
            opacity: 0.15;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: center;
            gap: 40px;
            padding: 40px;
            font-size: 70px;
        }
        .pulsing-hearts span {
            display: inline-block;
            animation: heartPulseColor 3.5s ease-in-out infinite;
            filter: drop-shadow(0 0 10px currentColor);
        }
        @keyframes heartPulseColor {
            0%, 100% {
                transform: scale(1);
                color: #ff3b6f;
                filter: drop-shadow(0 0 15px #ff3b6f);
            }
            50% {
                transform: scale(1.15);
                color: #ff6b9d;
                filter: drop-shadow(0 0 30px #ff6b9d);
            }
        }
        .pulsing-hearts span:nth-child(odd) { animation-delay: 0.2s; }
        .pulsing-hearts span:nth-child(3n) { animation-delay: 0.8s; }
        .pulsing-hearts span:nth-child(5n+2) { animation-delay: 1.4s; }
        .pulsing-hearts span:nth-child(7n+4) { animation-delay: 0.5s; }

        /* ===== LOADING ===== */
        #special-loader {
            position: fixed;
            inset: 0;
            z-index: 99999;
            background: radial-gradient(circle at center, #1a0a0a, #000000 90%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            transition: opacity 1.2s ease;
        }
        #special-loader.hidden {
            opacity: 0;
            pointer-events: none;
        }
        .loader-heart {
            position: relative;
            width: 100px;
            height: 90px;
            animation: heartPulseLoader 1.2s ease-in-out infinite;
        }
        .loader-heart::before,
        .loader-heart::after {
            content: '';
            position: absolute;
            top: 0;
            width: 52px;
            height: 80px;
            background: #ff3b6f;
            border-radius: 50px 50px 0 0;
            box-shadow: 0 0 40px #ff3b6f88;
        }
        .loader-heart::before {
            left: 50px;
            transform: rotate(-45deg);
            transform-origin: 0 100%;
        }
        .loader-heart::after {
            left: 0;
            transform: rotate(45deg);
            transform-origin: 100% 100%;
        }
        @keyframes heartPulseLoader {
            0%, 100% { transform: scale(1); }
            14% { transform: scale(1.2); }
            28% { transform: scale(1); }
            42% { transform: scale(1.15); }
            70% { transform: scale(1); }
        }
        .loader-text {
            margin-top: 50px;
            display: flex;
            gap: 10px;
            font-size: 14px;
            letter-spacing: 0.5em;
            color: #ff6b8a;
            text-transform: uppercase;
            font-weight: 700;
        }
        .loader-text span {
            animation: dotFade 1.4s infinite;
        }
        .loader-text span:nth-child(2) { animation-delay: 0.2s; }
        .loader-text span:nth-child(3) { animation-delay: 0.4s; }
        @keyframes dotFade {
            0%, 80%, 100% { opacity: 0.2; transform: scale(0.8); }
            40% { opacity: 1; transform: scale(1.2); }
        }
        .loader-bar {
            margin-top: 30px;
            width: 200px;
            height: 3px;
            background: rgba(255, 59, 111, 0.2);
            border-radius: 4px;
            overflow: hidden;
            position: relative;
        }
        .loader-bar::after {
            content: '';
            position: absolute;
            left: -50%;
            top: 0;
            width: 50%;
            height: 100%;
            background: linear-gradient(to right, #ff3b6f, #a855f7);
            animation: barSlide 1.8s ease-in-out infinite;
            border-radius: 4px;
        }
        @keyframes barSlide {
            0% { transform: translateX(0); }
            100% { transform: translateX(400%); }
        }

        /* ===== CONTEÚDO PRINCIPAL ===== */
        .amor-content {
            position: relative;
            z-index: 10;
            max-width: 1200px;
            margin: 0 auto;
            padding: 40px 20px 80px;
            opacity: 0;
            transform: translateY(30px);
            animation: fadeUp 1.2s ease forwards;
            animation-delay: 0.5s;
        }
        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ===== HEADER ===== */
        .amor-header {
            text-align: center;
            margin-bottom: 50px;
        }
        .amor-header .logo {
            width: 100px;
            height: 100px;
            margin: 0 auto 20px;
            filter: drop-shadow(0 0 30px rgba(255, 59, 111, 0.4));
            animation: floatLogo 4s ease-in-out infinite;
        }
        @keyframes floatLogo {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-12px); }
        }
        .amor-header .titulo-wrapper {
            display: inline-block;
            background: linear-gradient(145deg, #1a1a1a, #21040b);
            padding: 15px 40px;
            border-radius: 60px;
            box-shadow: 0 8px 30px rgba(184, 11, 11, 0.7);
            border: 2px solid rgba(253, 48, 120, 0.96);
        }
        .amor-header h1 {
            font-size: 3.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #ffffff, #fdf8fd, #fdfdfd);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 0 0 40px rgba(255, 59, 111, 0.2);
            letter-spacing: 2px;
            margin: 0;
        }
        .amor-header .subtitle {
            font-size: 1.2rem;
            color: #ff8ca8;
            letter-spacing: 0.3em;
            text-transform: uppercase;
            border-top: 1px solid rgba(255, 59, 111, 0.2);
            border-bottom: 1px solid rgba(255, 59, 111, 0.2);
            padding: 12px 0;
            display: inline-block;
            margin-top: 15px;
        }

        /* ===== DIV ATENÇÃO ===== */
        .atencao-box {
            background: rgba(20, 10, 10, 0.85);
            backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 59, 111, 0.3);
            border-radius: 24px;
            padding: 30px 40px;
            margin: 0 auto 50px;
            max-width: 800px;
            text-align: center;
            box-shadow: 0 10px 40px rgba(0,0,0,0.6);
        }
        .atencao-box .titulo-azul {
            font-size: 1.8rem;
            font-weight: 900;
            color: #ff3561;
            text-shadow: 0 0 20px rgba(250, 96, 219, 0.3);
            letter-spacing: 3px;
            margin-bottom: 15px;
        }
        .atencao-box p {
            color: #f0d0d0;
            font-size: 1.1rem;
            line-height: 1.8;
        }
        .atencao-box p strong {
            color: #ff6b8a;
        }

        /* ===== GRADE DE CARDS (3 por linha) ===== */
        .cards-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 30px;
            margin-top: 40px;
        }

        /* ===== CARD INDIVIDUAL ===== */
        .personagem-card {
            background: #111;
            border-radius: 20px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.06);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 8px 25px rgba(0,0,0,0.5);
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 25px 20px 30px;
            position: relative;
        }
        .personagem-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 40px rgba(0,0,0,0.7);
        }

        .personagem-card .aura {
            position: absolute;
            inset: -2px;
            border-radius: 20px;
            padding: 2px;
            background: conic-gradient(from var(--angle, 0deg), transparent 30%, var(--aura-color) 50%, transparent 70%);
            -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
            -webkit-mask-composite: xor;
            mask-composite: exclude;
            pointer-events: none;
            animation: rotateAura 6s linear infinite;
            opacity: 0.7;
        }
        @keyframes rotateAura {
            to { --angle: 360deg; }
        }
        .personagem-card .imagem-wrapper {
            width: 100%;
            aspect-ratio: 1/1;
            background: #000;
            border-radius: 12px;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 15px;
            border: 1px solid rgba(255,255,255,0.05);
            position: relative;
            z-index: 1;
        }
        .personagem-card .imagem-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 0 20px var(--aura-color, #fff));
            transition: transform 0.4s ease;
        }
        .personagem-card:hover .imagem-wrapper img {
            transform: scale(1.05);
        }

        .personagem-card .nome-personagem {
            font-size: 1.2rem;
            font-weight: 700;
            color: #eee;
            letter-spacing: 1px;
            margin-bottom: 12px;
            z-index: 1;
            position: relative;
        }
        .personagem-card .btn-inspecionar {
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.15);
            color: #ddd;
            padding: 8px 20px;
            border-radius: 30px;
            font-size: 0.8rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            cursor: pointer;
            z-index: 1;
            position: relative;
            backdrop-filter: blur(4px);
        }
        .personagem-card .btn-inspecionar:hover {
            background: var(--aura-color, #fff);
            color: #000;
            box-shadow: 0 0 20px var(--aura-color, #fff);
            border-color: var(--aura-color, #fff);
        }

        /* ===== MODAL ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 9998;
            background: rgba(0,0,0,0.8);
            backdrop-filter: blur(6px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        .modal-overlay.active {
            display: flex;
        }
        .modal-box {
            background: #1a1a1a;
            border-radius: 28px;
            max-width: 700px;
            width: 100%;
            max-height: 90vh;
            overflow-y: auto;
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 30px 80px rgba(0,0,0,0.8);
            position: relative;
            padding: 30px 30px 40px;
            transform: scale(0.95);
            transition: transform 0.3s ease;
        }
        .modal-overlay.active .modal-box {
            transform: scale(1);
        }
        .modal-close {
            position: absolute;
            top: 16px;
            right: 20px;
            background: rgba(255,255,255,0.06);
            border: none;
            color: #aaa;
            font-size: 1.8rem;
            cursor: pointer;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
            z-index: 10;
        }
        .modal-close:hover {
            background: rgba(255,59,111,0.2);
            color: #fff;
        }

        .modal-conteudo {
            display: flex;
            flex-direction: column;
            gap: 25px;
        }
        .modal-imagem {
            width: 100%;
            max-height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #0a0a0a;
            border-radius: 16px;
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.04);
        }
        .modal-imagem img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            max-height: 250px;
            filter: drop-shadow(0 0 30px var(--aura-color, #fff));
        }

        .modal-texto {
            position: relative;
            padding: 20px;
            border-radius: 16px;
            background: rgba(0,0,0,0.5);
            border: 1px solid rgba(255,255,255,0.04);
            min-height: 150px;
            overflow: hidden;
        }
        .modal-texto .watermark {
            position: absolute;
            right: -30px;
            top: 50%;
            transform: translateY(-50%);
            width: 160px;
            height: 160px;
            background-image: var(--watermark-img);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            opacity: 0.06;
            pointer-events: none;
            filter: grayscale(1);
            z-index: 0;
        }
        .modal-texto .descricao {
            position: relative;
            z-index: 1;
            color: #d4c4c4;
            font-size: 1rem;
            line-height: 1.8;
            white-space: pre-wrap;
        }
        .modal-texto .descricao strong {
            color: var(--aura-color, #ff6b8a);
        }

        /* ===== SCROLL PERSONALIZADO ===== */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: #111; }
        ::-webkit-scrollbar-thumb { background: #ff3b6f; border-radius: 10px; }

        /* ===== RESPONSIVO ===== */
        @media (max-width: 992px) {
            .cards-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 768px) {
            .amor-header h1 { font-size: 2.5rem; }
            .amor-header .titulo-wrapper { padding: 12px 25px; }
            .atencao-box { padding: 20px; }
            .modal-box { padding: 20px; }
        }
        @media (max-width: 550px) {
            .cards-grid { grid-template-columns: 1fr 1fr; gap: 15px; }
            .personagem-card { padding: 15px 10px; }
            .amor-header h1 { font-size: 2rem; }
        }
    </style>
    <?php $__env->stopPush(); ?>

    
    <div class="amor-bg"></div>

    
    <div class="pulsing-hearts">
        <?php for($i = 0; $i < 25; $i++): ?>
            <span>❤️</span>
        <?php endfor; ?>
    </div>

    
    <div id="special-loader">
        <div class="loader-heart"></div>
        <div class="loader-text"><span>•</span><span>•</span><span>•</span></div>
        <div class="loader-bar"></div>
    </div>

    
    <div class="amor-content">

        
        <div class="amor-header">
            <div class="logo">
                <?php if (isset($component)) { $__componentOriginal8892e718f3d0d7a916180885c6f012e7 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal8892e718f3d0d7a916180885c6f012e7 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'components.application-logo','data' => ['class' => 'w-full h-full','style' => 'fill: #ff3b6f; filter: drop-shadow(0 0 10px #ff3b6f);']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('application-logo'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'w-full h-full','style' => 'fill: #ff3b6f; filter: drop-shadow(0 0 10px #ff3b6f);']); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $attributes = $__attributesOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__attributesOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal8892e718f3d0d7a916180885c6f012e7)): ?>
<?php $component = $__componentOriginal8892e718f3d0d7a916180885c6f012e7; ?>
<?php unset($__componentOriginal8892e718f3d0d7a916180885c6f012e7); ?>
<?php endif; ?>
            </div>
            <div class="titulo-wrapper">
                <h1>PARABÉNS, VC CONSEGUIU AMOR!</h1>
            </div>
            <div class="subtitle">✦ ARK • Edição meu amor ✦</div>
        </div>

        
        <div class="atencao-box">
            <div class="titulo-azul">⚠️ ATENÇÃO ⚠️</div>
            <p>
                Oi minha princesa! Bom se você tá lendo isso você conseguiu fazer o enigma, parabéns!!!<br>
                Agora você sabe do pq eu fiquei tantas vezes com sono, isso realmente me tirou algumas noites pq eu tive que esperar você ir dormir... <br>
                Mas eu espero que você goste meu bem!<br><br>
                <strong>ATENÇÃO AMOR:</strong><br>
                Como você acabou de entrar no Ark, você está entrando em um território em que um sentimento pode ser real e isso pode fazer todos os seus sonhos de ser algum personagem saltarem da tela!!!<br>
                A nãoooo acho a já é tarde demais, eles já tão ali embaixo...
            </p>
        </div>

        
        <?php
            $personagens = [
                [
                    'nome' => 'Kuromi',
                    'cor' => '#a855f7',
                    'imagem' => 'icon_kuromi.png',
                    'descricao' => "A Kuromi é a personagem que me faz lembrar mais rápido de você, porque eu te dei de presente várias coisas da Kuromi. Só que desde o segundo ano, que eu te dei aquele moletom e você adorou, eu fiquei com isso na cabeça, porque você me lembra exatamente ela. Principalmente quando você faz aquelas suas brincadeiras ou fica com a cara fechada, que parece muito do mal na hora, porém você está, na verdade, muito fofa, kakaka. E o jeito como você é às vezes... não digo rebelde, mas sim que gosta de tomar suas próprias decisões e bem rápido, sendo bem comovida quando quer. Agora pra comida... meu Deus. Então ela tinha que aparecer, porque simplesmente eu vejo essa personagem e lembro de você, principalmente como você é fofa às vezes, mesmo não querendo ser; acho que é natural. Também lembro porque nas nossas calls, principalmente do Krypta, você fala que adora roxo. E tipo, mano, roxo é uma cor tão boa, não é verdade? Tipo, ela não é exagerada, parece ter um toque de luxo e, ao mesmo tempo, um ar próprio da cor. Sempre enriquecendo quem usa com algum novo estilo. Então eu adoro preto e você adora roxo, além do amarelo né, também. Porém, preto com roxo... olha só, né? KUROMI. Um dos meus sonhos é eu poder acordar e ver meu setup todo montado e, do meu lado, ter a sua área também do quarto, com um setup todo montadinho do seu jeito — que provavelmente será da Kuromi, kakaka, porque ela combina com você, amor.",
                ],
                [
                    'nome' => 'Foxy',
                    'cor' => '#dc2626',
                    'imagem' => 'icon_foxy.png',
                    'descricao' => "Foxy, você deve estar se perguntando por quê? Tipo, por quê? Tanto personagem. Só que tipo, eu gosto muito de FNAF e desde o momento que eu fui massacrado naquele jogo que a gente tinha que montar o top 5, e você acertou o meu de primeira e eu errei tudo até acertar o seu animatronic favorito, ficou na minha cabeça. E você falou do Foxy, o que não era tão inesperado, porém eu achei que ia ser outro porque ele não era muito, muito do seu nicho. Tipo, se você quiser, sai do modal e entra de novo, dá uma olhada nos personagens em volta, kakaka, aí você percebe que tem um Foxy aqui no meio, akakak. Mas sabe o que eu fui parar pra pensar também toda vez que eu vejo agora? Quem foi fantasiada de pirata na escola? Eu acho que é coincidência do destino, porque também, afinal, você estava lindíssima de pirata. Eu acho que eu queria ter o prazer de poder ver de novo. Combina com você e as suas maldades que você gosta de fazer, kakak. Depois que você fez aquela fantasia, assim... eu já olhava muito pra você, porém quando eu vi aquilo também, me senti roubado, porque minha atenção não saía de você. Se você quis roubar algo aquele dia, com certeza funcionou. E olha que eu estava de Ghostface, então você não sabia exatamente para o quê e para quem eu estava olhando, kakakak. Isso torna tudo mais autoexplicativo. Além disso, o Foxy é um personagem que, desde sempre, antes de eu ver o Spring, o Foxy era meu favorito. Ele é um dos que tem mais estilo único e eu adoro isso. Então o fato de você escolher ele me faz admirar muito, porque acho que me lembra eu antigamente. Seu gosto é muito, mas muito bonito, amor, e eu admiro cada escolha sua e também agradeço por ter me escolhido.",
                ],
                [
                    'nome' => 'Triceratops-Fofo',
                    'cor' => '#facc15',
                    'imagem' => 'icon_trike_fofinho.png',
                    'descricao' => "Okk, okk... por que tem um triceratops no meio dos personagens? Então, meio que ele tinha que estar porque ele é o seu dinossauro favorito, e eu preciso obviamente saber, porque você é a minha garota, minha namorada. E como que eu tenho e você também não tem? Lembro que você me disse no dia que a gente saiu e fomos na Ri Happy, foi muito bom. Então toda vez que eu vejo um triceratops, principalmente bebê ou fofo, me lembra você. Porque ele é territorial, gosta de proteger as coisas que gosta e principalmente os seus dinos. Além de que eu fiquei feliz, amor, que você escolheu ele, porque ele também tem uma rivalidade ENORME com o Rex, porque os dois viviam juntos no mesmo período. Então não é só o meu espinossauro que tem rivalidade, você estava tendo e nem sabia, kakak! Ele me lembra você porque você é muito fofinha, e eu acho esse o dino mais fofo e também com a arma mais mortal do mundo, igual você. Quando você fala comigo com aquele tom de raiva, a alma sai mais rápido do corpo do que na montanha-russa! Então, amor, ele me lembra um pouquinho você e, se você fosse um dino, seria ele... e eu tranquilamente seria um triceratops macho e dançaria pra você, kaakKkakk, pra tentar te impressionar.",
                ],
                [
                    'nome' => 'Kemi',
                    'cor' => '#f97316',
                    'imagem' => 'icon_kemi.png',
                    'descricao' => "Tá, a Kemi... apesar de ela não ser uma personagem que você conheça muito, ela lembra exatamente você, tanto até na aparência quanto no jeito. Além de que, quando você falou para mim que o seu amigo tal lá falou que você parecia, eu fiquei com um PUTA ciúmes, mesmo eu não sendo seu namorado, porque como que eu, fã de Ordem, não tinha falado isso para você antes? Meu Deus! Além disso, todos aqueles problemas que eu tenho sobre meu corpo, que eu não preciso citar... uma das minhas grandes metas é eu poder um dia falar que eu sou o seu Eloy. Tipo, eu ia ser muito foda! O Eloy usa uma máscara quando está lutando e está puto, tipo uma focinheira... tipo, mano, eu USARIA muito. Eu quero ser seu homem, seu cachorro violento, e você vai me acalmar. Lembro que muitas vezes nos episódios do Hexatombe ela salvou ele, acho que umas 3 ou 4 vezes direto, e isso reflete muito como você sempre me salvou das minhas crises, ou pelo menos me ouvia e ficava um tempinho comigo nos anos passados e até neste ano. Você me lembra ela porque, tipo... as tranças são uma qualidade muito foda sua! Eu acho que combina demais, eu acho você muito, muito, muito bonita e empoderada com essas tranças, simplesmente incrível com elas. Eu sou apaixonado em te ver com elas. Além disso, eles dois me lembram muito uma cena que você fez comigo, que foi praticamente igual. Tipo, eu estava falando uma coisa com medo de ter te deixado brava ou triste, falando: O que você quer fazer?, e você meteu a mão em um lugar aí... literalmente no Hexatombe acontece a mesma coisa com eles dois, eu acho isso muito engraçado. Antes de ter me acostumado e me empolgado com você, o fato de você achar que é uma loba antes me assustava... agora eu acho que já domei essa loba aí, ou eu virei o caçador agora, meu amor.",
                ],
                [
                    'nome' => 'Clawdeen',
                    'cor' => '#78350f',
                    'imagem' => 'icon_clawdeen.png',
                    'descricao' => "Clawdeen... falando em loba, no caso, ela me lembra muito, muito você! Tipo, é a sua cara. Quando você me mostrou e falou, claramente tinha que ter dado você no teste. Quando eu vejo ela, eu lembro de você toda, como você é e o seu jeito. Não de personalidade, porque eu só vi um filme de Monster High na minha vida, mas sim, estou falando do jeito de ser gostosa, de ser um mulherão, amor. Essa sua essência toda de Loba que você tanto fala, eu realmente no começo senti medo... estava achando que ia ser devorado, mano! Esse seu jeito de chegar, toda bonita... uma mera aparição em algum lugar ou na escola já afeta todo mundo. Todos querem falar com você, todos têm uma fofoca pra te contar, enquanto isso eu vejo e fico, ao mesmo tempo, com inveja de eles terem a sua atenção, porque eu queria ela toda para mim. Fico admirando como minha mulher é incrível. Além disso, acho que você combina bem mais com essa temática do que com vampira. Você dá de 10 a 0 com esse estilo seu aí e a vibe que você passa. O jeito como você é pidona também... admito que eu sou mais, porém por você mesmo só. Esse jeito supera muito ao que você antes estava falando comigo, principalmente quando a gente estava falando sobre esse assunto, que falar de vampiro estava estragando um pouco porque lembrava outra pessoa. Amor, nossas pegadas normalmente são com a boca, nossa saliva, nossos dentes... cada mordida, cada gemido e agarrão são perfeitos.",
                ],
                [
                    'nome' => 'Tiana',
                    'cor' => '#22c55e',
                    'imagem' => 'icon_tiana.png',
                    'descricao' => "Tiana, de A Princesa e o Sapo. Bom, eu preciso dizer? Simplesmente a sua princesa. Eu não vou falar da personagem porque já é bem óbvio, e também não gosto de falar de outras princesas, porque a minha já é bem melhor que as outras... eu não preciso saber das outras, kakaka! Ela me vê todo dia na escola, ela canta pra mim às vezes, ela é doce, ela se importa com as pessoas, ela se importa comigo. Essa princesa brilha bem mais que as outras e, não importa o problema, ela está se levantando. Ela espanta os meus tormentos, e meu sonho é ter um final feliz com ela... é, eu estou falando de você, acho que escapou sem querer. Amor, o dia que você esteve com aquela roupa no seu aniversário, mano, que LINDEZA! Você estava extraordinária, você estava incrível! Você já é, porém eu nunca vi alguém tão próximo de ser uma princesa na minha vida do que naquela situação. Eu lembro dessa personagem por ela ter um jeito de agir um pouco igual ao seu; eu lembro das cores que simplesmente moldam aquele dia do seu aniversário; eu lembro dela porque foi naquele dia do seu aniversário que eu fiquei sabendo de uma informação que, se eu tivesse descoberto antes, seria bem mais cedo todo esse momento que estamos vivendo. Essa personagem me lembra você porque, a cada dia que passa, o sentimento de querer te dar o mundo e criar para você um final feliz aumenta. Ela me lembra você porque eu fico admirado com quanta resiliência você tem dentro de casa. Eu fico em choque em como você não surta, com as coisas que você cede... mas agora eu sempre vou estar aqui para você se apoiar. Eu te amo, meu amor. Literamente tudo dessa personagem me lembra você. E eu quero que você seja a minha princesa, para sempre...",
                ],
            ];
        ?>

        <div class="cards-grid">
            <?php $__currentLoopData = $personagens; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="personagem-card" style="--aura-color: <?php echo e($p['cor']); ?>;">
                    <div class="aura"></div>
                    <div class="imagem-wrapper">
                        <img src="<?php echo e(asset('images/'.$p['imagem'])); ?>" alt="<?php echo e($p['nome']); ?>" loading="lazy">
                    </div>
                    <div class="nome-personagem"><?php echo e($p['nome']); ?></div>
                    <button class="btn-inspecionar" onclick="abrirModal(<?php echo e($index); ?>)">
                        Inspecionar Ficha
                    </button>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    
    <div id="modal-overlay" class="modal-overlay">
        <div class="modal-box">
            <button class="modal-close" onclick="fecharModal()">✕</button>
            <div class="modal-conteudo">
                <div class="modal-imagem">
                    <img id="modal-img" src="" alt="Personagem" style="--aura-color: #fff;">
                </div>
                <div class="modal-texto" id="modal-texto-wrapper">
                    <div class="watermark" id="modal-watermark"></div>
                    <div class="descricao" id="modal-descricao"></div>
                </div>
            </div>
        </div>
    </div>

    
    <?php $__env->startPush('scripts'); ?>
    <script>
        // ===== LOADING =====
        window.addEventListener('load', () => {
            const loader = document.getElementById('special-loader');
            setTimeout(() => {
                loader.classList.add('hidden');
            }, 2500);
        });

        // ===== PARTÍCULAS DE CORAÇÃO NO MOUSE =====
        (function heartParticles() {
            const body = document.body;
            let timeoutId = null;
            let lastX = 0, lastY = 0;

            function createHeart(x, y) {
                const heart = document.createElement('span');
                heart.className = 'heart-particle';
                heart.textContent = ['❤️', '💖', '💗', '💝', '♥️'][Math.floor(Math.random() * 5)];
                const size = 18 + Math.random() * 20;
                heart.style.fontSize = size + 'px';
                heart.style.left = x + 'px';
                heart.style.top = y + 'px';
                heart.style.position = 'fixed';
                heart.style.pointerEvents = 'none';
                heart.style.zIndex = '9999';
                heart.style.transform = 'translate(-50%, -50%)';
                heart.style.animation = 'heartFly 1.8s ease-out forwards';
                heart.style.opacity = '0';
                heart.style.filter = 'drop-shadow(0 0 6px rgba(255, 59, 111, 0.6))';

                const angle = Math.random() * Math.PI * 2;
                const distance = 60 + Math.random() * 80;
                const tx = Math.cos(angle) * distance;
                const ty = Math.sin(angle) * distance - 30;
                heart.style.setProperty('--tx', tx + 'px');
                heart.style.setProperty('--ty', ty + 'px');

                const dur = 1.2 + Math.random() * 1.0;
                heart.style.animationDuration = dur + 's';

                body.appendChild(heart);
                setTimeout(() => heart.remove(), dur * 1000 + 100);
            }

            document.addEventListener('mousemove', (e) => {
                const x = e.clientX;
                const y = e.clientY;
                if (timeoutId) return;
                timeoutId = setTimeout(() => { timeoutId = null; }, 25);
                const dx = x - lastX, dy = y - lastY;
                if (Math.sqrt(dx*dx + dy*dy) < 5) return;
                lastX = x; lastY = y;
                const count = 1 + Math.floor(Math.random() * 2);
                for (let i = 0; i < count; i++) {
                    createHeart(x + (Math.random()-0.5)*20, y + (Math.random()-0.5)*20);
                }
            });

            document.addEventListener('touchmove', (e) => {
                const touch = e.touches[0];
                if (touch) createHeart(touch.clientX, touch.clientY);
            }, { passive: true });
        })();

        // ===== DADOS DOS PERSONAGENS (passados do PHP para JS) =====
        const personagens = <?php echo json_encode($personagens, 15, 512) ?>;

        // ===== FUNÇÕES DO MODAL =====
        function abrirModal(index) {
            const p = personagens[index];
            if (!p) return;

            const overlay = document.getElementById('modal-overlay');
            const img = document.getElementById('modal-img');
            const desc = document.getElementById('modal-descricao');
            const watermark = document.getElementById('modal-watermark');

            // Monta caminho da imagem
            const imgPath = '<?php echo e(asset('images/')); ?>' + '/' + p.imagem;

            img.src = imgPath;
            img.alt = p.nome;
            img.style.setProperty('--aura-color', p.cor);

            desc.textContent = p.descricao; // ou innerHTML se quiser tags
            desc.style.setProperty('--aura-color', p.cor);

            // Marca d'água
            watermark.style.setProperty('--watermark-img', 'url(' + imgPath + ')');

            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function fecharModal() {
            const overlay = document.getElementById('modal-overlay');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        // Fechar modal ao clicar fora da caixa
        document.getElementById('modal-overlay').addEventListener('click', function(e) {
            if (e.target === this) fecharModal();
        });

        // Fechar com tecla ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') fecharModal();
        });
    </script>
    <?php $__env->stopPush(); ?>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $attributes = $__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__attributesOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54)): ?>
<?php $component = $__componentOriginal9ac128a9029c0e4701924bd2d73d7f54; ?>
<?php unset($__componentOriginal9ac128a9029c0e4701924bd2d73d7f54); ?>
<?php endif; ?><?php /**PATH C:\Users\vinig\OneDrive\Documentos\GitHub\Ark-RPG\resources\views/amor.blade.php ENDPATH**/ ?>