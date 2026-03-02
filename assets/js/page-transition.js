(function () {
  "use strict";

  const TRANSITION_MS = 350;

  const markReady = () => {
    document.body.classList.add("page-ready");
  };

  if (document.readyState === "loading") {
    document.addEventListener("DOMContentLoaded", markReady);
  } else {
    markReady();
  }

  const shouldHandleLink = (anchor) => {
    if (!anchor || !anchor.href) return false;
    if (anchor.target === "_blank" || anchor.hasAttribute("download")) return false;

    const href = anchor.getAttribute("href") || "";
    if (!href || href.startsWith("#") || href.startsWith("javascript:") || href.startsWith("mailto:") || href.startsWith("tel:")) {
      return false;
    }

    const url = new URL(anchor.href, window.location.href);
    if (url.origin !== window.location.origin) return false;
    if (url.href === window.location.href) return false;

    return true;
  };

  document.addEventListener("click", (event) => {
    const anchor = event.target.closest("a");
    if (!shouldHandleLink(anchor)) return;

    event.preventDefault();

    document.body.classList.remove("page-ready");
    document.body.classList.add("page-leaving");

    setTimeout(() => {
      window.location.href = anchor.href;
    }, TRANSITION_MS);
  });
})();
