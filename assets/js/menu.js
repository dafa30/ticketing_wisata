const nav = document.querySelector('nav');
const toggleShadow = () => nav.classList.toggle('shadow', window.scrollY > 0);

window.addEventListener('scroll', toggleShadow);
toggleShadow();