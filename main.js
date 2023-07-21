// console.log("Hello World!");

const deleteEmployeeBtns = document.querySelectorAll(".delete-employee");

deleteEmployeeBtns.forEach((btn) => {
  btn.addEventListener("click", (e) => {
    if (confirm("Are you sure you want to delete this employee?")) {
      let employeeId = e.target.value;
      console.log(employeeId);

      // Create Ajax POST Request
      $.post("delete.php", { id: employeeId }).done(function (data) {
        window.location = "index.php";
      });
    }
  });
});
