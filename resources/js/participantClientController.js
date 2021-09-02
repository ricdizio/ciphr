const { isNull, forEach, split } = require("lodash");

// Gets a reference to the form (add) element
var formAdd = document.getElementById('modal-form');

// Gets a reference to the form (add) element
var formEdit= document.getElementById('edit-modal-form');

// prevent default event form "submit" event. (Add participant)
formAdd.addEventListener('submit', function(e) {
    e.preventDefault();
});

// prevent default event form "submit" event. (Edit participant)
formEdit.addEventListener('submit', function(e) {
    e.preventDefault();
});


window.addRegister = function () {

    let url = document.getElementById("addRegisterURL").getAttribute("href");
    let fnameI = document.getElementById("first-name").value;
    let lnameI = document.getElementById("last-name").value;
    let phoneI = document.getElementById("phone").value;
    let noteI = document.getElementById("note").value;
    let data = {
        firstName: fnameI,
        lastName: lnameI,
        phone: phoneI,
        note: noteI
    };

    fetch(url, {
        method: 'POST', // or 'PUT'
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if( data.hasOwnProperty("success") && data.success == "true") { 
            Swal.fire(
                'Done!',
                'Participant added successfully!',
                'success'
            )
            .then(()=>{
                location.reload(); 
            })
        }
        else {
            try {
                for (const e in data) {
                    data[e].forEach(m => {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: `Something went wrong! ${m}`,
                        })
                    });
                }
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
                console.error('Error:', error);
            }
            
        }
    })
    .catch((error) => {

        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',
        })

        console.error('Error:', error);

    });
}

window.deleteRegister = function (id) {

    let url = document.getElementById("deleteRegisterURL").getAttribute("href");
    let data = {
        id: id
    }

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(url, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(data),
            })
            .then(response => response.json())
            .then(data => {
                if( data.hasOwnProperty("success") && data.success == "true") { 
                    Swal.fire(
                        'Deleted!',
                        'Your register has been deleted.',
                        'success'
                    )
                    .then(()=>{
                        location.reload(); 
                    })
                }
                else {
                    try {
                        for (const e in data) {
                            data[e].forEach(m => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: `Something went wrong! ${m}`,
                                })
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                        console.error('Error:', error);
                    }
                    
                }
            })
            .catch((error) => {
        
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
                console.error('Error:', error);
            });
        }
    })
}

window.refreshShow = function() {

    let url = new URL(document.getElementById("showURL").getAttribute("href"));

    let checked = getParameterByName("checked");

    if( document.getElementById("note-toggle").checked ) {
        checked = "true";
    }else{
        checked = "false"
    }

    let params = {
        note: checked
    }

    Object.keys(params).forEach(key => url.searchParams.append(key, params[key]))

    window.location = url;

}

window.updateRegisterLoad = function (id) {

    let data = getRowInfo(id);

    loadEditModal(id, data.fname, data.lname, data.phone, data.note);       
    
}

window.updateRegister = function() {

    Swal.fire({
        title: 'Are you sure?',
        text: "The field will be updated!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, update it!'
    }).then((result, id) => {

        if (result.isConfirmed) {

            let url = document.getElementById("updateRegisterURL").getAttribute("href");
            let params = {
                id: document.getElementById("idLabel").value,
                fName: document.getElementById("edit-first-name").value,
                lName: document.getElementById("edit-last-name").value,
                phone: document.getElementById("edit-phone").value,
                note: document.getElementById("edit-note").value,
            }

            fetch(url, {
                method: 'POST', // or 'PUT'
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify(params),
            })
            .then(response => response.json())
            .then(data => {
                if( data.hasOwnProperty("success") && data.success == "true") { 
                    Swal.fire(
                        'Updated!',
                        'Your register has been updated.',
                        'success'
                    )
                    .then(()=>{
                        location.reload(); 
                    })
                }
                else {

                    try {
                        for (const e in data) {
                            data[e].forEach(m => {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: `Something went wrong! ${m}`,
                                })
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                        console.error('Error: request could not be processed');
                    }
                }
            })
            .catch((error) => {
        
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                })
                console.error('Error:', error);
            });
        }
    })
    
}

function loadEditModal(id, fname, lname, phone, note) {
    document.getElementById("idLabel").value = id;
    document.getElementById("edit-first-name").value = fname;
    document.getElementById("edit-last-name").value = lname;
    document.getElementById("edit-phone").value = phone;
    document.getElementById("edit-note").value = note;
}

function getRowInfo(id) {
    return {
        "fname": document.getElementById(`row-${id}-col-fname`).innerHTML,
        "lname": document.getElementById(`row-${id}-col-lname`).innerHTML,
        "phone": document.getElementById(`row-${id}-col-phone`).innerHTML,
        "note": document.getElementById(`row-${id}-col-note`).innerHTML,
    }
}

function getParameterByName(name, url = window.location.href) {
    name = name.replace(/[\[\]]/g, '\\$&');
    var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
        results = regex.exec(url);
    if (!results) return null;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, ' '));
}