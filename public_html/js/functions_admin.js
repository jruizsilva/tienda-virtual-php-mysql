const d = document

function controlTag(e) {
  tecla = e.keyCode || e.which;
  if (tecla == 8) return true; // backspace
  else if (tecla == 0 || tecla == 9) return true; // tab
  patron = /[0-9\s]/;
  tecla_final = String.fromCharCode(tecla);
  return patron.test(tecla_final);
}

function isText(txtString) {
  const stringText = new RegExp(/^[a-zA-ZÑñÁáÉéÍíÓóÚúÜü\s]+$/);
  return stringText.test(txtString);
}

function isInt(numEntero) {
  const numInt = new RegExp(/^[0-9]+$/);
  return numInt.test(numEntero);
}

function isEmailValid(email) {
  const emailValid = new RegExp(/^(([^<>()\[\]\\.,;:\s@”]+(\.[^<>()\[\]\\.,;:\s@”]+)*)|(“.+”))@((\[[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}\.[0–9]{1,3}])|(([a-zA-Z\-0–9]+\.)+[a-zA-Z]{2,}))$/);
  return emailValid.test(email);
}



function assignButtonEvents() {
  function validText() {
    const validText = d.querySelectorAll('.validText');
    validText.forEach(function (validText) {
      validText.addEventListener('keyup', function () {
        const inputTag = this;
        if (!isText(inputTag.value)) {
          inputTag.classList.add('is-invalid');
        } else {
          inputTag.classList.remove('is-invalid');
        }
      });
    });
  }

  function validNumber() {
    const validNumber = d.querySelectorAll('.validNumber');
    validNumber.forEach(function (validNumber) {
      validNumber.addEventListener('keyup', function () {
        const inputTag = this;
        if (!isInt(inputTag.value)) {
          inputTag.classList.add('is-invalid');
        } else {
          inputTag.classList.remove('is-invalid');
        }
      });
    });
  }

  function validEmail() {
    const validEmail = d.querySelectorAll('.validEmail');
    validEmail.forEach(function (validEmail) {
      validEmail.addEventListener('keyup', function () {
        const inputTag = this;
        if (!isEmailValid(inputTag.value)) {
          inputTag.classList.add('is-invalid');
        } else {
          inputTag.classList.remove('is-invalid');
        }
      });
    });
  }

  validText();
  validNumber();
  validEmail();
}

window.addEventListener('load', function () {
  assignButtonEvents();
})