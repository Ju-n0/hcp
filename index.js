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
  const statusElement = document.getElementById("response-form");
  const formButton = document.querySelector(".formButton");
  const oldText = formButton.textContent;
  formButton.textContent = "Envoi...";

  // removes the error messages
  document.querySelectorAll(`[data-name]`).forEach((el) => {
    el.classList.add("hidden");
  });

  const data = new FormData(event.target);
  fetch(event.target.action, {
    method: form.method,
    body: data,
    headers: {
      Accept: "application/json",
    },
  })
    .then((response) => {
      return response.json();
    })
    .then((data) => {
      if (data.status === "success") {
        statusElement.textContent = data.message;
        statusElement.classList.remove("hidden");
        statusElement.classList.remove("error");
        setTimeout(() => {
          statusElement.classList.add("hidden");
        }, 5_000);
        form.reset();
        return;
      }

      if (data.status === "error") {
        const errors = Object.entries(data.errors);

        for (const [name, error] of errors) {
          const input = document.querySelector(`[name="${name}"]`);
          input.classList.add("has-error");
          const errorMessageElement = document.querySelector(`[data-name="${name}"]`);
          errorMessageElement.classList.remove("hidden");
          errorMessageElement.textContent = error;
        }
      }
    })
    .catch((error) => {
      console.log(error);
      statusElement.classList.remove("hidden");
      statusElement.textContent = "Une erreur est survenue. Merci de réessayer plus tard.";
      statusElement.classList.add("error");
      setTimeout(() => {
        statusElement.classList.add("hidden");
      }, 5_000);
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
