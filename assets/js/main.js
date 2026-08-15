/* =============================================================
   Amazon Rage E-Sports — comportamentos da página
   ============================================================= */
(function () {
	"use strict";

	var header = document.querySelector(".site-header");
	var nav = document.getElementById("nav");
	var toggle = document.getElementById("navToggle");

	/* ---------------------------------------- header fixo */

	function onScroll() {
		header.classList.toggle("is-stuck", window.scrollY > 40);
	}
	onScroll();
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
