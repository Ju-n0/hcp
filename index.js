if (matchMedia("(min-width: 992px)").matches) {
  const sectionElements = document.querySelectorAll("section");

  const sectionObserver = new IntersectionObserver(
    (entries) => {
      for (const entry of entries) {
        if (entry.isIntersecting) {
          entry.target.closest("section").classList.add("visible");
        }
      }
    },
    {
      rootMargin: "-300px 0px",
    }
  );

  sectionElements.forEach((el) => sectionObserver.observe(el));
}

const logoFloatingHeaderContainerElement = document.querySelector(
  ".logo-floating-header-container"
);

document.addEventListener("scroll", (e) => {
  if (matchMedia("(max-width: 992px)").matches) return;

  const mainElement = document.querySelector("main");

  if (mainElement.getBoundingClientRect().top <= 120) {
    logoFloatingHeaderContainerElement.classList.add("visible");
  } else {
    logoFloatingHeaderContainerElement.classList.remove("visible");
  }
});

const form = document.getElementById("contact-form");

async function handleSubmit(event) {
  event.preventDefault();
  const status = document.getElementById("response-form");
  const formButton = document.querySelector(".formButton");
  const oldText = formButton.textContent;
  formButton.textContent = "Envoi...";

  const data = new FormData(event.target);
  fetch(event.target.action, {
    method: form.method,
    body: data,
    headers: {
      Accept: "application/json",
    },
  })
    .then((response) => {
      formButton.textContent = "Envoi...";
      if (response.ok) {
        status.textContent = "Votre email a été envoyé";
        status.classList.remove("error");
        form.reset();
      } else {
        return response.json();
      }
    })
    .then((data) => {
      if (!data) {
        return;
      }
      if (Object.hasOwn(data, "errors")) {
        status.textContent = data.errors.map((error) => error.message).join(", ");
        status.classList.add("error");
      } else {
        status.textContent = "Une erreur est survenue. Merci de réessayer plus tard.";
        status.classList.add("error");
      }
    })
    .catch((error) => {
      status.textContent = "Une erreur est survenue. Merci de réessayer plus tard.";
      status.classList.add("error");
    })
    .finally(() => {
      formButton.textContent = oldText;
    });
}
form.addEventListener("submit", handleSubmit);

const burgerElement = document.querySelector(".burger");

burgerElement.addEventListener("click", () => {
  burgerElement.classList.toggle("open");

  if (burgerElement.classList.contains("open")) {
    document.body.style.overflow = "hidden";
    return;
  }

  document.body.style.overflow = "";
});

const navItemElements = document.querySelectorAll(".nav-item");

navItemElements.forEach((el) => {
  el.addEventListener("click", () => {
    burgerElement.classList.remove("open");
    document.body.style.overflow = "";
  });
});
