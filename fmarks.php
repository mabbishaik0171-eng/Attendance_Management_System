<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marks Management</title>
    <link rel="stylesheet" href="fmarks.css">

</head>

<body>
    <div class="container">
        <h2>Marks Management</h2>
        <nav>
            <button onclick="showSection('display')">Display Marks</button>
            <button onclick="showSection('add')">Add Marks</button>
            <button onclick="showSection('edit')">Edit Marks</button>
            <button onclick="showSection('delete')">Delete Marks</button>
        </nav>


        <div id="display" class="section active">
            <h3>Marks Records</h3>
            <table id="marksTable">
                <thead>
                    <tr>
                        <th>Roll No</th>
                        <th>Name</th>
                        <th>Subject</th>
                        <th>Marks</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>

        <div id="add" class="section">
            <h3>Add Marks</h3>
            <form id="addForm">
                <label>Roll No:</label><input type="text" id="addRoll" required>
                <label>Name:</label><input type="text" id="addName" required>
                <label>Subject:</label><input type="text" id="addSubject" required>
                <label>Marks:</label><input type="number" id="addMarks" required>
                <button type="submit" class="submit-btn">Add</button>
            </form>
        </div>

        <div id="edit" class="section">
            <h3>Edit Marks</h3>
            <form id="editForm">
                <label>Roll No:</label><input type="text" id="editRoll" required>
                <label>Subject:</label><input type="text" id="editSubject" required>
                <label>Update Marks:</label><input type="number" id="editMarks" required>
                <button type="submit" class="submit-btn">Update</button>
            </form>
        </div>


        <div id="delete" class="section">
            <h3>Delete Marks</h3>
            <form id="deleteForm">
                <label>Roll No:</label><input type="text" id="deleteRoll" required>
                <label>Subject:</label><input type="text" id="deleteSubject" required>
                <button type="submit" class="submit-btn" style="background:#dc3545;">Delete</button>
            </form>
        </div>
    </div>

    <script>
        function showSection(id) {
            document.querySelectorAll('.section').forEach(s => s.classList.remove('active'));
            document.getElementById(id).classList.add('active');
        }


        document.getElementById("addForm").addEventListener("submit", e => {
            e.preventDefault();
            const roll = document.getElementById("addRoll").value.trim();
            const name = document.getElementById("addName").value.trim();
            const subject = document.getElementById("addSubject").value.trim();
            const marks = document.getElementById("addMarks").value.trim();
            const row = document.getElementById("marksTable").querySelector("tbody").insertRow();
            row.insertCell(0).innerText = roll;
            row.insertCell(1).innerText = name;
            row.insertCell(2).innerText = subject;
            row.insertCell(3).innerText = marks;
            alert("Marks added!");
            e.target.reset();
            showSection("display");
        });


        document.getElementById("editForm").addEventListener("submit", e => {
            e.preventDefault();
            const roll = document.getElementById("editRoll").value.trim();
            const subject = document.getElementById("editSubject").value.trim();
            const marks = document.getElementById("editMarks").value.trim();
            let found = false;
            const rows = document.getElementById("marksTable").querySelector("tbody").rows;
            for (let row of rows) {
                if (row.cells[0].innerText === roll && row.cells[2].innerText === subject) {
                    row.cells[3].innerText = marks;
                    found = true;
                    break;
                }
            }
            alert(found ? "Marks updated!" : "Record not found!");
            e.target.reset();
            showSection("display");
        });

        document.getElementById("deleteForm").addEventListener("submit", e => {
            e.preventDefault();
            const roll = document.getElementById("deleteRoll").value.trim();
            const subject = document.getElementById("deleteSubject").value.trim();
            let found = false;
            const tbody = document.getElementById("marksTable").querySelector("tbody");
            for (let i = 0; i < tbody.rows.length; i++) {
                if (tbody.rows[i].cells[0].innerText === roll && tbody.rows[i].cells[2].innerText === subject) {
                    tbody.deleteRow(i);
                    found = true;
                    break;
                }
            }
            alert(found ? "Record deleted!" : "Record not found!");
            e.target.reset();
            showSection("display");
        });
    </script>
</body>

</html>