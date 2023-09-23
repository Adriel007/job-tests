const sender = document.getElementById("sender");
const result = document.getElementById("result");

sender.onclick = function () {
    const post = {
        method: "POST",
        body: JSON.stringify({
            base_url: document.getElementById("base_url").value,
            source_kladr: document.getElementById("source_kladr").value,
            target_kladr: document.getElementById("target_kladr").value,
            weight: document.getElementById("weight").value
        })
    };

    fetch("./server.php", post)
        .then(response => response.json())
        .then(showInfo);
};

function showInfo(json) {
    const titles = ["FastDelivery", "SlowDelivery"];
    result.innerHTML = ""; // Clear the result container

    const jsonArray = json.map((obj, index) => {
        const container = document.createElement("div");
        container.classList.add("delivery-info");

        const title = document.createElement("h2");
        title.textContent = titles[index];
        container.appendChild(title);

        const infoList = document.createElement("ul");

        for (let key in obj) {
            const listItem = document.createElement("li");
            listItem.innerHTML = `<strong>${key}:</strong> ${obj[key]} ${key == "price" ? "₽" : ""}`;
            infoList.appendChild(listItem);
        }

        container.appendChild(infoList);
        result.appendChild(container);

        return obj; // Preserve the original JSON structure
    });

    return jsonArray;
}

