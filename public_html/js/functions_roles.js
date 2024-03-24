$("#tableRoles").DataTable();

let tableRoles;
let formRole;

function openModal() {
  resetFormValues();
  d.querySelector("#id_role").value = "";
  d.querySelector("#modalTitle").textContent = "Nuevo Rol";
  d.querySelector(".modal-header").classList.replace(
    "headerUpdate",
    "headerRegister"
  );
  d.querySelector("#btnActionForm").classList.replace(
    "btn-info",
    "btn-primary"
  );
  d.querySelector("#btnText").textContent = "Guardar";
  $("#role_modal").modal("show");
}
function resetFormValues() {
  d.querySelector("#id_role").value = "";
  d.querySelector("#role_name").value = "";
  d.querySelector("#role_description").value = "";
}

function insertRole(formData) {
  axios
    .post(base_url + "/roles/insert", formData)
    .then((res) => {
      console.log(res);
      if (res.data.success === true) {
        $("#role_modal").modal("hide");
        formRole.reset();
        swal("Roles de usuarios", res.data.message, "success");
        tableRoles.ajax.reload();
      }
    })
    .catch((err) => {
      const errorMessage = err.response.data.message ?? "Error al crear rol";
      swal("Error", errorMessage, "error");
      console.log(err);
    });
}

function updateRole(formData) {
  axios
    .post(base_url + "/roles/update", formData)
    .then((res) => {
      console.log(res);
      if (res.data.success === true) {
        $("#role_modal").modal("hide");
        formRole.reset();
        swal("Roles de usuarios", res.data.message, "success");
        tableRoles.ajax.reload();
      }
    })
    .catch((err) => {
      const errorMessage = err.response.data.message ?? "Error al editar rol";
      swal("Error", errorMessage, "error");
      console.log(err);
    });
}

function handleSubmit(e) {
  e.preventDefault();
  const idRole = d.querySelector("#id_role").value;
  const role_name = d.querySelector("#role_name").value;
  const role_description = d.querySelector("#role_description").value;
  const status = d.querySelector("#role_status").value;
  if (role_name == "" || role_description == "" || status == "") {
    swal("Error", "Todos los campos son obligatorios", "error");
    return false;
  }
  const formData = new FormData(formRole);
  if (idRole == "") {
    formData.delete("id");
    insertRole(formData);
  } else {
    updateRole(formData);
  }
}

function handleButtonEditRole(roleId) {
  d.querySelector("#modalTitle").textContent = "Editar Rol";
  d.querySelector(".modal-header").classList.replace(
    "headerRegister",
    "headerUpdate"
  );
  d.querySelector("#btnActionForm").classList.replace(
    "btn-primary",
    "btn-info"
  );
  d.querySelector("#btnText").textContent = "Actualizar";
  $button = this;
  axios
    .get(`${base_url}/roles/find/${roleId}`)
    .then((res) => {
      const $role = res.data.data;
      if (res.data.success === true) {
        d.querySelector("#id_role").value = $role.id;
        d.querySelector("#role_name").value = $role.role_name;
        d.querySelector("#role_description").value = $role.role_description;
        let optionSelect = "";
        if ($role.status == 1) {
          optionSelect =
            '<option value="1" selected class="notBlock">Activo</option>';
        } else {
          optionSelect =
            '<option value="1" selected class="notBlock">Inactivo</option>';
        }
        const htmlSelectOptions = `${optionSelect}
                                    <option value="1">Activo</option>
                                    <option value="2">Inactivo</option>`;
        d.querySelector("#role_status").innerHTML = htmlSelectOptions;
        $("#role_modal").modal("show");
      } else {
        swal("Error", res.data.message, "error");
      }
    })
    .catch((err) => {
      const errorMessage = err.response.data.message ?? "Error al obtener rol";
      swal("Error", errorMessage, "error");
      console.log(err);
    });
}
function handleButtonDeleteRole(roleId) {
  swal(
    {
      title: "Eliminar Rol",
      text: "¿Está seguro de eliminar este rol?",
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
          .post(`${base_url}/roles/delete/${roleId}`)
          .then((res) => {
            if (res.data.success === true) {
              swal("Eliminado!", res.data.message, "success");
              tableRoles.ajax.reload(function () {});
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
function handleButtonPermissionsRole(roleId) {
  axios
    .get(`${base_url}/permissions/all/roles/${roleId}`)
    .then((res) => {
      if (res.data.success === true) {
        d.querySelector("#ajaxContent").innerHTML = res.data.html;
        $(".permissions_modal").modal("show");
        d.querySelector("#formPermissions").addEventListener(
          "submit",
          handleSubmitPermissionsRole
        );
      }
    })
    .catch((err) => {
      const errorMessage =
        err.response.data.message ?? "Error al obtener permisos del rol";
      swal("Error", errorMessage, "error");
      console.log(err);
    });
}

function handleSubmitPermissionsRole(e) {
  e.preventDefault();
  const formPermissions = document.querySelector("#formPermissions");
  const formData = new FormData(formPermissions);
  const roleId = formData.get("id");
  axios
    .post(`${base_url}/permissions/update/roles/${roleId}`, formData)
    .then((res) => {
      if (res.data.success === true) {
        swal("Permisos de usuario", res.data.message, "success");
      } else {
        swal("Error", res.data.message, "error");
      }
    })
    .catch((err) => {
      const errorMessage =
        err.response.data.message ?? "Error al asignar permisos";
      swal("Error", errorMessage, "error");
      console.log(err);
    });
}

document.addEventListener("DOMContentLoaded", () => {
  if ($("#tableRoles") != null) {
    tableRoles = $("#tableRoles").DataTable({
      aProcessing: true,
      aServerSide: true,
      language: {
        url: "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
      },
      ajax: {
        url: " " + base_url + "/roles/all",
        dataSrc: "",
      },
      columns: [
        { data: "id" },
        { data: "role_name" },
        { data: "role_description" },
        { data: "status" },
        { data: "options" },
      ],
      responsive: true,
      bDestroy: true,
      iDisplayLength: 5,
      order: [[0, "desc"]], //Ordenar (columna,orden)
    });
  }

  formRole = document.querySelector("#formRole");
  if (formRole != null) {
    formRole.addEventListener("submit", handleSubmit);
  }
});
