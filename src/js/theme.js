document.addEventListener('DOMContentLoaded', () => {
  const navbar     = document.getElementById('navbar');
  const topbar     = document.getElementById('topbar');
  const menuBtn      = document.getElementById('menu-btn');
  const menuClose    = document.getElementById('menu-close');
  const mobileMenu   = document.getElementById('mobile-menu');
  const mobileOverlay = document.getElementById('mobile-overlay');

  // Navbar + topbar scroll effect
  window.addEventListener('scroll', () => {
    const scrolled = window.scrollY > 60;
    navbar?.classList.toggle('scrolled', scrolled);
    if (topbar) topbar.classList.toggle('topbar-hidden', scrolled);
  });

  // Mobile drawer open/close
  function openMobileMenu() {
    mobileMenu?.classList.remove('right-[-100%]');
    mobileMenu?.classList.add('right-0');
    mobileOverlay?.classList.remove('opacity-0', 'pointer-events-none');
    mobileOverlay?.classList.add('opacity-100');
    document.body.style.overflow = 'hidden';
  }

  function closeMobileMenu() {
    mobileMenu?.classList.add('right-[-100%]');
    mobileMenu?.classList.remove('right-0');
    mobileOverlay?.classList.add('opacity-0', 'pointer-events-none');
    mobileOverlay?.classList.remove('opacity-100');
    document.body.style.overflow = '';
  }

  menuBtn?.addEventListener('click', openMobileMenu);
  menuClose?.addEventListener('click', closeMobileMenu);
  mobileOverlay?.addEventListener('click', closeMobileMenu);

  // Close drawer whenever the viewport enters the desktop breakpoint (lg = 1024px).
  // Without this, an open drawer keeps its translate-x-0 class after resize and
  // snaps back open the next time the window is narrowed again.
  const lgBreakpoint = window.matchMedia('(min-width: 1024px)');
  lgBreakpoint.addEventListener('change', e => {
    if (e.matches) closeMobileMenu();
  });

  // Close drawer when a leaf link is tapped
  mobileMenu?.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', closeMobileMenu);
  });

  // Mobile accordion for items with sub-menus
  mobileMenu?.querySelectorAll('.mobile-accordion-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const subMenu = btn.closest('li').querySelector('.mobile-sub-menu');
      const chevron = btn.querySelector('.mobile-chevron');
      if (!subMenu) return;
      const isOpen = !subMenu.classList.contains('hidden');
      subMenu.classList.toggle('hidden', isOpen);
      chevron?.classList.toggle('rotate-180', !isOpen);
    });
  });

  // Shop page: filter pills + search
  const filterPills = document.querySelectorAll('.filter-pill');
  const catCards    = document.querySelectorAll('#category-grid a');
  const noResults   = document.getElementById('no-results');
  const searchInput = document.getElementById('search-input');

  if ( filterPills.length && catCards.length ) {
    let activeFilter = 'all';
    let searchQuery  = '';

    function applyFilters() {
      let visible = 0;
      catCards.forEach( card => {
        const tags = card.dataset.tags || '';
        const name = card.dataset.name || '';
        const matchesFilter = activeFilter === 'all' || tags.includes( activeFilter );
        const matchesSearch = !searchQuery || name.includes( searchQuery ) || tags.includes( searchQuery );
        card.style.display = ( matchesFilter && matchesSearch ) ? '' : 'none';
        if ( matchesFilter && matchesSearch ) visible++;
      } );
      noResults?.classList.toggle( 'hidden', visible > 0 );
    }

    filterPills.forEach( pill => {
      pill.addEventListener( 'click', () => {
        filterPills.forEach( p => p.classList.remove( 'active' ) );
        pill.classList.add( 'active' );
        activeFilter = pill.dataset.filter;
        applyFilters();
      } );
    } );

    searchInput?.addEventListener( 'input', e => {
      searchQuery = e.target.value.toLowerCase().trim();
      applyFilters();
    } );

    window.resetFilters = function () {
      searchQuery  = '';
      activeFilter = 'all';
      if ( searchInput ) searchInput.value = '';
      filterPills.forEach( p => p.classList.remove( 'active' ) );
      document.querySelector( '[data-filter="all"]' )?.classList.add( 'active' );
      applyFilters();
    };
  }

  // Mega nav: hover with delay to bridge the gap between trigger and dropdown
  const navItems = document.querySelectorAll('#navbar .nav-item');
  navItems.forEach(item => {
    let hideTimer = null;

    item.addEventListener('mouseenter', () => {
      clearTimeout(hideTimer);
      navItems.forEach(other => {
        if (other !== item) other.classList.remove('is-open');
      });
      item.classList.add('is-open');
    });

    item.addEventListener('mouseleave', () => {
      hideTimer = setTimeout(() => {
        item.classList.remove('is-open');
      }, 150);
    });
  });

  // Close all dropdowns on outside click
  document.addEventListener('click', e => {
    if (!e.target.closest('#navbar .nav-item')) {
      navItems.forEach(item => item.classList.remove('is-open'));
    }
  });

  // Scroll reveal via IntersectionObserver
  const revealObserver = new IntersectionObserver(
    (entries) => entries.forEach(e => {
      if (e.isIntersecting) {
        e.target.classList.add('visible');
        revealObserver.unobserve(e.target);
      }
    }),
    { threshold: 0.12 }
  );
  document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

  // ── Gallery Lightbox ──────────────────────────────────────────────
  const galleries = document.querySelectorAll('.wp-block-gallery');
  if ( galleries.length ) {

    // Build modal DOM
    const lightbox = document.createElement('div');
    lightbox.id = 'zg-lightbox';
    lightbox.setAttribute('role', 'dialog');
    lightbox.setAttribute('aria-modal', 'true');
    lightbox.setAttribute('aria-label', 'Image lightbox');
    lightbox.innerHTML = `
      <button id="zg-lightbox-close" aria-label="Close lightbox">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <button id="zg-lightbox-prev" aria-label="Previous image">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
        </svg>
      </button>
      <img src="" alt="" />
      <button id="zg-lightbox-next" aria-label="Next image">
        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
        </svg>
      </button>
      <div id="zg-lightbox-caption"></div>
    `;
    document.body.appendChild(lightbox);

    const lbImg     = lightbox.querySelector('img');
    const lbCaption = lightbox.querySelector('#zg-lightbox-caption');
    const lbClose   = lightbox.querySelector('#zg-lightbox-close');
    const lbPrev    = lightbox.querySelector('#zg-lightbox-prev');
    const lbNext    = lightbox.querySelector('#zg-lightbox-next');

    let allImages = [];
    let current   = 0;

    function openLightbox( images, index ) {
      allImages = images;
      current   = index;
      showImage( current );
      lightbox.classList.add('is-open');
      document.body.style.overflow = 'hidden';
      lbClose.focus();
    }

    function closeLightbox() {
      lightbox.classList.remove('is-open');
      document.body.style.overflow = '';
    }

    function showImage( index ) {
      const { src, alt, caption } = allImages[ index ];
      lbImg.src = src;
      lbImg.alt = alt || '';
      lbCaption.textContent = caption || '';
      lbPrev.style.display = allImages.length > 1 ? '' : 'none';
      lbNext.style.display = allImages.length > 1 ? '' : 'none';
    }

    function navigate( dir ) {
      current = ( current + dir + allImages.length ) % allImages.length;
      showImage( current );
    }

    // Inject zoom icon + collect images per gallery
    galleries.forEach( gallery => {
      const items = gallery.querySelectorAll('.wp-block-image');
      const images = [];

      items.forEach( item => {
        const img = item.querySelector('img');
        if ( ! img ) return;

        // Add zoom icon overlay
        const zoom = document.createElement('div');
        zoom.className = 'zg-gallery-zoom';
        zoom.innerHTML = `<span>
          <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
            <circle cx="11" cy="11" r="8"/><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.35-4.35"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M11 8v6M8 11h6"/>
          </svg>
        </span>`;
        item.appendChild(zoom);

        const caption = item.querySelector('figcaption')?.textContent?.trim() || '';
        const fullSrc = img.dataset.fullUrl || img.src;
        images.push({ src: fullSrc, alt: img.alt, caption });
      } );

      items.forEach( ( item, idx ) => {
        item.style.cursor = 'zoom-in';
        item.addEventListener('click', () => openLightbox( images, idx ) );
      } );
    } );

    lbClose.addEventListener('click', closeLightbox);
    lbPrev.addEventListener('click', () => navigate(-1));
    lbNext.addEventListener('click', () => navigate(1));

    lightbox.addEventListener('click', e => {
      if ( e.target === lightbox ) closeLightbox();
    } );

    document.addEventListener('keydown', e => {
      if ( ! lightbox.classList.contains('is-open') ) return;
      if ( e.key === 'Escape' )      closeLightbox();
      if ( e.key === 'ArrowLeft' )   navigate(-1);
      if ( e.key === 'ArrowRight' )  navigate(1);
    } );
  }

  // ── Add-to-bag toast ──────────────────────────────────────────────
  function showBagToast( productName ) {
    document.getElementById( 'zg-bag-toast' )?.remove();

    const cartUrl = ( typeof wc_add_to_cart_params !== 'undefined' && wc_add_to_cart_params.cart_url )
      ? wc_add_to_cart_params.cart_url
      : '/cart';

    const toast = document.createElement( 'div' );
    toast.id = 'zg-bag-toast';
    toast.setAttribute( 'role', 'status' );
    toast.setAttribute( 'aria-live', 'polite' );
    toast.innerHTML = `
      <div class="zg-bag-toast-icon">
        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 11H4L5 9z"/>
        </svg>
      </div>
      <div class="zg-bag-toast-body">
        <p class="zg-bag-toast-title">Added to bag!</p>
        <p class="zg-bag-toast-name">${ productName }</p>
      </div>
      <a href="${ cartUrl }" class="zg-bag-toast-cta">View Bag &rarr;</a>
      <button class="zg-bag-toast-close" aria-label="Dismiss">
        <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
    `;
    document.body.appendChild( toast );

    requestAnimationFrame( () => requestAnimationFrame( () => toast.classList.add( 'is-visible' ) ) );

    function dismiss() {
      clearTimeout( toast._timer );
      toast.classList.remove( 'is-visible' );
      toast.addEventListener( 'transitionend', () => toast.remove(), { once: true } );
    }

    toast.querySelector( '.zg-bag-toast-close' ).addEventListener( 'click', dismiss );
    toast._timer = setTimeout( dismiss, 5000 );
  }

  // WooCommerce fires `added_to_cart` on document.body (via jQuery)
  if ( typeof jQuery !== 'undefined' ) {
    jQuery( document.body ).on( 'added_to_cart', function ( _e, _fragments, _hash, $btn ) {
      // Remove any WC-injected "View cart" links
      document.querySelectorAll( 'a.added_to_cart.wc-forward' ).forEach( el => el.remove() );

      const productName = $btn && $btn.length
        ? ( $btn.closest( '.service-card' ).find( 'h3' ).text().trim() || 'Item' )
        : 'Item';

      showBagToast( productName );
    } );
  }
});
