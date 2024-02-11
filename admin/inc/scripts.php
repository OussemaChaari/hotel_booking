<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
    function alert(type, msg,position='body') {
    const bsClass = (type === "success") ? "alert-success" : "alert-danger";

    const alertDiv = document.createElement('div');
    alertDiv.innerHTML = `
        <div class="alert ${bsClass} alert-dismissible fade show" role="alert">
            <strong>${msg}</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    `;
    if(position === 'body'){
        document.body.appendChild(alertDiv);
        alertDiv.classList.add('custom-alert');
    }else{
        document.getElementById(position).appendChild(alertDiv);
    }
    setTimeout(removeAlert,2000);

}
function removeAlert(){
    document.getElementsByClassName('alert')[0].remove();
}
</script>
<script>
    function setActive() {
    let navbar = document.getElementById('adminDropdown');
    let tag_a = navbar.getElementsByTagName('a');
    for (let i = 0; i < tag_a.length; i++) {
        let file = tag_a[i].href.split('/').pop();
        let file_name = file.split('.')[0];
        if (document.location.href.indexOf(file_name) >= 0) {
            tag_a[i].classList.add('active');
        }
    }
}

setActive();
</script>