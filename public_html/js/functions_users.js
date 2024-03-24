let formUsers;
let tableUsers;

function handleButtonViewUser(userId) {
  $("#view_user_modal").modal("show");

  axios
    .get(base_url + "/users/find/" + userId)
    .then((res) => {
      console.log(res);
      if (res.data.success === true) {
        const user = res.data.data;
        const userStatusHtml =
          Number(user.status) === 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">Inactivo</span>';
        d.querySelector("#identificacion_view").innerHTML = user.identificacion;
        d.querySelector("#names_view").innerHTML = user.names;
        d.querySelector("#surname_view").innerHTML = user.surname;
        d.querySelector("#email_view").innerHTML = user.status;
        d.querySelector("#tipo_usuario_view").innerHTML = user.role_name;
        d.querySelector("#status_view").innerHTML = userStatusHtml;
        d.querySelector("#date_created_view").innerHTML = user.fecha_registro;
      } else {
        const errorMessage = res.data.message ?? "Error al obtener usuario";
        swal("Error", errorMessage, "error");
        console.error(err);
        $("#view_user_modal").modal("hide");
      }
    })
    .catch((err) => {
      const errorMessage = res.data.message ?? "Error al obtener usuario";
      swal("Error", errorMessage, "error");
      console.error(err);
      $("#view_user_modal").modal("hide");
    });
}
function handleButtonEditUser(userId) {
  d.querySelector("#modalTitle").innerHTML = "Actualizar Usuario";
  d.querySelector(".modal-header").classList.replace(
    "headerRegister",
    "headerUpdate"
  );
  d.querySelector("#btnActionForm").classList.replace(
    "btn-primary",
    "btn-info"
  );
  d.querySelector("#btnText").innerHTML = "Actualizar";

  axios
    .get(base_url + "/users/find/" + userId)
    .then((res) => {
      console.log(res);
      if (res.data.success === true) {
        $("#users_modal").modal("show");
        const user = res.data.data;
        d.querySelector("#id_user").value = user.id;
        d.querySelector("#identificacion").value = user.identificacion;
        d.querySelector("#names").value = user.names;
        d.querySelector("#surname").value = user.surname;
        d.querySelector("#phone").value = user.phone;
        d.querySelector("#email").value = user.email;
        d.querySelector("#role_id_list").value = user.role_id;
        $("#role_id_list").selectpicker("render");
        d.querySelector("#status_list").value = user.status;
        $("#status_list").selectpicker("render");
      } else {
        const errorMessage = res.data.message ?? "Error al obtener usuario";
        swal("Error", errorMessage, "error");
        console.error(err);
        $("#view_user_modal").modal("hide");
      }
    })
    .catch((err) => {
      console.error(err);
      const errorMessage =
        err.response.data.message ?? "Error al obtener usuario";
      swal("Error", errorMessage, "error");
      $("#view_user_modal").modal("hide");
    });
}
function handleButtonDeleteUser(userId) {
  swal(
    {
      title: "Eliminar Usuario",
      text: "¿Está seguro de eliminar este usuario?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, eliminar!",
      cancelButtonText: "No, cancelar!",
      closeOnConfirm: false,
      closeOnCancel: true,
    },
    function (isConfirm) {
      if (isConfirm) {
        axios
          .post(`${base_url}/users/delete/${userId}`)
          .then((res) => {
            if (res.data.success === true) {
              swal("Eliminado!", res.data.message, "success");
              tableUsers.ajax.reload(function () {});
            } else {
              swal("Error!", res.data.message, "error");
            }
          })
          .catch((err) => {
            const errorMessage =
              err.response.data.message ?? "Error al eliminar rol";
            swal("Error!", errorMessage, "error");
            console.log(err);
          });
      }
    }
  );
}

function openModal() {
  d.querySelector("#formUsers").reset();
  d.querySelector("#id_user").value = "";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegister"
  );
  d.querySelector("#btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.querySelector("#btnText").innerHTML = "Guardar";
  d.querySelector("#modalTitle").innerHTML = "Registrar Usuario";
  $("#users_modal").modal("show");
}

function fetchRolesOptions() {
  if (d.querySelector("#role_id_list") != null) {
    axios
      .get(base_url + "/roles/allSelectOptions")
      .then((res) => {
        if (res.data.success == true) {
          const html = res.data.data;
          d.querySelector("#role_id_list").innerHTML = html;
          d.querySelector("#role_id_list").value = 1;
          $("#role_id_list").selectpicker("render");
        }
      })
      .catch((err) => {
        console.log(err);
      });
  }
}

function insertUser(formData) {
  axios
    .post(base_url + "/users/insert", formData)
    .then((res) => {
      console.log(res);
      if (res.data.success === true) {
        $("#users_modal").modal("hide");
        formUsers.reset();
        swal("Lista usuarios", res.data.message, "success");
        tableUsers.ajax.reload();
      } else {
        console.error(err);
        const errorMessage =
          err.response.data.message ?? "Error al crear usuario";
        swal("Error", errorMessage, "error");
      }
    })
    .catch((err) => {
      console.error(err);
      const errorMessage =
        err.response.data.message ?? "Error al crear usuario";
      swal("Error", errorMessage, "error");
    });
}

function updateUser(formData) {
  axios
    .post(base_url + "/users/update", formData)
    .then((res) => {
      console.log(res);
      if (res.data.success === true) {
        $("#users_modal").modal("hide");
        formUsers.reset();
        swal("Lista de usuarios", res.data.message, "success");
        tableUsers.ajax.reload();
      }
    })
    .catch((err) => {
      const errorMessage =
        err.response.data.message ?? "Error al editar usuario";
      swal("Error", errorMessage, "error");
      console.log(err);
    });
}
function handleSubmit(e) {
  e.preventDefault();
  const identificacion = d.querySelector("#identificacion").value;
  const names = d.querySelector("#names").value;
  const surname = d.querySelector("#surname").value;
  const phone = d.querySelector("#phone").value;
  const email = d.querySelector("#email").value;
  const roleId = d.querySelector("#role_id_list").value;

  if (
    identificacion == "" ||
    names == "" ||
    surname == "" ||
    phone == "" ||
    email == "" ||
    roleId == ""
  ) {
    swal("Atención", "Todos los campos son obligatorios", "error");
    return false;
  }

  const elementsWithClassValid = d.getElementsByClassName("valid");
  for (let i = 0; i < elementsWithClassValid.length; i++) {
    if (elementsWithClassValid[i].classList.contains("is-invalid")) {
      swal("Atención", "Verifique los campos en rojo", "error");
      return false;
    }
  }

  const idUser = d.querySelector("#id_user").value;
  const formData = new FormData(formUsers);

  if (idUser == "") {
    formData.delete("id");
    insertUser(formData);
  } else {
    updateUser(formData);
  }
}

d.addEventListener("DOMContentLoaded", function () {
  fetchRolesOptions();
  formUsers = d.querySelector("#formUsers");

  tableUsers = $("#tableUsers").DataTable({
    aProcessing: true,
    aServerSide: true,
    language: {
      url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
    },
    ajax: {
      url: " " + base_url + "/users/all",
      dataSrc: "",
    },
    columns: [
      { data: "id" },
      { data: "names" },
      { data: "surname" },
      { data: "email" },
      { data: "phone" },
      { data: "role_name" },
      { data: "status" },
      { data: "options" },
    ],
    dom: "lBfrtip", //Botones de exportacion
    buttons: [
      {
        extend: "copyHtml5",
        text: "<i class='fas fa-copy'></i> Copiar",
        titleAttr: "Copiar",
        className: "btn btn-secondary",
      },
      {
        extend: "excelHtml5",
        text: "<i class='fas fa-file-excel'></i> Excel",
        titleAttr: "Exportar a Excel",
        className: "btn btn-success",
      },
      {
        extend: "pdfHtml5",
        text: "<i class='fas fa-file-pdf'></i> PDF",
        titleAttr: "Exportar a PDF",
        className: "btn btn-danger",
      },
      {
        extend: "csvHtml5",
        text: "<i class='fas fa-file-csv'></i> CSV",
        titleAttr: "Exportar a CSV",
        className: "btn btn-info",
      },
    ],
    responsive: true,
    bDestroy: true,
    iDisplayLength: 2,
    order: [[0, "desc"]], //Ordenar (columna,orden)
  });

  if (formUsers != null) {
    formUsers.addEventListener("submit", handleSubmit);
  }
});
