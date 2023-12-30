<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Task Page</title>
    <style>
        body,
        h1,
        h2,
        h3,
        p,
        ul {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
        }

        h1 {
            text-align: center;
            margin-top: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        table,
        th,
        td {
            border: 1px solid black;
        }

        th,
        td {
            padding: 12px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        tfoot {
            text-align: center;
        }

        .pagination {
            display: flex;
            list-style: none;
            padding: 0;
            justify-content: center;
        }

        .pagination li {
            margin-right: 10px;
        }

        .pagination a {
            text-decoration: none;
            padding: 10px;
            background-color: #4CAF50;
            color: white;
            border-radius: 5px;
        }

        .pagination a.active {
            background-color: #45a049;
        }

        .pagination a:hover {
            background-color: #388e3c;
        }

        #searchInput {
            margin-bottom: 10px;
            padding: 8px;
        }

        #popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: white;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 2;
            opacity: 0;
            transition: opacity 0.3s ease-in-out;
            flex-direction: column;
            box-sizing: border-box;
            width: 60%;
        }

        #popupFooter {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
        }

        #popupHeader {
            text-align: center;
            margin-bottom: 20px;
        }

        #popupContent {
            text-align: left;
        }

        #popupContent div {
            display: flex;
            flex-direction: row;
            align-items: baseline;
            justify-content: space-between;
            padding-right: 200px;
            margin-bottom: 10px;
        }

        #popupContent div input,
        #popupContent div textarea {
            font-family: Arial, sans-serif;
            padding: 2px;
            outline: none;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 1.2em;
            width: 400px;
            resize: none;
        }

        #closeButton {
            cursor: pointer;
            display: block;
            margin-top: 20px;
            text-align: center;
            padding: 10px;
            background-color: #f44336;
            color: white;
            border: none;
            border-radius: 5px;
            width: fit-content;
            font-weight: bold;
            font-size: 1.2em;
            transition: background-color 0.3s ease;
        }

        #closeButton:hover {
            background-color: #d32f2f;
        }
    </style>
</head>

<body>
    <h1>Task Page</h1>
    <input type="text" id="searchInput" placeholder="Search by Title">
    <hr>
    <table id="taskTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Date</th>
                <th>Author</th>
                <th>Status</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($tasks as $task) {
                echo "<tr><td>{$task['id']}</td><td>{$task['title']}</td><td>{$task['date']}</td><td>{$task['author']}</td><td>{$task['status']}</td><td>{$task['description']}</td></tr>";
            }
            ?>
        </tbody>
    </table>
    <div id="popup">
        <div id="popupHeader">
            <h2></h2>
        </div>
        <div id="popupContent">
            <div>
                <h3>Заголовок</h3>
                <input type="text" id="title" value="" readonly>
            </div>
            <div>
                <h3>Дата выполнения</h3>
                <input type="date" id="date" value="" readonly>
            </div>
            <div>
                <h3>Автор</h3>
                <input type="text" id="author" value="" readonly>
            </div>
            <div>
                <h3>Статус</h3>
                <input type="text" id="status" value="" readonly>
            </div>
            <div>
                <h3>Описание</h3>
                <textarea id="description" readonly></textarea>
            </div>
        </div>
        <div id="popupFooter">
            <button id="closeButton">Закрывать</button>
        </div>
    </div>
    <div id="pagination" class="pagination"></div>
    <script>
        (
            function() {
                let tasks = <?php echo json_encode($tasks); ?>;
                let filteredTasks = tasks;

                const perPage = 10;
                let currentPage = 1;

                function displayTasks() {
                    const tableBody = document.querySelector("#taskTable tbody");
                    tableBody.innerHTML = "";

                    const start = (currentPage - 1) * perPage;
                    const end = start + perPage;
                    const currentTasks = filteredTasks.slice(start, end);

                    currentTasks.forEach(task => {
                        const row = document.createElement("tr");
                        row.innerHTML =
                            `<td>${task.id}</td><td>${task.title}</td><td>${task.date}</td><td>${task.author}</td><td>${task.status}</td><td>${task.description}</td>`;
                        tableBody.appendChild(row);
                    });
                }

                function generatePagination() {
                    const paginationContainer = document.querySelector("#pagination");
                    paginationContainer.innerHTML = "";

                    const totalPages = Math.ceil(filteredTasks.length / perPage);
                    const maxButtons = 5;

                    let startPage = Math.max(1, currentPage - Math.floor(maxButtons / 2));
                    let endPage = Math.min(totalPages, startPage + maxButtons - 1);

                    if (endPage - startPage + 1 < maxButtons) {
                        startPage = Math.max(1, endPage - maxButtons + 1);
                    }

                    for (let i = startPage; i <= endPage; i++) {
                        const pageLink = document.createElement("a");
                        pageLink.href = "#";
                        pageLink.textContent = i;

                        if (i === currentPage) {
                            pageLink.classList.add("active");
                        }

                        pageLink.addEventListener("click", () => {
                            currentPage = i;
                            displayTasks();
                            generatePagination();
                        });

                        paginationContainer.appendChild(pageLink);
                    }
                }

                function filterTable() {
                    const input = document.getElementById("searchInput");
                    const filter = input.value.toUpperCase();
                    filteredTasks = tasks.filter(task => task.title.toUpperCase().includes(filter));
                    currentPage = 1;
                    displayTasks();
                    generatePagination();
                }

                function showPopup(task) {
                    const popup = document.getElementById("popup");
                    const popupContent = document.getElementById("popupContent");
                    const popupHeader = document.getElementById("popupHeader").children[0];
                    const fields = {
                        title: document.getElementById("title"),
                        date: document.getElementById("date"),
                        author: document.getElementById("author"),
                        status: document.getElementById("status"),
                        description: document.getElementById("description")
                    };

                    const closeButton = document.getElementById("closeButton");
                    closeButton.addEventListener("click", closePopup);

                    popupHeader.textContent = "Информация о задании № " + task.id;
                    fields.title.value = task.title;
                    fields.date.value = task.date;
                    fields.author.value = task.author;
                    fields.status.value = task.status;
                    fields.description.value = task.description;

                    popup.style.display = "flex";
                    setTimeout(() => {
                        popup.style.opacity = 1;
                    }, 10);
                }

                function closePopup() {
                    const popup = document.getElementById("popup");

                    popup.style.opacity = 0;
                    setTimeout(() => {
                        popup.style.display = "none";
                    }, 300);
                }

                document.getElementById("searchInput").addEventListener("input", filterTable);

                document.getElementById("taskTable").addEventListener("click", function(event) {
                    const target = event.target;
                    if (target.tagName === "TD") {
                        const rowIndex = target.parentElement.rowIndex;
                        const task = filteredTasks[(currentPage - 1) * perPage + rowIndex - 1];
                        showPopup(task);
                    }
                });

                displayTasks();
                generatePagination();
            }
        )();
    </script>
</body>

</html>
