let features_form = document.getElementById('features_form');
let facilities_form = document.getElementById('facilities_form');
features_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_feature();
});
function add_feature() {
    let data = new FormData();
    data.append('name', features_form.elements['feature_name'].value);
    data.append('add_feature', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.onload = function () {
        var myModal = document.getElementById('features');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'New Feature Added!');
            features_form.elements['feature_name'].value = '';
            get_features();
        } else {
            alert('error', 'Failed to insert feature!');

        }
    }
    xhr.send(data);
}
function get_features() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('features-data').innerHTML = this.responseText;
    }
    xhr.send('get_features');
}
function rem_feature(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Feature Removed Successfuly!');
            get_features();
        } else if (this.responseText == 'room_added') {
            alert('error', 'Feature is added to room!');
        } else {
            alert('error', 'Failed to Remove Feature!');
        }
    }
    xhr.send('rem_feature=' + val);
}
facilities_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_facilitie();
});
function add_facilitie() {
    let data = new FormData();
    data.append('name', facilities_form.elements['facility_name'].value);
    data.append('icon', facilities_form.elements['facility_icon'].files[0]);
    data.append('description', facilities_form.elements['facility_description'].value);
    data.append('add_facilitie', '');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.onload = function () {
        var myModal = document.getElementById('facilities');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 'inv_img') {
            alert('error', 'Only SVG are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 1MB!');
        } else if (this.responseText == 'upl_failed') {
            alert('error', 'Image uploaded failed!');
        } else {
            alert('success', 'New Facilitie Added!');
            facilities_form.reset();

            get_facilities();
        }

    }
    xhr.send(data);
}
function get_facilities() {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('facilities-data').innerHTML = this.responseText;
    }
    xhr.send('get_facilities');
}
function rem_facilitie(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/features_facilities.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Facilitie Removed Successfuly!');
            get_facilities();
        }else if (this.responseText == 'room_added') {
            alert('error', 'Facilitie is added to room!');
        } else {
            alert('error', 'Failed to Remove Facilitie!');
        }
    }
    xhr.send('rem_facilitie=' + val);
}
window.onload = function () {
    get_features();
    get_facilities();
}
