<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Table with Add & Edit Popup</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            flex-direction: column;
        }
    </style>
</head>

<body>

    <div class="container">
        <h2 class="mb-4">User Table</h2>
        <button class="btn btn-primary mb-3" id="addUserBtn">Add User</button>
        <button class="btn btn-primary mb-3" id="logout">Logout</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>#</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Handle</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="userTable">
                <tr>
                    <td>1</td>
                    <td>Mark</td>
                    <td>Otto</td>
                    <td>@mdo</td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn">Edit</button>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Jacob</td>
                    <td>Thornton</td>
                    <td>@fat</td>
                    <td>
                        <button class="btn btn-warning btn-sm editBtn">Edit</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="userModal" tabindex="-1" aria-labelledby="userModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="userModalLabel">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="userForm">
                        <input type="hidden" id="rowIndex">
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" required>
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" required>
                        </div>
                        <div class="mb-3">
                            <label for="handle" class="form-label">Handle</label>
                            <input type="text" class="form-control" id="handle" required>
                        </div>
                        <button type="submit" class="btn btn-success">Save</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Open modal for adding new user
            $("#addUserBtn").click(function() {
                $("#userModalLabel").text("Add User");
                $("#userForm")[0].reset();
                $("#rowIndex").val(""); // Clear index for new user
                $("#userModal").modal("show");
            });

            // Open modal for editing existing user
            $(document).on("click", ".editBtn", function() {
                let row = $(this).closest("tr");
                let rowIndex = row.index();
                let firstName = row.find("td:eq(1)").text();
                let lastName = row.find("td:eq(2)").text();
                let handle = row.find("td:eq(3)").text();

                $("#userModalLabel").text("Edit User");
                $("#firstName").val(firstName);
                $("#lastName").val(lastName);
                $("#handle").val(handle);
                $("#rowIndex").val(rowIndex);

                $("#userModal").modal("show");
            });

            // Save new or updated user
            $("#userForm").submit(function(event) {
                event.preventDefault();

                let firstName = $("#firstName").val();
                let lastName = $("#lastName").val();
                let handle = $("#handle").val();
                let rowIndex = $("#rowIndex").val();

                if (rowIndex === "") {
                    // Add new user
                    let rowCount = $("#userTable tr").length + 1;
                    let newRow = `<tr>
                        <td>${rowCount}</td>
                        <td>${firstName}</td>
                        <td>${lastName}</td>
                        <td>${handle}</td>
                        <td><button class="btn btn-warning btn-sm editBtn">Edit</button></td>
                    </tr>`;
                    $("#userTable").append(newRow);
                } else {
                    // Update existing user
                    let row = $("#userTable tr").eq(rowIndex);
                    row.find("td:eq(1)").text(firstName);
                    row.find("td:eq(2)").text(lastName);
                    row.find("td:eq(3)").text(handle);
                }

                $("#userModal").modal("hide");
            });
        });
    </script>

    <script>
        document.querySelector('#logout').addEventListener('click', function() {
            const token = localStorage.getItem('api_token');

            fetch('/api/logout', {
                    method: 'POST',
                    headers: {
                        'Authorization': `Bearer ${token}`,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    window.location.href = "/";
                })
                .catch(error => console.error('Logout failed:', error));
        });
    </script>


</body>

</html>
