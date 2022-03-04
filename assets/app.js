/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you import will output into a single css file (app.css in this case)
import './styles/app.scss';

// Importing jquery
var $ = require('jquery');

// create global $ and jQuery variables
global.$ = global.jQuery = $;

// start the Stimulus application
require("bootstrap");

import "sweetalert2/src/sweetalert2.scss";
import 'mapbox-gl/dist/mapbox-gl.css';


/* import './rating/script.js';
import './rating/theme.js';
import './rating/lang.js';
import './rating/style.css';
import './rating/theme.css'; */

require('@fortawesome/fontawesome-free/css/all.min.css');
require('@fortawesome/fontawesome-free/js/all.js');
/* 
require('pdfmake');
require('datatables.net-bs5')();
require('datatables.net-buttons-bs5')();
require('datatables.net-buttons/js/buttons.html5.js')();
require('datatables.net-buttons/js/buttons.print.js')();
require('datatables.net-datetime')();
require('datatables.net-fixedcolumns-bs5')();
require('datatables.net-responsive-bs5')();
require('datatables.net-scroller-bs5')();
require('datatables.net-searchbuilder-bs5')();
require('datatables.net-searchpanes-bs5')(); */

window.moment = require('moment');
const mapboxgl = require('mapbox-gl');
