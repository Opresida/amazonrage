/* =============================================================
   Amazon Rage E-Sports — comportamentos da página
   ============================================================= */
(function () {
	"use strict";

	var header = document.querySelector(".site-header");
	var nav = document.getElementById("nav");
	var toggle = document.getElementById("navToggle");

	var calmo = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
	var mousePreciso = window.matchMedia("(hover: hover) and (pointer: fine)").matches;

	/* ---------------------------------------- tela de carregamento
	   A saída fica por conta do CSS. Aqui só animamos o contador e
	   liberamos o atalho para quem não quer esperar. */

	var preloader = document.getElementById("preloader");

	if (preloader) {
		var pct = document.getElementById("preloaderPct");
		var duracao = calmo ? 200 : 3500;
		var inicio = null;

		(function conta(agora) {
			if (inicio === null) inicio = agora;
			var p = Math.min((agora - inicio) / duracao, 1);
			pct.textContent = String(Math.round(p * 100));
			if (p < 1) requestAnimationFrame(conta);
		})(performance.now());

		var pular = function () {
			pct.textContent = "100";
			preloader.classList.add("is-done");
			document.removeEventListener("keydown", aoTeclar);
		};
		var aoTeclar = function (e) {
			if (e.key === "Enter" || e.key === "Escape" || e.key === " ") pular();
		};

		preloader.addEventListener("click", pular);
		document.addEventListener("keydown", aoTeclar);
		setTimeout(function () { document.removeEventListener("keydown", aoTeclar); }, duracao + 700);
	}

	/* ---------------------------------------- header fixo + progresso */

	var scrollBar = document.getElementById("scrollBar");
	var pendente = false;

	function aoRolar() {
		header.classList.toggle("is-stuck", window.scrollY > 40);

		if (scrollBar) {
			var total = document.documentElement.scrollHeight - window.innerHeight;
			scrollBar.style.width = (total > 0 ? (window.scrollY / total) * 100 : 0) + "%";
		}

		if (!calmo) parallaxHero();
	}

	function onScroll() {
		if (pendente) return;
		pendente = true;
		requestAnimationFrame(function () {
			pendente = false;
			aoRolar();
		});
	}

	/* ---------------------------------------- profundidade no hero */

	var crest = document.querySelector(".hero-crest");
	var heroBg = document.querySelector(".hero-bg");

	function parallaxHero() {
		var y = window.scrollY;
		if (y > window.innerHeight) return;
		if (crest) crest.style.transform = "translateY(" + y * .16 + "px)";
		if (heroBg) heroBg.style.transform = "translateY(" + y * .06 + "px)";
	}

	aoRolar();
	window.addEventListener("scroll", onScroll, { passive: true });

	/* ---------------------------------------- menu mobile */

	function closeNav() {
		nav.classList.remove("is-open");
		document.body.classList.remove("nav-open");
		toggle.setAttribute("aria-expanded", "false");
		toggle.setAttribute("aria-label", "Abrir menu");
	}

	toggle.addEventListener("click", function () {
		var open = nav.classList.toggle("is-open");
		document.body.classList.toggle("nav-open", open);
		toggle.setAttribute("aria-expanded", String(open));
		toggle.setAttribute("aria-label", open ? "Fechar menu" : "Abrir menu");
	});

	nav.addEventListener("click", function (e) {
		if (e.target.closest("a")) closeNav();
	});

	document.addEventListener("keydown", function (e) {
		if (e.key === "Escape" && nav.classList.contains("is-open")) {
			closeNav();
			toggle.focus();
		}
	});

	/* ---------------------------------------- link ativo conforme a rolagem */

	var navLinks = Array.prototype.slice.call(nav.querySelectorAll('a[href^="#"]:not(.btn)'));
	var sections = navLinks
		.map(function (link) { return document.querySelector(link.getAttribute("href")); })
		.filter(Boolean);

	if ("IntersectionObserver" in window && sections.length) {
		var spy = new IntersectionObserver(function (entries) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				navLinks.forEach(function (link) {
					link.classList.toggle("is-active", link.getAttribute("href") === "#" + entry.target.id);
				});
			});
		}, { rootMargin: "-45% 0px -50% 0px" });

		sections.forEach(function (section) { spy.observe(section); });
	}

	/* ---------------------------------------- entrada dos blocos */

	var revealables = document.querySelectorAll(".reveal");

	if ("IntersectionObserver" in window) {
		var appear = new IntersectionObserver(function (entries, observer) {
			entries.forEach(function (entry, i) {
				if (!entry.isIntersecting) return;
				setTimeout(function () { entry.target.classList.add("is-visible"); }, i * 80);
				observer.unobserve(entry.target);
			});
		}, { rootMargin: "0px 0px -12% 0px", threshold: .12 });

		revealables.forEach(function (el) { appear.observe(el); });
	} else {
		revealables.forEach(function (el) { el.classList.add("is-visible"); });
	}

	/* ---------------------------------------- contadores */

	function format(el, value) {
		var prefix = el.dataset.prefix || "";
		var suffix = el.dataset.suffix || "";
		var body = el.dataset.raw === "true" ? String(value) : value.toLocaleString("pt-BR");
		el.textContent = prefix + body + suffix;
	}

	function countUp(el) {
		var target = Number(el.dataset.count);
		var reduced = window.matchMedia("(prefers-reduced-motion: reduce)").matches;

		if (reduced || !Number.isFinite(target)) {
			format(el, target);
			return;
		}

		var duration = 1500;
		var start = null;

		function step(now) {
			if (start === null) start = now;
			var progress = Math.min((now - start) / duration, 1);
			var eased = 1 - Math.pow(1 - progress, 3);
			format(el, Math.round(target * eased));
			if (progress < 1) requestAnimationFrame(step);
		}

		requestAnimationFrame(step);
	}

	var counters = document.querySelectorAll("[data-count]");

	if ("IntersectionObserver" in window) {
		var counterObserver = new IntersectionObserver(function (entries, observer) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				countUp(entry.target);
				observer.unobserve(entry.target);
			});
		}, { threshold: .5 });

		counters.forEach(function (el) { counterObserver.observe(el); });
	} else {
		counters.forEach(function (el) { format(el, Number(el.dataset.count)); });
	}

	/* ---------------------------------------- embaralhar as legendas de seção
	   As legendas ("01 — Quem somos") se montam letra a letra ao entrar na
	   tela, como um terminal decifrando o texto. */

	var CARACTERES = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789/\\<>*#$%&";

	function embaralhar(el) {
		var texto = el.textContent;
		var quadro = 0;
		var passos = texto.length * 3 + 12;

		function tick() {
			var saida = "";
			for (var i = 0; i < texto.length; i++) {
				var revelaEm = i * 3;
				if (texto[i] === " " || quadro >= revelaEm + 6) {
					saida += texto[i];
				} else if (quadro >= revelaEm) {
					saida += CARACTERES[Math.floor(Math.random() * CARACTERES.length)];
				}
			}
			el.textContent = saida;
			if (++quadro <= passos) setTimeout(tick, 28);
			else el.textContent = texto;
		}

		tick();
	}

	if (!calmo && "IntersectionObserver" in window) {
		var scrambler = new IntersectionObserver(function (entries, observer) {
			entries.forEach(function (entry) {
				if (!entry.isIntersecting) return;
				embaralhar(entry.target);
				observer.unobserve(entry.target);
			});
		}, { threshold: .9 });

		document.querySelectorAll(".eyebrow").forEach(function (el) { scrambler.observe(el); });
	}

	/* ---------------------------------------- reações ao cursor */

	if (mousePreciso && !calmo) {
		// holofote do hero
		var hero = document.querySelector(".hero");
		var spotlight = document.querySelector(".hero-spotlight");

		if (hero && spotlight) {
			hero.addEventListener("mousemove", function (e) {
				var r = hero.getBoundingClientRect();
				spotlight.style.setProperty("--mx", ((e.clientX - r.left) / r.width) * 100 + "%");
				spotlight.style.setProperty("--my", ((e.clientY - r.top) / r.height) * 100 + "%");
			}, { passive: true });
		}

		// brilho seguindo o cursor dentro dos botões
		document.querySelectorAll(".btn").forEach(function (btn) {
			btn.addEventListener("mousemove", function (e) {
				var r = btn.getBoundingClientRect();
				btn.style.setProperty("--mx", e.clientX - r.left + "px");
				btn.style.setProperty("--my", e.clientY - r.top + "px");
			}, { passive: true });
		});

		// inclinação 3D nos cards do elenco
		document.querySelectorAll(".player").forEach(function (card) {
			card.addEventListener("mousemove", function (e) {
				var r = card.getBoundingClientRect();
				var px = (e.clientX - r.left) / r.width - .5;
				var py = (e.clientY - r.top) / r.height - .5;
				card.style.setProperty("--ry", px * 12 + "deg");
				card.style.setProperty("--rx", -py * 12 + "deg");
			}, { passive: true });

			card.addEventListener("mouseleave", function () {
				card.style.setProperty("--ry", "0deg");
				card.style.setProperty("--rx", "0deg");
			});
		});
	}

	/* ---------------------------------------- carrossel de episódios
	   A fita é clonada uma vez para o giro emendar sem salto. O clone fica
	   fora da leitura de tela e fora da navegação por teclado. */

	var belt = document.getElementById("reelBelt");
	var reelToggle = document.getElementById("reelToggle");

	if (belt) {
		var trilha = belt.querySelector(".reel-track");
		var clone = trilha.cloneNode(true);
		clone.setAttribute("aria-hidden", "true");
		clone.querySelectorAll("button").forEach(function (b) { b.tabIndex = -1; });
		belt.appendChild(clone);
		if (!calmo) belt.classList.add("is-looping");
	}

	if (reelToggle && belt) {
		reelToggle.addEventListener("click", function () {
			var pausado = belt.classList.toggle("is-paused");
			reelToggle.setAttribute("aria-pressed", String(pausado));
			reelToggle.textContent = pausado ? "Retomar giro" : "Pausar giro";
		});
	}

	/* ---------------------------------------- player em sobreposição */

	var lightbox = document.getElementById("lightbox");
	var lbFrame = document.getElementById("lightboxFrame");
	var lbTitle = document.getElementById("lightboxTitle");
	var lbClose = document.getElementById("lightboxClose");
	var quemAbriu = null;

	function abrirPlayer(botao) {
		var id = botao.dataset.video;
		if (!id) return;

		quemAbriu = botao;
		lbTitle.textContent = botao.dataset.title || "Amazon Rage";

		var iframe = document.createElement("iframe");
		iframe.src = "https://www.youtube-nocookie.com/embed/" + id + "?autoplay=1&rel=0";
		iframe.title = lbTitle.textContent;
		iframe.allow = "accelerometer; autoplay; encrypted-media; picture-in-picture; web-share";
		iframe.allowFullscreen = true;
		lbFrame.appendChild(iframe);

		lightbox.hidden = false;
		document.body.classList.add("modal-open");
		lbClose.focus();
	}

	function fecharPlayer() {
		if (lightbox.hidden) return;
		lightbox.hidden = true;
		lbFrame.textContent = "";
		document.body.classList.remove("modal-open");
		if (quemAbriu) {
			quemAbriu.focus();
			quemAbriu = null;
		}
	}

	if (lightbox) {
		// vale para os cards do carrossel e para o botão das partidas
		document.querySelectorAll("[data-video]").forEach(function (card) {
			card.addEventListener("click", function () { abrirPlayer(card); });
		});

		lbClose.addEventListener("click", fecharPlayer);

		lightbox.addEventListener("click", function (e) {
			if (e.target === lightbox) fecharPlayer();
		});

		document.addEventListener("keydown", function (e) {
			if (e.key === "Escape") fecharPlayer();
			// mantém o foco preso no player enquanto ele estiver aberto
			if (e.key === "Tab" && !lightbox.hidden) {
				e.preventDefault();
				lbClose.focus();
			}
		});
	}

	/* ---------------------------------------- card de compartilhamento
	   Monta um JPEG 1080x1080 no próprio navegador, a partir dos dados que
	   já estão no HTML do destaque. No celular abre a bandeja de
	   compartilhamento do sistema; no computador baixa o arquivo. */

	var LADO = 1080;

	function carregarImagem(src) {
		return new Promise(function (ok, erro) {
			var img = new Image();
			img.onload = function () { ok(img); };
			img.onerror = erro;
			img.src = src;
		});
	}

	function cobrir(ctx, img, x, y, w, h) {
		var escala = Math.max(w / img.width, h / img.height);
		var lw = img.width * escala;
		var lh = img.height * escala;
		ctx.drawImage(img, x + (w - lw) / 2, y + (h - lh) / 2, lw, lh);
	}

	function desenharCard(dados, foto, escudo) {
		var c = document.createElement("canvas");
		c.width = c.height = LADO;
		var ctx = c.getContext("2d");

		ctx.fillStyle = "#07090b";
		ctx.fillRect(0, 0, LADO, LADO);
		cobrir(ctx, foto, 0, 0, LADO, LADO);

		// escurece o topo para o escudo e o rótulo lerem sobre foto clara
		var topo = ctx.createLinearGradient(0, 0, 0, LADO * .26);
		topo.addColorStop(0, "rgba(7,9,11,.8)");
		topo.addColorStop(1, "rgba(7,9,11,0)");
		ctx.fillStyle = topo;
		ctx.fillRect(0, 0, LADO, LADO * .26);

		// escurece a base para o texto respirar
		var base = ctx.createLinearGradient(0, LADO * .3, 0, LADO);
		base.addColorStop(0, "rgba(7,9,11,0)");
		base.addColorStop(.45, "rgba(7,9,11,.82)");
		base.addColorStop(1, "rgba(7,9,11,.98)");
		ctx.fillStyle = base;
		ctx.fillRect(0, 0, LADO, LADO);

		// brilho da marca, colado no canto para não esverdear o rosto
		var brilho = ctx.createRadialGradient(LADO * .94, -LADO * .08, 0, LADO * .94, -LADO * .08, LADO * .62);
		brilho.addColorStop(0, "rgba(0,199,102,.30)");
		brilho.addColorStop(1, "rgba(0,199,102,0)");
		ctx.fillStyle = brilho;
		ctx.fillRect(0, 0, LADO, LADO);

		// faixas diagonais no canto inferior direito
		ctx.fillStyle = "rgba(199,245,30,.85)";
		for (var i = 0; i < 4; i++) {
			var x = LADO - 190 + i * 34;
			ctx.beginPath();
			ctx.moveTo(x, LADO);
			ctx.lineTo(x + 14, LADO);
			ctx.lineTo(x + 14 + 44, LADO - 120);
			ctx.lineTo(x + 44, LADO - 120);
			ctx.closePath();
			ctx.fill();
		}

		ctx.drawImage(escudo, 56, 50, 118, 118 * escudo.height / escudo.width);

		ctx.textBaseline = "alphabetic";
		ctx.fillStyle = "#c7f51e";
		ctx.font = '600 26px "Chakra Petch", sans-serif';
		ctx.fillText("RAGEMATCH", 190, 96);
		ctx.fillStyle = "rgba(238,243,239,.75)";
		ctx.font = '500 24px "Barlow", sans-serif';
		ctx.fillText("#reisdonorte", 190, 130);

		var base_y = 700;

		ctx.fillStyle = "#00c766";
		ctx.font = '600 24px "Chakra Petch", sans-serif';
		ctx.fillText(dados.papel.toUpperCase() + " · " + dados.jogo.toUpperCase(), 60, base_y);

		ctx.fillStyle = "#c7f51e";
		var tamanho = 104;
		ctx.font = '700 ' + tamanho + 'px "Chakra Petch", sans-serif';
		while (ctx.measureText(dados.nome.toUpperCase()).width > LADO - 120 && tamanho > 48) {
			tamanho -= 4;
			ctx.font = '700 ' + tamanho + 'px "Chakra Petch", sans-serif';
		}
		ctx.fillText(dados.nome.toUpperCase(), 58, base_y + 96);

		// números lado a lado, encolhendo até caber na largura do card
		var util = LADO - 120;

		function medir(num, rot, folga) {
			var total = 0;
			dados.numeros.forEach(function (n, i) {
				ctx.font = '700 ' + num + 'px "Chakra Petch", sans-serif';
				var a = ctx.measureText(n.valor).width;
				ctx.font = '500 ' + rot + 'px "Barlow", sans-serif';
				var b = ctx.measureText(n.rotulo.toUpperCase()).width;
				total += Math.max(a, b) + (i ? folga : 0);
			});
			return total;
		}

		var num = 62, rot = 22, folga = 66;
		while (medir(num, rot, folga) > util && num > 30) {
			num -= 3;
			rot = Math.max(15, rot - 1);
			folga = Math.max(28, folga - 5);
		}

		var col = 60;
		dados.numeros.forEach(function (n, i) {
			if (i) {
				ctx.fillStyle = "rgba(238,243,239,.16)";
				ctx.fillRect(col - folga / 2 - 1, base_y + 148, 2, num + 6);
			}
			ctx.fillStyle = "#eef3ef";
			ctx.font = '700 ' + num + 'px "Chakra Petch", sans-serif';
			ctx.fillText(n.valor, col, base_y + 202);
			var largura = ctx.measureText(n.valor).width;

			ctx.fillStyle = "#93a29b";
			ctx.font = '500 ' + rot + 'px "Barlow", sans-serif';
			ctx.fillText(n.rotulo.toUpperCase(), col, base_y + 236);
			col += Math.max(largura, ctx.measureText(n.rotulo.toUpperCase()).width) + folga;
		});

		ctx.fillStyle = "rgba(199,245,30,.9)";
		ctx.fillRect(60, LADO - 118, 120, 3);

		ctx.fillStyle = "#eef3ef";
		ctx.font = '600 26px "Chakra Petch", sans-serif';
		ctx.fillText(dados.partida.toUpperCase(), 60, LADO - 72);
		ctx.fillStyle = "#93a29b";
		ctx.font = '500 22px "Barlow", sans-serif';
		ctx.fillText("@amazonrage · amazonrage.netlify.app", 60, LADO - 38);

		return c;
	}

	function lerDestaque(mvp) {
		var numeros = [];
		mvp.querySelectorAll(".mvp-stats li").forEach(function (li) {
			numeros.push({
				valor: li.querySelector("b").textContent.trim(),
				rotulo: li.querySelector("span").textContent.trim()
			});
		});

		var partida = mvp.closest(".match-details");

		return {
			nome: mvp.querySelector(".mvp-name").textContent.trim(),
			papel: mvp.querySelector(".mvp-role").textContent.trim(),
			jogo: mvp.querySelector(".mvp-game").textContent.trim(),
			foto: mvp.querySelector(".mvp-photo img").getAttribute("src"),
			partida: partida ? partida.dataset.match : "Amazon Rage",
			numeros: numeros
		};
	}

	function semAcento(txt) {
		return txt.normalize("NFD").replace(/[\u0300-\u036f]/g, "")
			.replace(/[^a-zA-Z0-9]+/g, "-").replace(/^-|-$/g, "").toLowerCase();
	}

	document.querySelectorAll(".btn-share").forEach(function (botao) {
		botao.addEventListener("click", function () {
			var mvp = botao.closest(".mvp");
			if (!mvp || botao.disabled) return;

			var original = botao.innerHTML;
			botao.disabled = true;
			botao.textContent = "Gerando...";

			var dados = lerDestaque(mvp);

			var fontes = document.fonts
				? Promise.all([
					document.fonts.load('700 104px "Chakra Petch"'),
					document.fonts.load('600 26px "Chakra Petch"'),
					document.fonts.load('500 24px "Barlow"')
				])
				: Promise.resolve();

			Promise.all([fontes, carregarImagem(dados.foto), carregarImagem("/assets/img/logo.png")])
				.then(function (r) {
					var canvas = desenharCard(dados, r[1], r[2]);
					return new Promise(function (ok) { canvas.toBlob(ok, "image/jpeg", .92); });
				})
				.then(function (blob) {
					if (!blob) throw new Error("sem imagem");
					var nome = "amazonrage-" + semAcento(dados.nome) + ".jpg";
					var arquivo = new File([blob], nome, { type: "image/jpeg" });

					if (navigator.canShare && navigator.canShare({ files: [arquivo] })) {
						return navigator.share({
							files: [arquivo],
							title: dados.nome + " — " + dados.partida,
							text: dados.nome + " foi destaque no RageMatch. #reisdonorte"
						}).then(function () { botao.textContent = "Compartilhado!"; });
					}

					var url = URL.createObjectURL(blob);
					var link = document.createElement("a");
					link.href = url;
					link.download = nome;
					document.body.appendChild(link);
					link.click();
					link.remove();
					setTimeout(function () { URL.revokeObjectURL(url); }, 4000);
					botao.textContent = "Card baixado!";
				})
				.catch(function (e) {
					// cancelar a bandeja do sistema não é erro
					botao.textContent = (e && e.name === "AbortError") ? "Compartilhar card" : "Não deu certo";
				})
				.then(function () {
					setTimeout(function () {
						botao.innerHTML = original;
						botao.disabled = false;
					}, 2200);
				});
		});
	});

	/* ---------------------------------------- planos -> formulário */

	var planoSelect = document.getElementById("plano");

	document.querySelectorAll("[data-plan]").forEach(function (link) {
		link.addEventListener("click", function () {
			if (!planoSelect) return;
			var wanted = link.dataset.plan;
			Array.prototype.forEach.call(planoSelect.options, function (option) {
				if (option.value.indexOf(wanted) === 0) planoSelect.value = option.value;
			});
		});
	});

	/* ---------------------------------------- envio via Netlify Forms */

	var form = document.getElementById("formPatrocinio");
	var status = document.getElementById("formStatus");

	if (form) {
		form.addEventListener("submit", function (e) {
			e.preventDefault();

			var button = form.querySelector('button[type="submit"]');
			var original = button.textContent;
			button.disabled = true;
			button.textContent = "Enviando...";
			status.className = "form-status";
			status.textContent = "";

			fetch("/", {
				method: "POST",
				headers: { "Content-Type": "application/x-www-form-urlencoded" },
				body: new URLSearchParams(new FormData(form)).toString()
			})
				.then(function (response) {
					if (!response.ok) throw new Error(response.status);
					form.reset();
					status.className = "form-status is-ok";
					status.textContent = "Proposta enviada! Nossa equipe responde em até 2 dias úteis.";
				})
				.catch(function () {
					status.className = "form-status is-error";
					status.innerHTML =
						'Não foi possível enviar agora. Fale com a gente em ' +
						'<a href="mailto:contato@amazonrage.com">contato@amazonrage.com</a>.';
				})
				.finally(function () {
					button.disabled = false;
					button.textContent = original;
				});
		});
	}

	/* ---------------------------------------- ano do rodapé */

	var ano = document.getElementById("ano");
	if (ano) ano.textContent = String(new Date().getFullYear());
})();
