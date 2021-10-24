/**
 * Скрипт посылает Ajax для проверки статуса текущего пользователя
 */

async function getStatus(user_code) {
    let response = await fetch('/ajax/user/check-banned?user_code=' + user_code);
    let result = await response.json();
    checkBan(result);
}

function checkBan(status){
    if(status == true){
        window.location.replace("/banned");
    }
}

$(document).ready(function () {
    let user_code = $("#hidden-input-user-code").val();
    let timerId = setInterval(() => getStatus(user_code), 100000);
});