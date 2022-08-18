window.onload = addListener();

function handleButtonClick() {
    alert('You clicked the button!');
}

function addListener() {
    var el = document.getElementById("button-id");
    el.addEventListener("click", handleButtonClick);
}
