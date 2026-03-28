const timeSlot = [];
const slotList = document.querySelector(".slots");

for (let i = 0; i < 10; i++) {
    const randHour = Math.floor(Math.random() * (23 - 6 + 1)) + 6;
    const time = new Date(2025, 2, 3, randHour, 0);
    timeSlot.push(time);
}

timeSlot.forEach(t => {
    const li = document.createElement("li");
    const hours = String(t.getHours()).padStart(2, "0");
    const minutes = String(t.getMinutes()).padStart(2, "0");
    li.textContent = `${hours}:${minutes}`;
    slotList.appendChild(li);
});
function submitTime() {
    const p = document.querySelector(".result");
    const timeInput = document.getElementById("time").value;

    if (!timeInput) {
        p.textContent = "Please select a time.";
        p.style.color = "orange";
        return;
    }

    const isAvailable = timeSlot.some(currTime => {
        const hours = String(currTime.getHours()).padStart(2, '0');
        const minutes = String(currTime.getMinutes()).padStart(2, '0');
        return `${hours}:${minutes}` === timeInput;
    });

    if (isAvailable) {
        p.textContent = "Slot is Available! Redirecting...";
        p.style.color = "lightgreen";

        setTimeout(() => {
            window.location.href = "appointments.html";
        }, 1000);

    } else {
        p.textContent = "Slot not available.";
        p.style.color = "red";
    }
}
