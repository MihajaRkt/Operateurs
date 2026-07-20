// Small helpers for pages
document.addEventListener('DOMContentLoaded', function(){
  // password toggle handlers on signup page
  const toggleBtn = document.getElementById('bouton');
  if(toggleBtn){ toggleBtn.addEventListener('click', password_action); }
});

function password_action(){
  const pass = document.getElementById('mdp');
  const bouton = document.getElementById('bouton');
  if(!pass) return;
  if(pass.type === 'text'){ pass.type = 'password'; bouton.textContent = 'Afficher'; }
  else { pass.type = 'text'; bouton.textContent = 'Masquer'; }
}
