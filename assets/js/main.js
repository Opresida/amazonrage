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
