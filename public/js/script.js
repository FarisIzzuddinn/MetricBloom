document.addEventListener('DOMContentLoaded', function() {
    document.querySelector('.toggle-btn').addEventListener('click', function() {
        document.getElementById('sidebar').classList.toggle('shrink');
    });
});

document.querySelector('.toggle-btn').addEventListener('click', function() {
    document.getElementById('sidebar').classList.toggle('shrink');
});

function openPopup() {
    document.getElementById('popupOverlay').style.display = 'block';
}

function closePopup() {
    document.getElementById('popupOverlay').style.display = 'none';
}

// $('#basic-datatables').DataTable();