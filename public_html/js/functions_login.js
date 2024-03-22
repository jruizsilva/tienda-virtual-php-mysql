// Login Page Flipbox control
const d = document;

$('.login-content [data-toggle="flip"]').click(function () {
  $(".login-box").toggleClass("flipped");
  return false;
});

d.addEventListener("DOMContentLoaded", function () {
  const formLogin = d.querySelector("#formLogin");
  const formResetPassword = d.querySelector("#formResetPassword");
  const divloading = d.querySelector("#divloading");

  formLogin.onsubmit = function (e) {
    e.preventDefault();
    const email = d.querySelector("#email").value;
    const password = d.querySelector("#password").value;

    if (email == "" || password == "") {
      swal("Error", "Todos los campos son obligatorios", "error");
      return false;
    }
    divloading.style.display = "flex";
    const formData = new FormData(formLogin);
    axios
      .post(`${base_url}/auth/login`, formData)
      .then((res) => {
        if (res.data.success == true) {
          window.location.href = `${base_url}/dashboard`;
        } else {
          swal("Error", res.data.message, "error");
          d.querySelector("#password").value = "";
        }
      })
      .catch((err) => {
        console.log(err);
        swal("Error", err.response.data.message, "error");
      })
      .finally(() => {
        divloading.style.display = "none";
      });
  };

  formResetPassword.onsubmit = function (e) {
    e.preventDefault();

    const resetPasswordEmail = d.querySelector("#resetPasswordEmail").value;

    if (resetPasswordEmail == "") {
      swal("Error", "Ingresa tu correo electronico", "error");
      return false;
    }
    divloading.style.display = "flex";
    const formData = new FormData(formResetPassword);
    axios
      .post(`${base_url}/auth/reset-password`, formData)
      .then((res) => {
        console.log("res", res);
        if (res.data.success == true) {
          swal(
            {
              title: "",
              text: res.data.message,
              type: "success",
              showCancelButton: false,
              confirmButtonText: "Aceptar",
              closeOnConfirm: false,
            },
            function (isConfirm) {
              if (isConfirm) {
                window.location.href = `${base_url}`;
              }
              d.querySelector("#resetPasswordEmail").value = "";
            }
          );
        } else {
          swal("Error", res.data.message, "error");
          d.querySelector("#resetPasswordEmail").value = "";
          d.querySelector("#resetPasswordEmail").focus();
        }
      })
      .catch((err) => {
        console.log(err);
        swal("Error", err.response.data.message, "error");
      })
      .finally(() => {
        divloading.style.display = "none";
      });
  };
});
