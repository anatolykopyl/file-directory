const buttons = document.querySelectorAll('.delete-button')
buttons.forEach((button) => {
    button.addEventListener("click", async function (event) {
        const response = await fetch("delete.php", {
            method: 'POST',
            headers: {
                'Accept': 'application/x-www-form-urlencoded',
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: `file=${event.target.dataset.file}`
        });
        if (response.status === 200) {
            const deletedRow = document.querySelector(`.list-group-item[data-file='${event.target.dataset.file}']`);
            deletedRow.remove();
        }
    })
});

const fileInput = document.getElementById('upload');
fileInput.addEventListener('change', async function (event) {
    const file = event.target.files[0];
    let formData = new FormData();
    formData.append("file", file);
    const response = await fetch('upload.php', { method: "POST", body: formData });
    if (response.status === 200) {
        window.location.reload(false);
    }
});