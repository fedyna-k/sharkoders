let select = document.querySelector("select");
let submit = document.querySelector("input[type='submit']");
let hidden = document.querySelector("#language");

submit.disabled = true;
select.onchange = () => {
    if (select.value === "") {
        submit.disabled = true;
    } else {
        submit.disabled = false;
    }
    hidden.value = select.value;
};