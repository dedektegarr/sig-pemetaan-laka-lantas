import $ from "jquery";
import "datatables";
import "datatables.net-bs4";

const initDatatables = () => {
    $('#table').DataTable();
}

export default initDatatables;