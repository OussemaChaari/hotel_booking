

let general_data, contact_data;
let general_settings_form = document.getElementById('general_settings_form');
let contact_settings_form = document.getElementById('contact_settings_form');
let team_form = document.getElementById('team_form');
let member_name_inp = document.getElementById('member_name_inp');
let member_picture_inp = document.getElementById('member_picture_inp');

let site_title_inp = document.getElementById('site_title_inp');
let site_about_inp = document.getElementById('site_about_inp');

function get_general() {
    let site_title = document.getElementById('site_title');
    let site_about = document.getElementById('site_about');
    let shutdown = document.getElementById('shutdown');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        general_data = JSON.parse(this.responseText);
        site_title.innerText = general_data.site_title;
        site_about.innerText = general_data.site_about;

        site_title_inp.value = general_data.site_title;
        site_about_inp.value = general_data.site_about;
        if (general_data.shutdown == 0) {
            shutdown.checked == false;
            shutdown.value == 0;
        } else {
            shutdown.checked == true;
            shutdown.value == 1;
        }
    }
    xhr.send('get_general');
}
general_settings_form.addEventListener('submit', function (e) {
    e.preventDefault(); // Ajoutez cette ligne pour empêcher le comportement par défaut du formulaire
    upd_general(site_title_inp.value, site_about_inp.value);
});
function upd_shutdown(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        let response = JSON.parse(this.responseText); // Parsez la réponse JSON
        let shutdown = document.getElementById('shutdown');

        if (response.status == 1 && val == 0) {
            alert('success', 'Site has been Shutdown!');
        } else {
            alert('success', 'Shutdown made off');
        }

        get_general();
    }

    xhr.send('upd_shutdown=' + val);
}

function upd_general(site_title_val, site_about_val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        var myModal = document.getElementById('general-settings');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            get_general();
            alert('success', 'change saved!');
        } else {
            alert('error', 'No changes made');

        }
    }
    xhr.send('site_title=' + site_title_val + '&site_about=' + site_about_val + '&up_general');
}



function get_contacts() {
    let all_contacts = ['address', 'gmap', 'pn1', 'pn2', 'email', 'tw', 'fb', 'insta'];
    let iframe = document.getElementById('iframe');
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        contact_data = JSON.parse(this.responseText);
        contact_data = Object.values(contact_data);
        console.log(contact_data);
        for (i = 0; i < all_contacts.length; i++) {
            document.getElementById(all_contacts[i]).innerText = contact_data[i + 1];
        }
        iframe.src = contact_data[9];
        contacts_inp(contact_data);
    }
    xhr.send('get_contacts');
}
function contacts_inp(data) {
    let contact_inp = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'tw_inp', 'fb_inp', 'insta_inp', 'iframe_inp'];
    for (i = 0; i < contact_inp.length; i++) {
        document.getElementById(contact_inp[i]).value = data[i + 1];
    }
}
contact_settings_form.addEventListener('submit', function (e) {
    e.preventDefault();
    upd_contacts();
});
function upd_contacts() {
    let index = ['address', 'gmap', 'pn1', 'pn2', 'email', 'tw', 'fb', 'insta', 'iframe'];
    let contact_inp = ['address_inp', 'gmap_inp', 'pn1_inp', 'pn2_inp', 'email_inp', 'tw_inp', 'fb_inp', 'insta_inp', 'iframe_inp'];
    let data_str = "";
    for (i = 0; i < index.length; i++) {
        data_str += index[i] + "=" + document.getElementById(contact_inp[i]).value + '&';
    }
    data_str += "upd_contacts";
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        var myModal = document.getElementById('contacts-settings');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 1) {
            alert('success', 'changes saved!');
            get_contacts();
        } else {
            alert('error', 'No Changes made');
        }
    }
    xhr.send(data_str);

}
team_form.addEventListener('submit', function (e) {
    e.preventDefault();
    add_member();
});
function add_member() {
    let data = new FormData();
    data.append('name', member_name_inp.value);
    data.append('picture', member_picture_inp.files[0]);
    data.append('add_member', '');

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.onload = function () {
        var myModal = document.getElementById('team');
        var modal = bootstrap.Modal.getInstance(myModal);
        modal.hide();
        if (this.responseText == 'inv_img') {
            alert('error', 'Only JPG or PNG are allowed!');
        } else if (this.responseText == 'inv_size') {
            alert('error', 'Image should be less than 2MB!');
        } else if (this.responseText == 'upl_failed') {
            alert('error', 'Image uploaded failed!');
        } else {
            alert('success', 'New Member Added!');
            member_name_inp.value = '';
            member_picture_inp.value = '';
            get_members();
        }
    }
    xhr.send(data);
}
function get_members() {


    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        document.getElementById('team-data').innerHTML = this.responseText;
    }
    xhr.send('get_members');
}
function rem_member(val) {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "ajax/settings_crud.php", true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function () {
        if (this.responseText == 1) {
            alert('success', 'Member Removed Successfuly!');
            get_members();
        } else {
            alert('error', 'Failed to Remove Member!');
        }
    }
    xhr.send('rem_member=' + val);
}
window.onload = function () {
    get_general();
    get_contacts();
    get_members();
}
