import "admin-lte";

import $ from "jquery";
import setMap from "./function/map";
import initSelect2 from "./function/select2";

$(document).ready(function () {
    setMap({
        lng: 102.263641,
        lat: -3.792228
    });

    initSelect2();
});