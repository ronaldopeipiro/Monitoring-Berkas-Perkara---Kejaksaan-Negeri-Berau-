"use strict";
var promises = [];

self.addEventListener("push", async function (e) {
  var body;
  // const analyticsPromise = pushReceivedTracking();

  if (e.data) {
    body = e.data.text();
  } else {
    body = "Push message no payload";
  }

  var options = {
    body: body,
    icon: "https://kejari-berau.djknkalbar.net/assets/img/logo.png",
    vibrate: [100, 50, 100, 100, 50, 100],
    data: {
      dateOfArrival: Date.now(),
      primaryKey: 1,
    },
    actions: [
      {
        action: "explore",
        title: "Buka",
        icon: "https://kejari-berau.djknkalbar.net/assets/img/checkmark.png",
      },
      {
        action: "close",
        title: "Tutup",
        icon: "https://kejari-berau.djknkalbar.net/assets/img/xmark.png",
      },
    ],
  };

  promises.push(
    self.registration.showNotification(
      "MONITORING PERKARA KEJARI BERAU APP",
      options
    )
  );
  Promise.all(promises);
});

// self.addEventListener("notificationclick", function (event) {
//   console.log("[Service Worker] Notification click Received.");
//   event.notification.close();
//   event.waitUntil(clients.openWindow("https//kejari-berau.djknkalbar.net/"));
// });

var CACHE_NAME = "monitoring-perkara-kejari-berau-app-cache-v2022";

var urlsToCache = [
  // "./",
  "./offline",
  "./img/logo.png",
  "./img/offline-logo.png",
];

self.addEventListener("install", function (event) {
  event.waitUntil(
    caches.open(CACHE_NAME).then(function (cache) {
      console.log("Opened cache");
      return cache.addAll(urlsToCache);
    })
  );
});

self.addEventListener("fetch", function (event) {
  event.respondWith(
    caches
      .match(event.request)
      .then(function (response) {
        return response || fetch(event.request);
      })
      .catch(function () {
        return caches.match("https://kejari-berau.djknkalbar.net/offline");
      })
  );
});

self.addEventListener("activate", function (event) {
  var cacheAllowlist = CACHE_NAME;
  event.waitUntil(
    caches.keys().then(function (cacheNames) {
      return Promise.all(
        cacheNames.map(function (cacheName) {
          if (cacheAllowlist.indexOf(cacheName) === -1) {
            return caches.delete(cacheName);
          }
        })
      );
    })
  );
});

self.addEventListener("activate", function (event) {
  event.waitUntil(
    caches.keys().then(function (cacheNames) {
      return Promise.all(
        cacheNames
          .filter(function (cacheName) {
            // the whole origin
          })
          .map(function (cacheName) {
            return caches.delete(cacheName);
          })
      );
    })
  );
});

function updateCache(request, response) {
  return caches.open(CACHE_NAME).then(function (cache) {
    return cache.put(request, response);
  });
}
