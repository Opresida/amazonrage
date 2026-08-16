# Amazon Rage E-Sports — site oficial

Site institucional e comercial da **Amazon Rage**, organização de e-sports do Amazonas.
Página única, estática, sem etapa de build — pensada para deploy direto no **Netlify**.

## Estrutura

```
index.html            Página principal (todas as seções)
404.html              Página de erro personalizada
netlify.toml          Deploy, cabeçalhos e redirects
site.webmanifest      Nome, cores e ícones ao salvar na tela inicial
robots.txt            Liberação para buscadores
sitemap.xml           Mapa do site
assets/
  css/style.css       Folha de estilo única
  js/main.js          Menu, loader, efeitos, contadores e envio do formulário
  fonts/              Chakra Petch e Barlow auto-hospedadas
  img/                Logo, ícones, capa social e imagens de fundo
  img/team/           Fotos do elenco
```

## Ícones e capa social

O favicon é uma marca própria, simplificada a partir do escudo — o logo
completo vira uma mancha verde em 16 px. A geometria vive em
`assets/img/favicon.svg` e os PNG/ICO saem dela:

| Arquivo                  | Uso                                        |
| ------------------------ | ------------------------------------------ |
| `favicon.svg`            | Navegadores modernos, escala perfeita      |
| `favicon.ico`            | 16/32/48 px, navegadores antigos           |
| `apple-touch-icon.png`   | 180 px, atalho no iOS                      |
| `icon-192/512.png`       | Manifest e Android                         |
| `icon-maskable-512.png`  | Android adaptativo, com área de segurança  |
| `og-cover.jpg`           | 1200×630, preview em WhatsApp/Instagram/X  |

Ao trocar a capa social, mantenha 1200×630 e teste o resultado no
[Facebook Sharing Debugger](https://developers.facebook.com/tools/debug/)
— as redes guardam o preview em cache por dias.

## Tela de carregamento

Dura **3,5 segundos** e sai sozinha. A saída é feita por animação CSS com
atraso, não por JavaScript: se o script falhar, a tela some do mesmo jeito.
O JS só anima o contador de porcentagem.

- Duração: variável `--preloader-time` em `.preloader` no `style.css`
- Clique, `Esc`, `Enter` ou espaço pulam a espera
- Com `prefers-reduced-motion` a tela sai quase imediatamente

Vale lembrar: 3,5 s é bastante tempo para quem chega pela primeira vez. Se
o time notar queda no contato, reduzir para 1,5–2 s costuma resolver.

## RageMatch — placar das partidas

Seção `#ragematch`, com o narrador em destaque e a lista de partidas.
Cada jogo é um `<article class="match">`. Para adicionar outro, duplique o
bloco e troque:

| O que | Onde |
| ----- | ---- |
| Formato | `.match-format` (MD1, MD3, MD5…) |
| Modalidade e campeonato | `.match-mode` |
| Situação | `.match-state` (use `is-title` num título) |
| Destaque do card | classe `match-title` no `<article>` |
| Times | `.side-crest img` e o `<h3>` de cada lado |
| Placar | os dois `<b>` dentro de `.match-score` |
| Vencedor | classe `is-win` no `<b>` que venceu |
| Selos | `.side-badge` (use `is-muted` no time visitante) |
| Vídeo | `data-video` no botão "Assistir a partida" |

O `.sr-only` dentro do placar existe para leitores de tela — o "2 × 0"
visual não é lido de forma compreensível, então há uma versão em texto.

### Destaques e card de compartilhamento

O botão **Ver mais detalhes** é um `<details>` nativo do HTML: abre e fecha
sozinho, sem JavaScript. Dentro dele fica um `<article class="mvp">` por
jogo da série, com foto, nome e os três números.

O botão **Compartilhar card** gera um **JPEG 1080×1080** no próprio
navegador, com canvas — não há servidor nem serviço externo envolvido:

- no celular abre a bandeja de compartilhamento do sistema (Instagram,
  WhatsApp, etc.) via Web Share API;
- no computador, onde essa API não aceita arquivos, o card é baixado.

Os dados do card são **lidos do próprio HTML** do destaque — nome, jogo,
foto e os três números. Não existe lista duplicada em JavaScript: editar o
HTML já muda o card gerado. O nome diminui de corpo sozinho se for longo.

A arte fica em `desenharCard()` no `main.js`. As fotos precisam estar no
mesmo domínio, senão o navegador bloqueia a exportação do canvas.

Fotos dos destaques ficam em `assets/img/mvp/`, quadradas, 640 px.

### Escudos dos times convidados

Ficam em `assets/img/teams/`. A logo da Fera veio como PNG branco sobre
fundo preto estrelado; o fundo foi convertido em transparência pelo
brilho e os respingos de estrela removidos por tamanho de mancha. A do
Manaus FC é colorida e tem contornos pretos por dentro, então o recorte
foi por preenchimento a partir das bordas, parando no contorno claro do
escudo. Para um novo time, o ideal é pedir o arquivo já com fundo
transparente.

Os escudos chegam em proporções bem diferentes — o da Fera é largo, o do
Manaus é alto. A caixa `.side-crest` usa medida absoluta e `object-fit`
justamente para que todos ocupem o mesmo espaço no placar.

## Carrossel de episódios do Rage Cast

Fica dentro da seção `#ragecast`, logo abaixo do texto. Gira sozinho, em
loop contínuo, e pausa quando o mouse entra, quando algo recebe foco pelo
teclado ou quando o visitante clica em **Pausar giro**.

### Trocar ou adicionar um episódio

Cada card é um `<button class="ep">` no `index.html`. Só dois valores
importam — o resto é automático:

```html
<button class="ep" type="button" data-video="JS6_V7fWRos" data-title="Episódio 01">
	<img src="https://i.ytimg.com/vi/JS6_V7fWRos/hqdefault.jpg" ...>
	...
	<span class="ep-title">Episódio 01</span>
</button>
```

- `data-video` e o `src` da miniatura usam o **ID do vídeo no YouTube** —
  é o trecho depois de `youtu.be/`, `watch?v=` ou `/live/`.
  Em `youtube.com/live/JS6_V7fWRos?is=...` o ID é `JS6_V7fWRos`.
- `data-title` e `.ep-title` são o nome exibido. Os episódios estão
  numerados de 01 a 08 na ordem em que foram enviados — troque pelos
  títulos reais quando quiser.

Não há limite de quantidade: o JavaScript duplica a fita sozinho para o
giro emendar sem salto.

### Como o vídeo abre

Nada do YouTube carrega antes de alguém clicar — a página mostra só a
miniatura. Ao clicar, o player abre numa sobreposição usando o domínio
`youtube-nocookie.com`. Ao fechar (`Esc`, botão ✕ ou clique fora), o
iframe é destruído, o que interrompe a reprodução.

## Trilha sonora

Player flutuante no canto inferior esquerdo, com play/pause, volume e
mudo. O arquivo vai em `assets/audio/` — veja o `LEIA-ME.md` de lá.

**Sobre tocar sozinho ao abrir:** nenhum navegador permite áudio com som
antes de o visitante interagir com a página. Não há como contornar. O que
o site faz:

1. tenta tocar assim que o áudio carrega;
2. se o navegador barrar, mostra "Clique para ouvir" e engata no primeiro
   clique ou tecla — inclusive o clique que pula a tela de carregamento;
3. quem pausar não é surpreendido na visita seguinte: a escolha fica
   guardada, junto com volume e mudo.

Dois cuidados que já estão resolvidos:

- Abrir um vídeo (RageMatch, Rage Cast ou o clipe) **pausa a trilha** e a
  retoma ao fechar — nunca dois áudios ao mesmo tempo.
- Se o arquivo não existir, o player **não aparece**.

## Efeitos de ambiente

Todos desligam sozinhos com `prefers-reduced-motion`, e os que dependem do
cursor só rodam em telas com mouse (`hover: hover`):

| Efeito                    | Onde                                     |
| ------------------------- | ---------------------------------------- |
| Barra de progresso        | Topo da página, acompanha a rolagem      |
| Scanlines                 | Textura fina sobre todo o site           |
| Holofote do cursor        | Dentro do hero                           |
| Falha de sinal (glitch)   | "Rage" no hero e no nome do loader       |
| Decodificação de texto    | Legendas de seção ao entrarem na tela    |
| Inclinação 3D             | Cards do elenco                          |
| Brilho no cursor          | Todos os botões                          |
| Profundidade na rolagem   | Escudo e fundo do hero                   |
| Contadores                | Números do hero, impacto e mídia         |
| Carrossel em loop         | Episódios do Rage Cast                   |

## Seções da página

1. **Hero** — apresentação, `#reisdonorte` e números principais
2. **Quem somos** — missão, campeonatos e movimento
3. **Hall de ídolos** — elenco (Free Fire e Wild Rift)
4. **RageMatch** — amistosos narrados e placar das partidas
5. **Rage Cast** — o podcast oficial
6. **Música** — clipe oficial e as faixas autorais
7. **Impacto do e-sports** — números do mercado
8. **Comunidade** — Instagram e canais
9. **Parceiro de mídia** — Conexão Amazonas
10. **Benefícios do patrocinador** — 8 frentes de exposição
11. **Planos de patrocínio** — Apoiador, Oficial e Master
12. **Perguntas frequentes**
13. **Contato** — formulário de proposta e canais diretos

Todo o conteúdo veio da apresentação comercial oficial da equipe.

### Valores dos planos

Os preços **não aparecem no site** — cada plano mostra `R$ ****` com o aviso
"valor sob consulta", mantendo a lista completa de benefícios. A negociação
acontece pela proposta comercial, a partir do formulário de contato.

Para exibir os valores no futuro, troque o bloco `.plan-price.is-masked` de
cada plano no `index.html` por um preço normal.

## SEO

Termos-alvo: **Amazon Rage**, **Reis do Norte**, **e-sports Manaus**,
**e-sports Amazonas**.

### O que está feito na página

| Item | Onde |
| ---- | ---- |
| Título e descrição com marca, apelido e cidade | `<head>` |
| `robots` com `max-image-preview:large` | `<head>` |
| `geo.region` / `geo.placename` | `<head>` |
| Dados estruturados em `@graph` | bloco JSON-LD no `<head>` |
| Perguntas frequentes | seção `#faq` + `FAQPage` no JSON-LD |
| H1 com complemento para leitores e buscadores | `.sr-only` dentro do `<h1>` |
| Sitemap com imagens | `sitemap.xml` |
| Open Graph e Twitter completos | `<head>` |

O JSON-LD é um `@graph` com cinco entidades ligadas por `@id`:
`SportsOrganization`, `WebSite`, `WebPage`, `PodcastSeries` e `FAQPage`.

**Regra importante:** o texto das perguntas no HTML e no `FAQPage` precisa
ser **idêntico**. O Google compara os dois e desconsidera a marcação quando
divergem. Ao editar uma pergunta, edite nos dois lugares.

Só entram no schema fatos confirmados pela equipe — sem data de fundação,
sem canais não informados, sem números inventados.

### Desempenho

Velocidade conta como sinal de posicionamento. O que foi feito:

- Todas as fotos têm versão **WebP**, servida por `<picture>` com o JPEG
  como reserva. Os fundos em CSS usam `image-set()` dentro de `@supports`,
  então navegador antigo continua recebendo o JPEG.
- A logo foi reduzida de 320 KB para 138 KB (paleta), e a versão WebP tem
  33 KB. Ela aparece no cabeçalho, no topo, no rodapé e no carregamento.
- O fundo do topo é pré-carregado com `fetchpriority="high"`.

Resultado medido no Chromium: LCP caiu de **1,34 s para 0,94 s**, e o
conjunto de imagens ficou **43% mais leve**.

### O que depende de vocês (fora do site)

Código sozinho não coloca ninguém em primeiro lugar. Falta:

1. **Google Search Console** — cadastrar o site e enviar o `sitemap.xml`.
   É o que faz o Google descobrir a página em dias, não em semanas.
2. **Perfil da Empresa no Google** — decisivo para "e-sports Manaus".
   Sem ele, quem pesquisa por cidade dificilmente encontra o site.
3. **Links apontando para o site** — a assinatura do Instagram, a
   descrição dos vídeos no YouTube, o portal Conexão Amazonas, páginas dos
   campeonatos disputados. É o fator que mais pesa nos termos genéricos.
4. **Domínio próprio** — `amazonrage.com` passa mais autoridade que um
   endereço `.netlify.app`.
5. **Conteúdo novo com regularidade** — cada RageMatch e cada episódio do
   Rage Cast publicados aqui dão ao Google motivo para voltar.

## Rodando localmente

Não há dependências nem build. Basta servir a pasta:

```bash
python3 -m http.server 8000
# depois abra http://localhost:8000
```

Abrir o `index.html` direto pelo `file://` também funciona, mas os caminhos
absolutos (`/assets/...`) só resolvem corretamente sob um servidor.

## Deploy no Netlify

1. No painel do Netlify: **Add new site → Import an existing project → GitHub**
2. Selecione o repositório `Opresida/amazonrage`
3. Confirme as configurações — o `netlify.toml` já define tudo:
   - **Build command:** vazio
   - **Publish directory:** `.`
4. **Deploy**

Cada push na branch de produção gera um novo deploy automaticamente.

### Formulário de patrocínio

O formulário usa **Netlify Forms**: o atributo `data-netlify="true"` no
`<form name="patrocinio">` faz o Netlify detectar e registrar os envios no
deploy. As mensagens aparecem em **Site configuration → Forms**.

Para receber por e-mail, configure em **Forms → Form notifications →
Email notification** apontando para `contato@amazonrage.com`.

O campo `bot-field` é um honeypot anti-spam e fica escondido por CSS.

### Domínio próprio

O site foi escrito com a URL provisória `https://amazonrage.netlify.app`.
Ao apontar um domínio definitivo, atualize as referências em:

- `index.html` — `<link rel="canonical">`, tags `og:url` e `og:image`, e o bloco JSON-LD
- `robots.txt` — linha `Sitemap:`
- `sitemap.xml` — tag `<loc>`

### Atalhos já configurados

| Caminho      | Destino                          |
| ------------ | -------------------------------- |
| `/instagram` | Instagram oficial                |
| `/whatsapp`  | WhatsApp comercial               |
| `/podcast`   | Instagram do Rage Cast           |
| `/patrocinio`| Âncora dos planos na home        |

Úteis para bio, flyers e QR codes.

## Manutenção rápida

| O que mudar          | Onde                                                       |
| -------------------- | ---------------------------------------------------------- |
| Cotas dos planos     | `index.html`, seção `#patrocinio`                           |
| Elenco               | `index.html`, seção `#elenco` + fotos em `assets/img/team/` |
| Números do hero      | Atributos `data-count` no `index.html`                      |
| Cores da marca       | Variáveis `--green`, `--lime` no topo do `style.css`         |
| Contatos             | Seção `#contato`, rodapé e `netlify.toml`                    |

As fotos do elenco são quadradas (~595 px) e exibidas em proporção 3:4 com
recorte automático. Para trocar, mantenha o mesmo nome de arquivo.

## Notas técnicas

- Sem framework e sem dependências: apenas HTML, CSS e JavaScript.
- Fontes **auto-hospedadas** em `assets/fonts/` (Chakra Petch + Barlow, SIL
  Open Font License). Sem chamada a CDN de terceiros: carrega mais rápido,
  não vaza IP dos visitantes e não quebra em rede com bloqueio.
- Animações respeitam `prefers-reduced-motion`.
- Cabeçalhos de segurança configurados no `netlify.toml`. Uma
  `Content-Security-Policy` não foi incluída porque o bloco JSON-LD inline
  exigiria hash fixo — vale adicionar se o conteúdo estabilizar.
