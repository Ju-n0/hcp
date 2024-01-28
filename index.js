const sectionElements = document.querySelectorAll('section');

const sectionObserver = new IntersectionObserver(
  (entries) => {
    for (const entry of entries) {
      if (entry.isIntersecting) {
        entry.target.closest('section').classList.add('visible');
      }
    }
  },
  {
    rootMargin: '-300px 0px',
  },
);

sectionElements.forEach((el) => sectionObserver.observe(el));

const navTriggerElement = document.getElementById('nav-trigger');
const headerElement = document.querySelector('header');
const logoFloatingHeaderContainerElement = document.querySelector('.logo-floating-header-container');

const navTriggerObserver = new IntersectionObserver((entries) => {
  const entry = entries[0];
  console.log(entry.isIntersecting);
  if (!entry.isIntersecting) {
    headerElement.classList.add('floating');
    logoFloatingHeaderContainerElement.classList.add('visible');
  } else {
    headerElement.classList.remove('floating');
    logoFloatingHeaderContainerElement.classList.remove('visible');
  }
});

navTriggerObserver.observe(navTriggerElement);

const form = document.getElementById('contact-form');

async function handleSubmit(event) {
  event.preventDefault();
  const status = document.getElementById('response-form');
  const formButton = document.querySelector('.formButton');
  const oldText = formButton.textContent;
  formButton.textContent = 'Envoi...';

  const data = new FormData(event.target);
  fetch(event.target.action, {
    method: form.method,
    body: data,
    headers: {
      Accept: 'application/json',
    },
  })
    .then((response) => {
      formButton.textContent = 'Envoi...';
      if (response.ok) {
        status.textContent = 'Votre email a été envoyé';
        status.classList.remove('error');
        form.reset();
      } else {
        return response.json();
      }
    })
    .then((data) => {
      if (!data) {
        return;
      }
      if (Object.hasOwn(data, 'errors')) {
        status.textContent = data.errors.map((error) => error.message).join(', ');
        status.classList.add('error');
      } else {
        status.textContent = 'Une erreur est survenue. Merci de réessayer plus tard.';
        status.classList.add('error');
      }
    })
    .catch((error) => {
      status.textContent = 'Une erreur est survenue. Merci de réessayer plus tard.';
      status.classList.add('error');
    })
    .finally(() => {
      formButton.textContent = oldText;
    });
}
form.addEventListener('submit', handleSubmit);
