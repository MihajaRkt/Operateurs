document.addEventListener('DOMContentLoaded', () => {
  initSidebarToggle();
  initSidebarState();
  initPasswordToggle();
  syncRangeLabel();
});

function initSidebarToggle() {
  const toggleButton = document.querySelector('[data-sidebar-toggle]');
  const backdrop = document.querySelector('[data-sidebar-backdrop]');

  if (toggleButton) {
    toggleButton.addEventListener('click', () => {
      document.body.classList.toggle('sidebar-open');
    });
  }

  if (backdrop) {
    backdrop.addEventListener('click', () => {
      document.body.classList.remove('sidebar-open');
    });
  }
}

function initSidebarState() {
  const currentPath = window.location.pathname.replace(/\/+$/, '') || '/';

  document.querySelectorAll('[data-sidebar-link]').forEach((link) => {
    const href = new URL(link.getAttribute('href'), window.location.origin)
      .pathname.replace(/\/+$/, '') || '/';

    const isActive = href === currentPath || (href !== '/' && currentPath.startsWith(href));
    if (isActive) {
      link.classList.add('is-active');
    }

    link.addEventListener('click', () => {
      if (window.matchMedia('(max-width: 991.98px)').matches) {
        document.body.classList.remove('sidebar-open');
      }
    });
  });
}

function initPasswordToggle() {
  const toggleBtn = document.getElementById('bouton');
  const pass = document.getElementById('mdp');

  if (!toggleBtn || !pass) {
    return;
  }

  toggleBtn.addEventListener('click', password_action);
}

function password_action() {
  const pass = document.getElementById('mdp');
  const bouton = document.getElementById('bouton');

  if (!pass || !bouton) {
    return;
  }

  const isHidden = pass.type === 'password';
  pass.type = isHidden ? 'text' : 'password';
  bouton.textContent = isHidden ? 'Masquer' : 'Afficher';
  bouton.setAttribute('aria-pressed', String(isHidden));
}

function syncRangeLabel() {
  const range = document.getElementById('priority-range');
  const label = document.getElementById('range-label');

  if (!range || !label) {
    return;
  }

  label.textContent = range.value;
  range.addEventListener('input', () => {
    label.textContent = range.value;
  });
}

function setStars(n) {
  document.querySelectorAll('#stars span').forEach((star, index) => {
    star.classList.toggle('on', index < n);
  });
}
