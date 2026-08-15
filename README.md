# Amazon Rage E-Sports — site oficial

Site institucional e comercial da **Amazon Rage**, organização de e-sports do Amazonas.
Página única, estática, sem etapa de build — pensada para deploy direto no **Netlify**.

## Estrutura

```
index.html            Página principal (todas as seções)
404.html              Página de erro personalizada
netlify.toml          Deploy, cabeçalhos e redirects
robots.txt            Liberação para buscadores
sitemap.xml           Mapa do site
assets/
  css/style.css       Folha de estilo única
  js/main.js          Menu, animações, contadores e envio do formulário
  img/                Logo, favicon, capa social e imagens de fundo
  img/team/           Fotos do elenco
```

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
| Preços e cotas       | `index.html`, seção `#patrocinio`                           |
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
