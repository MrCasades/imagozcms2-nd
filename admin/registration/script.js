//Проверка заполнения форм

const authorName = document.getElementById('authorname')
const email = document.getElementById('email')
const password = document.getElementById('password')
const password2 = document.getElementById('password2')

const confirm = document.getElementById('confirm')

confirm.addEventListener('click', (event) => {
    if ((authorName.value === '') || (email.value === '') || (password.value === '') || (password2.value === '')){
        const incorr = document.getElementById('incorr')
        incorr.innerHTML = '<strong>Не заполнены обязательные поля!</strong>'
        event.preventDefault()
    }

    else if (password.value !== password2.value){
        const incorr = document.getElementById('incorr')
        incorr.innerHTML = '<strong>Пароли не совпадают!</strong>'
        event.preventDefault()
    }
})
