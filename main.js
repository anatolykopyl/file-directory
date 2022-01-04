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
const progressBar = document.getElementById('progress');
fileInput.addEventListener('change', async function (event) {
    const file = event.target.files[0];
    let formData = new FormData();
    formData.append("file", file);
    axios.request({
        method: "post",
        url: "upload.php", 
        data: formData,
        headers: { "Content-Type": "multipart/form-data" },
        onUploadProgress: (p) => {
            progressBar.style.display = 'block';
            progressBar.children[0].style.width = `${p.loaded / p.total}%`;
        }
    }).then (data => {
        window.location.reload(false);
    })
});
