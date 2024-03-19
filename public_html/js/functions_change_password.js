const d = document;

if (d.querySelector("#formChangePassword")) {
  const formChangePassword = d.querySelector("#formChangePassword");
  formChangePassword.addEventListener("submit", (e) => {
    e.preventDefault();

    const password = d.querySelector("#password").value;
    const confirmPassword = d.querySelector("#confirmPassword").value;

    if (password == "" || confirmPassword == "") {
      swal("Error", "Escribe la nueva contraseña", "error");
      return;
    }
    if (password !== confirmPassword) {
      swal("Error", "Las contraseñas no coinciden", "error");
      return;
    }
    if (password.length < 3) {
      swal("Error", "La contraseña debe tener al menos 3 caracteres", "error");
      return;
    }
    if (password !== confirmPassword) {
      swal("Error", "Las contraseñas no coinciden", "error");
      return;
    }
    const formData = new FormData(formChangePassword);
    axios
      .post(`${base_url}/auth/change-password`, formData)
      .then((res) => {
        console.log(res);
        if (res.data.success) {
          swal(
            {
              title: "Éxito",
              text: res.data.message,
              type: "success",
              confirmButtonText: "Iniciar Sesión",
              closeOnConfirm: false,
            },
            function (isConfirm) {
              if (isConfirm) {
                window.location.href = `${base_url}/login`;
              }
            }
          );
        }
      })
      .catch((err) => {
        console.log(err);
        swal("Error", err.response.data.message, "error");
      });
  });
}
