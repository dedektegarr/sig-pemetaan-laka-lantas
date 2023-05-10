import $ from "jquery";
import select2 from "select2"; "select2";

// Konfigurasi library select2
const initSelect2 = () => {
    select2();
    $('.select2').select2();
}

// cek apakah form disable
const enableSelect = (element, isDisable) => {
    if (isDisable) {
        element.removeAttr('disabled');
    } else {
        element.attr('disabled', true);
    }
}

export { initSelect2, enableSelect };