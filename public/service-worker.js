const CACHE_NAME = "laporpak-v1";

// HANYA asset statis
const STATIC_ASSETS = [
    "/",
    "/css/app.css",
    "/js/app.js",
    "/offline.html"
];

// =======================
// INSTALL
// =======================
self.addEventListener("install", event => {
    event.waitUntil(
        caches.open(CACHE_NAME)
            .then(cache => cache.addAll(STATIC_ASSETS))
    );
});

// =======================
// FETCH
// =======================
self.addEventListener("fetch", event => {

    // SKIP request selain GET
    if (event.request.method !== "GET") return;

    const url = new URL(event.request.url);

    // SKIP halaman penting Laravel
    if (
        url.pathname.startsWith("/dashboard") ||
        url.pathname.startsWith("/lapor") ||
        url.pathname.startsWith("/login") ||
        url.pathname.startsWith("/admin")
    ) {
        return;
    }

    // =======================
    // CACHE FIRST (untuk asset)
    // =======================
    event.respondWith(
        caches.match(event.request)
            .then(response => {
                return response || fetch(event.request)
                    .then(fetchRes => {
                        return caches.open(CACHE_NAME)
                            .then(cache => {
                                cache.put(event.request, fetchRes.clone());
                                return fetchRes;
                            });
                    })
                    .catch(() => caches.match("/offline.html"));
            })
    );
});