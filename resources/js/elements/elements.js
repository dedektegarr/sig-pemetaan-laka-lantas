import $ from "jquery";

// option element
const newOptionElement = (parent, data) => {
    const options = Array.isArray(data) ? data : [data];

    for (let data of options) {
        const newOption = document.createElement('option');
        newOption.value = data.id;
        newOption.innerText = data.nama;
        parent.append(newOption);
    }
}

// result element
const resultElement = (data) => {
    $('#results').html('');
    for (let value of data) {
        const newList = document.createElement('li');
        newList.classList.add('result-item');
        newList.setAttribute('data-coor', value.center);
        newList.innerText = value.place_name;

        $('#results').append(newList);
    }
}

export { newOptionElement, resultElement };