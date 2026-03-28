    const department = document.getElementById("department");
    const secDiv = document.querySelector(".secInputSection");

    function setProcedure() {
        const val = department.value;

        secDiv.innerHTML = "";

        const procedureSelect = document.createElement("select");
        procedureSelect.id = "procedure";
        procedureSelect.multiple = true;

        let procedures = [];

        switch (val) {
            case "Pediatrics":
                procedures = [
                    { name: "Vaccination", cost: 50 },
                    { name: "General Checkup", cost: 30 },
                    { name: "Growth Assessment", cost: 40 }
                ];
                break;

            case "Radiology":
                procedures = [
                    { name: "X-Ray", cost: 100 },
                    { name: "MRI", cost: 500 },
                    { name: "CT Scan", cost: 400 }
                ];
                break;

            case "Cardiology":
                procedures = [
                    { name: "ECG", cost: 120 },
                    { name: "Echocardiogram", cost: 300 },
                    { name: "Stress Test", cost: 250 }
                ];
                break;

            default:
                return;
        }

        const defaultOption = document.createElement("option");
        defaultOption.textContent = "Select Procedure";
        defaultOption.value = "";
        procedureSelect.appendChild(defaultOption);

        procedures.forEach(proc => {
            const option = document.createElement("option");
            option.textContent = `${proc.name} ($${proc.cost})`;
            option.value = proc.cost; // cost as value
            procedureSelect.appendChild(option);
        });

        secDiv.appendChild(procedureSelect);
    }

function totalBill() {
    const procedureSelect = document.getElementById("procedure");

    if (!procedureSelect) {
        alert("Please select a department first!");
        return;
    }

    let total = 0;
    let bill_items = [];

    for (let option of procedureSelect.options) {
        if (option.selected && option.value !== "") {
            const cost = Number(option.value);
            const procedureName = option.textContent.split(" ($")[0];
            total += cost;
            bill_items.push({ name: procedureName, cost: cost });
        }
    }

    if (bill_items.length === 0) {
        alert("Please select at least one procedure!");
        return;
    }

    // Update the result section
    const resultSection = document.getElementById("resultSection");
    const billDetails = document.getElementById("billDetails");
    const totalAmount = document.getElementById("totalAmount");

    let billHTML = "<ul style='list-style: none; padding: 0;'>";
    bill_items.forEach(item => {
        billHTML += `<li style='color: #ccc; margin: 8px 0; font-size: 1rem; display: flex; justify-content: space-between;'><span>${item.name}</span><span style='color: #ffd54f;'>$${item.cost}</span></li>`;
    });
    billHTML += "</ul>";

    billDetails.innerHTML = billHTML;
    totalAmount.textContent = "$" + total.toFixed(2);
    resultSection.classList.add("active");
}
