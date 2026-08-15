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

## Seções da página

1. **Hero** — apresentação, `#reisdonorte` e números principais
2. **Quem somos** — missão, campeonatos e movimento
3. **Hall de ídolos** — elenco (Free Fire e Wild Rift)
4. **Rage Cast** — o podcast oficial
5. **Impacto do e-sports** — números do mercado
6. **Comunidade** — Instagram e canais
7. **Parceiro de mídia** — Conexão Amazonas
8. **Benefícios do patrocinador** — 8 frentes de exposição
9. **Planos de patrocínio** — Apoiador, Oficial e Master
10. **Contato** — formulário de proposta e canais diretos

Todo o conteúdo veio da apresentação comercial oficial da equipe.

### Valores dos planos

Os preços **não aparecem no site** — cada plano mostra `R$ ****` com o aviso
"valor sob consulta", mantendo a lista completa de benefícios. A negociação
acontece pela proposta comercial, a partir do formulário de contato.

Para exibir os valores no futuro, troque o bloco `.plan-price.is-masked` de
cada plano no `index.html` por um preço normal.

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
