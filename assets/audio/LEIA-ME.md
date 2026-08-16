# Trilha sonora do site

Coloque aqui o arquivo da música que toca ao abrir o site.

**Arquivo atual:** `rage.mp3` — a faixa **RAGE**, a mesma do clipe oficial.
2 min 2 s, 128 kbps estéreo, 1,9 MB.

O original enviado tinha 4,7 MB a 319 kbps. Como o arquivo baixa junto com
a página, foi recodificado para 128 kbps — 60% menor, qualidade de
streaming. O master original **não fica no repositório**: guarde-o à parte.

Enquanto o arquivo não existir, o player simplesmente **não aparece** — o
site continua funcionando normalmente, sem erro e sem espaço vazio.

## Preparando o arquivo

- **Formato:** MP3 (o que todo navegador entende).
- **Tamanho:** mire em **menos de 3 MB**. Como o arquivo baixa junto com a
  página, um MP3 de 10 MB deixa o site lento no 4G. Para uma faixa de
  três a quatro minutos, exportar a 128 kbps mono costuma resolver.
- **Volume:** exporte já normalizado. O player começa em 35% de volume,
  mas se a faixa estiver estourada na origem vai assustar mesmo assim.
- **Emenda:** a faixa toca em repetição. Se o começo e o fim não casarem,
  o loop fica perceptível.

## Trocando a música ou o nome exibido

Tudo vive em uma linha do `index.html`:

```html
<aside class="trilha" id="player" hidden
	data-fonte="/assets/audio/rage.mp3"
	data-titulo="RAGE">
```

- `data-fonte` — caminho do arquivo
- `data-titulo` — nome que aparece no player

Como são duas músicas autorais, dá para alternar qual toca trocando o
`data-fonte` e o `data-titulo`. A segunda faixa ainda será enviada.
