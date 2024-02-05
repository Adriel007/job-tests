document.getElementById('fileInput').addEventListener('change', function (event) {
    const file = event.target.files[0];
    const formData = new FormData();
    formData.append('file', file);

    fetch('upload.php', {
        method: 'POST',
        body: formData
    })
        .then(response => {
            if (response.ok) {
                document.getElementById('status').innerHTML = '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: green;"></div>';
                return response.text();
            } else {
                document.getElementById('status').innerHTML = '<div style="width: 50px; height: 50px; border-radius: 50%; background-color: red;"></div>';
                throw new Error('Error in file upload');
            }
        })
        .then(data => {
            const lines = data.split('\n');
            lines.forEach(line => {
                const digitCount = (line.match(/\d/g) || []).length;
                console.log(`${line} = ${digitCount}`);
            });
        })
        .catch(error => {
            console.error('Error:', error);
        });
});

document.querySelector('select[name="type_val"]').addEventListener('change', function () {
    const selectedValue = this.value;
    const inputs = document.querySelectorAll('input[name^="input_"]');

    inputs.forEach(input => {
        if (input.name === 'input_' + selectedValue) {
            input.style.display = 'block';
        } else {
            input.style.display = 'none';
        }
    });
});

