/* ============================================================
   Mobbin-style landing page — interactions
   ============================================================ */
(function () {
    "use strict";

    const prefersReduced = window.matchMedia(
        "(prefers-reduced-motion: reduce)"
    ).matches;

    /* ---------- Password visibility toggles (supports multiple) ---------- */
    document.querySelectorAll(".toggle-pass").forEach(function (toggle) {
        toggle.addEventListener("click", function () {
            const field = toggle.closest(".field") || toggle.parentElement;
            const input = field
                ? field.querySelector('input[type="password"], input[data-pass]')
                : null;
            if (!input) return;
            const isHidden = input.type === "password";
            input.type = isHidden ? "text" : "password";
            input.setAttribute("data-pass", "1");
            toggle.setAttribute(
                "aria-label",
                isHidden ? "Hide password" : "Show password"
            );
            toggle.style.color = isHidden ? "#7c6cff" : "";
        });
    });

    /* ---------- Submit feedback (real submission) ---------- */
    document.querySelectorAll("form.form").forEach(function (form) {
        form.addEventListener("submit", function () {
            const btn = form.querySelector(".btn-continue");
            if (btn && !btn.disabled) {
                const loading = btn.getAttribute("data-loading");
                if (loading) btn.textContent = loading;
                btn.disabled = true;
            }
            // Allow the form to submit normally to the server.
        });
    });

    /* ---------- Build infinite phone mosaic ---------- */
    const mosaic = document.getElementById("mosaic");
    if (mosaic) {
        // Screenshot images from assets/screen
        const SCREENS = [
            "images/screen/59460f85-780a-4131-928f-c1910dec8397.png",
            "images/screen/9af28fa6-c82d-48a7-a497-6346d80f066e.png",
            "images/screen/ac1cb724-92d4-453a-8989-fcb44daea419.png",
            "images/screen/b054a1c7-5ad7-4d84-ba69-34d0bd8b1c96.png",
            "images/screen/c133f6b0-a0c4-4d69-b381-5469566450c4.png",
            "images/screen/f3ca9d73-ed48-491e-b39b-7595ea4dd34f.png",
            "images/screen/fe5c377d-08dd-4ec6-8cbd-270ccb23f64a.png",
        ];

        // Column config: scroll duration (s) and direction (higher = slower)
        const COLS = [
            { dur: 80, down: false },
            { dur: 100, down: true },
            { dur: 90, down: false },
            { dur: 115, down: true },
            { dur: 95, down: false },
        ];
        const PER_COL = 5;

        COLS.forEach(function (cfg, ci) {
            const col = document.createElement("div");
            col.className = "col" + (cfg.down ? " down" : "");

            const track = document.createElement("div");
            track.className = "col-track";
            track.style.setProperty("--dur", 400 + "s");

            // One set of screens, then duplicated for a seamless -50% loop
            const set = [];
            for (let i = 0; i < PER_COL; i++) {
                set.push(SCREENS[(ci * 3 + i) % SCREENS.length]);
            }
            set.concat(set).forEach(function (src, idx) {
                const card = document.createElement("article");
                card.className = "phone";
                const img = document.createElement("img");
                img.src = src;
                img.loading = "lazy";
                img.alt = idx >= PER_COL ? "" : "App screen";
                if (idx >= PER_COL) card.setAttribute("aria-hidden", "true");
                card.appendChild(img);
                track.appendChild(card);
            });

            col.appendChild(track);
            mosaic.appendChild(col);
        });
    }

    /* ---------- Subtle mouse tilt on the mosaic (pointer devices only) ---------- */
    const scene = document.getElementById("scene");
    const canHover = window.matchMedia("(hover: hover) and (pointer: fine)").matches;
    if (scene && mosaic && canHover && !prefersReduced) {
        let targetX = 0,
            targetY = 0,
            curX = 0,
            curY = 0;

        // scene.addEventListener("mousemove", function (e) {
        //     const rect = scene.getBoundingClientRect();
        //     targetX = (e.clientX - rect.left) / rect.width - 0.5;
        //     targetY = (e.clientY - rect.top) / rect.height - 0.5;
        // });

        scene.addEventListener("mouseleave", function () {
            targetX = 0;
            targetY = 0;
        });

        function animate() {
            curX += (targetX - curX) * 0.08;
            curY += (targetY - curY) * 0.08;
            mosaic.style.transform =
                "rotate(-12deg) scale(1.3) translate(" +
                (curX * 22).toFixed(2) + "px, " +
                (curY * 22).toFixed(2) + "px)";
            requestAnimationFrame(animate);
        }
        requestAnimationFrame(animate);
    }
})();
