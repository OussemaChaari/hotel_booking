let add_room_form = document.getElementById('add_room_form');
add_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_room();
});
function add_room() {
    let data = new FormData();
    data.append('add_room', '');
    data.append('name', add_room_form.elements['name'].value);
    data.append('area', add_room_form.elements['area'].value);
    data.append('price', add_room_form.elements['price'].value);
    data.append('quantity', add_room_form.elements['quantity'].value);
    data.append('adult', add_room_form.elements['adult'].value);
    data.append('children', add_room_form.elements['children'].value);
    data.append('description', add_room_form.elements['description'].value);
    let features = [];
    add_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });
    let facilities = [];
    add_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });
    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.onload = function () {
        $('#add_room_modal').modal('hide');
        if (this.responseText == 1) {
            alert('success', 'New Room Added!');
            add_room_form.reset();
            get_rooms();
        } else {
            alert('error', 'Failed to insert Room!');
        }
    };
    xhr.send(data);
}
function get_rooms() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('rooms-data').innerHTML = this.responseText;
    }
    xhr.send('get_rooms');
}

function toggle_status(id, val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Status Toggled!');
            get_rooms();
        } else {
            alert('error', 'Failed to toggle!');
        }
    }
    xhr.send('toggle_status=' + id + '&value=' + val);
}
let edit_room_form = document.getElementById('edit_room_form');

function edit_details(id) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        // $('#edit_room_modal').modal('hide');
        let data = JSON.parse(this.responseText);
        edit_room_form.elements['name'].value = data.room_data.name;
        edit_room_form.elements['area'].value = data.room_data.area;
        edit_room_form.elements['price'].value = data.room_data.price;
        edit_room_form.elements['quantity'].value = data.room_data.quantity;
        edit_room_form.elements['adult'].value = data.room_data.adult;
        edit_room_form.elements['children'].value = data.room_data.children;
        edit_room_form.elements['description'].value = data.room_data.description;
        edit_room_form.elements['room_id'].value = data.room_data.id;

        edit_room_form.elements['features'].forEach(el => {
            el.checked = data.features.includes(Number(el.value));
        });
        edit_room_form.elements['facilities'].forEach(el => {
            el.checked = data.facilities.includes(Number(el.value));
        });

    };
    xhr.send('get_room=' + id);
}
edit_room_form.addEventListener('submit', function (e) {
    e.preventDefault();
    edit_room();
});
function edit_room() {
    let data = new FormData();
    data.append('edit_room', '');
    data.append('room_id', edit_room_form.elements['room_id'].value);
    data.append('name', edit_room_form.elements['name'].value);
    data.append('area', edit_room_form.elements['area'].value);
    data.append('price', edit_room_form.elements['price'].value);
    data.append('quantity', edit_room_form.elements['quantity'].value);
    data.append('adult', edit_room_form.elements['adult'].value);
    data.append('children', edit_room_form.elements['children'].value);
    data.append('description', edit_room_form.elements['description'].value);

    let features = [];
    edit_room_form.elements['features'].forEach(el => {
        if (el.checked) {
            features.push(el.value);
        }
    });
    let facilities = [];
    edit_room_form.elements['facilities'].forEach(el => {
        if (el.checked) {
            facilities.push(el.value);
        }
    });
    data.append('features', JSON.stringify(features));
    data.append('facilities', JSON.stringify(facilities));
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.onload = function () {
        $('#edit_room_modal').modal('hide');
        if (this.responseText == 1) {
            alert('success', 'New Room Updated!');
            edit_room_form.reset();
            get_rooms();
        } else {
            alert('error', 'Failed to Updated Room!');
        }
    };
    xhr.send(data);
}
let add_image_form = document.getElementById('add_image_form');
add_image_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_image();
});
function add_image() {
    let data = new FormData();
    data.append('image', add_image_form.elements['image'].files[0]);
    data.append('room_id', add_image_form.elements['room_id'].value);

    data.append('add_image', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.onload = function () {
        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG or PNG are allowed!', 'image_alert');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2MB!', 'image_alert');
        } else if (this.responseText == 'upl_failed') {
            alert('error', 'Image uploaded failed!', 'image_alert');
        } else {
            alert('success', 'New Image Added!', 'image_alert');
            room_images(add_image_form.elements['room_id'].value, document.querySelector("#room_images .modal-title").innerText);
            add_image_form.reset();
        }
    }
    xhr.send(data);
}
function rem_img(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('rem_img', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Image Removed Successfuly!', 'image_alert');
            room_images(room_id, document.querySelector("#room_images .modal-title").innerText);
        } else {
            alert('error', 'Image Failed Removed!', 'image_alert');
        }
    }
    xhr.send(data);
}

function thumb_img(img_id, room_id) {
    let data = new FormData();
    data.append('image_id', img_id);
    data.append('room_id', room_id);
    data.append('thumb_img', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Image Thumbail changed!', 'image_alert');
            room_images(room_id, document.querySelector("#room_images .modal-title").innerText);
        } else {
            alert('error', 'Image Thumbail Failed to Change!', 'image_alert');
        }
    }
    xhr.send(data);
}

function room_images(id, rname) {
    document.querySelector("#room_images .modal-title").innerText = rname;
    add_image_form.elements['room_id'].value = id;
    add_image_form.elements['image'].value = '';
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/add_room.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('images-data').innerHTML = this.responseText;
    }
    xhr.send('get_room_images=' + id);

}

function remove_room(room_id) {
    if (confirm("Are you Sure,You want to delete this room")) {
        let data = new FormData();
        data.append('room_id', room_id);
        data.append('remove_room', '');
        let xhr = new XMLHttpRequest();
        xhr.open("POST", "ajax/add_room.php", true);
        xhr.onload = function () {
            if (this.responseText == 1) {
                alert('success', 'Room Removed Successfuly!');
                get_rooms();
            } else {
                alert('error', 'Failed To romve Room!');
            }
        }
        xhr.send(data);
    }
}

window.onload = function () {
    get_rooms();
}

