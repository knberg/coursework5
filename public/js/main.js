function openModal() {
    document.getElementById('overlay').style.display = 'flex';
}

function closeModal(event) {
    if (event.target === document.getElementById('overlay')) {
    document.getElementById('overlay').style.display = 'none';
    }
}

function openTab(tabName) {
    var tabs = document.getElementsByClassName("tab-content");
    for (var i = 0; i < tabs.length; i++) {
    tabs[i].style.display = "none";
    }
    document.getElementById(tabName).style.display = "block";
}

document.addEventListener('click', closeModal);

async function handleLogin(event) {
    event.preventDefault();

    var email = document.getElementById('login-email').value;
    var password = document.getElementById('login-password').value;

    var formData = new FormData(); 
    formData.append('email', email);
    formData.append('password', password);

    fetch('/login', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            window.location.href = '/';
        } else {
            alert(data.error);
        }
    });
}

async function handleRegister(event) {
    event.preventDefault();

    var name = document.getElementById('reg-name').value;
    var email = document.getElementById('reg-email').value;
    var password = document.getElementById('reg-password').value;
    var confirmPassword = document.getElementById('reg-confirm-password').value;

    var formData = new FormData(); 
    formData.append('name', name);
    formData.append('email', email);
    formData.append('password', password);
    formData.append('confirm_password', confirmPassword);

    fetch('/register', {
        method: 'POST',
        body: formData,
    })
    .then(response => response.json())
    .then(data => {
        if (data.status == "success") {
            alert("Регистрация прошла успешно!");
        } else {
            alert(data.error);
        }
    });
}

function updateSessions() {
    var selectedDate = document.getElementById('session-date').value;
    var uri =  window.location.href.split('?')[0]
    window.location.href = uri + '?date=' + selectedDate;
}