/* Password handling */

let pass = document.querySelector("#password");
let pass_confirm = document.querySelector("#password_confirm");
let sub = document.querySelector("#submit-div input");

function checkValidityPass () {
    if (pass.checkValidity() && pass.value == pass_confirm.value) {
        sub.disabled = false;
    } else {
        sub.disabled = true;
    }
}

pass.addEventListener("keyup", checkValidityPass);
pass_confirm.addEventListener("keyup", checkValidityPass);

/* Captcha handling */

let captcha = document.querySelector("#captcha_string");
let captcha_image = document.querySelector("#captcha-image");
let context = captcha_image.getContext("2d");

let captcha_string = ""
for (let i = 0 ; i < 8 ; i++) {
    captcha_string += String.fromCharCode(Math.floor(Math.random() * 93) + 33);
}

context.font = "3em 'Fira Code', monospace";
context.textAlign = "start";
context.textBaseline = "top";
context.fillStyle = "white";
context.fillText(captcha_string, 20, 50);

/* Source https://developer.mozilla.org/fr/docs/Web/API/SubtleCrypto/digest */

async function digestMessage(message) {
    const msgUint8 = new TextEncoder().encode(message);                          
    const hashBuffer = await crypto.subtle.digest('SHA-256', msgUint8);          
    const hashArray = Array.from(new Uint8Array(hashBuffer));                    
    const hashHex = hashArray.map(b => b.toString(16).padStart(2, '0')).join('');
    return hashHex;
}

/* end of copy pasta */

digestMessage(captcha_string).then(res => captcha.value = res);

captcha_string = "";