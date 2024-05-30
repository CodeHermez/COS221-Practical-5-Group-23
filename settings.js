// function updateProfile(data) {
//     return new Promise((resolve, reject) => {
//         const xhr = new XMLHttpRequest();
//         const url = 'http://localhost/221/Prac5/COS221-Practical-5-GROUP-23/hoop/COS221P5/updateProfile.php'; // http://localhost/221/Prac5/COS221-Practical-5-GROUP-23/api/ProfilePicture.php

//         xhr.open('PATCH', url, true);
//         xhr.setRequestHeader('Content-Type', 'application/json');

//         xhr.onreadystatechange = function () {
//             if (xhr.readyState === XMLHttpRequest.DONE) {
//                 if (xhr.status === 200) {
//                     resolve(JSON.parse(xhr.responseText));
//                 } else {
//                     reject(xhr.responseText);
//                 }
//             }
//         };

//         xhr.send(JSON.stringify(data));
//     });
// }

// function updateProfile(data) {
//     return new Promise((resolve, reject) => {
//         const url = 'http://localhost/221/Prac5/COS221-Practical-5-GROUP-23/hoop/COS221P5/updateProfile.php';

//         axios.patch(url, data, {
//             headers: {
//                 'Content-Type': 'application/json'
//             }
//         })
//         .then(response => {
//             resolve(response.data);
//         })
//         .catch(error => {
//             reject(error.response.data);
//             console.log(error.response.data);
//         });
//     });
// }

// document.getElementById('settingsForm').addEventListener('submit', async function (event) {
//     event.preventDefault();

//     const formData = new FormData(this);
//     const jsonData = {};

//     // Loop through form data and only include initialized keys
//     formData.forEach((value, key) => {
//         if (value !== '') { // Check if value is initialized
//             jsonData[key] = value;
//         }
//     });

//     try {
//         const response = await updateProfile(jsonData);

//         const responseMessage = document.getElementById('responseMessage');
//         if (response.status === 'success') {
//             responseMessage.innerHTML = `<div class="alert alert-success">${response.message}</div>`;
//         } else {
//             responseMessage.innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
//         }
//     } catch (error) {
//         document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">An error occurred: ${error}</div>`;
//     }
// });

function updateProfile(data) {
    return new Promise((resolve, reject) => {
        const url = 'http://UpdateProfile.php';

        axios.patch(url, data, {
            headers: {
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            resolve(response.data);
        })
        .catch(error => {
            console.error('Error updating profile:', error); // Log error to console
            reject(error.response.data);
        });
    });
}

document.getElementById('settingsForm').addEventListener('submit', async function (event) {
    event.preventDefault();

    const formData = new FormData(this);
    const jsonData = {};

    // Loop through form data and only include initialized keys
    formData.forEach((value, key) => {
        if (value !== '') { // Check if value is initialized
            jsonData[key] = value;
        }
    });

    console.log('Submitting updateProfile request with data:', jsonData); // Log request data

    try {
        const response = await updateProfile(jsonData);

        console.log('updateProfile response:', response); // Log response

        const responseMessage = document.getElementById('responseMessage');
        if (response.status === 'success') {
            responseMessage.innerHTML = `<div class="alert alert-success">${response.message}</div>`;
        } else {
            responseMessage.innerHTML = `<div class="alert alert-danger">${response.message}</div>`;
        }
    } catch (error) {
        console.error('Error updating profile:', error); // Log error to console
        document.getElementById('responseMessage').innerHTML = `<div class="alert alert-danger">An error occurred: ${error}</div>`;
    }
});